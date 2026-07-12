<?php

namespace App\Services\Invoice;

class InvoiceStockService
{
    public function __construct(
        protected InvoiceItemService $itemService
    ) {
    }

    public function reduceForItems(int $userId, array $items): void
    {
        $this->itemService->decreaseStockForItems($userId, $items);
    }

    public function syncForUpdate(int $userId, array $oldItems, array $newItems): void
    {
        $this->itemService->syncStockForUpdate($userId, $oldItems, $newItems);
    }
}
