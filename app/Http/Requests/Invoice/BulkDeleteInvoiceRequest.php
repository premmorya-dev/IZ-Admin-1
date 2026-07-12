<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\JsonRequest;

class BulkDeleteInvoiceRequest extends JsonRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $codes = $this->input('invoices_code', $this->input('invoice_codes', []));

        if (!empty($codes) && !is_array($codes)) {
            $codes = [$codes];
        }

        $this->merge([
            'invoices_code' => $codes,
        ]);
    }

    public function rules(): array
    {
        return [
            'invoices_code' => ['required', 'array', 'min:1'],
            'invoices_code.*' => ['required', 'exists:invoices,invoice_code'],
        ];
    }

    public function messages(): array
    {
        return [
            'invoices_code.required' => 'Please select at least one invoice.',
            'invoices_code.array' => 'Selected invoices are invalid.',
            'invoices_code.*.exists' => 'One or more invoices do not exist.',
        ];
    }
}
