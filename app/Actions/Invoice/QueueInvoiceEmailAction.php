<?php

namespace App\Actions\Invoice;

use App\Http\Requests\Invoice\QueueEmailRequest;
use App\Repositories\Invoice\InvoiceRepository;
use App\Services\Invoice\InvoiceNotificationService;
use Throwable;

class QueueInvoiceEmailAction
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected InvoiceNotificationService $notificationService
    ) {}

    public function handle(QueueEmailRequest $request): array
    {
        try {
            $queued = 0;

            foreach ($request->input('invoices_code', []) as $invoiceCode) {
                $invoice = $this->invoiceRepository->findForUserByCode($invoiceCode, auth()->id());

                if (! $invoice) {
                    continue;
                }

                $this->notificationService->queueEmail(auth()->id(), $invoice->invoice_id, $invoiceCode);
                $this->invoiceRepository->markAsSubmitted($invoice->invoice_id);
                $queued++;
            }


            if ($queued > 0) {
                session()->flash('success', 'Email queued successfully.');
            } else {
                session()->flash('warning', 'No invoices were queued.');
            }

            return [
                'status' => 200,
                'error' => $queued > 0 ? 0 : 1,
                'message' => $queued > 0 ? 'Email queued successfully.' : 'No invoices were queued.',
                'queued' => $queued,
            ];
        } catch (Throwable $e) {
            logger()->error('Invoice email queue failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Something went wrong while queueing emails.'],
                ],
                'message' => 'Something went wrong while queueing emails.',
            ];
        }
    }
}
