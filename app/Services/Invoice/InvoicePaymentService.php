<?php

namespace App\Services\Invoice;

use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\PaymentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoicePaymentService
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    public function recordPayment(int $invoiceId, int $userId, array $payload)
    {
        return DB::transaction(function () use ($invoiceId, $userId, $payload) {
            $payment = $this->paymentRepository->create([
                'invoice_id' => $invoiceId,
                'user_id' => $userId,
                'amount' => $payload['amount'],
                'payment_date' => $payload['payment_date'],
                'payment_method' => $payload['payment_method'],
                'transaction_reference' => $payload['transaction_reference'] ?? null,
                'notes' => $payload['notes'] ?? null,
            ]);

            $invoice = $this->invoiceRepository->findForUserById($invoiceId, $userId);

            if ($invoice) {
                $remaining = max(0, (float) $invoice->total_due - (float) $payload['amount']);
                $advancePayment = (float) ($invoice->advance_payment ?? 0) + (float) $payload['amount'];

                $update = [
                    'total_due' => $remaining,
                    'advance_payment' => $advancePayment,
                ];

                if ($remaining <= 0) {
                    $update['status'] = 'paid';
                    $update['is_paid'] = 'Y';
                    $update['paid_at'] = Carbon::now('UTC')->format('Y-m-d H:i:s');
                }

                $this->invoiceRepository->updateInvoiceTotals($invoiceId, $update);
            }

            return $payment;
        });
    }
}
