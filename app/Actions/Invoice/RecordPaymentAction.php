<?php

namespace App\Actions\Invoice;

use App\Http\Requests\Invoice\RecordPaymentRequest;
use App\Services\Invoice\InvoicePaymentService;
use Throwable;

class RecordPaymentAction
{
    public function __construct(
        protected InvoicePaymentService $paymentService
    ) {
    }

    public function handle(RecordPaymentRequest $request): array
    {
        try {
            $this->paymentService->recordPayment((int) $request->input('invoice_id'), auth()->id(), [
                'amount' => $request->input('amount'),
                'payment_date' => $request->input('payment_date'),
                'payment_method' => $request->input('payment_method'),
                'transaction_reference' => $request->input('transaction_reference'),
                'notes' => $request->input('notes'),
            ]);

            return [
                'status' => 200,
                'error' => 0,
                'message' => 'Payment recorded successfully!',
            ];
        } catch (Throwable $e) {
            logger()->error('Invoice payment failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'error' => 1,
                'errors' => [
                    'general' => ['Something went wrong while recording the payment.'],
                ],
                'message' => 'Something went wrong while recording the payment.',
            ];
        }
    }
}
