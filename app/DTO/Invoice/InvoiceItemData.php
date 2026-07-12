<?php

namespace App\DTO\Invoice;

class InvoiceItemData
{
    public $itemId;
    public $name;
    public $hsn;
    public $quantity;
    public $rate;
    public $discount;
    public $tax;
    public $amount;
    public $description;

    public static function fromArray(array $item): self
    {
        $dto = new self();

        $dto->itemId = $item['item_id'] ?? null;
        $dto->name = (string) ($item['name'] ?? $item['item_name'] ?? '');
        $dto->hsn = $item['hsn'] ?? null;
        $dto->quantity = self::cleanNumber($item['quantity'] ?? 0);
        $dto->rate = self::cleanNumber($item['rate'] ?? 0);
        $dto->discount = self::cleanNumber($item['discount'] ?? 0);
        $dto->tax = self::cleanNumber($item['tax'] ?? 0);
        $dto->amount = self::cleanNumber($item['amount'] ?? 0);
        $dto->description = $item['description'] ?? null;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'item_id' => $this->itemId,
            'item_name' => $this->name,
            'name' => $this->name,
            'hsn' => $this->hsn,
            'quantity' => $this->quantity,
            'rate' => $this->rate,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'amount' => $this->amount,
            'description' => $this->description,
        ];
    }

    public static function cleanNumber($value)
    {
        if ($value === null || $value === '') {
            return '0';
        }

        return preg_replace('/[^\d.\-]/', '', (string) $value);
    }
}
