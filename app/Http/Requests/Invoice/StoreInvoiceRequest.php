<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\JsonRequest;

class StoreInvoiceRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $items = $this->input('item', []);

        if (is_array($items)) {
            foreach ($items as $index => $item) {
                foreach (['quantity', 'rate', 'discount', 'tax', 'amount'] as $field) {
                    if (isset($items[$index][$field])) {
                        $items[$index][$field] = $this->cleanNumericValue($item[$field]);
                    }
                }
            }
        }

        $this->merge([
            'display_shipping_status' => $this->boolean('display_shipping_status') ? 1 : 0,
            'send_status'             => $this->boolean('send_status') ? 1 : 0,
            'is_recurring'            => $this->boolean('is_recurring') ? 1 : 0,
            'paid_status'             => $this->boolean('paid_status') ? 1 : 0,
            'item'                    => $items,
        ]);
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'client_id' => [
                'required',
                'exists:clients,client_id',
            ],

            'invoice_number' => [
                'required',
                'string',
                'max:255',
                'unique:invoices,invoice_number',
            ],

            'currency_code' => [
                'required',
                'exists:currencies,currency_code',
            ],

            'template_id' => [
                'required',
                'exists:templates,template_id',
            ],

            'invoice_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:invoice_date',
            ],

            'item' => [
                'required',
                'array',
                'min:1',
            ],

            'item.*.item_id' => [
                'nullable',
                'exists:items,item_id',
            ],

            'item.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'item.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'item.*.rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'item.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'item.*.tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'item.*.amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'item.*.description' => [
                'nullable',
                'string',
            ],

            'item.*.hsn' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'terms' => [
                'nullable',
                'string',
            ],

            'upi_id' => [
                'nullable',
               
            ],

            'frequency' => [
                'required_if:is_recurring,1',
                'nullable',
                'in:monthly,weekly,yearly',
            ],

            'day_of_month' => [
                'nullable',
                'integer',
                'min:1',
                'max:31',
                'required_if:frequency,monthly',
            ],

            'day_of_week' => [
                'nullable',
                'string',
                'max:20',
                'required_if:frequency,weekly',
            ],

            'month_of_year' => [
                'nullable',
                'integer',
                'min:1',
                'max:12',
                'required_if:frequency,yearly',
            ],

            'yearly_day_of_month' => [
                'nullable',
                'integer',
                'min:1',
                'max:31',
                'required_if:frequency,yearly',
            ],

            'time_of_day' => [
                'required_if:is_recurring,1',
                'date_format:H:i',
            ],
        ];
    }

    /**
     * Validation Messages
     */
    public function messages(): array
    {
        return [

            'client_id.required' => 'Please select a client.',
            'client_id.exists'   => 'Selected client does not exist.',

            'invoice_number.required' => 'Invoice number is required.',
            'invoice_number.unique'   => 'This invoice number already exists.',
            'invoice_number.max'      => 'Invoice number must not exceed 255 characters.',

            'currency_code.required' => 'Please select a currency.',

            'template_id.required' => 'Please select an invoice template.',

            'invoice_date.required' => 'Invoice date is required.',

            'due_date.required' => 'Due date is required.',
            'due_date.after_or_equal' => 'Due date must be greater than or equal to invoice date.',

            'item.required' => 'Please add at least one invoice item.',
            'item.array'    => 'Invalid invoice items.',
            'item.min'      => 'Please add at least one invoice item.',

            'item.*.name.required' => 'Item name is required.',
            'item.*.quantity.required'  => 'Quantity is required.',
            'item.*.rate.required'      => 'Rate is required.',
            'item.*.amount.required'    => 'Amount is required.',
        ];
    }

    /**
     * Return only validated invoice data.
     */
    public function invoiceData(): array
    {
        return $this->validated();
    }

    private function cleanNumericValue($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        return preg_replace('/[^\d.\-]/', '', (string) $value);
    }
}
