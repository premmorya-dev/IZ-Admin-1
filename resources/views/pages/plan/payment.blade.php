<x-default-layout>
<!-- iz-pay v1 -->
<script>
    // for google ads
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event: "admin_plan_payment_page" });
</script>

<style>
    .iz-pay-page{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a}
    .iz-pay-page .container{max-width:1180px}

    /* ---------- stepper ---------- */
    .iz-steps{display:flex;align-items:center;justify-content:center;gap:10px;margin:6px 0 34px;flex-wrap:wrap}
    .iz-step{display:flex;align-items:center;gap:9px;font-size:13.5px;font-weight:600;color:#94a3b8}
    .iz-step .n{width:28px;height:28px;border-radius:50%;display:grid;place-items:center;font-size:12.5px;background:#f1f5f9;border:1.5px solid #e2e8f0}
    .iz-step.done{color:#059669}
    .iz-step.done .n{background:#ecfdf5;border-color:#a7f3d0;color:#059669}
    .iz-step.now{color:var(--i1)}
    .iz-step.now .n{background:linear-gradient(135deg,var(--i1),var(--i2));border-color:transparent;color:#fff;box-shadow:0 8px 16px -8px rgba(79,70,229,.8)}
    .iz-step-line{width:44px;height:2px;border-radius:2px;background:#e2e8f0}
    .iz-step-line.done{background:#a7f3d0}

    /* ---------- hero ---------- */
    .iz-hero{position:relative;overflow:hidden;border-radius:24px;padding:34px 34px 30px;color:#fff;margin-bottom:24px;
        background:radial-gradient(700px 280px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(500px 280px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 26px 50px -26px rgba(79,70,229,.65)}
    .iz-hero::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:36px 36px;mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%)}
    .iz-hero > *{position:relative;z-index:1}
    .iz-hero .eyebrow{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:99px;font-size:11.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#e0e7ff;margin-bottom:16px}
    .iz-hero h1{margin:0 0 8px;font-size:34px;line-height:1.15;font-weight:800;letter-spacing:-.03em;color:#fff}
    .iz-hero h1 span{background:linear-gradient(90deg,#a5b4fc,#e9d5ff);-webkit-background-clip:text;background-clip:text;color:transparent}
    .iz-hero p{margin:0 0 20px;color:#c7d2fe;font-size:15px;line-height:1.7;max-width:560px}
    .iz-chips{display:flex;gap:10px;flex-wrap:wrap}
    .iz-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:12px;font-size:13px;font-weight:600;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;backdrop-filter:blur(8px)}
    .iz-chip i{color:#a5b4fc}

    /* ---------- cards ---------- */
    .iz-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -20px rgba(15,23,42,.2);margin-bottom:24px;overflow:hidden}
    .iz-card-h{display:flex;align-items:center;gap:14px;padding:20px 26px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff)}
    .iz-ico{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-card-h h3{margin:0;font-size:16.5px;font-weight:700;color:var(--ink)}
    .iz-card-h p{margin:2px 0 0;font-size:13px;color:var(--mut)}
    .iz-card-b{padding:24px 26px}

    .iz-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 24px;list-style:none;margin:0;padding:0}
    .iz-grid li{display:flex;align-items:flex-start;gap:11px;font-size:14px;color:#334155;line-height:1.45}
    .iz-grid .ck{flex:none;width:20px;height:20px;border-radius:50%;display:grid;place-items:center;font-size:10px;margin-top:1px;background:#eef2ff;color:var(--i1)}
    .iz-grid .ck.no{background:#f1f5f9;color:#cbd5e1}
    .iz-grid li.off{color:#94a3b8}
    .iz-grid li.off span.t{text-decoration:line-through;text-decoration-color:#cbd5e1}
    .iz-grid b{color:var(--ink)}

    .iz-next{list-style:none;margin:0;padding:0;display:grid;gap:18px}
    .iz-next li{display:flex;gap:14px;align-items:flex-start}
    .iz-next .no{flex:none;width:32px;height:32px;border-radius:10px;display:grid;place-items:center;font-weight:700;font-size:13px;color:var(--i1);background:#eef2ff;border:1px solid #e0e7ff}
    .iz-next b{display:block;font-size:14.5px;color:var(--ink)}
    .iz-next small{color:var(--mut);font-size:13px;line-height:1.5}

    /* ---------- order summary ---------- */
    .iz-sticky{position:sticky;top:90px}
    .iz-sum{border-radius:24px;border:1px solid var(--bd);background:#fff;box-shadow:0 30px 60px -30px rgba(79,70,229,.4);overflow:hidden;margin-bottom:18px}
    .iz-sum-h{padding:22px 26px 18px;background:linear-gradient(180deg,#f8f9ff,#fff);border-bottom:1px solid var(--bd)}
    .iz-sum-h small{display:block;font-size:11.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--i1);margin-bottom:6px}
    .iz-sum-h h4{margin:0;font-size:20px;font-weight:800;letter-spacing:-.02em;color:var(--ink)}
    .iz-sum-b{padding:22px 26px 26px}
    .iz-row{display:flex;justify-content:space-between;align-items:center;gap:12px;font-size:14px;color:#475569;padding:7px 0}
    .iz-row b{color:var(--ink);font-weight:600}
    .iz-total{display:flex;justify-content:space-between;align-items:flex-end;gap:12px;margin:14px 0 6px;padding-top:16px;border-top:1px dashed #cbd5e1}
    .iz-total span{font-size:14px;font-weight:600;color:var(--ink)}
    .iz-total .amt{font-size:34px;font-weight:800;letter-spacing:-.04em;line-height:1;color:var(--ink)}
    .iz-total small{display:block;text-align:right;font-size:12px;color:var(--mut);margin-top:4px;font-weight:500}
    .iz-save{display:flex;align-items:center;gap:8px;margin:14px 0 20px;padding:10px 14px;border-radius:12px;font-size:13px;font-weight:600;color:#047857;background:#ecfdf5;border:1px solid #a7f3d0}

    /* razorpay button (generated by checkout.js) */
    .iz-paybox form{margin:0!important}
    .iz-paybox .razorpay-payment-button{display:block;width:100%;height:56px;border:0;border-radius:14px;cursor:pointer;font-size:16px;font-weight:700;color:#fff;
        background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 16px 28px -12px rgba(79,70,229,.8);transition:.2s}
    .iz-paybox .razorpay-payment-button:hover{transform:translateY(-2px);box-shadow:0 22px 34px -14px rgba(79,70,229,.9)}
    .iz-paybox .razorpay-payment-button:active{transform:translateY(0)}

    .iz-secure{display:flex;align-items:center;justify-content:center;gap:7px;margin-top:14px;font-size:12.5px;color:#94a3b8;text-align:center}
    .iz-trust{display:grid;gap:12px;margin:0;padding:18px 20px;list-style:none;border-radius:18px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-trust li{display:flex;align-items:center;gap:11px;font-size:13px;color:#475569}
    .iz-trust i{flex:none;width:30px;height:30px;border-radius:9px;display:grid;place-items:center;font-size:13px;color:var(--i1);background:#fff;box-shadow:0 4px 10px -4px rgba(79,70,229,.35)}

    .iz-done{text-align:center;padding:10px 0}
    .iz-done .ok{width:60px;height:60px;border-radius:18px;display:grid;place-items:center;margin:0 auto 14px;font-size:24px;color:#059669;background:#ecfdf5;border:1px solid #a7f3d0}
    .iz-done h5{margin:0 0 6px;font-weight:700;color:var(--ink)}
    .iz-done p{color:var(--mut);font-size:13.5px;margin:0 0 16px}
    .iz-back{display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 20px;border-radius:12px;font-weight:600;font-size:14px;color:var(--i1);border:1.5px solid #c7d2fe;background:#fff;text-decoration:none!important;transition:.2s}
    .iz-back:hover{background:#eef2ff}

    @media (max-width:991px){.iz-sticky{position:static}}
    @media (max-width:767px){
        .iz-hero{padding:26px 22px}
        .iz-hero h1{font-size:26px}
        .iz-grid{grid-template-columns:1fr}
        .iz-card-h,.iz-card-b{padding-left:20px;padding-right:20px}
        .iz-sum-h,.iz-sum-b{padding-left:20px;padding-right:20px}
        .iz-step-line{width:22px}
    }
</style>

@php
    $fmt = fn($n) => number_format($n, $n == floor($n) ? 0 : 2);

    // price = per month, billing = annual (price x months)
    $isFree       = $plan->plan_id == 1;
    $monthlyPrice = (float) $plan->price;
    $months       = max(1, (int) floor($plan->duration_days / 30));
    $totalPrice   = $monthlyPrice * $months;
    $billingLabel = $months == 12 ? 'Billed annually' : 'Billed for ' . $months . ' month' . ($months > 1 ? 's' : '');

    $planStart = $data['plan_start'] ?? null;
    $planEnd   = $data['plan_end'] ?? null;

    $features = json_decode($plan->features, true);
    $items = [
        ['ok' => true, 'html' => 'Invoices: <b>' . e(!$isFree ? 'Unlimited' : $plan->invoice_limit . ' / month') . '</b>'],
        ['ok' => true, 'html' => 'Clients: <b>' . e(!$isFree ? 'Unlimited' : $plan->client_limit) . '</b>'],
        ['ok' => true, 'html' => 'Product listing: <b>' . e(!$isFree ? 'Unlimited' : ($plan->product_listing_limit ?? '-')) . '</b>'],
        ['ok' => true, 'html' => 'Validity: <b>' . e($plan->duration_days) . ' days</b>'],
    ];
    if ($features) {
        foreach ($features as $key => $value) {
            $items[] = ['ok' => (bool) $value, 'html' => e(ucwords(str_replace('_', ' ', $key)))];
        }
    }
@endphp

<div class="iz-pay-page">
<div class="container py-4">

    <!-- STEPPER -->
    <div class="iz-steps">
        <div class="iz-step done"><span class="n"><i class="fas fa-check" style="font-size:11px"></i></span> Choose plan</div>
        <span class="iz-step-line done"></span>
        <div class="iz-step now"><span class="n">2</span> Review &amp; pay</div>
        <span class="iz-step-line"></span>
        <div class="iz-step"><span class="n">3</span> Start invoicing</div>
    </div>

    <div class="row g-6">

        <!-- RIGHT (mobile: first) : ORDER SUMMARY -->
        <div class="col-lg-5 order-1 order-lg-2">
            <div class="iz-sticky">
                <div class="iz-sum">
                    <div class="iz-sum-h">
                        <small>Order summary</small>
                        <h4>{{ $plan->name }} Plan</h4>
                    </div>
                    <div class="iz-sum-b">

                        @if($plan->price > 0)
                            <div class="iz-row"><span>Price per month</span><b>₹{{ $fmt($monthlyPrice) }}</b></div>
                            <div class="iz-row"><span>Duration</span><b>{{ $months }} month{{ $months > 1 ? 's' : '' }}</b></div>
                            @if($planStart && $planEnd)
                                <div class="iz-row"><span>Valid</span><b>{{ $planStart }} → {{ $planEnd }}</b></div>
                            @endif

                            <div class="iz-total">
                                <span>Total today</span>
                                <div>
                                    <div class="amt">₹{{ $fmt($totalPrice) }}</div>
                                    <small>{{ $billingLabel }} </small>
                                </div>
                            </div>

                            <div class="iz-save">
                                <i class="fas fa-tag"></i>
                                Just ₹{{ $fmt($monthlyPrice) }} per month, with unlimited invoicing
                            </div>
                        @else
                            <div class="iz-total"><span>Total</span><div class="amt">Free</div></div>
                        @endif

                        <div class="iz-paybox">
                            @if( empty( $activePlan ) )
                            <form action="{{ route('plan.payment_callback') }}" method="POST" style="margin-bottom:0px !important;">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->plan_id }}">

                                <script
                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ $data['payment_keys']['public_key'] }}"
                                    data-amount="{{ (int) round($totalPrice * 100) }}"
                                    data-order_id="{{ $data['razorpay_order_id'] }}"
                                    data-name="InvoiceZy"
                                    data-description="InvoiceZy Subcription Plan {{ $plan->name }} {{ $data['plan_start'] }} to {{ $data['plan_end'] }} | user_code: {{ auth()->id() }} "
                                    data-image="{{ asset('razorpay_invoicezy_logo.jpg') }}"
                                    data-notes.user_code="{{ auth()->id() }}"
                                    data-prefill.name="{{ $user->first_name }} {{ $user->last_name }}"
                                    data-prefill.email="{{ $user->email }}"
                                    data-prefill.contact="{{ $user->mobile_no }}"
                                    data-theme.color="#4f46e5"
                                    data-buttontext="Pay ₹{{ $fmt($totalPrice) }} securely">
                                </script>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const btn = document.querySelector('.razorpay-payment-button');
                                        if (!btn) return;
                                        btn.classList.add('iz-paybtn');
                                        btn.addEventListener('click', function () {
                                            window.dataLayer.push({
                                                event: 'plan_pay_click',
                                                plan_name: @json($plan->name),
                                                plan_price: {{ $totalPrice }}
                                            });
                                        });
                                    });
                                </script>
                            </form>

                            <div class="iz-secure">
                                <i class="fas fa-lock"></i> Secured by Razorpay · UPI, cards &amp; net banking
                            </div>

                            @else
                            <div class="iz-done">
                                <div class="ok"><i class="fas fa-circle-check"></i></div>
                                <h5>Plan activated</h5>
                                <p>Your plan is active on this account.</p>
                                <a href="{{ route('invoice.list') }}" class="iz-back"><i class="fas fa-arrow-left"></i> Back to invoices</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="iz-trust">
                    <li><i class="fas fa-shield-halved"></i> 256-bit encrypted checkout</li>
                    <li><i class="fas fa-file-invoice"></i> GST-compliant invoice for your payment</li>
                    <li><i class="fas fa-bolt"></i> Plan activates right after payment</li>
                </ul>
            </div>
        </div>

        <!-- LEFT : PLAN DETAILS -->
        <div class="col-lg-7 order-2 order-lg-1">

            <div class="iz-hero">
                <span class="eyebrow"><i class="fas fa-gem"></i> You're upgrading to</span>
                <h1><span>{{ $plan->name }}</span> Plan</h1>
                <p>{{ $plan->description ?: 'Powerful features to simplify your billing process and help you get paid faster.' }}</p>
                <div class="iz-chips">
                    @if($plan->price > 0)
                        <span class="iz-chip"><i class="fas fa-indian-rupee-sign"></i> ₹{{ $fmt($monthlyPrice) }} / month</span>
                    @endif
                    <span class="iz-chip"><i class="fas fa-calendar-check"></i> {{ $plan->duration_days }} days access</span>
                    <span class="iz-chip"><i class="fas fa-infinity"></i> {{ !$isFree ? 'Unlimited invoices' : $plan->invoice_limit . ' invoices / month' }}</span>
                </div>
            </div>

            <div class="iz-card">
                <div class="iz-card-h">
                    <span class="iz-ico"><i class="fas fa-list-check"></i></span>
                    <div><h3>What's included</h3><p>Everything you get with the {{ $plan->name }} plan.</p></div>
                </div>
                <div class="iz-card-b">
                    <ul class="iz-grid">
                        @foreach($items as $it)
                        <li class="{{ $it['ok'] ? '' : 'off' }}">
                            <span class="ck {{ $it['ok'] ? '' : 'no' }}"><i class="fas {{ $it['ok'] ? 'fa-check' : 'fa-xmark' }}"></i></span>
                            <span class="t">{!! $it['html'] !!}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="iz-card">
                <div class="iz-card-h">
                    <span class="iz-ico"><i class="fas fa-route"></i></span>
                    <div><h3>What happens next</h3><p>It takes less than a minute.</p></div>
                </div>
                <div class="iz-card-b">
                    <ul class="iz-next">
                        <li><span class="no">1</span><div><b>Pay securely</b><small>Complete the payment using UPI, card or net banking.</small></div></li>
                        <li><span class="no">2</span><div><b>Plan gets activated</b><small>Your account is upgraded right after the payment is confirmed.</small></div></li>
                        <li><span class="no">3</span><div><b>Start invoicing</b><small>Create GST-compliant invoices with no limits.</small></div></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>
</div>
</x-default-layout>