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

    public function __construct()
    {
        // override in child
    }

    public function getDocumentData($code, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        $document = DB::table($this->table)
            ->select(
                "{$this->table}.*",
                'settings.*',
                'clients.*',
                'users.*',
                'mobile_country_list.country_code',



                'clients.company_name as client_company_name',
                'clients.email as client_email',
                'clients.address_1 as client_address_1',
                'clients.address_2 as client_address_2',
                'clients.state_id as client_state_id',
                'clients.country_id as client_country_id',
                'clients.gst_number as client_gst_number',


                'settings.company_name as user_company_name',
                'settings.email as user_email',
                'settings.address_1 as user_address_1',
                'settings.address_2 as user_address_2',
                'settings.state_id as user_state_id',
                'settings.country_id as user_country_id',
                'settings.user_gst_number as user_gst_number',



            )
            ->leftJoin('settings', 'settings.user_id', "{$this->table}.user_id")
            ->leftJoin('clients', 'clients.client_id', "{$this->table}.client_id")
            ->leftJoin('users', 'clients.user_id', "{$this->table}.user_id")
            ->leftJoin('mobile_country_list', 'mobile_country_list.mobile_country_code_id', 'users.mobile_country_code_id')
            ->where("{$this->table}.{$this->codeField}", $code)
            ->where('users.user_id', $userId)
            ->first();

        if (!$document) {
            return null;
        }

        // Fetch country and state names
        $document->client_country = optional(DB::table('countries')->where('country_id', $document->client_country_id)->first())->country_name ?? '';
        $document->client_state = optional(DB::table('country_states')->where('state_id', $document->client_state_id)->first())->state_name ?? '';

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


        $document->qr_base64 = '';
        if (!empty($document->upi_id)) {
            $note = "Payment|{$document->company_name}|{$document->{$this->numberField}}";
            $upiUrl = "upi://pay?pa={$document->upi_id}&pn={$document->company_name}&am={$document->total_due}&cu={$document->currency_code}&tn={$note}";
            $qrCode = QrCode::format('png')->size(100)->generate($upiUrl);
            $document->qr_base64 = 'data:image/png;base64,' . base64_encode($qrCode);
        }



        $document->qr_code_image = '';
        if (!empty($document->upi_id)) {
            $note = "Payment|{$document->company_name}|{$document->{$this->numberField}}";
            $upiUrl = "upi://pay?pa={$document->upi_id}&pn={$document->company_name}&am={$document->total_due}&cu={$document->currency_code}&tn={$note}";

            // Generate unique file name
            $fileName = 'upi_qr_' . Str::random(10) . '.png';

            // Path to save the image in public folder
            $filePath = public_path('qrcodes/' . $fileName);

            // Ensure the directory exists
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            // Generate and save the QR code image
            QrCode::format('png')->size(100)->generate($upiUrl, $filePath);

            // Get the public URL to show in email or browser
            $document->qr_code_image = asset('qrcodes/' . $fileName);
        }



        // Get currency symbol
        $document->currency_symbol = optional(DB::table('currencies')->where('currency_code', $document->currency_code)->first())->currency_symbol ?? '';

        return $document;
    }

    public function generateDynamicItemRows($items, $currencySymbol)
    {


        $rows = '';
        foreach ($items as $item) {
            $discount = (($item->rate * $item->quantity) / 100) * $item->discount;
            $discountText = $discount > 0 ? "{$item->discount}% <br> {$currencySymbol}{$discount}" : '-';

            $tax = ((($item->rate * $item->quantity) - $discount) / 100) * $item->tax;
            $taxText = $tax > 0 ? "{$item->tax}% <br> {$currencySymbol}{$tax}" : '-';

            $hsn = $item->hsn ?? '-';
            $item->description = $item->description ?? '' ;
            $rows .= "<tr>
                <td style='text-left:center;border: 1px solid #ddd; padding: 5px; width: 40%;'>{$item->name}<br><p style='font-size:10px;'>{$item->description}<p></td>
                <td style='text-align:left;border: 1px solid #ddd; padding: 5px; width: 10%;'>{$hsn}</td>
                <td style='text-align:left;border: 1px solid #ddd; padding: 5px; width: 10%;'>{$item->quantity}</td>
                <td style='text-align:left;border: 1px solid #ddd; padding: 5px; width: 10%;'>{$currencySymbol}{$item->rate}</td>
                <td style='border: 1px solid #ddd; padding: 5px; width: 10%;'>{$discountText}</td>
                <td style='border: 1px solid #ddd; padding: 5px; width: 10%;'>{$taxText}</td>
                <td style='text-align:right;border: 1px solid #ddd; padding: 5px; width: 10%;'>{$currencySymbol}{$item->amount}</td>
            </tr>";
        }
        return $rows;
    }

    public function getAttribute($name)
    {

        $attribute = match ($name) {
            'table' => $this->table,
            'codeField' => $this->codeField,
            'numberField' => $this->numberField,
            'dateField' => $this->dateField,
            'dueField' => $this->dueField,
            'idField' => $this->idField,

            default => null,
        };

        return $attribute;
    }
}
