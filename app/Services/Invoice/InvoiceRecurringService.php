<?php

namespace App\Services\Invoice;

use App\DTO\Invoice\RecurringInvoiceData;
use App\Repositories\Invoice\InvoiceRepository;

class InvoiceRecurringService
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    public function syncForInvoice(int $invoiceId, int $userId, ?RecurringInvoiceData $data): void
    {
        if ($data === null) {
            $this->invoiceRepository->deleteRecurringInvoice($invoiceId, $userId);
            return;
        }

        $existing = $this->invoiceRepository->getRecurringInvoice($invoiceId, $userId);

        $this->invoiceRepository->upsertRecurringInvoice(
            $invoiceId,
            $userId,
            $data->toDatabaseAttributes($invoiceId, $userId, $existing === null)
        );
    }
}
