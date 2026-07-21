<?php

namespace App\Http\Controllers;

use App\Actions\Invoice\BulkDeleteInvoiceAction;
use App\Actions\Invoice\CreateInvoiceAction;
use App\Actions\Invoice\DeleteInvoiceAction;
use App\Actions\Invoice\DownloadInvoicePdfAction;
use App\Actions\Invoice\QueueInvoiceEmailAction;
use App\Actions\Invoice\RecordPaymentAction;
use App\Actions\Invoice\UpdateInvoiceAction;
use App\Http\Requests\Invoice\BulkDeleteInvoiceRequest;
use App\Http\Requests\Invoice\QueueEmailRequest;
use App\Http\Requests\Invoice\RecordPaymentRequest;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Services\Invoice\InvoiceFilterService;
use App\Services\Invoice\InvoiceService as InvoiceModuleService;
use App\Services\Invoice\InvoiceTemplateService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request, InvoiceFilterService $filterService)
    {
        $data = $filterService->getIndexData($request);

        return view('pages/invoice.list', compact('data'));
    }

    public function getRecordPaymentForm(Request $request, InvoiceModuleService $invoiceService)
    {
        $data = $invoiceService->getPaymentFormData($request->input('invoice_code'));

        if (empty($data)) {
            return response('<div class="alert alert-danger m-3">Invoice not found.</div>', 200);
        }

        return view('pages/invoice.payment', compact('data'));
    }

    public function recordPayment(RecordPaymentRequest $request, RecordPaymentAction $action)
    {
        $result = $action->handle($request);

        return response()->json($result, 200);
    }

    public function create(Request $request, InvoiceModuleService $invoiceService)
    {
        $data = $invoiceService->getCreateData();

        return view('pages/invoice.add', compact('data'));
    }

    public function edit(Request $request, $invoice_code, InvoiceModuleService $invoiceService)
    {
        $data = $invoiceService->getEditData($invoice_code);

        if (empty($data)) {
            return abort(404);
        }

        return view('pages/invoice.edit', compact('data'));
    }

    public function store(StoreInvoiceRequest $request, CreateInvoiceAction $action)
    {
        $result = $action->handle($request);

        return response()->json($result, 200);
    }

    public function update(UpdateInvoiceRequest $request, UpdateInvoiceAction $action)
    {
        $result = $action->handle($request);

        return response()->json($result, 200);
    }

    public function viewModel(Request $request, InvoiceTemplateService $templateService)
    {
        $html = $templateService->renderInvoiceHtml($request->input('invoice_code'));

        if ($html === null) {
            return response()->json([
                'error' => 1,
                'html' => '<div class="alert alert-danger m-3">Invoice template not found.</div>',
                'message' => 'Invoice template not found.',
            ], 200);
        }

        return response()->json([
            'error' => 0,
            'html' => $html,
            'message' => 'Invoice preview generated successfully.',
        ]);
    }

    public function shortcode($invoice_code)
    {
        return response()->json([
            'error' => 0,
            'data' => getShortcode('invoice', $invoice_code),
        ]);
    }

    public function downloadMultiple(Request $request, DownloadInvoicePdfAction $action)
    {
        $invoiceCodes = $request->input('invoices_code');

        if (empty($invoiceCodes) || !is_array($invoiceCodes)) {
            return back()->with('error', 'No invoices selected.');
        }

        return $action->downloadMultiple($invoiceCodes);
    }

    public function invoiceDownload(Request $request, $invoice_code, DownloadInvoicePdfAction $action)
    {
        return $action->download($invoice_code, $request->input('preview') === 'true');
    }

    public function bulkDelete(BulkDeleteInvoiceRequest $request, BulkDeleteInvoiceAction $action)
    {
        $result = $action->handle($request);

        return response()->json($result, 200);
    }

    public function destroy(Request $request, DeleteInvoiceAction $action)
    {
        $result = $action->handle((string) $request->input('invoice_code'));

        return response()->json($result, 200);
    }

    public function queueEmail(QueueEmailRequest $request, QueueInvoiceEmailAction $action)
    {
        $result = $action->handle($request);

        return response()->json($result, 200);
    }
}
