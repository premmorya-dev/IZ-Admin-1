<?php

namespace App\Actions\Invoice;

use App\DTO\Invoice\InvoiceData;
use App\DTO\Invoice\RecurringInvoiceData;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Repositories\Invoice\InvoiceRepository;
use App\Services\Invoice\InvoiceCodeService;
use App\Services\Invoice\InvoiceNotificationService;
use App\Services\Invoice\InvoiceRecurringService;
use App\Services\Invoice\InvoiceStockService;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Services\Invoice\DocumentSequenceService;

class CreateInvoiceAction
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected InvoiceCodeService $codeService,
        protected InvoiceStockService $stockService,
        protected InvoiceRecurringService $recurringService,
        protected InvoiceNotificationService $notificationService,
        protected DocumentSequenceService $documentSequenceService
    ) {}

    public function handle(StoreInvoiceRequest $request): array
    {
        try {
            $userId = auth()->id();
            $invoiceData = InvoiceData::fromRequest($request, $userId);
            $normalizedItems = $invoiceData->items;

            $invoice = DB::transaction(function () use ($invoiceData, $normalizedItems, $userId, $request) {
                $invoice = $this->invoiceRepository->create(
                    $invoiceData->toCreateAttributes($this->codeService->generate())
                );

                $this->documentSequenceService->generate(auth()->id(), 'invoice');

                $this->stockService->reduceForItems($userId, $normalizedItems);

                $recurringData = RecurringInvoiceData::fromRequest($request);
                if ($recurringData !== null) {
                    $this->recurringService->syncForInvoice($invoice->invoice_id, $userId, $recurringData);
                }

                if ($invoiceData->sendStatus) {
                    $this->notificationService->queueEmail($userId, $invoice->invoice_id, $invoice->invoice_code);
                    $this->invoiceRepository->markAsSubmitted($invoice->invoice_id);
                }

                return $invoice;
            });

            return [
                'status' => 200,
                'error' => 0,
                'message' => 'Invoice Saved Successfully!',
                'invoice_code' => $invoice->invoice_code,
            ];
        } catch (Throwable $e) {
            logger()->error('Invoice create failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Something went wrong while saving the invoice.'],
                ],
                'message' => 'Something went wrong while saving the invoice.',
            ];
        }
    }
}
