<x-default-layout>

    <h2 class="py-3">Plan Description</h2>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4 p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">{{ $plan->name }} Plan</h2>

                        @php
                        $monthlyPrice = $plan->price;
                        $months = floor($plan->duration_days / 30);
                        $totalPrice = $monthlyPrice * $months;
                        @endphp


                        <h3 class="text-primary">
                            @if($plan->price == 0)
                            Free
                            @else
                            ₹{{ number_format($plan->price, 2) * $months }}
                            @endif
                        </h3>

                        @if($plan->price > 0 && $plan->duration_days >= 30)

                        <div class="mt-2">
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">
                                ₹{{ number_format($monthlyPrice, 0) }}/month × {{ $months }} month{{ $months > 1 ? 's' : '' }} =
                                <strong>₹{{ number_format($totalPrice, 0) }}</strong>
                            </span>
                            <div class="text-muted mt-1 small fst-italic">
                                Best value for just ₹{{ number_format($monthlyPrice, 0) }} per month
                            </div>
                        </div>
                        @endif

                        <p class="text-muted"> {{ $plan->description ?? '' }}</p>
                    </div>

                    <ul class="list-group list-group-flush mb-4">

                     
                        <li class="list-group-item"><i class="fas fa-file-invoice text-success me-2"></i> Invoices: {{  $plan->plan_id == '4' ? 'Unlimited' : $plan->invoice_limit }}/per month</li>
                        <li class="list-group-item"><i class="fas fa-user-friends text-success me-2"></i> Clients: {{ $plan->plan_id == '4' ? 'Unlimited' : $plan->client_limit }}</li>
                        <li class="list-group-item"><i class="fas fa-clock text-success me-2"></i> Duration: {{ $plan->duration_days }} days</li>

                        @php $features = json_decode($plan->features, true); @endphp

                        @if($features)
                        @foreach ($features as $key => $value)
                        <li class="list-group-item">
                            <i class="fas {{ $value ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-2"></i>
                            {{ ucwords(str_replace('_', ' ', $key)) }}
                        </li>
                        @endforeach
                        @endif
                    </ul>



                    <div class="text-center mt-4">

                        @if( empty( $activePlan ) )
                        <form action="{{ route('plan.payment_callback') }}" method="POST" style="margin-bottom:0px !important;">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->plan_id }}">


                            <script
                                src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ $data['payment_keys']['public_key'] }}"
                                data-amount="{{ number_format($plan->price, 2) *  $months }}"
                                data-order_id="{{ $data['razorpay_order_id'] }}"
                                data-name="InvoiceZy"
                                data-description="InvoiceZy Subcription Plan {{ $plan->name }} {{  $data['plan_start'] }} to {{ $data['plan_end'] }} | user_code: {{ auth()->id() }} "
                                data-image="https://pro.invoicezy.com/logo.png"
                                data-notes.user_code="{{ auth()->id() }}"
                                data-prefill.name="{{ $user->first_name }} {{ $user->last_name }}"
                                data-prefill.email="{{ $user->email }}"
                                data-prefill.contact="{{ $user->mobile_no }}"
                                data-theme.color="#0000ff"
                                data-buttontext="Pay Now">
                            </script>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const btn = document.querySelector('.razorpay-payment-button');
                                    btn.classList.add('btn', 'btn-success', 'btn-sm');
                                });
                            </script>




                        </form>

                        @else

                        <span class="badge bg-success mb-1 text-white">Activated</span>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>












    <script>
        function simulatePayment() {
            alert('Payment Successful! Premium access activated.');
            window.location.href = "/dashboard"; // Replace with your premium dashboard
        }
    </script>
</x-default-layout>