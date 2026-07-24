<?php

namespace App\Services\Invoice;

use App\Models\DocumentSequence;
use Illuminate\Support\Facades\DB;

class DocumentSequenceService
{
    /**
     * Default configuration.
     */
    private array $defaults = [
        'invoice' => [
            'prefix' => 'INV-',
            'padding' => 4,
            'start_from' => 1,
        ],
        'estimate' => [
            'prefix' => 'EST-',
            'padding' => 4,
            'start_from' => 1,
        ],
        'bill' => [
            'prefix' => 'BILL-',
            'padding' => 4,
            'start_from' => 1,
        ],
    ];

    /**
     * Get sequence or create default.
     */
    public function getOrCreate(int $userId, string $documentType): DocumentSequence
    {
        $default = $this->defaults[$documentType] ?? [
            'prefix' => strtoupper(substr($documentType, 0, 3)) . '-',
            'padding' => 4,
            'start_from' => 1,
        ];

        return DocumentSequence::firstOrCreate(
            [
                'user_id' => $userId,
                'document_type' => $documentType,
            ],
            [
                'prefix'      => $default['prefix'],
                'padding'     => $default['padding'],
                'start_from'  => $default['start_from'],
                'next_number' => $default['start_from'],
            ]
        );
    }

    /**
     * Update numbering settings.
     */
    public function update(int $userId, string $documentType, array $data): DocumentSequence
    {
        $sequence = $this->getOrCreate($userId, $documentType);

        $exists = DB::table("invoicezy_{$documentType}s")
            ->where('user_id', $userId)
            ->exists();

        $update = [
            'prefix'  => $data['prefix'],
            'padding' => $data['padding'],
        ];

        if (!$exists && isset($data['start_from'])) {
            $update['start_from'] = $data['start_from'];
            $update['next_number'] = $data['start_from'];
        }

        $sequence->update($update);

        return $sequence->fresh();
    }

    /**
     * Generate document number.
     */
    public function generate(int $userId, string $documentType): string
    {
        return DB::transaction(function () use ($userId, $documentType) {

            $sequence = DocumentSequence::where('user_id', $userId)
                ->where('document_type', $documentType)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                $sequence = $this->getOrCreate($userId, $documentType);

                $sequence = DocumentSequence::whereKey($sequence->sequence_id)
                    ->lockForUpdate()
                    ->first();
            }

            $number = $this->format(
                $sequence->prefix,
                $sequence->padding,
                $sequence->next_number
            );

            $sequence->increment('next_number');

            return $number;
        });
    }

    /**
     * Preview next document number.
     */
    public function preview(int $userId, string $documentType): string
    {
        $sequence = $this->getOrCreate($userId, $documentType);

        return $this->format(
            $sequence->prefix,
            $sequence->padding,
            $sequence->next_number
        );
    }

    /**
     * Reset sequence.
     */
    public function reset(int $userId, string $documentType, int $startFrom): DocumentSequence
    {
        $sequence = $this->getOrCreate($userId, $documentType);

        $sequence->update([
            'start_from' => $startFrom,
            'next_number' => $startFrom,
        ]);

        return $sequence->fresh();
    }

    /**
     * Format number.
     */
    private function format(string $prefix, int $padding, int $number): string
    {
        return $prefix . str_pad($number, $padding, '0', STR_PAD_LEFT);
    }
}