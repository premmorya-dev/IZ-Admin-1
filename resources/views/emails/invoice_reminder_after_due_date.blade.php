<p>Dear {{ $invoice->client_name ?? 'Customer' }},</p>

<p>This is a reminder that your invoice <strong>#{{ $invoice->invoice_number }}</strong> was due on <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</strong> and is still unpaid.</p>


<p>Total Amount Due: <strong>{{ $invoice->currency_code }} {{ number_format($invoice->total_due, 2) }}</strong></p>

<p>Please make the payment at your earliest convenience.</p>

<p>
    Thanks,<br>
    {{ $invoice->company_name ? $invoice->company_name : $invoice->first_name . ' ' . $invoice->last_name }}
</p>
