{{ $invoice->company_name ?: $invoice->client_name }}<br>
@if(!empty($invoice->address_1)){{ $invoice->address_1 }}<br>@endif
@if(!empty($invoice->address_2)){{ $invoice->address_2 }}<br>@endif
{{ collect([$invoice->city, $invoice->state_name, $invoice->country_name])->filter()->implode(', ') }}
{{ $invoice->zip }}
<button client-code="{{ $invoice->client_code }}"
        class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute shadow"
        style="width: 36px; height: 36px; bottom: 10px; right: 10px;"
        data-bs-toggle="modal" data-bs-target="#editClientAddressModal">
    <i class="bi bi-pencil-fill"></i>
</button>