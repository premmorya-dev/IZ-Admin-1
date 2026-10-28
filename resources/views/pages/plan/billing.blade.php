<x-default-layout>
<!-- iz-billing v1 -->
<style>
    .iz-bill{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a}
    .iz-bill .container{max-width:1180px}

    /* header */
    .iz-top{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:24px}
    .iz-top h2{margin:0;font-size:26px;font-weight:800;letter-spacing:-.02em;color:var(--ink)}
    .iz-top p{margin:2px 0 0;color:var(--mut);font-size:14px}
    .iz-btn{display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 22px;border:0;border-radius:12px;font-weight:700;font-size:14px;color:#fff;text-decoration:none!important;
        background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 12px 24px -12px rgba(79,70,229,.8);transition:.2s}
    .iz-btn:hover{transform:translateY(-2px);color:#fff;box-shadow:0 18px 30px -14px rgba(79,70,229,.9)}

    /* active plan */
    .iz-active{position:relative;overflow:hidden;border-radius:24px;padding:28px 30px;color:#fff;margin-bottom:24px;
        background:radial-gradient(700px 260px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(500px 260px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 26px 50px -26px rgba(79,70,229,.65)}
    .iz-active::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:36px 36px;mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(circle at 20% 20%,#000,transparent 75%)}
    .iz-active > *{position:relative;z-index:1}
    .iz-a-row{display:flex;align-items:center;gap:18px;flex-wrap:wrap}
    .iz-gem{flex:none;width:56px;height:56px;border-radius:16px;display:grid;place-items:center;font-size:22px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25)}
    .iz-active small{display:block;color:#c7d2fe;font-size:12px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .iz-active h4{margin:0;color:#fff;font-size:24px;font-weight:800;letter-spacing:-.02em}
    .iz-active .valid{margin-top:4px;color:#c7d2fe;font-size:13.5px}
    .iz-active .valid b{color:#fff}
    .iz-a-side{margin-left:auto;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
    .iz-pill{display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:99px;font-size:12.5px;font-weight:600}
    .iz-pill.ok{background:rgba(52,211,153,.18);color:#6ee7b7;border:1px solid rgba(52,211,153,.35)}
    .iz-pill.warn{background:rgba(251,191,36,.18);color:#fcd34d;border:1px solid rgba(251,191,36,.4)}
    .iz-pill .dot{width:7px;height:7px;border-radius:50%;background:currentColor;box-shadow:0 0 0 4px rgba(255,255,255,.1)}
    .iz-prog{margin-top:22px}
    .iz-prog .meta{display:flex;justify-content:space-between;font-size:12px;color:#c7d2fe;margin-bottom:8px}
    .iz-prog .bar{height:8px;border-radius:99px;background:rgba(255,255,255,.15);overflow:hidden}
    .iz-prog .bar b{display:block;height:100%;border-radius:99px;background:linear-gradient(90deg,#818cf8,#34d399)}
    .iz-a-btn{display:inline-flex;align-items:center;gap:8px;height:44px;padding:0 20px;border-radius:12px;font-weight:700;font-size:14px;color:var(--i1);background:#fff;text-decoration:none!important;transition:.2s}
    .iz-a-btn:hover{transform:translateY(-2px);color:var(--i1);background:#f5f3ff}

    /* stats */
    .iz-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
    .iz-stat{display:flex;align-items:center;gap:14px;padding:20px 22px;border-radius:20px;background:#fff;border:1px solid var(--bd);box-shadow:0 10px 30px -22px rgba(15,23,42,.25)}
    .iz-stat .ic{flex:none;width:46px;height:46px;border-radius:14px;display:grid;place-items:center;font-size:18px;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-stat small{display:block;font-size:12.5px;color:var(--mut);font-weight:500}
    .iz-stat b{display:block;font-size:22px;font-weight:800;letter-spacing:-.02em;color:var(--ink);line-height:1.2}

    /* history card */
    .iz-card{background:#fff;border:1px solid var(--bd);border-radius:24px;box-shadow:0 10px 30px -20px rgba(15,23,42,.2);overflow:hidden}
    .iz-card-h{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;padding:22px 26px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff)}
    .iz-card-h h3{margin:0;font-size:18px;font-weight:700;color:var(--ink)}
    .iz-card-h p{margin:2px 0 0;font-size:13px;color:var(--mut)}
    .iz-filters{display:flex;gap:8px;flex-wrap:wrap}
    .iz-f{display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:99px;border:1.5px solid var(--bd);background:#fff;color:#475569;font-size:13px;font-weight:600;cursor:pointer;transition:.2s}
    .iz-f:hover{border-color:#c7d2fe;color:var(--i1)}
    .iz-f.on{background:linear-gradient(135deg,var(--i1),var(--i2));border-color:transparent;color:#fff;box-shadow:0 8px 16px -8px rgba(79,70,229,.8)}
    .iz-f em{font-style:normal;font-size:11.5px;padding:1px 7px;border-radius:99px;background:#f1f5f9;color:#64748b}
    .iz-f.on em{background:rgba(255,255,255,.22);color:#fff}

    .iz-tbl{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .iz-tbl th{padding:14px 22px;text-align:left;font-size:11.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;background:#f8fafc;border-bottom:1px solid var(--bd);white-space:nowrap}
    .iz-tbl td{padding:18px 22px;border-bottom:1px solid #f1f5f9;font-size:14px;color:#334155;vertical-align:middle}
    .iz-tbl tbody tr{transition:.15s}
    .iz-tbl tbody tr:hover{background:#fafaff}
    .iz-tbl tbody tr:last-child td{border-bottom:0}
    .iz-plan{display:flex;align-items:center;gap:12px}
    .iz-plan .pi{flex:none;width:38px;height:38px;border-radius:11px;display:grid;place-items:center;font-size:14px;color:var(--i1);background:#eef2ff;border:1px solid #e0e7ff}
    .iz-plan b{display:block;color:var(--ink);font-weight:700}
    .iz-plan small{color:#94a3b8;font-size:12px}
    .iz-amt{font-weight:800;color:var(--ink);font-size:15px;white-space:nowrap}
    .iz-id{display:inline-flex;align-items:center;gap:8px;font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:12.5px;color:#475569;background:#f8fafc;border:1px solid var(--bd);border-radius:8px;padding:4px 8px;max-width:190px}
    .iz-id span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .iz-copy{flex:none;border:0;background:none;color:#94a3b8;padding:0;cursor:pointer;font-size:12px}
    .iz-copy:hover{color:var(--i1)}
    .iz-copy.done{color:#16a34a}
    .iz-st{display:inline-flex;align-items:center;gap:7px;padding:5px 12px;border-radius:99px;font-size:12.5px;font-weight:700}
    .iz-st::before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}
    .iz-st.ok{background:#ecfdf5;color:#047857}
    .iz-st.bad{background:#fff1f2;color:#be123c}
    .iz-st.warn{background:#fffbeb;color:#b45309}
    .iz-st.gray{background:#f1f5f9;color:#475569}
    .iz-mode{display:inline-flex;align-items:center;gap:8px;font-weight:600;font-size:13px;color:#475569}
    .iz-mode i{color:#94a3b8}
    .iz-date b{display:block;color:var(--ink);font-weight:600}
    .iz-date small{color:#94a3b8;font-size:12px}
    .iz-none{display:none;text-align:center;padding:36px 20px;color:var(--mut);font-size:14px}

    /* empty */
    .iz-empty{text-align:center;padding:56px 24px}
    .iz-empty .ei{width:76px;height:76px;border-radius:22px;display:grid;place-items:center;margin:0 auto 18px;font-size:30px;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-empty h5{font-size:19px;font-weight:700;color:var(--ink);margin:0 0 6px}
    .iz-empty p{color:var(--mut);margin:0 0 20px;font-size:14px}

    /* mobile: table -> cards */
    @media (max-width:767px){
        .iz-top h2{font-size:22px}
        .iz-active{padding:22px 20px}
        .iz-a-side{margin-left:0;width:100%}
        .iz-stats{grid-template-columns:1fr}
        .iz-card-h{padding:18px 20px}
        .iz-tbl thead{display:none}
        .iz-tbl,.iz-tbl tbody{display:block}
        .iz-tbl tr{display:block;padding:14px 18px;border-bottom:1px solid var(--bd)}
        .iz-tbl tbody tr:last-child{border-bottom:0}
        .iz-tbl td{display:flex;justify-content:space-between;align-items:center;gap:14px;padding:8px 0;border:0;text-align:right}
        .iz-tbl td::before{content:attr(data-label);flex:none;font-size:11.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8;text-align:left}
        .iz-id{max-width:170px}
    }
</style>

@php
    // pagination ho ya normal collection, dono chalega
    $rows = $payments instanceof \Illuminate\Pagination\AbstractPaginator ? $payments->getCollection() : collect($payments);

    // plans page ka route (apne route name ke hisaab se badal lena)
    $plansUrl = '#';
    foreach (['plan.list', 'plans', 'plan.index', 'plans.index'] as $r) {
        if (\Illuminate\Support\Facades\Route::has($r)) { $plansUrl = route($r); break; }
    }

    $captured  = $rows->where('payment_status', 'captured');
    $totalPaid = $captured->sum('amount');
    $lastPaid  = $captured->sortByDesc('paid_at')->first();

    $counts = [
        'all'      => $rows->count(),
        'paid'     => $captured->count(),
        'failed'   => $rows->where('payment_status', 'failed')->count(),
        'refunded' => $rows->where('payment_status', 'refunded')->count(),
    ];

    // active plan progress
    $daysLeft = null; $pct = 0;
    if (isset($activePlan) && !empty($activePlan->ends_at)) {
        try {
            $s = \Carbon\Carbon::parse($activePlan->starts_at);
            $e = \Carbon\Carbon::parse($activePlan->ends_at);
            $daysLeft = (int) ceil(now()->diffInDays($e, false));
            $total = max(1, $s->diffInDays($e));
            $pct = max(0, min(100, round(($s->diffInDays(now()) / $total) * 100)));
        } catch (\Throwable $ex) {}
    }
    $fmt = fn($n) => number_format($n, $n == floor($n) ? 0 : 2);
@endphp

<div class="iz-bill">
<div class="container py-4">

    <!-- HEADER -->
    <div class="iz-top">
        <div>
            <h2>Billing</h2>
            <p>Your plan, payments and purchase history in one place.</p>
        </div>
        <a href="{{ $plansUrl }}" class="iz-btn"><i class="fas fa-rocket"></i> {{ isset($activePlan) ? 'Change plan' : 'Upgrade plan' }}</a>
    </div>

    <!-- ACTIVE PLAN -->
    <div class="iz-active">
        <div class="iz-a-row">
            <div class="iz-gem"><i class="fas fa-gem"></i></div>
            <div>
                <small>Current plan</small>
                @if(isset($activePlan))
                    <h4>{{ $activePlan->plan_name }}</h4>
                    <div class="valid">Valid from <b>{{ $activePlan->starts_at }}</b> to <b>{{ $activePlan->ends_at }}</b></div>
                @else
                    <h4>Free Plan</h4>
                    <div class="valid">Validity: <b>Unlimited</b></div>
                @endif
            </div>
            <div class="iz-a-side">
                @if(isset($activePlan) && $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 7)
                    <span class="iz-pill warn"><i class="fas fa-hourglass-half"></i> Expires in {{ $daysLeft }} {{ $daysLeft == 1 ? 'day' : 'days' }}</span>
                @elseif(isset($activePlan) && $daysLeft !== null && $daysLeft > 7)
                    <span class="iz-pill ok"><i class="fas fa-clock"></i> {{ $daysLeft }} days left</span>
                @endif
                <span class="iz-pill ok"><span class="dot"></span> Active</span>
                @if(!isset($activePlan))
                    <a href="{{ $plansUrl }}" class="iz-a-btn">Upgrade <i class="fas fa-arrow-right"></i></a>
                @endif
            </div>
        </div>

        @if(isset($activePlan) && $daysLeft !== null)
        <div class="iz-prog">
            <div class="meta"><span>{{ $pct }}% of plan period used</span><span>{{ max(0, $daysLeft) }} days remaining</span></div>
            <div class="bar"><b style="width:{{ $pct }}%"></b></div>
        </div>
        @endif
    </div>

    <!-- STATS -->
    <div class="iz-stats">
        <div class="iz-stat">
            <span class="ic"><i class="fas fa-indian-rupee-sign"></i></span>
            <div><small>Total paid</small><b>₹{{ $fmt($totalPaid) }}</b></div>
        </div>
        <div class="iz-stat">
            <span class="ic"><i class="fas fa-receipt"></i></span>
            <div><small>Successful payments</small><b>{{ $counts['paid'] }}</b></div>
        </div>
        <div class="iz-stat">
            <span class="ic"><i class="fas fa-calendar-check"></i></span>
            <div><small>Last payment</small>
                <b>{{ $lastPaid && $lastPaid->paid_at ? \Carbon\Carbon::parse($lastPaid->paid_at)->format('d M Y') : '-' }}</b></div>
        </div>
    </div>

    <!-- PAYMENT HISTORY -->
    <div class="iz-card">
        <div class="iz-card-h">
            <div>
                <h3>Payment history</h3>
                <p>Every plan purchase made from this account.</p>
            </div>
            @if($rows->isNotEmpty())
            <div class="iz-filters" id="izFilters">
                <button type="button" class="iz-f on" data-f="all">All <em>{{ $counts['all'] }}</em></button>
                <button type="button" class="iz-f" data-f="paid">Paid <em>{{ $counts['paid'] }}</em></button>
                @if($counts['failed'])<button type="button" class="iz-f" data-f="failed">Failed <em>{{ $counts['failed'] }}</em></button>@endif
                @if($counts['refunded'])<button type="button" class="iz-f" data-f="refunded">Refunded <em>{{ $counts['refunded'] }}</em></button>@endif
            </div>
            @endif
        </div>

        @if($rows->isEmpty())
            <div class="iz-empty">
                <div class="ei"><i class="fas fa-file-invoice-dollar"></i></div>
                <h5>No payments yet</h5>
                <p>When you purchase a plan, your payments will show up here.</p>
                <a href="{{ $plansUrl }}" class="iz-btn"><i class="fas fa-rocket"></i> View plans</a>
            </div>
        @else
        <div class="table-responsive" style="overflow-x:auto">
            <table class="iz-tbl">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Mode</th>
                        <th>Order ID</th>
                        <th>Payment ID</th>
                        <th>Paid on</th>
                    </tr>
                </thead>
                <tbody id="izRows">
                @foreach($rows as $payment)
                    @php
                        $st = strtolower($payment->payment_status ?? '');
                        [$label, $cls, $key] = match($st) {
                            'captured' => ['Paid', 'ok', 'paid'],
                            'refunded' => ['Refunded', 'warn', 'refunded'],
                            'failed'   => ['Failed', 'bad', 'failed'],
                            default    => [ucfirst($st ?: 'Pending'), 'gray', 'other'],
                        };
                        $mode = strtolower($payment->payment_mode ?? '');
                        $modeIcon = match(true) {
                            $mode === 'upi' => 'fa-mobile-screen',
                            str_contains($mode, 'card') => 'fa-credit-card',
                            str_contains($mode, 'netbanking'), str_contains($mode, 'bank') => 'fa-building-columns',
                            str_contains($mode, 'wallet') => 'fa-wallet',
                            default => 'fa-money-bill-wave',
                        };
                        $paidAt = !empty($payment->paid_at) ? \Carbon\Carbon::parse($payment->paid_at) : null;
                    @endphp
                    <tr data-status="{{ $key }}">
                        <td data-label="Plan">
                            <div class="iz-plan">
                                <span class="pi"><i class="fas fa-gem"></i></span>
                                <div><b>{{ $payment->plan_name }}</b><small>Subscription</small></div>
                            </div>
                        </td>
                        <td data-label="Amount"><span class="iz-amt">₹{{ number_format($payment->amount, 2) }}</span></td>
                        <td data-label="Status"><span class="iz-st {{ $cls }}">{{ $label }}</span></td>
                        <td data-label="Mode">
                            @if($mode)
                                <span class="iz-mode"><i class="fas {{ $modeIcon }}"></i> {{ strtoupper($payment->payment_mode) }}</span>
                            @else - @endif
                        </td>
                        <td data-label="Order ID">
                            <span class="iz-id"><span title="{{ $payment->order_id }}">{{ $payment->order_id }}</span>
                                <button type="button" class="iz-copy" data-copy="{{ $payment->order_id }}" title="Copy"><i class="far fa-copy"></i></button></span>
                        </td>
                        <td data-label="Payment ID">
                            @if(!empty($payment->payment_id))
                            <span class="iz-id"><span title="{{ $payment->payment_id }}">{{ $payment->payment_id }}</span>
                                <button type="button" class="iz-copy" data-copy="{{ $payment->payment_id }}" title="Copy"><i class="far fa-copy"></i></button></span>
                            @else - @endif
                        </td>
                        <td data-label="Paid on">
                            @if($paidAt)
                                <div class="iz-date"><b>{{ $paidAt->format('d M Y') }}</b><small>{{ $paidAt->format('h:i A') }}</small></div>
                            @else - @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="iz-none" id="izNone">No payments in this category.</div>
        </div>

        @if($payments instanceof \Illuminate\Pagination\AbstractPaginator && $payments->hasPages())
            <div class="p-4">{{ $payments->links() }}</div>
        @endif
        @endif
    </div>

</div>
</div>

<script>
(function () {
    // status filter
    const filters = document.getElementById('izFilters');
    if (filters) {
        const rows = document.querySelectorAll('#izRows tr');
        const none = document.getElementById('izNone');
        filters.addEventListener('click', function (e) {
            const b = e.target.closest('.iz-f');
            if (!b) return;
            filters.querySelectorAll('.iz-f').forEach(x => x.classList.toggle('on', x === b));
            const f = b.dataset.f;
            let shown = 0;
            rows.forEach(function (r) {
                const ok = f === 'all' || r.dataset.status === f;
                r.style.display = ok ? '' : 'none';
                if (ok) shown++;
            });
            none.style.display = shown ? 'none' : 'block';
        });
    }

    // copy IDs
    document.querySelectorAll('.iz-copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const done = function () {
                btn.classList.add('done');
                btn.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(function () {
                    btn.classList.remove('done');
                    btn.innerHTML = '<i class="far fa-copy"></i>';
                }, 1400);
            };
            if (navigator.clipboard) {
                navigator.clipboard.writeText(btn.dataset.copy).then(done);
            } else {
                const t = document.createElement('textarea');
                t.value = btn.dataset.copy; document.body.appendChild(t);
                t.select(); document.execCommand('copy'); t.remove(); done();
            }
        });
    });
})();
</script>
</x-default-layout>