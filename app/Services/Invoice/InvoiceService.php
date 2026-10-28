<?php

namespace App\Services\Invoice;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        protected DocumentSequenceService $documentSequenceService
    ) {
    }

    public function getCreateData(): array
    {
        return $this->baseFormData(Auth::id());
    }

    public function getEditData(string $invoiceCode): ?array
    {
        $userId = Auth::id();

        $invoice = DB::table('invoices')
            ->leftJoin('clients', 'invoices.client_id', '=', 'clients.client_id')
            ->leftJoin('countries', 'countries.country_id', '=', 'clients.country_id')
            ->leftJoin('country_states', 'country_states.state_id', '=', 'clients.state_id')
            ->where('invoices.user_id', $userId)
            ->where('invoices.invoice_code', $invoiceCode)
            ->select(
                'clients.*',
                'invoices.*',
                'countries.country_name',
                'country_states.state_name'
            )
            ->first();

        if (!$invoice) {
            return null;
        }

        $data = $this->baseFormData($userId);

        $data['invoice']             = $invoice;
        $data['items']               = json_decode($invoice->item_json, true) ?: [];
        $data['client_details_html'] = view('pages.invoice.partials.client_details', [
            'invoice' => $invoice,
        ])->render();
        $data['recurring']           = DB::table('recurring_invoices')
            ->where('invoice_id', $invoice->invoice_id)
            ->where('user_id', $userId)
            ->first();

        return $data;
    }

    public function getPaymentFormData(string $invoiceCode): ?object
    {
        return DB::table('invoices')
            ->leftJoin('clients', 'invoices.client_id', '=', 'clients.client_id')
            ->where('invoices.user_id', Auth::id())
            ->where('invoices.invoice_code', $invoiceCode)
            ->first();
    }

    private function baseFormData(int $userId): array
    {
        // Static data: 1 din cache (DB hit nahi)
        $currencies = Cache::remember('invoice:currencies', now()->addDay(), fn () =>
            DB::table('currencies')->orderBy('currency_name')->get()
        );

        $templates = Cache::remember('invoice:templates', now()->addDay(), fn () =>
            DB::table('templates')->orderBy('template_name')->get()
        );

        // settings + country + state = 1 query (pehle 3 thi)
        $setting = DB::table('settings')
            ->leftJoin('countries', 'countries.country_id', '=', 'settings.country_id')
            ->leftJoin('country_states', 'country_states.state_id', '=', 'settings.state_id')
            ->where('settings.user_id', $userId)
            ->select('settings.*', 'countries.country_name', 'country_states.state_name')
            ->first();

        if ($setting) {
            // purane JS/blade ke compatibility ke liye same structure
            $setting->country = (object) [
                'country_id'   => $setting->country_id,
                'country_name' => $setting->country_name,
            ];
            $setting->state = (object) [
                'state_id'   => $setting->state_id,
                'state_name' => $setting->state_name,
            ];
        }

        return [
            'currencies'     => $currencies,
            'templates'      => $templates,
            'upi_payment_id' => DB::table('upi_payment_id')
                ->where('user_id', $userId)->orderBy('upi_name')->get(),
            'setting'        => $setting,
            'discounts'      => DB::table('discounts')
                ->where('user_id', $userId)->orderBy('name')->get(),
            'taxes'          => DB::table('taxes')
                ->where('user_id', $userId)->orderBy('name')->get(),
            'invoice_number' => $this->documentSequenceService->preview($userId, 'invoice'),
        ];
    }
}