<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\JsonRequest;

class QueueEmailRequest extends JsonRequest
{
    public function authorize(): bool
    {
        return auth()->check();
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
