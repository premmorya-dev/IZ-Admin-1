<?php

namespace App\Services\Invoice;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class InvoicePdfService
{
    public function __construct(
        protected InvoiceTemplateService $templateService
    ) {
    }

    public function download(string $invoiceCode, bool $preview = false)
    {
        $html = $this->templateService->renderInvoiceHtml($invoiceCode);

        if ($html === null) {
            abort(404);
        }

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        if ($preview) {
            return $pdf->stream($invoiceCode . '.pdf', ['Attachment' => false]);
        }

        return $pdf->download(time() . '_' . $invoiceCode . '.pdf');
    }

    public function downloadMultiple(array $invoiceCodes)
    {
        if (empty($invoiceCodes)) {
            return back()->with('error', 'No invoices selected.');
        }

        $zipFileName = 'invoices_' . time() . '.zip';
        $zipPath = storage_path("app/public/{$zipFileName}");

        if (!is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return back()->with('error', 'Unable to create ZIP file.');
        }

        $addedFiles = 0;

        foreach ($invoiceCodes as $invoiceCode) {
            $invoiceExists = DB::table('invoices')
                ->where('invoice_code', $invoiceCode)
                ->where('user_id', auth()->id())
                ->exists();

            if (! $invoiceExists) {
                continue;
            }

            $html = $this->templateService->renderInvoiceHtml($invoiceCode);

            if ($html === null) {
                continue;
            }

            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setWarnings(false)
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);

            $pdfContent = $pdf->output();
            $fileName = $invoiceCode . '.pdf';

            if ($zip->locateName($fileName) !== false) {
                $fileName = $invoiceCode . '_' . uniqid() . '.pdf';
            }

            $zip->addFromString($fileName, $pdfContent);
            $addedFiles++;
        }

        $zip->close();

        if ($addedFiles === 0) {
            @unlink($zipPath);
            return back()->with('error', 'No valid invoices were found.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
