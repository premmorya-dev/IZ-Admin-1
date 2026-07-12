<?php

namespace App\Actions\Invoice;

use App\Repositories\Invoice\InvoiceRepository;
use Throwable;

class DeleteInvoiceAction
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    public function handle(string $invoiceCode): array
    {
        try {
            $deleted = $this->invoiceRepository->deleteForUserByCode($invoiceCode, auth()->id());

            return [
                'status' => 200,
                'error' => $deleted > 0 ? 0 : 1,
                'message' => $deleted > 0 ? 'Invoice deleted successfully.' : 'Invoice not found.',
            ];
        } catch (Throwable $e) {
            logger()->error('Invoice delete failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Error deleting invoice.'],
                ],
                'message' => 'Error deleting invoice.',
            ];
        }
    }
}
