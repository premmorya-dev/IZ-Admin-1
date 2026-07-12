<?php

namespace App\Services\Invoice;

use App\Models\InvoiceModel;

class InvoiceCodeService
{
    public function generate(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (InvoiceModel::where('invoice_code', $code)->exists());

        return $code;
    }
}
