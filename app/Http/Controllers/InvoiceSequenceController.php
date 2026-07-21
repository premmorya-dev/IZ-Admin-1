<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceSequenceRequest;
use App\Http\Requests\UpdateInvoiceSequenceRequest;
use App\Services\InvoiceSequenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceSequenceController extends Controller
{
    /**
     * @var InvoiceSequenceService
     */
    protected InvoiceSequenceService $invoiceSequenceService;

    /**
     * Constructor.
     */
    public function __construct(InvoiceSequenceService $invoiceSequenceService)
    {
        $this->invoiceSequenceService = $invoiceSequenceService;
    }

    /**
     * Display invoice numbering settings.
     */
    public function index(): View
    {
        $sequence = $this->invoiceSequenceService
            ->getOrCreate(auth()->id());

        return view('invoice-sequences.index', compact('sequence'));
    }

    /**
     * Show edit form.
     */
    public function edit(): View
    {
        $sequence = $this->invoiceSequenceService
            ->getOrCreate(auth()->id());

        return view('invoice-sequences.edit', compact('sequence'));
    }

    /**
     * Store sequence (only first time).
     */
    public function store(StoreInvoiceSequenceRequest $request): RedirectResponse
    {
        $this->invoiceSequenceService->store(
            auth()->id(),
            $request->validated()
        );

        return redirect()
            ->route('invoice-sequences.index')
            ->with('success', 'Invoice numbering settings saved successfully.');
    }

    /**
     * Update sequence.
     */
    public function update(UpdateInvoiceSequenceRequest $request): RedirectResponse
    {
        $this->invoiceSequenceService->update(
            auth()->id(),
            $request->validated()
        );

        return redirect()
            ->route('invoice-sequences.index')
            ->with('success', 'Invoice numbering settings updated successfully.');
    }
}