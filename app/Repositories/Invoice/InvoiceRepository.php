<?php

namespace App\Repositories\Invoice;

use App\Models\InvoiceModel;
use Illuminate\Support\Facades\DB;

class InvoiceRepository
{
    public function create(array $attributes): InvoiceModel
    {
        return InvoiceModel::create($attributes);
    }

    public function update(InvoiceModel $invoice, array $attributes): InvoiceModel
    {
        $invoice->update($attributes);

        return $invoice->refresh();
    }

    public function findForUserByCode(string $invoiceCode, int $userId): ?InvoiceModel
    {
        return InvoiceModel::where('invoice_code', $invoiceCode)
            ->where('user_id', $userId)
            ->first();
    }

    public function findForUserById(int $invoiceId, int $userId): ?InvoiceModel
    {
        return InvoiceModel::where('invoice_id', $invoiceId)
            ->where('user_id', $userId)
            ->first();
    }

    public function deleteForUserByCode(string $invoiceCode, int $userId): int
    {
        return InvoiceModel::where('invoice_code', $invoiceCode)
            ->where('user_id', $userId)
            ->delete();
    }

    public function deleteForUserByCodes(array $invoiceCodes, int $userId): int
    {
        return InvoiceModel::whereIn('invoice_code', $invoiceCodes)
            ->where('user_id', $userId)
            ->delete();
    }

    public function markAsSubmitted(int $invoiceId): void
    {
        DB::table('invoices')
            ->where('invoice_id', $invoiceId)
            ->update(['is_sent' => 'submitted']);
    }

    public function markAsPaid(int $invoiceId): void
    {
        DB::table('invoices')
            ->where('invoice_id', $invoiceId)
            ->update([
                'status' => 'paid',
                'is_paid' => 'Y',
                'paid_at' => now('UTC')->format('Y-m-d H:i:s'),
            ]);
    }

    public function updateInvoiceTotals(int $invoiceId, array $attributes): void
    {
        DB::table('invoices')
            ->where('invoice_id', $invoiceId)
            ->update($attributes);
    }

    public function getRecurringInvoice(int $invoiceId, int $userId): ?object
    {
        return DB::table('recurring_invoices')
            ->where('invoice_id', $invoiceId)
            ->where('user_id', $userId)
            ->first();
    }

    public function upsertRecurringInvoice(int $invoiceId, int $userId, array $attributes): void
    {
        DB::table('recurring_invoices')->updateOrInsert(
            [
                'invoice_id' => $invoiceId,
                'user_id' => $userId,
            ],
            $attributes
        );
    }

    public function deleteRecurringInvoice(int $invoiceId, int $userId): void
    {
        DB::table('recurring_invoices')
            ->where('invoice_id', $invoiceId)
            ->where('user_id', $userId)
            ->delete();
    }
}
