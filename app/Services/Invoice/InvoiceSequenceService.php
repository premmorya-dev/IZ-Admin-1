<?php

namespace App\Services\Invoice;

use App\Models\InvoiceSequence;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class InvoiceSequenceService
{
    /**
     * Get user sequence or create default.
     */
    public function getOrCreate(int $userId): InvoiceSequence
    {
        return InvoiceSequence::firstOrCreate(
            ['user_id' => $userId],
            [
                'prefix'      => 'INV-',
                'padding'     => 4,
                'start_from'  => 1,
                'next_number' => 1,
            ]
        );
    }

    /**
     * Update invoice numbering settings.
     */
    public function update(int $userId, array $data): InvoiceSequence
    {
        $sequence = $this->getOrCreate($userId);

        $sequence->update([
            'prefix'  => $data['prefix'],
            'padding' => $data['padding'],
        ]);

        /**
         * Agar abhi tak koi invoice generate nahi hua
         * tabhi Start From change karne do.
         */
     
        $invoiceExists = Invoice::where('user_id', $userId)->exists();

        if (!$invoiceExists && isset($data['start_from'])) {
            $sequence->update([
                'start_from'  => $data['start_from'],
                'next_number' => $data['start_from'],
            ]);
        }

        return $sequence->fresh();
    }

    /**
     * Generate next invoice number.
     *
     * Race condition safe.
     */
    public function generateInvoiceNumber(int $userId): string
    {
        return DB::transaction(function () use ($userId) {

            $sequence = InvoiceSequence::where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {

                $sequence = InvoiceSequence::create([
                    'user_id'     => $userId,
                    'prefix'      => 'INV-',
                    'padding'     => 4,
                    'start_from'  => 1,
                    'next_number' => 1,
                ]);

                $sequence = InvoiceSequence::where('sequence_id', $sequence->sequence_id)
                    ->lockForUpdate()
                    ->first();
            }

            $invoiceNumber = $this->format(
                $sequence->prefix,
                $sequence->padding,
                $sequence->next_number
            );

            $sequence->increment('next_number');

            return $invoiceNumber;
        });
    }

    /**
     * Preview next invoice number.
     */
    public function preview(int $userId): string
    {
        $sequence = $this->getOrCreate($userId);

        return $this->format(
            $sequence->prefix,
            $sequence->padding,
            $sequence->next_number
        );
    }

    /**
     * Format invoice number.
     *
     * Example:
     * INV-0001
     */
    private function format(
        string $prefix,
        int $padding,
        int $number
    ): string {

        return $prefix .
            str_pad(
                $number,
                $padding,
                '0',
                STR_PAD_LEFT
            );
    }
}
