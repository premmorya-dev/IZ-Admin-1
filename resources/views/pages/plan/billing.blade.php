<x-default-layout>

 <h2 class="py-3">Billing</h2>

    @if(isset($activePlan))
    <div class="container py-4">
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-gem fa-2x text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Your Active Plan: <strong>{{ $activePlan->plan_name }}</strong></h5>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                        Valid from <strong>{{ $activePlan->starts_at }}</strong>
                        to <strong>{{ $activePlan->ends_at }}</strong>
                    </p>
                </div>
                <div class="ms-auto text-end">
                    <span class="badge bg-success px-3 py-2 rounded-pill">Active</span>
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="container py-4">
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-gem fa-2x text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Your Active Plan: <strong>Free Plan</strong></h5>
                    <p class="mb-0">
                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                        Validity <strong>Unlimited</strong>
                    </p>
                </div>
                <div class="ms-auto text-end">
                    <span class="badge bg-success px-3 py-2 rounded-pill">Active</span>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="container py-5">
        <h2 class="mb-4 text-center fw-bold">Payment History</h2>

        @if($payments->isEmpty())
        <div class="alert alert-info text-center">
            No payment history found.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Payment ID</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                        <th>Paid On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $payment)
                    <tr>
                         <td>{{ $payment->order_id }}</td>
                        <td>{{ $payment->payment_id ?? '-' }}</td>
                        <td>{{ $payment->plan_name }}</td>
                        <td>₹{{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                        @if($payment->payment_status == 'captured') bg-success 
                                        @elseif($payment->payment_status == 'refunded') bg-danger 
                                        @elseif($payment->payment_status == 'failed') bg-danger 
                                        @else bg-secondary @endif">
                                {{ $payment->payment_status == 'captured' ? 'Paid' : ucfirst($payment->payment_status) }}
                            </span>
                        </td>
                        <td>{{ strtoupper($payment->payment_mode ?? '-') }}</td>

                        <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, h:i A') }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        @endif
    </div>



</x-default-layout>