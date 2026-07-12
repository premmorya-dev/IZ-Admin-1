<?php

namespace App\Actions\Invoice;

use App\Services\Invoice\InvoicePdfService;

class DownloadInvoicePdfAction
{
    public function __construct(
        protected InvoicePdfService $pdfService
    ) {
    }

    public function download(string $invoiceCode, bool $preview = false)
    {
        return $this->pdfService->download($invoiceCode, $preview);
    }

    public function downloadMultiple(array $invoiceCodes)
    {
        return $this->pdfService->downloadMultiple($invoiceCodes);
    }
}
