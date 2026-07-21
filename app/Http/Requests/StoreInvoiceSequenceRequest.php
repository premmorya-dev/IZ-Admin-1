<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceSequenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prefix' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\-_\/]+$/',
            ],

            'padding' => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],

            'start_from' => [
                'required',
                'integer',
                'min:1',
                'max:999999999999',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'prefix.required'    => 'Invoice prefix is required.',
            'prefix.max'         => 'Invoice prefix may not be greater than 20 characters.',
            'prefix.regex'       => 'Invoice prefix may only contain letters, numbers, hyphen (-), underscore (_) and slash (/).',

            'padding.required'   => 'Padding is required.',
            'padding.integer'    => 'Padding must be a number.',
            'padding.min'        => 'Padding must be at least 1.',
            'padding.max'        => 'Padding may not be greater than 10.',

            'start_from.required' => 'Start From is required.',
            'start_from.integer'  => 'Start From must be a number.',
            'start_from.min'      => 'Start From must be at least 1.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'prefix' => strtoupper(trim($this->prefix)),
        ]);
    }
}