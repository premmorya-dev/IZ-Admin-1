<h1 style="text-align:center; margin-top:20px;">ITC Statement</h1>

<div style="margin-top:30px; overflow-x:auto;">
    <table align="left" style="width:100%; border-collapse:collapse; border:1px solid #ccc; text-align:left;">
        <thead>
            <tr style="background-color:#f5f5f5;">
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">#</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">Bill #</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">Date</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">Grand Total</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">Input Tax Credit</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($bills as $key => $bill)
            <tr>
                <td align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ $key + 1 }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ $bill->bill_number }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ $bill->bill_date }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ number_format($bill->grand_total, 2) }}</td>
                <td align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ number_format($bill->total_tax, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">
                    No ITC found for the selected criteria.
                </td>
            </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr style="background-color:#f5f5f5;">
                <th colspan="3" align="left" style="border:1px solid #ccc; padding:8px; text-align:center;">Total</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ number_format($summary['total_grand'], 2) }}</th>
                <th align="left" style="border:1px solid #ccc; padding:8px; text-align:left;">{{ number_format($summary['total_tax'], 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
