<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center p-2 px-5" style="min-height: 60px;">
        <h1 class="h5 m-0"><strong>Bill Summary</strong></h1>
        <a href="{{ route('download.report') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="download"></i>  Download</a>
    </div>


    <div class="card-body">
        <p><strong>Total Bills:</strong> {{ $summary['total_bills'] }}</p>
        <p><strong>Subtotal:</strong> {{ number_format($summary['total_sub_total'], 2) }}</p>
        <p><strong>Total Tax:</strong> {{ number_format($summary['total_tax'], 2) }}</p>
        <p><strong>Total Discount:</strong> {{ number_format($summary['total_discount'], 2) }}</p>
        <p><strong>Grand Total:</strong> {{ number_format($summary['total_grand'], 2) }}</p>    
        <p><strong>Total Due:</strong> {{ number_format($summary['total_due'], 2) }}</p>
    </div>
</div>

<div class="table-responsive mt-4 report">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Bill #</th>
                <th>Date</th>
                <th>Status</th>
                <th>Currency</th>
                <th>Subtotal</th>
                <th>Tax</th>
                <th>Discount</th>
                <th>Grand Total</th>              
                <th>Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $key => $bill)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $bill->bill_number }}</td>
                <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d-M-Y') }}</td>
                <td>{{ ucfirst($bill->bill_status) }}</td>
                <td>{{ $bill->currency_code }}</td>
                <td>{{ number_format($bill->sub_total, 2) }}</td>
                <td>{{ number_format($bill->total_tax, 2) }}</td>
                <td>{{ number_format($bill->total_discount, 2) }}</td>
                <td>{{ number_format($bill->grand_total, 2) }}</td>               
                <td>{{ number_format($bill->total_due, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">No bills found for the selected criteria.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="5" class="text-center">Total</th>
                <th>{{ number_format($summary['total_sub_total'], 2) }}</th>
                <th>{{ number_format($summary['total_tax'], 2) }}</th>
                <th>{{ number_format($summary['total_discount'], 2) }}</th>
                <th>{{ number_format($summary['total_grand'], 2) }}</th>              
                <th>{{ number_format($summary['total_due'], 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>