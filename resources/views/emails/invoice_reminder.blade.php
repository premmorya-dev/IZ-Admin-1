<p>Dear {{ $invoice->client_name ?? 'Customer' }},</p>

@if ($type === 'before_due')
    <p>This is a friendly reminder that your invoice <strong>#{{ $invoice->invoice_number }}</strong> is due on <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</strong>.</p>
@elseif ($type === 'after_due')
    <p>This is a reminder that your invoice <strong>#{{ $invoice->invoice_number }}</strong> was due on <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</strong> and is still unpaid.</p>
@endif

<p>Total Amount Due: <strong>{{ $invoice->currency_code }} {{ number_format($invoice->total_due, 2) }}</strong></p>

<p>Please make the payment at your earliest convenience.</p>

<p>Thanks,<br>Invoicezy Team</p>
