<h1 style="text-align:center; margin-top:20px;">Bill Statement</h1>

<div style="margin-top:30px; overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
        <thead>
            <tr style="background-color:#f5f5f5;">
                <th align="left" style="border:1px solid #ccc; padding:8px;">#</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Bill #</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Date</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Status</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Currency</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Subtotal</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Tax</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Discount</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">Grand Total</th>       
                <th align="left" style="border:1px solid #ccc; padding:8px;">Total Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $key => $bill)
            <tr>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ $key + 1 }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ $bill->bill_number }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ $bill->bill_date }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ ucfirst($bill->bill_status) }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ $bill->currency_code }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($bill->sub_total, 2) }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($bill->total_tax, 2) }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($bill->total_discount, 2) }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($bill->grand_total, 2) }}</td>          
                <td align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($bill->total_due, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" align="left" style="border:1px solid #ccc; padding:8px; text-align:center;">
                    No bills found for the selected criteria.
                </td>
            </tr>
            @endforelse
        </tbody>
       
       
        <tfoot>
            <tr style="background-color:#f5f5f5;">
                <th colspan="5" align="left" style="border:1px solid #ccc; padding:8px; text-align:center;">Total</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_sub_total'], 2) }}</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_tax'], 2) }}</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_discount'], 2) }}</th>
                <th align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_grand'], 2) }}</th>          
                <th align="left" style="border:1px solid #ccc; padding:8px;">{{ number_format($summary['total_due'], 2) }}</th>
            </tr>
        </tfoot>



    </table>
</div>
