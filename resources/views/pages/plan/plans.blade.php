<x-default-layout>
<!-- iz-plans v5 -->
<script>
    // for google ads
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event: "admin_view_all_plan" });
</script>

<style>
    .iz-plans{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a}
    .iz-plans .container{max-width:1280px}

    /* ---------- active plan banner ---------- */
    .iz-active{position:relative;overflow:hidden;border-radius:22px;padding:26px 30px;color:#fff;margin-bottom:44px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;
        background:radial-gradient(700px 260px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(500px 260px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 24px 50px -24px rgba(79,70,229,.6)}
    .iz-active::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:36px 36px;mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%)}
    .iz-active > *{position:relative;z-index:1}
    .iz-active .gem{flex:none;width:54px;height:54px;border-radius:16px;display:grid;place-items:center;font-size:22px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(8px)}
    .iz-active small{display:block;color:#c7d2fe;font-size:12px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .iz-active h4{margin:0;color:#fff;font-size:22px;font-weight:700;letter-spacing:-.01em}
    .iz-active .valid{margin-top:4px;color:#c7d2fe;font-size:13.5px}
    .iz-active .valid b{color:#fff}
    .iz-active .side{margin-left:auto;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
    .iz-pill{display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:99px;font-size:12.5px;font-weight:600}
    .iz-pill.ok{background:rgba(52,211,153,.18);color:#6ee7b7;border:1px solid rgba(52,211,153,.35)}
    .iz-pill.warn{background:rgba(251,191,36,.18);color:#fcd34d;border:1px solid rgba(251,191,36,.4)}
    .iz-pill .dot{width:7px;height:7px;border-radius:50%;background:currentColor;box-shadow:0 0 0 4px rgba(255,255,255,.1)}

    /* ---------- heading ---------- */
    .iz-head{text-align:center;max-width:680px;margin:0 auto 44px}
    .iz-head .eyebrow{display:inline-block;padding:6px 14px;border-radius:99px;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--i1);background:#eef2ff;border:1px solid #e0e7ff;margin-bottom:16px}
    .iz-head h2{font-size:38px;line-height:1.15;font-weight:800;letter-spacing:-.03em;color:var(--ink);margin:0 0 12px}
    .iz-head h2 span{background:linear-gradient(90deg,var(--i1),#a855f7);-webkit-background-clip:text;background-clip:text;color:transparent}
    .iz-head p{color:var(--mut);font-size:16px;line-height:1.7;margin:0}

    /* ---------- plan cards ---------- */
    .iz-pcard{position:relative;height:100%;display:flex;flex-direction:column;padding:30px 26px 26px;border-radius:24px;background:#fff;border:1.5px solid var(--bd);
        box-shadow:0 10px 30px -20px rgba(15,23,42,.2);transition:.25s}
    .iz-pcard:hover{transform:translateY(-6px);border-color:#c7d2fe;box-shadow:0 28px 50px -24px rgba(79,70,229,.35)}
    .iz-pcard .ptop{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:6px;min-height:28px}
    .iz-pcard .pname{font-size:18px;font-weight:700;color:var(--ink);margin:0}
    .iz-tag{padding:4px 11px;border-radius:99px;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}
    .iz-tag.cur{background:#ecfdf5;color:#047857;border:1px solid #a7f3d0}
    .iz-pdesc{color:var(--mut);font-size:13.5px;line-height:1.6;min-height:44px;margin:0 0 18px}
    .iz-price{display:flex;align-items:baseline;gap:6px;flex-wrap:wrap}
    .iz-price .amt{font-size:44px;font-weight:800;letter-spacing:-.04em;color:var(--ink);line-height:1}
    .iz-price .per{font-size:14px;color:var(--mut);font-weight:500}
    .iz-sub{margin-top:8px;font-size:12.5px;font-weight:600;color:#059669;display:flex;align-items:center;gap:6px;min-height:20px}
    .iz-div{height:1px;background:var(--bd);margin:22px 0}
    .iz-feat{list-style:none;margin:0 0 14px;padding:0;display:grid;gap:12px;flex:1;align-content:start}
    .iz-feat li{display:flex;align-items:flex-start;gap:11px;font-size:14px;color:#334155;line-height:1.45}
    .iz-feat .ck{flex:none;width:20px;height:20px;border-radius:50%;display:grid;place-items:center;font-size:10px;margin-top:1px;background:#eef2ff;color:var(--i1)}
    .iz-feat .ck.no{background:#f1f5f9;color:#cbd5e1}
    .iz-feat li.off{color:#94a3b8}
    .iz-feat li.off span.t{text-decoration:line-through;text-decoration-color:#cbd5e1}
    .iz-feat b{color:var(--ink)}

    /* ---------- see more / less (CSS only, all cards sync) ---------- */
    .iz-toggle{position:absolute;opacity:0;pointer-events:none;width:0;height:0}
    .iz-toggle:not(:checked) ~ .row .iz-feat li.extra{display:none}
    .iz-toggle:checked ~ .row .iz-feat li.extra{animation:izfade .3s ease both}
    @keyframes izfade{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:none}}

    .iz-more{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;margin:0 0 18px;padding:9px 12px;border:1.5px dashed #c7d2fe;border-radius:12px;background:#f8f9ff;color:var(--i1);font-size:13px;font-weight:600;cursor:pointer;user-select:none;transition:.2s}
    .iz-more:hover{background:#eef2ff;border-color:#a5b4fc}
    .iz-more i{font-size:11px;transition:transform .25s}
    .iz-more .m-open{display:none}
    .iz-toggle:checked ~ .row .iz-more .m-open{display:inline}
    .iz-toggle:checked ~ .row .iz-more .m-closed{display:none}
    .iz-toggle:checked ~ .row .iz-more i{transform:rotate(180deg)}
    .iz-toggle:focus-visible ~ .row .iz-more{outline:2px solid var(--i1);outline-offset:2px}

    /* CTA */
    .iz-cta{display:flex;align-items:center;justify-content:center;gap:8px;height:52px;border-radius:14px;font-weight:700;font-size:15px;text-decoration:none!important;transition:.2s;border:1.5px solid #c7d2fe;color:var(--i1);background:#fff}
    .iz-cta:hover{background:#eef2ff;transform:translateY(-2px)}
    .iz-cta.primary{border:0;color:#fff;background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 14px 26px -12px rgba(79,70,229,.75)}
    .iz-cta.primary:hover{color:#fff;box-shadow:0 20px 32px -14px rgba(79,70,229,.85);background:linear-gradient(135deg,var(--i1),var(--i2))}
    .iz-cta.disabled{pointer-events:none;background:#f1f5f9;color:#94a3b8;border-color:#e2e8f0;box-shadow:none}
    .iz-note{text-align:center;font-size:12px;color:#94a3b8;margin-top:12px;display:flex;align-items:center;justify-content:center;gap:6px}

    /* popular */
    .iz-pcard.popular{border:0;color:#fff;background:radial-gradient(500px 240px at 0% 0%,#6366f1 0%,transparent 65%),radial-gradient(400px 240px at 100% 100%,#a855f7 0%,transparent 60%),#1e1b4b;
        box-shadow:0 34px 60px -24px rgba(79,70,229,.75)}
    .iz-pcard.popular:hover{border:0;box-shadow:0 40px 70px -24px rgba(79,70,229,.9)}
    .iz-pcard.popular .pname,.iz-pcard.popular .iz-price .amt,.iz-pcard.popular .iz-feat b{color:#fff}
    .iz-pcard.popular .iz-pdesc,.iz-pcard.popular .iz-price .per{color:#c7d2fe}
    .iz-pcard.popular .iz-div{background:rgba(255,255,255,.14)}
    .iz-pcard.popular .iz-feat li{color:#e0e7ff}
    .iz-pcard.popular .iz-feat .ck{background:rgba(255,255,255,.16);color:#fff}
    .iz-pcard.popular .iz-feat li.off{color:#a5b4fc}
    .iz-pcard.popular .iz-sub{color:#6ee7b7}
    .iz-pcard.popular .iz-note{color:#a5b4fc}
    .iz-pcard.popular .iz-more{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.3);color:#fff}
    .iz-pcard.popular .iz-more:hover{background:rgba(255,255,255,.16)}
    .iz-pcard.popular .iz-cta.primary{background:#fff;color:var(--i1);box-shadow:0 14px 26px -12px rgba(0,0,0,.5)}
    .iz-pcard.popular .iz-cta.primary:hover{background:#f5f3ff;color:var(--i1)}
    .iz-pcard.popular .iz-cta.disabled{background:rgba(255,255,255,.12);color:#c7d2fe}
    .iz-ribbon{position:absolute;top:-14px;left:50%;transform:translateX(-50%);padding:6px 18px;border-radius:99px;font-size:11.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#fff;white-space:nowrap;
        background:linear-gradient(90deg,#f59e0b,#f97316);box-shadow:0 10px 20px -8px rgba(249,115,22,.7)}
    @media (min-width:1200px){.iz-pcard.popular{transform:scale(1.04)}.iz-pcard.popular:hover{transform:scale(1.04) translateY(-6px)}}

    /* ---------- trust strip ---------- */
    .iz-trust{margin-top:56px;display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
    .iz-trust > div{display:flex;align-items:center;gap:14px;padding:18px 20px;border-radius:18px;background:#fff;border:1px solid var(--bd)}
    .iz-trust .ti{flex:none;width:42px;height:42px;border-radius:12px;display:grid;place-items:center;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff;font-size:16px}
    .iz-trust b{display:block;font-size:14px;color:var(--ink)}
    .iz-trust small{color:var(--mut);font-size:12.5px}

    @media (max-width:991px){.iz-trust{grid-template-columns:1fr 1fr}.iz-head h2{font-size:30px}}
    @media (max-width:575px){
        .iz-trust{grid-template-columns:1fr}
        .iz-head h2{font-size:26px}
        .iz-active{padding:22px 20px}
        .iz-active .side{margin-left:0;width:100%}
        .iz-price .amt{font-size:38px}
    }
</style>

@php
    // "Most popular" = middle paid plan (specific plan chahiye to: $popularId = 3;)
    $paid = collect($plans)->filter(fn($p) => $p->price > 0)->sortBy('price')->values();
    $popularId = $paid->count() ? $paid[intdiv($paid->count(), 2)]->plan_id : null;

    // Active plan days left
    $daysLeft = null;
    if (isset($activePlan) && !empty($activePlan->ends_at)) {
        try { $daysLeft = (int) ceil(now()->diffInDays(\Carbon\Carbon::parse($activePlan->ends_at), false)); } catch (\Throwable $e) {}
    }

    $visible = 5; // har plan me kitne features hamesha dikhen
@endphp

<div class="iz-plans">
<div class="container py-4">

    <!-- ACTIVE PLAN -->
    <div class="iz-active">
        <div class="gem"><i class="fas fa-gem"></i></div>
        <div>
            <small>Your current plan</small>
            @if(isset($activePlan))
                <h4>{{ $activePlan->plan_name }}</h4>
                <div class="valid">Valid from <b>{{ $activePlan->starts_at }}</b> to <b>{{ $activePlan->ends_at }}</b></div>
            @else
                <h4>Free Plan</h4>
                <div class="valid">Validity: <b>Unlimited</b></div>
            @endif
        </div>
        <div class="side">
            @if(isset($activePlan) && $daysLeft !== null && $daysLeft <= 7 && $daysLeft >= 0)
                <span class="iz-pill warn"><i class="fas fa-hourglass-half"></i> Expires in {{ $daysLeft }} {{ $daysLeft == 1 ? 'day' : 'days' }}</span>
            @elseif(isset($activePlan) && $daysLeft !== null && $daysLeft > 7)
                <span class="iz-pill ok"><i class="fas fa-clock"></i> {{ $daysLeft }} days left</span>
            @endif
            <span class="iz-pill ok"><span class="dot"></span> Active</span>
        </div>
    </div>

    <!-- HEADING -->
    <div class="iz-head">
        <span class="eyebrow">Pricing</span>
        <h2>Invoice faster. <span>Grow without limits.</span></h2>
        <p>Pick the plan that fits your business. Simple monthly pricing, billed annually.</p>
    </div>

    <!-- shared toggle: .row ke just pehle, same parent me -->
    <input type="checkbox" id="izShowAll" class="iz-toggle" aria-label="Show all plan features">

    <!-- PLANS -->
    <div class="row g-6 justify-content-center">
        @foreach ($plans as $plan)
        @php
            $isFree        = $plan->plan_id == 1;
            $isCurrentPlan = isset($activePlan) ? $plan->plan_id == $activePlan->plan_id : $isFree;
            $isPopular     = $popularId !== null && $plan->plan_id == $popularId;
            $days          = (int) $plan->duration_days;

            // price = per month, billing = annual (price x 12)
            $yearly   = $plan->price * 12;
            $priceFmt = number_format($plan->price, $plan->price == floor($plan->price) ? 0 : 2);
            $yearFmt  = number_format($yearly, $yearly == floor($yearly) ? 0 : 2);

            $features = json_decode($plan->features, true);

            $items = [
                ['ok' => true, 'html' => 'Invoices: <b>' . e(!$isFree ? 'Unlimited' : $plan->invoice_limit . ' / month') . '</b>'],
                ['ok' => true, 'html' => 'Clients: <b>' . e(!$isFree ? 'Unlimited' : $plan->client_limit) . '</b>'],
                ['ok' => true, 'html' => 'Product listing: <b>' . e(!$isFree ? 'Unlimited' : $plan->product_listing_limit) . '</b>'],
                ['ok' => true, 'html' => 'Validity: <b>' . e($days) . ' days</b>'],
            ];

            if ($features) {
                foreach ($features as $key => $value) {
                    $items[] = ['ok' => $value === true, 'html' => e(ucwords(str_replace('_', ' ', $key)))];
                }
            }

            $extraCount = max(0, count($items) - $visible);
        @endphp

        <div class="col-12 col-md-6 col-xl-3">
            <div class="iz-pcard {{ $isPopular ? 'popular' : '' }}">

                @if($isPopular)<span class="iz-ribbon">★ Most popular</span>@endif

                <div class="ptop">
                    <h5 class="pname">{{ $plan->name }}</h5>
                    @if($isCurrentPlan)<span class="iz-tag cur">Current</span>@endif
                </div>

                <p class="iz-pdesc">{{ $plan->description ?? 'Powerful features to simplify your billing process.' }}</p>

                <div class="iz-price">
                    @if($plan->price == 0)
                        <span class="amt">Free</span>
                        <span class="per">forever</span>
                    @else
                        <span class="amt">₹{{ $priceFmt }}</span>
                        <span class="per">/ month</span>
                    @endif
                </div>
                <div class="iz-sub">
                    @if($plan->price > 0)
                        <i class="fas fa-receipt"></i> Billed annually · ₹{{ $yearFmt }} / year
                    @endif
                </div>

                <div class="iz-div"></div>

                <ul class="iz-feat">
                    @foreach($items as $i => $it)
                    <li class="{{ $it['ok'] ? '' : 'off' }} {{ $i >= $visible ? 'extra' : '' }}">
                        <span class="ck {{ $it['ok'] ? '' : 'no' }}"><i class="fas {{ $it['ok'] ? 'fa-check' : 'fa-xmark' }}"></i></span>
                        <span class="t">{!! $it['html'] !!}</span>
                    </li>
                    @endforeach
                </ul>

                @if($extraCount > 0)
                <label for="izShowAll" class="iz-more" role="button">
                    <span class="m-closed">See all features (+{{ $extraCount }})</span>
                    <span class="m-open">Show less</span>
                    <i class="fas fa-chevron-down"></i>
                </label>
                @endif

                @if($isCurrentPlan)
                    <span class="iz-cta disabled"><i class="fas fa-circle-check"></i> Current plan</span>
                @elseif($isFree)
                    <span class="iz-cta disabled">Free plan</span>
                @else
                    <a href="{{ route('plan.payment', ['plan_id' => $plan->plan_id]) }}"
                       class="iz-cta primary js-plan-cta"
                       data-plan="{{ $plan->name }}" data-price="{{ $yearly }}">
                        {{ isset($activePlan) ? 'Switch to ' . $plan->name : 'Upgrade to ' . $plan->name }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="iz-note"><i class="fas fa-lock"></i> Billed annually</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- TRUST -->
    <div class="iz-trust">
        <div><span class="ti"><i class="fas fa-shield-halved"></i></span><div><b>Secure payments</b><small>Encrypted checkout</small></div></div>
        <div><span class="ti"><i class="fas fa-bolt"></i></span><div><b>Instant access</b><small>Unlock features right away</small></div></div>
        <div><span class="ti"><i class="fas fa-file-invoice"></i></span><div><b>GST-ready</b><small>Compliant invoices</small></div></div>
        <div><span class="ti"><i class="fas fa-headset"></i></span><div><b>Support</b><small>We're here to help</small></div></div>
    </div>

</div>
</div>

<script>
    // plan click tracking (google ads / GTM) - value = annual amount
    document.querySelectorAll('.js-plan-cta').forEach(function (a) {
        a.addEventListener('click', function () {
            window.dataLayer.push({
                event: 'plan_cta_click',
                plan_name: a.dataset.plan,
                plan_price: a.dataset.price
            });
        });
    });
</script>
</x-default-layout>