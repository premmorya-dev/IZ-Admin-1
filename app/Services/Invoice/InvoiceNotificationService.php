<?php

namespace App\Services\Invoice;

use App\Repositories\Invoice\NotificationRepository;

class InvoiceNotificationService
{
    public function __construct(
        protected NotificationRepository $notificationRepository
    ) {
    }

    public function queueEmail(int $userId, int $invoiceId, ?string $invoiceCode = null, int $templateId = 1): int
    {
        return $this->notificationRepository->queueInvoiceEmail($userId, $invoiceId, $invoiceCode, $templateId);
    }
}
