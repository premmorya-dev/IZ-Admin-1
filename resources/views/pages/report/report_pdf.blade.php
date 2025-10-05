<h1 style="text-align:center; margin-top:20px;">Statement</h1>

<div style="margin-top:30px; overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
        <thead>
            <tr style="background-color:#f5f5f5;">
                <th style="border:1px solid #ccc; padding:8px;">#</th>
                <th style="border:1px solid #ccc; padding:8px;">Invoice #</th>
                <th style="border:1px solid #ccc; padding:8px;">Date</th>
                <th style="border:1px solid #ccc; padding:8px;">Status</th>
                <th style="border:1px solid #ccc; padding:8px;">Currency</th>
                <th style="border:1px solid #ccc; padding:8px;">Subtotal</th>
                <th style="border:1px solid #ccc; padding:8px;">Tax</th>
                <th style="border:1px solid #ccc; padding:8px;">Discount</th>
                <th style="border:1px solid #ccc; padding:8px;">Grand Total</th>
                <th style="border:1px solid #ccc; padding:8px;">Advance</th>
                <th style="border:1px solid #ccc; padding:8px;">Total Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $key => $invoice)
            <tr>
                <td style="border:1px solid #ccc; padding:8px;">{{ $key + 1 }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ $invoice->invoice_number }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ $invoice->invoice_date }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ ucfirst($invoice->status) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ $invoice->currency_code }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->sub_total, 2) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->total_tax, 2) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->total_discount, 2) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->grand_total, 2) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->advance_payment, 2) }}</td>
                <td style="border:1px solid #ccc; padding:8px;">{{ number_format($invoice->total_due, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="border:1px solid #ccc; padding:8px; text-align:center;">
                    No invoices found for the selected criteria.
                </td>
            </tr>
            @endforelse
        </tbody>
       
       
        <tfoot>
            <tr style="background-color:#f5f5f5;">
                <th colspan="5" style="border:1px solid #ccc; padding:8px; text-align:right;">Total</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_sub_total'], 2) }}</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_tax'], 2) }}</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_discount'], 2) }}</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_grand'], 2) }}</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_advance'], 2) }}</th>
                <th style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_due'], 2) }}</th>
            </tr>
        </tfoot>



    </table>
</div>
