<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center p-2 px-5" style="min-height: 60px;">
        <h1 class="h5 m-0"><strong>ITC Summary</strong></h1>
        <a href="{{ route('download.report') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="download"></i>  Download</a>
    </div>


    <div class="card-body">
        <p><strong>Total Input Tax Credit Claim:</strong> {{ number_format($summary['total_tax'], 2) }}</p>
        <p><strong>Grand Total:</strong> {{ number_format($summary['total_grand'], 2) }}</p>    
    </div>
</div>

<div class="table-responsive mt-4 report">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Bill #</th>
                <th>Date</th>                
                <th>Grand Total</th>
                <th>Input Tax Credit</th>              
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $key => $bill)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $bill->bill_number }}</td>
                <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d-M-Y') }}</td>
                 <td>{{ number_format($bill->grand_total, 2) }}</td>    
                <td>{{ number_format($bill->total_tax, 2) }}</td>                          
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">No ITC found for the selected criteria.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="3" class="text-center">Total</th>              
                <th>{{ number_format($summary['total_grand'], 2) }}</th>              
              <th>{{ number_format($summary['total_tax'], 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>