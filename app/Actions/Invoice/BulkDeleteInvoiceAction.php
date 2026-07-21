<?php

namespace App\Actions\Invoice;

use App\Http\Requests\Invoice\BulkDeleteInvoiceRequest;
use App\Repositories\Invoice\InvoiceRepository;
use Throwable;

class BulkDeleteInvoiceAction
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    public function handle(BulkDeleteInvoiceRequest $request): array
    {
        try {
            $deleted = $this->invoiceRepository->deleteForUserByCodes($request->input('invoices_code', []), auth()->id());

            return [
                'status' => 200,
                'error' => $deleted > 0 ? 0 : 1,
                'message' => $deleted > 0 ? 'Invoices deleted successfully.' : 'No invoices were deleted.',
            ];
        } catch (Throwable $e) {
            logger()->error('Bulk invoice delete failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Error deleting invoices.'],
                ],
                'message' => 'Error deleting invoices.',
            ];
        }
    }
}
