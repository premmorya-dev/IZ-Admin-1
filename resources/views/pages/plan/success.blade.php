<x-default-layout>

    <!-- Meta Pixel Code for pro.invoicezy.com (Subscription Payment Success) -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1004383331897465', {
            autoConfig: true,
            xfbml: true
        });
        fbq('set', 'autoConfig', 'true', 'invoicezy.com');
        fbq('set', 'autoConfig', 'true', 'pro.invoicezy.com');


        // 🔥 Subscription Payment Tracking
        fbq('track', 'Purchase', {
            value: 999.00, // Replace with actual payment amount
            currency: '{{ number_format($plan->price, 2) }}', // Use appropriate currency code
            contents: [{
                id: '{{ $plan->plan_id }}',
                name: '{{ $plan->name }}',
                quantity: 1
            }],
            content_type: 'subscription',
            user_id: '{{ Auth::id() }}'
        });
    </script>

    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1004383331897465&ev=Purchase&noscript=1" /></noscript>
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-success mb-4">
                            <i class="bi bi-check-circle-fill display-3"></i>
                        </div>
                        <h2 class="mb-3">Payment Successful!</h2>
                        <p class="lead mb-4">Thank you for purchasing the <strong>{{ $plan->name }}</strong> subscription.</p>


                        @php
                        $monthlyPrice = $plan->price;
                        $months = floor($plan->duration_days / 30);
                        $totalPrice = $monthlyPrice * $months;
                        @endphp



                        <div class="mb-3">
                            <p class="mb-1">Transaction ID: <strong>{{ $payment_id }}</strong></p>
                            <p class="mb-1">Amount Paid: <strong>₹{{ number_format($plan->price, 2) * $months }}</strong></p>
                            <p class="mb-0">
                                <i class="fas fa-calendar-alt text-muted me-2"></i>
                                Valid from <strong>{{ $data['plan_start'] }}</strong>
                                to <strong>{{ $data['plan_end']  }}</strong>
                            </p>
                        </div>

                        <a href="{{ route('dashboard') }}" class="btn btn-success mt-3">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>