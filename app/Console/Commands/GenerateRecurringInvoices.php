<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\RecurringInvoice;
use App\Models\InvoiceModel;

class GenerateRecurringInvoices extends Command
{
    protected $signature = 'invoices:generate-recurring';
    protected $description = 'Generate invoices for active recurring schedules';

    public function handle()
    {
        $now = Carbon::now(); // Current date and time

        // Fetch all active recurring records
        $recurringList = DB::table('recurring_invoices')
            ->where('status', 'active')
            ->get();



        foreach ($recurringList as $recurring) {
            $shouldGenerate = false;

            $lastGenerated = $recurring->last_generated_at
                ? Carbon::parse($recurring->last_generated_at)
                : null;


            // dd(   $now->format('H:i') );
            // Ensure time matches
            $scheduledTime = Carbon::parse($recurring->time_of_day);
            if (
                $now->format('H:i') !== $scheduledTime->format('H:i')
            ) {
                continue;
            }

            // Handle scheduling logic
            switch ($recurring->frequency) {
                case 'weekly':
                    if (strtolower($now->format('l')) === $recurring->day_of_week) {
                        $shouldGenerate = true;
                    }
                    break;

                case 'monthly':
                    if ((int)$now->format('j') === (int)$recurring->day_of_month) {
                        $shouldGenerate = true;
                    }
                    break;

                case 'yearly':
                    if (
                        (int)$now->format('n') === (int)$recurring->month_of_year &&
                        (int)$now->format('j') === (int)$recurring->day_of_month
                    ) {
                        $shouldGenerate = true;
                    }
                    break;
            }


            // Avoid duplicate generation on same day
            if ($shouldGenerate && (! $lastGenerated || $lastGenerated->toDateString() !== $now->toDateString())) {
                $this->generateInvoice($recurring);
                $this->info("Invoice generated for recurring ID: {$recurring->recurring_id}");
            }
        }
    }

    protected function generateInvoice($recurring)
    {
        $originalInvoice = DB::table('invoices')->where('invoice_id', $recurring->invoice_id)->first();

        if (!$originalInvoice) {
            return;
        }

        // Clone invoice record
        $newInvoiceId = DB::table('invoices')->insertGetId([
            'user_id'         => $originalInvoice->user_id,
            'client_id'       => $originalInvoice->client_id,
            'invoice_number'  => $this->generateInvoiceNumber(),
            'invoice_code'    => $this->generateUniqueInvoiceCode(),
            'invoice_date'    => now()->toDateString(),
            'due_date'        => now()->addDays(7)->toDateString(),
            'status'          => 'pending',
            'sub_total'       => $originalInvoice->sub_total,
            'total_tax'       => $originalInvoice->total_tax,
            'total_discount'  => $originalInvoice->total_discount,
            'grand_total'     => $originalInvoice->grand_total,
            'advance_payment' => $originalInvoice->advance_payment,
            'total_due'       => $originalInvoice->total_due,
            'currency_code'   => $originalInvoice->currency_code,
            'item_json'       => $originalInvoice->item_json,
            'upi_id'          => $originalInvoice->upi_id,
            'template_id'     => $originalInvoice->template_id,

            'notes'     => $originalInvoice->notes,
            'terms'     => $originalInvoice->terms,
            'is_sent'         => 'pending',
            'is_paid'         => 'N',
            'is_overdue'      => 'N',
            'is_cancelled'    => 'N',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Update last_generated_at
        DB::table('recurring_invoices')
            ->where('recurring_id', $recurring->recurring_id)
            ->update(['last_generated_at' => now()]);
    }



    protected   function generateInvoiceNumber()
    {
        $prefix = setting('invoice_prefix') ?? 'INV';
        $formattedDate = now()->format('YmdHi');

        do {
            $random = rand(1000, 9999);
            $invoice_number = "{$prefix}-{$formattedDate}-{$random}";
        } while (InvoiceModel::where('invoice_number', $invoice_number)->exists());

        return $invoice_number;
    }



    private function generateUniqueInvoiceCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\InvoiceModel::where('invoice_code', $code)->exists());

        return $code;
    }
}
