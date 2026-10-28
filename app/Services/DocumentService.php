<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

abstract class DocumentService
{
    protected $table;
    protected $codeField;
    protected $numberField;
    protected $dateField;
    protected $dueField;
    protected $idField;

    // ✅ new fields for flexibility
    protected $partyTable;       // 'clients' or 'vendors'
    protected $partyKey;         // 'client_id' or 'vendor_id'
    protected $partyAlias;       // 'client' or 'vendor'

    private $same_state;

    public function __construct()
    {
        // override in child
    }

    public function getDocumentData($code, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        $partyAlias = $this->partyAlias;
        $partyTable = $this->partyTable;
        $partyKey   = $this->partyKey;

        $document = DB::table($this->table)
            ->select(
                "{$this->table}.*",
                'settings.*',
                "{$partyTable}.*",
                'users.*',
                'mobile_country_list.country_code',

                "{$this->table}.notes",
                "{$this->table}.terms",

                "{$partyTable}.company_name as {$partyAlias}_company_name",
                "{$partyTable}.email as {$partyAlias}_email",
                "{$partyTable}.address_1 as {$partyAlias}_address_1",
                "{$partyTable}.address_2 as {$partyAlias}_address_2",
                "{$partyTable}.state_id as {$partyAlias}_state_id",
                "{$partyTable}.country_id as {$partyAlias}_country_id",
                "{$partyTable}.gst_number as {$partyAlias}_gst_number",
                "{$partyTable}.phone as {$partyAlias}_phone",
                "{$partyTable}.city as {$partyAlias}_city",
                "{$partyTable}.zip as {$partyAlias}_zip",

                'settings.company_name as user_company_name',
                'settings.email as user_email',
                'settings.address_1 as user_address_1',
                'settings.address_2 as user_address_2',
                'settings.state_id as user_state_id',
                'settings.country_id as user_country_id',
                'settings.user_gst_number as user_gst_number'
            )
            ->leftJoin('settings', 'settings.user_id', "{$this->table}.user_id")
            ->leftJoin($partyTable, "{$partyTable}.{$partyKey}", "{$this->table}.{$partyKey}")
            ->leftJoin('users', "{$partyTable}.user_id", "{$this->table}.user_id")
            ->leftJoin('mobile_country_list', 'mobile_country_list.mobile_country_code_id', 'users.mobile_country_code_id')
            ->where("{$this->table}.{$this->codeField}", $code)
            ->where('users.user_id', $userId)
            ->first();


        if ($partyTable  == 'clients') {
            if ($document->user_state_id == $document->client_state_id) {
                $this->same_state = true;
            } else {
                $this->same_state = false;
            }
        }

        if ($partyTable  == 'vendors') {
            if ($document->user_state_id == $document->vendor_state_id) {
                $this->same_state = true;
            } else {
                $this->same_state = false;
            }
        }






        if (!$document) {
            return null;
        }

        // Fetch country and state names
        $document->{"{$partyAlias}_country"} = optional(DB::table('countries')->where('country_id', $document->{"{$partyAlias}_country_id"})->first())->country_name ?? '';
        $document->{"{$partyAlias}_state"} = optional(DB::table('country_states')->where('state_id', $document->{"{$partyAlias}_state_id"})->first())->state_name ?? '';

        if ($partyTable  == 'clients') {
            $document->client_shipping_country = optional(DB::table('countries')->where('country_id', $document->shipping_country_id)->first())->country_name ?? '';
            $document->client_shipping_state = optional(DB::table('country_states')->where('state_id', $document->shipping_state_id)->first())->state_name ?? '';
        }

        $document->user_country = optional(DB::table('countries')->where('country_id', $document->user_country_id)->first())->country_name ?? '';
        $document->user_state = optional(DB::table('country_states')->where('state_id', $document->user_state_id)->first())->state_name ?? '';




        // Convert logo and signature to base64 if available
        $document->logo_base64 = $document->logo_path && file_exists(public_path($document->logo_path))
            ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($document->logo_path))) : '';

        $document->logo_image = $document->logo_path && file_exists(public_path($document->logo_path))
            ? url('/') . "/" . $document->logo_path : '';

        $document->signature_base64 = $document->signature && file_exists(public_path($document->signature))
            ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($document->signature))) : '';

        $document->signature_image = $document->signature && file_exists(public_path($document->signature))
            ?   url('/') . "/" . $document->signature : '';

        if ($this->table == 'estimates') {
            $document->total_due = $document->grand_total;
        }


        $document->qr_base64 = '';
        $document->qr_code_image = '';

        if (!empty($document->upi_id)) {

            $note = "Payment|{$document->company_name}|{$document->{$this->numberField}}";

            $upiUrl = "upi://pay?"
                . http_build_query([
                    'pa' => $document->upi_id,
                    'pn' => $document->company_name,
                    'am' => $document->total_due,
                    'cu' => $document->currency_code,
                    'tn' => $note,
                ], '', '&', PHP_QUERY_RFC3986);

            // Detect changes in payment data.
            $payloadHash = hash('sha256', $upiUrl);

            // Reuse the existing path if the saved QR is still valid.
            $savedPath = $document->qr_code_path ?? null;

            $fullPath = $savedPath
                ? public_path($savedPath)
                : null;

            $qrExists = $fullPath && is_file($fullPath);

            $samePayload = ($document->qr_payload_hash ?? '') === $payloadHash;

            if (!$qrExists || !$samePayload) {

                $directory = public_path('qrcodes');

                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Stable filename: don't create a random file on every request.
                $fileName = 'upi_qr_'
                    . $this->table . '_'
                    . $document->{$this->idField}
                    . '.png';

                $relativePath = 'qrcodes/' . $fileName;
                $fullPath = public_path($relativePath);

                // Generate only when missing or payment data has changed.
                QrCode::format('png')
                    ->size(100)
                    ->generate($upiUrl, $fullPath);

                // Save the path and payload hash in the document table.
                DB::table($this->table)
                    ->where($this->codeField, $code)
                    ->where('user_id', $userId)
                    ->update([
                        'qr_code_path' => $relativePath,
                        'qr_payload_hash' => $payloadHash,
                    ]);

                $savedPath = $relativePath;
            }

            // Use the saved PNG for both the PDF and regular image URL.
            if (is_file(public_path($savedPath))) {
                $document->qr_code_path = $savedPath;
              
                $qr_base64 = 'data:image/png;base64,'
                    . base64_encode(file_get_contents(public_path($savedPath)));

                $document->qr_base64 =  '<img src="' . $qr_base64 . '" style="height:54px; width:54px;">';

                $document->qr_code_image = asset($savedPath);
            }
        }




        // Get currency symbol
        $document->currency_symbol = optional(DB::table('currencies')->where('currency_code', $document->currency_code)->first())->currency_symbol ?? '';

        return $document;
    }

    public function generateDynamicItemRows($items, $currencySymbol)
    {
        $rows = '';
        $index = 0;

        foreach ($items as $item) {

            $base = $item->rate * $item->quantity;
            $discount = ($base / 100) * $item->discount;
            $discountText = $discount > 0 ? "{$item->discount}%<br>{$currencySymbol}{$discount}" : '-';

            $tax = (($base - $discount) / 100) * $item->tax;
            $taxText = $tax > 0 ? "{$item->tax}%<br>{$currencySymbol}{$tax}" : '-';

            $taxable = $base - $discount;
            // Initialize
            $cgstPercent = 0;
            $sgstPercent = 0;
            $igstPercent = 0;

            if ($this->same_state) {
                // CGST + SGST
                $cgstPercent = $item->tax / 2;
                $sgstPercent = $item->tax / 2;
                $igstPercent = 0;
            } else {
                // IGST only
                $cgstPercent = 0;
                $sgstPercent = 0;
                $igstPercent = $item->tax;
            }

            // Calculate amounts
            $cgst = ($taxable * $cgstPercent) / 100;
            $sgst = ($taxable * $sgstPercent) / 100;
            $igst = ($taxable * $igstPercent) / 100;

            $cgst_text = $cgst > 0 ? "{$cgstPercent}%<br>{$currencySymbol}{$cgst}" : '-';
            $sgst_text = $sgst > 0 ? "{$sgstPercent}%<br>{$currencySymbol}{$sgst}" : '-';
            $igst_text = $igst > 0 ? "{$igstPercent}%<br>{$currencySymbol}{$igst}" : '-';

            $hsn = $item->hsn ?? '-';
            $item->description = $item->description ?? '';

            $rowBg = ($index % 2 === 0) ? '#ffffff' : '#F9FAFB';

            $rows .= "<tr style='background-color:{$rowBg};'>
            <td style='text-align:left; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:28%;'>
                <span style='font-size:9px; font-weight:bold; color:#111827;'>{$item->name}</span>" .
                ($item->description !== '' ? "<br><span style='font-size:7.5px; color:#6B7280; line-height:1.3;'>{$item->description}</span>" : "") . "
            </td>
            <td style='text-align:left; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:9%; font-size:8px; color:#374151;'>{$hsn}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:6%; font-size:8px; color:#374151;'>{$item->quantity}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:9%; font-size:8px; color:#374151;'>{$currencySymbol}{$item->rate}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:9%; font-size:8px; color:#374151;'>{$discountText}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:9%; font-size:8px; color:#374151;'>{$currencySymbol}{$taxable}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:8%; font-size:8px; color:#374151;'>{$cgst_text}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:8%; font-size:8px; color:#374151;'>{$sgst_text}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:8%; font-size:8px; color:#374151;'>{$igst_text}</td>
            <td style='text-align:right; vertical-align:top; border-bottom:1px solid #E5E7EB; padding:6px 6px; width:10%; font-size:9px; font-weight:bold; color:#111827;'>{$currencySymbol}{$item->amount}</td>
        </tr>";

            $index++;
        }
        return $rows;
    }

    public function getAttribute($name)
    {
        return match ($name) {
            'table' => $this->table,
            'codeField' => $this->codeField,
            'numberField' => $this->numberField,
            'dateField' => $this->dateField,
            'dueField' => $this->dueField,
            'idField' => $this->idField,
            default => null,
        };
    }
}
