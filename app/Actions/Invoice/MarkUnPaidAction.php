<?php

namespace App\Actions\Invoice;

use Illuminate\Support\Facades\DB;


use Throwable;

class MarkUnPaidAction
{


    public function handle($invoice_code): array
    {

        try {

            DB::transaction(function () use ($invoice_code) {

                $paymentIds = DB::table('invoices')
                    ->select('invoices.invoice_id', 'invoice_payments.invoice_payment_id')
                    ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', 'invoices.invoice_id')
                    ->where('invoices.invoice_code', $invoice_code)
                    ->where('invoices.user_id', auth()->id())
                    ->pluck('invoice_payment_id');

                if ($paymentIds->isNotEmpty()) {
                    DB::table('invoice_payments')
                        ->whereIn('invoice_payment_id', $paymentIds)
                        ->where('invoice_payments.user_id', auth()->id())
                        ->delete();
                }

                $invoice = DB::table('invoices')
                    ->select('invoice_id', 'grand_total', 'round_off')
                    ->where('invoices.invoice_code', $invoice_code)
                    ->where('invoices.user_id', auth()->id())
                    ->first();

                $invoice_total = $invoice->grand_total + $invoice->round_off;

                DB::table('invoices')
                    ->where('invoice_code', $invoice_code)
                    ->update([
                        'status' => 'pending',
                        'updated_at'     => now(),
                        'total_due'     => $invoice_total,
                    ]);
            });

            return [
                'status' => 200,
                'error' => 0,
                'message' => 'Marked UnPaid Successfully!',
            ];
        } catch (Throwable $e) {

            logger()->error('Invoice marked unpaid failed: ' . $e->getMessage(), [
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
