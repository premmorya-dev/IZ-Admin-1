<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\JsonRequest;

class RecordPaymentRequest extends JsonRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => $this->input('amount'),
        ]);
    }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'exists:invoices,invoice_id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank,card,upi,paypal,stripe,other'],
            'transaction_reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'invoice_id.required' => 'Invoice ID is required.',
            'invoice_id.exists' => 'The selected invoice does not exist.',
            'amount.required' => 'Payment amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'payment_date.required' => 'Payment date is required.',
            'payment_method.required' => 'Payment method is required.',
        ];
    }
}
