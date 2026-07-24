<?php

namespace App\Services\Invoice;

use App\Services\Invoice\DocumentSequenceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceService
{

    public function __construct(
        protected DocumentSequenceService $documentSequenceService
    ) {
    }

    public function getCreateData(): array
    {
        return $this->baseFormData();
    }

    public function getEditData(string $invoiceCode): ?array
    {
        $invoice = DB::table('invoices')
            ->select(
                'clients.*',
                'invoices.*',
                'countries.country_name',
                'country_states.state_name'
            )
            ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
            ->leftJoin('countries', 'countries.country_id', 'clients.country_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('invoices.user_id', Auth::id())
            ->where('invoice_code', $invoiceCode)
            ->first();

        if (empty($invoice)) {
            return null;
        }

        $items = json_decode($invoice->item_json, true) ?: [];

        $clientDetailsHtml = '';
        $clientDetailsHtml .= !empty($invoice->company_name) ? $invoice->company_name . '<br>' : $invoice->client_name . '<br>';

        if (!empty($invoice->address_1)) {
            $clientDetailsHtml .= $invoice->address_1 . '<br>';
        }

        if (!empty($invoice->address_2)) {
            $clientDetailsHtml .= $invoice->address_2 . '<br>';
        }

        if (!empty($invoice->state_name)) {
            $clientDetailsHtml .= $invoice->state_name . ', ';
        }

        if (!empty($invoice->country_name)) {
            $clientDetailsHtml .= $invoice->country_name . ' ';
        }

        if (!empty($invoice->zip)) {
            $clientDetailsHtml .= $invoice->zip;
        }

        $clientDetailsHtml .= '<button client-code="' . $invoice->client_code . '" class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute shadow" style="width: 36px; height: 36px; bottom: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editClientAddressModal"><i class="bi bi-pencil-fill"></i></button>';

        $baseData = $this->baseFormData();
        $baseData['invoice'] = $invoice;
        $baseData['items'] = $items;
        $baseData['client_details_html'] = $clientDetailsHtml;
        $baseData['recurring'] = DB::table('recurring_invoices')
            ->where('invoice_id', $invoice->invoice_id)
            ->where('user_id', Auth::id())
            ->first();

        return $baseData;
    }

    public function getPaymentFormData(string $invoiceCode): ?object
    {
        return DB::table('invoices')
            ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
            ->where('invoices.user_id', Auth::id())
            ->where('invoices.invoice_code', $invoiceCode)
            ->first();
    }

    private function baseFormData(): array
    {
        $data = [];

        $data['currencies'] = DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = DB::table('templates')->orderBy('template_name', 'ASC')->get();
        $data['upi_payment_id'] = DB::table('upi_payment_id')
            ->where('user_id', Auth::id())
            ->orderBy('upi_name', 'ASC')
            ->get();
        $data['setting'] = DB::table('settings')->where('user_id', Auth::id())->first();
        $data['discounts'] = DB::table('discounts')
            ->where('user_id', Auth::id())
            ->orderBy('name', 'ASC')
            ->get();
        $data['taxes'] = DB::table('taxes')
            ->where('user_id', Auth::id())
            ->orderBy('name', 'ASC')
            ->get();

        if (!empty($data['setting'])) {
            $data['setting']->country = DB::table('countries')->where('country_id', $data['setting']->country_id)->first();
            $data['setting']->state = DB::table('country_states')->where('state_id', $data['setting']->state_id)->first();
        }


        $data['invoice_number'] = $this->documentSequenceService->preview(auth()->id(),'invoice');


        return $data;
    }
}
