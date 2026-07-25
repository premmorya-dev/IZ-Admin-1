<?php

namespace App\Services\Estimate;

use App\Services\Invoice\DocumentSequenceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstimateService
{

    public function __construct(
        protected DocumentSequenceService $documentSequenceService
    ) {}

    public function getCreateData(): array
    {
        return $this->baseFormData();
    }

    public function getEditData(string $estimateCode): ?array
    {
        $estimate = DB::table('estimates')
            ->select(
                'clients.*',
                'estimates.*',
                'countries.country_name',
                'country_states.state_name'
            )
            ->leftJoin('clients', 'estimates.client_id', 'clients.client_id')
            ->leftJoin('countries', 'countries.country_id', 'clients.country_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('estimates.user_id', Auth::id())
            ->where('estimate_code', $estimateCode)
            ->first();

        if (empty($estimate)) {
            return null;
        }

        $items = json_decode($estimate->item_json, true) ?: [];

        $clientDetailsHtml = '';
        $clientDetailsHtml .= !empty($estimate->company_name) ? $estimate->company_name . '<br>' : $estimate->client_name . '<br>';

        if (!empty($estimate->address_1)) {
            $clientDetailsHtml .= $estimate->address_1 . '<br>';
        }

        if (!empty($estimate->address_2)) {
            $clientDetailsHtml .= $estimate->address_2 . '<br>';
        }

        if (!empty($estimate->state_name)) {
            $clientDetailsHtml .= $estimate->state_name . ', ';
        }

        if (!empty($estimate->country_name)) {
            $clientDetailsHtml .= $estimate->country_name . ' ';
        }

        if (!empty($estimate->zip)) {
            $clientDetailsHtml .= $estimate->zip;
        }

        $clientDetailsHtml .= '<button client-code="' . $estimate->client_code . '" class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute shadow" style="width: 36px; height: 36px; bottom: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editClientAddressModal"><i class="bi bi-pencil-fill"></i></button>';

        $baseData = $this->baseFormData();
        $baseData['estimate'] = $estimate;
        $baseData['items'] = $items;
        $baseData['client_details_html'] = $clientDetailsHtml;

        return $baseData;
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


        $data['estimate_number'] = $this->documentSequenceService->preview(auth()->id(), 'estimate');
        $data['invoice_number'] = $this->documentSequenceService->preview(auth()->id(), 'invoice');


        return $data;
    }
}
