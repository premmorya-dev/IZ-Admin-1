<?php

namespace App\Services\Invoice;

use App\DTO\Invoice\InvoiceItemData;

class InvoiceItemService
{
    public function normalizeItems($items): array
    {
        if (is_string($items)) {
            $items = json_decode($items, true) ?: [];
        }

        if (!is_array($items)) {
            return [];
        }

        $normalized = [];

        foreach ($items as $item) {
            $normalized[] = InvoiceItemData::fromArray((array) $item)->toArray();
        }

        return $normalized;
    }

    public function decodeItemJson(?string $itemJson): array
    {
        if (empty($itemJson)) {
            return [];
        }

        $decoded = json_decode($itemJson, true);

        return is_array($decoded) ? $decoded : [];
    }

    public function restoreStockForItems(int $userId, array $items): void
    {
        foreach ($items as $item) {
            $itemId = $item['item_id'] ?? null;
            $quantity = (float) ($item['quantity'] ?? 0);

            if (empty($itemId) || $quantity <= 0) {
                continue;
            }

            \DB::table('items')
                ->where('user_id', $userId)
                ->where('item_id', $itemId)
                ->update([
                    'stock' => \DB::raw('stock + ' . $quantity),
                ]);
        }
    }

    public function decreaseStockForItems(int $userId, array $items): void
    {
        foreach ($items as $item) {
            $itemId = $item['item_id'] ?? null;
            $quantity = (float) ($item['quantity'] ?? 0);

            if (empty($itemId) || $quantity <= 0) {
                continue;
            }

            \DB::table('items')
                ->where('user_id', $userId)
                ->where('item_id', $itemId)
                ->update([
                    'stock' => \DB::raw('stock - ' . $quantity),
                ]);
        }
    }

    public function syncStockForUpdate(int $userId, array $oldItems, array $newItems): void
    {
        $this->restoreStockForItems($userId, $oldItems);
        $this->decreaseStockForItems($userId, $newItems);
    }
}
