<?php

namespace App\DTO\Invoice;

use Illuminate\Http\Request;

class InvoiceData
{
    public $userId;
    public $clientId;
    public $invoiceNumber;
    public $invoiceDate;
    public $dueDate;
    public $status = 'pending';
    public $subTotal;
    public $totalTax;
    public $totalDiscount;
    public $grandTotal;
    public $roundOff;
    public $taxableValue;
    public $cgstAmount;
    public $sgstAmount;
    public $igstAmount;
    public $totalDue;
    public $notes;
    public $terms;
    public $currencyCode;
    public $templateId;
    public $upiId;
    public $displayShippingStatus = 'N';
    public $items = [];
    public $sendStatus = false;
    public $isRecurring = false;
    public $paidStatus = false;

    public static function fromRequest(Request $request, int $userId): self
    {
        $dto = new self();
        $dto->userId = $userId;
        $dto->clientId = $request->input('client_id');
        $dto->invoiceNumber = $request->input('invoice_number');
        $dto->invoiceDate = $request->input('invoice_date');
        $dto->dueDate = $request->input('due_date');
        $dto->subTotal = $request->input('hidden_sub_total');
        $dto->totalTax = $request->input('hidden_total_tax');
        $dto->totalDiscount = $request->input('hidden_total_discount');
        $dto->grandTotal = $request->input('hidden_grand_total');
        $dto->roundOff = $request->input('hidden_round_off');
        $dto->taxableValue = $request->input('hidden_total_taxable');
        $dto->cgstAmount = $request->input('hidden_total_cgst');
        $dto->sgstAmount = $request->input('hidden_total_sgst');
        $dto->igstAmount = $request->input('hidden_total_igst');
        $dto->totalDue = $request->input('hidden_total_due');
        $dto->notes = $request->input('notes');
        $dto->terms = $request->input('terms');
        $dto->currencyCode = $request->input('currency_code');
        $dto->templateId = $request->input('template_id');
        $dto->upiId = $request->input('upi_id');
        $dto->displayShippingStatus = $request->boolean('display_shipping_status') ? 'Y' : 'N';
        $dto->sendStatus = $request->boolean('send_status');
        $dto->isRecurring = $request->boolean('is_recurring');
        $dto->paidStatus = $request->boolean('paid_status');

        $items = $request->input('item', []);
        $dto->items = [];

        if (is_array($items)) {
            foreach ($items as $item) {
                $dto->items[] = InvoiceItemData::fromArray($item)->toArray();
            }
        }

        return $dto;
    }

    public function toCreateAttributes(string $invoiceCode): array
    {
        return [
            'user_id' => $this->userId,
            'client_id' => $this->clientId,
            'invoice_number' => $this->invoiceNumber,
            'invoice_date' => $this->invoiceDate,
            'due_date' => $this->dueDate,
            'status' => $this->status,
            'sub_total' => $this->subTotal,
            'total_tax' => $this->totalTax,
            'total_discount' => $this->totalDiscount,
            'grand_total' => $this->grandTotal,
            'round_off' => $this->roundOff,
            'taxable_value' => $this->taxableValue,
            'cgst_amount' => $this->cgstAmount,
            'sgst_amount' => $this->sgstAmount,
            'igst_amount' => $this->igstAmount,
            'total_due' => $this->totalDue,
            'notes' => $this->notes,
            'terms' => $this->terms,
            'currency_code' => $this->currencyCode,
            'item_json' => json_encode($this->items),
            'upi_id' => $this->upiId,
            'invoice_code' => $invoiceCode,
            'template_id' => $this->templateId,
            'display_shipping_status' => $this->displayShippingStatus,
        ];
    }

    public function toUpdateAttributes(): array
    {
        return [
            'client_id' => $this->clientId,
            'invoice_number' => $this->invoiceNumber,
            'invoice_date' => $this->invoiceDate,
            'due_date' => $this->dueDate,
            'sub_total' => $this->subTotal,
            'total_tax' => $this->totalTax,
            'total_discount' => $this->totalDiscount,
            'grand_total' => $this->grandTotal,
            'round_off' => $this->roundOff,
            'taxable_value' => $this->taxableValue,
            'cgst_amount' => $this->cgstAmount,
            'sgst_amount' => $this->sgstAmount,
            'igst_amount' => $this->igstAmount,
            'total_due' => $this->totalDue,
            'notes' => $this->notes,
            'terms' => $this->terms,
            'currency_code' => $this->currencyCode,
            'item_json' => json_encode($this->items),
            'upi_id' => $this->upiId,
            'template_id' => $this->templateId,
            'display_shipping_status' => $this->displayShippingStatus,
        ];
    }
}
