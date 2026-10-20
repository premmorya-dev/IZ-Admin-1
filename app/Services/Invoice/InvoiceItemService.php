<?php

namespace App\Services\Invoice;

use App\DTO\Invoice\InvoiceItemData;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use App\Exceptions\InsufficientStockException;

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





    /**
     * Combine duplicate item rows into one quantity per item_id.
     */
    private function getItemQuantities(array $items): array
    {


        $quantities = [];

        foreach ($items as $item) {
            $itemId = $item['item_id'] ?? null;
            $quantity = (float) ($item['quantity'] ?? 0);

            if (
                $itemId === null ||
                $itemId === '' ||
                !is_numeric($itemId) ||
                (int) $itemId <= 0 ||
                !is_finite($quantity) ||
                $quantity < 0
            ) {
                continue;
            }

            if ($quantity == 0) {
                continue;
            }

            $itemId = (int) $itemId;

            $quantities[$itemId] =
                ($quantities[$itemId] ?? 0) + $quantity;
        }

        return $quantities;
    }

    /**
     * Restore stock when an invoice is cancelled/deleted,
     * or when a saved invoice quantity is reduced.
     */
    public function restoreStockForItems(
        int $userId,
        array $items
    ): void {
        $quantities = $this->getItemQuantities($items);

        DB::transaction(function () use ($userId, $quantities) {
            foreach ($quantities as $itemId => $quantity) {
                $item = DB::table('items')
                    ->where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->lockForUpdate()
                    ->first();

                if (!$item) {
                    throw new RuntimeException(
                        "Inventory item {$itemId} not found."
                    );
                }

                DB::table('items')
                    ->where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->increment('stock', $quantity);
            }
        });
    }

    /**
     * Decrease stock when an invoice is first finalized.
     */
    public function decreaseStockForItems(
        int $userId,
        array $items
    ): void {
        $quantities = $this->getItemQuantities($items);

        DB::transaction(function () use ($userId, $quantities) {
            foreach ($quantities as $itemId => $quantity) {
                $item = DB::table('items')
                    ->where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->lockForUpdate()
                    ->first();

                if (!$item) {
                    throw new RuntimeException(
                        "Inventory item {$itemId} not found."
                    );
                }

                if ((float) $item->stock < $quantity) {
                    throw new RuntimeException(
                        "Insufficient stock for item: {$item->item_name}. " .
                            "Available: {$item->stock}, Required: {$quantity}"
                    );
                }

                DB::table('items')
                    ->where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->decrement('stock', $quantity);
            }
        });
    }

    /**
     * Sync inventory when updating an invoice whose old
     * quantities have already affected stock.
     *
     * Positive difference: decrease stock.
     * Negative difference: restore stock.
     */
    public function syncStockForUpdate(
        int $userId,
        array $oldItems,
        array $newItems
    ): void {
        $oldQuantities = $this->getItemQuantities($oldItems);
        $newQuantities = $this->getItemQuantities($newItems);

        $itemIds = array_unique(array_merge(
            array_keys($oldQuantities),
            array_keys($newQuantities)
        ));

        sort($itemIds);

        DB::transaction(function () use (
            $userId,
            $oldQuantities,
            $newQuantities,
            $itemIds
        ) {
            foreach ($itemIds as $itemId) {
                $oldQty = $oldQuantities[$itemId] ?? 0;
                $newQty = $newQuantities[$itemId] ?? 0;

                // Only adjust the quantity difference.
                $difference = $newQty - $oldQty;

                if (abs($difference) < 0.0000001) {
                    continue;
                }

                $item = DB::table('items')
                    ->where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->lockForUpdate()
                    ->first();

                if (!$item) {
                    throw new RuntimeException(
                        "Inventory item {$itemId} not found."
                    );
                }

                if ($difference > 0) {
                    // More quantity sold: deduct only the difference.

                    if ((float) $item->stock < $difference) {
                        throw new InsufficientStockException(
                            "Insufficient stock for item: {$item->item_name}. " .
                                "Available: {$item->stock}, " .
                                "Additional required: {$difference}"
                        );
                    }

                    DB::table('items')
                        ->where('user_id', $userId)
                        ->where('item_id', $itemId)
                        ->decrement('stock', $difference);
                } else {
                    // Less quantity sold: restore the difference.
                    DB::table('items')
                        ->where('user_id', $userId)
                        ->where('item_id', $itemId)
                        ->increment('stock', abs($difference));
                }
            }
        });
    }
}
