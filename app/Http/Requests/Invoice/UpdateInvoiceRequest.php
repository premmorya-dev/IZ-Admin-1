<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends StoreInvoiceRequest
{
    /**
     * Validation rules for updating an invoice.
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['invoice_code'] = [
            'required',
            'string',
            'exists:invoices,invoice_code',
        ];

        $rules['invoice_number'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('invoices', 'invoice_number')
                ->ignore($this->input('invoice_code'), 'invoice_code'),
        ];

        return $rules;
    }

    /**
     * Custom validation messages for update flow.
     */
    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'invoice_code.required' => 'Invoice code is required.',
            'invoice_code.exists'   => 'The selected invoice does not exist.',
            'invoice_number.unique'  => 'This invoice number already exists. Please use a different number.',
        ]);
    }
}
