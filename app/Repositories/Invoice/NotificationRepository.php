<?php

namespace App\Repositories\Invoice;

use Illuminate\Support\Facades\DB;

class NotificationRepository
{
    public function queueInvoiceEmail(int $userId, int $invoiceId, ?string $invoiceCode = null, int $templateId = 1): int
    {
        return DB::table('notifications')->insertGetId([
            'user_id' => $userId,
            'invoice_id' => $invoiceId,
            'invoice_code' => $invoiceCode,
            'notification_type' => 'email',
            'template_id' => $templateId,
            'is_read' => 'N',
            'processing_status' => 'pending',
            'cron_start_datetime' => null,
            'cron_end_datetime' => null,
            'processing_log' => null,
        ]);
    }
}
