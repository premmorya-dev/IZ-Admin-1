<?php

namespace App\Actions\Invoice;

use App\DTO\Invoice\InvoiceData;
use App\DTO\Invoice\RecurringInvoiceData;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\PaymentModel;
use App\Repositories\Invoice\InvoiceRepository;
use App\Services\Invoice\InvoiceNotificationService;
use App\Services\Invoice\InvoicePaymentService;
use App\Services\Invoice\InvoiceRecurringService;
use App\Services\Invoice\InvoiceStockService;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateInvoiceAction
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected InvoiceStockService $stockService,
        protected InvoiceRecurringService $recurringService,
        protected InvoiceNotificationService $notificationService,
        protected InvoicePaymentService $paymentService
    ) {
    }

    public function handle(UpdateInvoiceRequest $request): array
    {
        try {
            $userId = auth()->id();
            $invoice = $this->invoiceRepository->findForUserByCode($request->input('invoice_code'), $userId);

            if (! $invoice) {
                return [
                    'status' => 404,
                    'error' => 1,
                    'message' => 'Invoice not found.',
                ];
            }

            $invoiceData = InvoiceData::fromRequest($request, $userId);
            $oldItems = json_decode($invoice->item_json, true) ?: [];
            $newItems = $invoiceData->items;

            DB::transaction(function () use ($invoice, $invoiceData, $userId, $request, $oldItems, $newItems) {
                $this->invoiceRepository->update($invoice, $invoiceData->toUpdateAttributes());

                $this->stockService->syncForUpdate($userId, $oldItems, $newItems);

                $recurringData = RecurringInvoiceData::fromRequest($request);
                $this->recurringService->syncForInvoice($invoice->invoice_id, $userId, $recurringData);

                if ($invoiceData->sendStatus) {
                    $this->notificationService->queueEmail($userId, $invoice->invoice_id, $invoice->invoice_code);
                    $this->invoiceRepository->markAsSubmitted($invoice->invoice_id);
                }

                if ($invoiceData->paidStatus) {
                    $paidAmount = (float) $invoiceData->totalDue;

                    if ($paidAmount > 0) {
                        $this->paymentService->recordPayment($invoice->invoice_id, $userId, [
                            'amount' => $paidAmount,
                            'payment_date' => now('UTC')->format('Y-m-d'),
                            'payment_method' => 'cash',
                            'transaction_reference' => 'manual payment',
                            'notes' => $invoiceData->notes,
                        ]);
                    } else {
                        $this->invoiceRepository->markAsPaid($invoice->invoice_id);
                    }
                }
            });

            return [
                'status' => 200,
                'error' => 0,
                'message' => 'Invoice Updated Successfully!',
            ];
        } catch (Throwable $e) {
            logger()->error('Invoice update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Something went wrong while updating the invoice.'],
                ],
                'message' => 'Something went wrong while updating the invoice.',
            ];
        }
    }
}
