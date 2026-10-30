<x-default-layout>
    @if( !empty($data['registration']) && $data['registration'] == 'success')

    <div class="dz-tip alert alert-dismissible fade show" role="alert">
        <span class="dz-tip-ico"><i class="bi bi-bookmark-star-fill"></i></span>
        <div class="dz-tip-body">
            <strong>Tip:</strong> Save your Admin URL for quick access next time!
            <div class="dz-tip-url"><code>{{ url('/') }}</code> <a href="#" class="copyButton" link="{{ url('/') }}" title="Copy URL"><i class="fa-regular fa-copy copy-font"> </i></a> </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Meta Pixel Code for pro.invoicezy.com (success page) -->
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
        fbq('track', 'CompleteRegistration'); // 🔥 This tracks successful registrations
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1004383331897465&ev=RegistrationPage&noscript=1" /></noscript>
    @endif

    {{-- ===================== Data prep (sirf display ke liye, backend same) ===================== --}}
    @php
        $cur        = $data['currency_symbol'] ?? '';
        $totalInv   = (int) ($data['summary']->total_invoices ?? 0);
        $revenue    = (float) ($data['summary']->total_revenue ?? 0);
        $pendingInv = (int) ($data['summary']->pending_invoices ?? 0);
        $overdueInv = (int) ($data['summary']->overdue_invoices ?? 0);

        $pendingPct = $totalInv > 0 ? min(100, round($pendingInv / $totalInv * 100)) : 0;
        $overduePct = $totalInv > 0 ? min(100, round($overdueInv / $totalInv * 100)) : 0;

        // greeting
        $hour = (int) now('Asia/Kolkata')->format('G');
        $greeting  = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $authUser  = auth()->user();
        $firstName = ($authUser && !empty($authUser->first_name)) ? \Illuminate\Support\Str::before(trim($authUser->first_name), ' ') : '';

        // monthly chart + trend
        $monthly     = is_array($data['monthlyChart'] ?? null) ? $data['monthlyChart'] : [];
        $monthlyVals = array_values($monthly);
        $monthlyKeys = array_keys($monthly);
        $hasMonthly  = count($monthlyVals) > 0;
        $trend       = null;
        if (count($monthlyVals) >= 2) {
            $last = (float) end($monthlyVals);
            $prev = (float) $monthlyVals[count($monthlyVals) - 2];
            $trend = $prev > 0 ? round(($last - $prev) / $prev * 100) : null;
        }
        $latestKey = $hasMonthly ? end($monthlyKeys) : null;
        $latestVal = $hasMonthly ? end($monthlyVals) : null;

        // status chart
        $statusChart = is_array($data['statusChart'] ?? null) ? $data['statusChart'] : [];
        $statusTotal = (float) array_sum($statusChart);
        $hasStatus   = $statusTotal > 0;
        $statusColors = ['paid' => '#10b981', 'pending' => '#f59e0b', 'overdue' => '#ef4444'];
        $statusLower  = [];
        foreach ($statusChart as $k => $v) { $statusLower[strtolower($k)] = (float) $v; }
        $paidRate = ($hasStatus && isset($statusLower['paid'])) ? round($statusLower['paid'] / $statusTotal * 100) : null;

        // upcoming dues
        $dues = [];
        foreach (($data['upcomingDues'] ?? []) as $d) {
            $days = (int) \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($d['due_date'])->startOfDay(), false);
            $dues[] = [
                'number' => $d['invoice_number'],
                'date'   => \Carbon\Carbon::parse($d['due_date']),
                'days'   => $days,
                'class'  => $days <= 2 ? 'soon' : ($days <= 7 ? 'week' : 'later'),
                'label'  => $days < 0 ? abs($days) . ' ' . \Illuminate\Support\Str::plural('day', abs($days)) . ' overdue'
                           : ($days === 0 ? 'Due today' : ($days === 1 ? 'Due tomorrow' : 'In ' . $days . ' days')),
            ];
        }
        $dueSoon = count(array_filter($dues, fn($x) => $x['days'] >= 0 && $x['days'] <= 7));

        // insights
        $insights = [];
        if ($overdueInv > 0) {
            $insights[] = ['type' => 'danger', 'icon' => 'bi-exclamation-triangle-fill', 'strong' => $overdueInv, 'text' => ' overdue ' . \Illuminate\Support\Str::plural('invoice', $overdueInv) . ' need your attention'];
        }
        if ($dueSoon > 0) {
            $insights[] = ['type' => 'warning', 'icon' => 'bi-alarm-fill', 'strong' => $dueSoon, 'text' => ' ' . \Illuminate\Support\Str::plural('invoice', $dueSoon) . ' due within the next 7 days'];
        }
        if ($paidRate !== null) {
            $insights[] = ['type' => 'success', 'icon' => 'bi-patch-check-fill', 'strong' => $paidRate . '%', 'text' => ' of your invoices are paid'];
        }
        if ($trend !== null) {
            $insights[] = ['type' => $trend >= 0 ? 'info' : 'warning', 'icon' => $trend >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow', 'strong' => abs($trend) . '%', 'text' => ($trend >= 0 ? ' more' : ' fewer') . ' invoices than the previous month'];
        }
    @endphp

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .dz-wrap{
            --dz-ink:#0f172a;--dz-mut:#64748b;--dz-bd:#e8ebf3;--dz-card:#fff;--dz-bg:#f8fafc;
            --dz-i1:#4f46e5;--dz-i2:#7c3aed;
            --dz-ok:#10b981;--dz-ok-bg:#ecfdf5;--dz-ok-ink:#047857;
            --dz-warn:#f59e0b;--dz-warn-bg:#fffbeb;--dz-warn-ink:#b45309;
            --dz-bad:#ef4444;--dz-bad-bg:#fff1f2;--dz-bad-ink:#be123c;
            --dz-info:#0ea5e9;--dz-info-bg:#f0f9ff;--dz-info-ink:#0369a1;
            font-family:'Inter',sans-serif;color:var(--dz-ink);
        }
        .dz-wrap h1,.dz-wrap h2,.dz-wrap h3,.dz-wrap h4,.dz-wrap h5,.dz-wrap h6{font-family:'Outfit',sans-serif}
        .dz-wrap .tabular{font-variant-numeric:tabular-nums}
        .dz-wrap a{text-decoration:none}

        /* ---------- registration tip ---------- */
        .dz-tip{display:flex;align-items:center;gap:14px;margin:18px 0 0;padding:14px 18px;border:1px solid #c7d2fe;border-left:4px solid #4f46e5;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);box-shadow:0 10px 30px -22px rgba(79,70,229,.5)}
        .dz-tip-ico{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;background:linear-gradient(135deg,#4f46e5,#818cf8);box-shadow:0 10px 18px -10px rgba(79,70,229,.7)}
        .dz-tip-ico,.dz-tip-ico i{color:#fff!important;font-size:18px}
        .dz-tip-body{flex:1;min-width:0;font-size:14px;color:#312e81}
        .dz-tip-url{margin-top:4px;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .dz-tip-url code{padding:3px 9px;border-radius:8px;background:#fff;border:1px solid #e0e7ff;color:#4338ca;word-break:break-all}
        .dz-tip .btn-close{position:static;padding:8px;margin:0}

        /* ---------- hero ---------- */
        .dz-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;margin:18px 0 22px;padding:30px 32px;border-radius:24px;color:#fff;
            background:radial-gradient(640px 260px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(460px 260px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
            box-shadow:0 26px 50px -28px rgba(79,70,229,.65)}
        .dz-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:34px 34px;-webkit-mask-image:radial-gradient(circle at 15% 25%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 25%,#000,transparent 75%)}
        .dz-hero > *{position:relative;z-index:1}
        .dz-hero-chips{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
        .dz-chip{display:inline-flex;align-items:center;gap:7px;padding:6px 12px;border-radius:99px;font-size:12px;font-weight:600;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#e0e7ff}
        .dz-chip i{color:inherit!important;font-size:12px}
        .dz-chip .dot{width:7px;height:7px;border-radius:50%;background:#34d399;box-shadow:0 0 0 3px rgba(52,211,153,.25)}
        .dz-hero h2{margin:0 0 6px;color:#fff;font-size:30px;font-weight:700;letter-spacing:-.02em}
        .dz-hero p{margin:0;color:#c7d2fe;font-size:14.5px}
        .dz-hero-actions{display:flex;gap:10px;flex-wrap:wrap}
        .dz-btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;height:46px;padding:0 22px;border-radius:13px;font-size:14px;font-weight:700;white-space:nowrap;transition:.2s}
        .dz-btn i{font-size:16px;color:inherit!important}
        .dz-btn.light{background:#fff;color:#1e1b4b;box-shadow:0 14px 28px -14px rgba(0,0,0,.5)}
        .dz-btn.light i{color:#4f46e5!important}
        .dz-btn.light:hover{transform:translateY(-2px);color:#1e1b4b}
        .dz-btn.glass{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.28);color:#fff}
        .dz-btn.glass:hover{background:rgba(255,255,255,.2);color:#fff}

        /* ---------- alert strip ---------- */
        .dz-alert{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:22px;padding:14px 18px;border-radius:16px;border:1px solid #fecdd3;background:linear-gradient(135deg,#fff1f2,#fff7f7)}
        .dz-alert .ico{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:linear-gradient(135deg,#e11d48,#fb7185);box-shadow:0 10px 18px -10px rgba(225,29,72,.6)}
        .dz-alert .ico,.dz-alert .ico i{color:#fff!important}
        .dz-alert .tx{flex:1;min-width:200px;font-size:14px;color:#881337}
        .dz-alert .tx b{color:#9f1239}
        .dz-alert .go{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;background:#fff;border:1px solid #fecdd3;color:#be123c;font-size:13px;font-weight:700;transition:.2s}
        .dz-alert .go:hover{background:#be123c;color:#fff;border-color:#be123c}

        /* ---------- KPI cards ---------- */
        .dz-kpi{position:relative;height:100%;padding:22px;background:var(--dz-card);border:1px solid var(--dz-bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22);overflow:hidden;transition:transform .2s,box-shadow .2s,border-color .2s}
        .dz-kpi:hover{transform:translateY(-4px);box-shadow:0 22px 40px -24px rgba(79,70,229,.35);border-color:#c7d2fe}
        .dz-kpi-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}
        .dz-ico{flex:none;width:48px;height:48px;border-radius:14px;display:grid;place-items:center;font-size:20px;transition:transform .25s}
        .dz-ico,.dz-ico i{color:#fff!important}
        .dz-kpi:hover .dz-ico{transform:scale(1.07) rotate(-3deg)}
        .dz-ico.indigo{background:linear-gradient(135deg,#6366f1,#4f46e5);box-shadow:0 10px 18px -10px rgba(79,70,229,.7)}
        .dz-ico.green{background:linear-gradient(135deg,#34d399,#059669);box-shadow:0 10px 18px -10px rgba(16,185,129,.7)}
        .dz-ico.amber{background:linear-gradient(135deg,#fbbf24,#d97706);box-shadow:0 10px 18px -10px rgba(245,158,11,.7)}
        .dz-ico.rose{background:linear-gradient(135deg,#fb7185,#e11d48);box-shadow:0 10px 18px -10px rgba(225,29,72,.6)}
        .dz-kpi-label{font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--dz-mut)}
        .dz-kpi-value{margin-top:4px;font-family:'Outfit',sans-serif;font-size:30px;font-weight:700;line-height:1.15;letter-spacing:-.02em;color:var(--dz-ink);word-break:break-word}
        .dz-kpi-foot{margin-top:14px;font-size:12.5px;color:var(--dz-mut)}
        .dz-kpi-foot b{color:var(--dz-ink)}
        .dz-bar{height:6px;margin-top:8px;border-radius:99px;background:#eef2f7;overflow:hidden}
        .dz-bar > span{display:block;height:100%;border-radius:99px}
        .dz-bar .amber{background:linear-gradient(90deg,#fbbf24,#f59e0b)}
        .dz-bar .rose{background:linear-gradient(90deg,#fb7185,#ef4444)}
        .dz-bar .green{background:linear-gradient(90deg,#34d399,#10b981)}
        #dzSpark{margin:8px -6px -8px;min-height:44px}

        /* ---------- section title ---------- */
        .dz-sec{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:6px 2px 14px}
        .dz-sec h5{margin:0;font-size:16px;font-weight:700;letter-spacing:-.01em}
        .dz-sec span{font-size:12.5px;color:var(--dz-mut)}

        /* ---------- quick actions ---------- */
        .dz-qa{display:flex;align-items:center;gap:14px;height:100%;padding:16px 18px;background:var(--dz-card);border:1px solid var(--dz-bd);border-radius:18px;box-shadow:0 10px 30px -24px rgba(15,23,42,.22);color:var(--dz-ink);transition:.2s}
        .dz-qa:hover{transform:translateY(-3px);border-color:#c7d2fe;box-shadow:0 20px 36px -24px rgba(79,70,229,.4);color:var(--dz-ink)}
        .dz-qa .ico{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px}
        .dz-qa .ico,.dz-qa .ico i{color:#fff!important}
        .dz-qa .tx{flex:1;min-width:0}
        .dz-qa .tx b{display:block;font-size:14px;font-weight:700;color:var(--dz-ink)}
        .dz-qa .tx small{display:block;margin-top:1px;font-size:12px;color:var(--dz-mut)}
        .dz-qa .go{flex:none;color:#cbd5e1;font-size:14px;transition:.2s}
        .dz-qa:hover .go{color:var(--dz-i1);transform:translateX(3px)}

        /* ---------- cards ---------- */
        .dz-card{height:100%;padding:24px;background:var(--dz-card);border:1px solid var(--dz-bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
        .dz-card-h{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px}
        .dz-card-h h5{margin:0 0 2px;font-size:16px;font-weight:700;letter-spacing:-.01em}
        .dz-card-h p{margin:0;font-size:12.5px;color:var(--dz-mut)}
        .dz-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:99px;font-size:12px;font-weight:700;white-space:nowrap;background:#eef2ff;color:var(--dz-i1)}
        .dz-badge i{color:inherit!important;font-size:12px}
        .dz-badge.up{background:var(--dz-ok-bg);color:var(--dz-ok-ink)}
        .dz-badge.down{background:var(--dz-bad-bg);color:var(--dz-bad-ink)}
        .dz-link{display:inline-flex;align-items:center;gap:6px;font-size:12.5px;font-weight:700;color:var(--dz-i1);white-space:nowrap}
        .dz-link:hover{color:#3730a3}
        .dz-link i{color:inherit!important;font-size:12px}
        .dz-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:34px 10px;text-align:center;font-size:13.5px;color:var(--dz-mut)}
        .dz-empty i{font-size:30px;color:#cbd5e1!important}

        /* ---------- collection health ---------- */
        .dz-seg{display:flex;height:12px;border-radius:99px;overflow:hidden;background:#eef2f7;gap:3px}
        .dz-seg > span{display:block;height:100%;min-width:6px;border-radius:99px;transition:width .4s}
        .dz-legend{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:12px;margin-top:18px}
        .dz-lg{padding:14px 16px;border-radius:16px;background:var(--dz-bg);border:1px solid var(--dz-bd)}
        .dz-lg .k{display:flex;align-items:center;gap:8px;font-size:12px;font-weight:700;color:var(--dz-mut);text-transform:uppercase;letter-spacing:.05em}
        .dz-lg .k i{width:9px;height:9px;border-radius:50%;display:inline-block}
        .dz-lg .v{margin-top:6px;font-family:'Outfit',sans-serif;font-size:24px;font-weight:700;color:var(--dz-ink)}
        .dz-lg .p{font-size:12px;color:var(--dz-mut)}

        /* ---------- insights ---------- */
        .dz-ins{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:14px;border:1px solid transparent;font-size:13.5px}
        .dz-ins + .dz-ins{margin-top:10px}
        .dz-ins .i{flex:none;width:34px;height:34px;border-radius:10px;display:grid;place-items:center;background:#fff;font-size:15px}
        .dz-ins.danger{background:var(--dz-bad-bg);border-color:#fecdd3;color:#881337}
        .dz-ins.danger .i,.dz-ins.danger .i i{color:var(--dz-bad-ink)!important}
        .dz-ins.warning{background:var(--dz-warn-bg);border-color:#fde68a;color:#78350f}
        .dz-ins.warning .i,.dz-ins.warning .i i{color:var(--dz-warn-ink)!important}
        .dz-ins.success{background:var(--dz-ok-bg);border-color:#a7f3d0;color:#064e3b}
        .dz-ins.success .i,.dz-ins.success .i i{color:var(--dz-ok-ink)!important}
        .dz-ins.info{background:var(--dz-info-bg);border-color:#bae6fd;color:#0c4a6e}
        .dz-ins.info .i,.dz-ins.info .i i{color:var(--dz-info-ink)!important}
        .dz-ins b{font-weight:800}

        /* ---------- table ---------- */
        .dz-table{width:100%;margin:0;border-collapse:separate;border-spacing:0}
        .dz-table thead th{padding:10px 12px;font-size:11.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--dz-mut);background:var(--dz-bg);border-bottom:1px solid var(--dz-bd);white-space:nowrap}
        .dz-table thead th:first-child{border-radius:12px 0 0 12px}
        .dz-table thead th:last-child{border-radius:0 12px 12px 0}
        .dz-table tbody td{padding:14px 12px;font-size:14px;vertical-align:middle;border-bottom:1px solid #f1f4f9;white-space:nowrap}
        .dz-table tbody tr:last-child td{border-bottom:0}
        .dz-table tbody tr{transition:background .15s}
        .dz-table tbody tr:hover{background:#fafaff}
        .dz-inv{display:inline-flex;align-items:center;gap:10px;font-weight:700}
        .dz-inv .ic{flex:none;width:36px;height:36px;border-radius:11px;display:grid;place-items:center;background:#eef2ff;font-size:15px}
        .dz-inv .ic,.dz-inv .ic i{color:var(--dz-i1)!important}
        .dz-pill{display:inline-flex;align-items:center;gap:7px;padding:5px 12px;border-radius:99px;font-size:12px;font-weight:700}
        .dz-pill .dot{width:7px;height:7px;border-radius:50%;background:currentColor}
        .dz-pill.paid{background:var(--dz-ok-bg);color:var(--dz-ok-ink)}
        .dz-pill.pending{background:var(--dz-warn-bg);color:var(--dz-warn-ink)}
        .dz-pill.overdue{background:var(--dz-bad-bg);color:var(--dz-bad-ink)}
        .dz-pill.default{background:#f1f5f9;color:var(--dz-mut)}

        /* ---------- dues ---------- */
        .dz-due{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 4px;border-bottom:1px solid #f1f4f9}
        .dz-due:last-child{border-bottom:0}
        .dz-due-l{display:flex;align-items:center;gap:12px;min-width:0}
        .dz-due-l .ic{flex:none;width:38px;height:38px;border-radius:11px;display:grid;place-items:center;font-size:15px}
        .dz-due-l .ic.soon{background:var(--dz-bad-bg)}  .dz-due-l .ic.soon,.dz-due-l .ic.soon i{color:var(--dz-bad-ink)!important}
        .dz-due-l .ic.week{background:var(--dz-warn-bg)} .dz-due-l .ic.week,.dz-due-l .ic.week i{color:var(--dz-warn-ink)!important}
        .dz-due-l .ic.later{background:var(--dz-info-bg)}.dz-due-l .ic.later,.dz-due-l .ic.later i{color:var(--dz-info-ink)!important}
        .dz-due-n{font-size:14px;font-weight:700;color:var(--dz-ink);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .dz-due-s{font-size:12px;color:var(--dz-mut)}
        .dz-due-pill{flex:none;padding:5px 11px;border-radius:99px;font-size:12px;font-weight:700;white-space:nowrap}
        .dz-due-pill.soon{background:var(--dz-bad-bg);color:var(--dz-bad-ink)}
        .dz-due-pill.week{background:var(--dz-warn-bg);color:var(--dz-warn-ink)}
        .dz-due-pill.later{background:var(--dz-info-bg);color:var(--dz-info-ink)}

        @media (max-width:991px){
            .dz-hero{padding:26px 22px}
        }
        @media (max-width:767px){
            .dz-hero{padding:22px 18px;border-radius:20px}
            .dz-hero h2{font-size:23px}
            .dz-hero-actions{width:100%}
            .dz-hero-actions .dz-btn{flex:1}
            .dz-kpi{padding:18px}
            .dz-kpi-value{font-size:26px}
            .dz-card{padding:18px}
            .dz-tip{align-items:flex-start;padding:12px 14px}
        }
        @media (prefers-reduced-motion:reduce){
            .dz-kpi,.dz-qa,.dz-btn,.dz-ico{transition:none}
            .dz-kpi:hover,.dz-qa:hover,.dz-btn:hover{transform:none}
        }
    </style>

    <div class="dz-wrap container-fluid {{ $data['registration'] ?? '' }}">

        <!-- ===================== Hero ===================== -->
        <div class="dz-hero">
            <div>
                <div class="dz-hero-chips">
                    <span class="dz-chip"><span class="dot"></span> Live overview</span>
                    <span class="dz-chip"><i class="bi bi-calendar3"></i> {{ now()->format('D, d M Y') }}</span>
                    <span class="dz-chip" title="Dashboard data refreshes every 10 minutes via backend process"><i class="bi bi-arrow-repeat"></i> Auto-sync every 10 min</span>
                </div>
                <h2>{{ $greeting }}, {{ $firstName  }} 👋</h2>
                <p>Here's what's happening with your invoices today.</p>
            </div>
            <div class="dz-hero-actions">
                <a href="{{ route('invoice.add') }}" class="dz-btn light">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Create New Invoice
                </a>
                <a href="{{ url('/estimate/add') }}" class="dz-btn glass">
                    <i class="bi bi-file-earmark-plus"></i>
                    New Estimate
                </a>
            </div>
        </div>

        @if($overdueInv > 0)
        <!-- ===================== Overdue alert ===================== -->
        <div class="dz-alert" role="alert">
            <span class="ico"><i class="bi bi-exclamation-triangle-fill"></i></span>
            <div class="tx"><b>{{ number_format($overdueInv) }}</b> {{ \Illuminate\Support\Str::plural('invoice', $overdueInv) }} {{ $overdueInv === 1 ? 'is' : 'are' }} overdue. Follow up with your clients to get paid faster.</div>
            <a href="{{ route('invoice.list') }}" class="go">Review invoices <i class="bi bi-arrow-right"></i></a>
        </div>
        @endif

        <!-- ===================== KPI cards ===================== -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="dz-kpi">
                    <div class="dz-kpi-top">
                        <div>
                            <div class="dz-kpi-label">Total Invoices</div>
                            <div class="dz-kpi-value tabular">{{ number_format($data['summary']->total_invoices ?? 0 ) }}</div>
                        </div>
                        <div class="dz-ico indigo"><i class="bi bi-receipt-cutoff"></i></div>
                    </div>
                    @if(count($monthlyVals) >= 2)
                    <div id="dzSpark"></div>
                    @endif
                    <div class="dz-kpi-foot">
                        @if($latestKey !== null)
                        Latest: <b>{{ $latestKey }}</b> · <b class="tabular">{{ $latestVal }}</b> {{ \Illuminate\Support\Str::plural('invoice', (int) $latestVal) }}
                        @else
                        Create your first invoice to get started
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dz-kpi">
                    <div class="dz-kpi-top">
                        <div>
                            <div class="dz-kpi-label">Revenue</div>
                            <div class="dz-kpi-value tabular">{{ $data['currency_symbol'] }}{{ number_format($data['summary']->total_revenue ?? 0, 2) }}</div>
                        </div>
                        <div class="dz-ico green"><i class="bi bi-graph-up-arrow"></i></div>
                    </div>
                    <div class="dz-kpi-foot">
                        @if($paidRate !== null)
                        <b>{{ $paidRate }}%</b> of invoices paid
                        <div class="dz-bar"><span class="green" style="width: {{ $paidRate }}%"></span></div>
                        @else
                        Across <b class="tabular">{{ number_format($totalInv) }}</b> {{ \Illuminate\Support\Str::plural('invoice', $totalInv) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dz-kpi">
                    <div class="dz-kpi-top">
                        <div>
                            <div class="dz-kpi-label">Pending</div>
                            <div class="dz-kpi-value tabular">{{ number_format($data['summary']->pending_invoices ?? 0) }}</div>
                        </div>
                        <div class="dz-ico amber"><i class="bi bi-clock-history"></i></div>
                    </div>
                    <div class="dz-kpi-foot">
                        <b>{{ $pendingPct }}%</b> of all invoices
                        <div class="dz-bar"><span class="amber" style="width: {{ $pendingPct }}%"></span></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dz-kpi">
                    <div class="dz-kpi-top">
                        <div>
                            <div class="dz-kpi-label">Overdue</div>
                            <div class="dz-kpi-value tabular">{{ number_format($data['summary']->overdue_invoices ?? 0) }}</div>
                        </div>
                        <div class="dz-ico rose"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    </div>
                    <div class="dz-kpi-foot">
                        @if($overdueInv > 0)
                        <b>{{ $overduePct }}%</b> of all invoices
                        <div class="dz-bar"><span class="rose" style="width: {{ $overduePct }}%"></span></div>
                        @else
                        <b>Nothing overdue</b> — great job!
                        <div class="dz-bar"><span class="green" style="width: 100%"></span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== Quick actions ===================== -->
        <div class="dz-sec"><h5>Quick actions</h5><span>Jump straight to common tasks</span></div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <a href="{{ route('invoice.add') }}" class="dz-qa">
                    <span class="ico" style="background:linear-gradient(135deg,#6366f1,#4f46e5)"><i class="bi bi-receipt"></i></span>
                    <span class="tx"><b>New invoice</b><small>Bill a client</small></span>
                    <i class="bi bi-arrow-right go"></i>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ url('/estimate/add') }}" class="dz-qa">
                    <span class="ico" style="background:linear-gradient(135deg,#38bdf8,#0284c7)"><i class="bi bi-file-earmark-text"></i></span>
                    <span class="tx"><b>New estimate</b><small>Send a quote</small></span>
                    <i class="bi bi-arrow-right go"></i>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ url('/expense/add') }}" class="dz-qa">
                    <span class="ico" style="background:linear-gradient(135deg,#fbbf24,#d97706)"><i class="bi bi-wallet2"></i></span>
                    <span class="tx"><b>New expense</b><small>Track spending</small></span>
                    <i class="bi bi-arrow-right go"></i>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ route('invoice.list') }}" class="dz-qa">
                    <span class="ico" style="background:linear-gradient(135deg,#34d399,#059669)"><i class="bi bi-collection"></i></span>
                    <span class="tx"><b>All invoices</b><small>View & manage</small></span>
                    <i class="bi bi-arrow-right go"></i>
                </a>
            </div>
        </div>

        <!-- ===================== Charts ===================== -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Monthly Invoice Summary</h5>
                            <p>Invoice volume trend across recent months</p>
                        </div>
                        @if($trend !== null)
                        <span class="dz-badge {{ $trend >= 0 ? 'up' : 'down' }}" title="Compared to the previous month">
                            <i class="bi {{ $trend >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>{{ abs($trend) }}% vs last month
                        </span>
                        @else
                        <span class="dz-badge"><i class="bi bi-bar-chart-fill"></i>Monthly</span>
                        @endif
                    </div>
                    @if($hasMonthly)
                    <div id="invoiceChart" style="height: 300px;"></div>
                    @else
                    <div class="dz-empty"><i class="bi bi-bar-chart"></i>No monthly data yet.<br>Your invoice trend will appear here.</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Invoice Status</h5>
                            <p>Breakdown by status</p>
                        </div>
                    </div>
                    @if($hasStatus)
                    <div id="statusPieChart" style="height: 300px;"></div>
                    @else
                    <div class="dz-empty"><i class="bi bi-pie-chart"></i>No invoices to chart yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ===================== Collection health + Insights ===================== -->
        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Collection Health</h5>
                            <p>How your invoices are distributed right now</p>
                        </div>
                        @if($paidRate !== null)
                        <span class="dz-badge up"><i class="bi bi-patch-check-fill"></i>{{ $paidRate }}% paid</span>
                        @endif
                    </div>
                    @if($hasStatus)
                    <div class="dz-seg" role="img" aria-label="Invoice status distribution">
                        @foreach($statusChart as $label => $count)
                        @php $w = round(((float) $count) / $statusTotal * 100, 2); $c = $statusColors[strtolower($label)] ?? '#94a3b8'; @endphp
                        @if($w > 0)
                        <span style="width: {{ $w }}%; background: {{ $c }}" title="{{ ucfirst($label) }}: {{ $count }}"></span>
                        @endif
                        @endforeach
                    </div>
                    <div class="dz-legend">
                        @foreach($statusChart as $label => $count)
                        @php $c = $statusColors[strtolower($label)] ?? '#94a3b8'; @endphp
                        <div class="dz-lg">
                            <div class="k"><i style="background: {{ $c }}"></i>{{ ucfirst($label) }}</div>
                            <div class="v tabular">{{ number_format((float) $count) }}</div>
                            <div class="p">{{ round(((float) $count) / $statusTotal * 100) }}% of invoices</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="dz-empty"><i class="bi bi-activity"></i>Once you create invoices, your collection health shows up here.</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Insights</h5>
                            <p>What needs your attention</p>
                        </div>
                    </div>
                    @forelse($insights as $ins)
                    <div class="dz-ins {{ $ins['type'] }}">
                        <span class="i"><i class="bi {{ $ins['icon'] }}"></i></span>
                        <div><b>{{ $ins['strong'] }}</b>{{ $ins['text'] }}</div>
                    </div>
                    @empty
                    <div class="dz-empty"><i class="bi bi-check2-circle"></i>You're all caught up!<br>No action needed right now.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ===================== Tables ===================== -->
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Recent Invoices</h5>
                            <p>Latest activity on your account</p>
                        </div>
                        <a href="{{ route('invoice.list') }}" class="dz-link">View all <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="dz-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data['recentInvoices']))
                                @foreach ($data['recentInvoices'] as $index => $invoice)
                                <tr>
                                    <td class="text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="dz-inv"><span class="ic"><i class="bi bi-file-earmark-text"></i></span>{{ $invoice['invoice_number'] }}</span>
                                    </td>
                                    <td class="text-muted">{{ $invoice['date'] }}</td>
                                    <td>
                                        @php
                                        $status = strtolower($invoice['status']);
                                        $pillClass = match($status) {
                                        'paid' => 'paid',
                                        'pending' => 'pending',
                                        'overdue' => 'overdue',
                                        default => 'default'
                                        };
                                        @endphp
                                        <span class="dz-pill {{ $pillClass }}"><span class="dot"></span>{{ ucfirst($status) }}</span>
                                    </td>
                                    <td class="text-end fw-semibold tabular">{{ $cur !== '' ? $cur : '$' }}{{ number_format($invoice['amount'], 2) }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5">
                                        <div class="dz-empty"><i class="bi bi-inbox"></i>No recent invoices yet.</div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="dz-card">
                    <div class="dz-card-h">
                        <div>
                            <h5>Upcoming Dues</h5>
                            <p>Invoices due soon</p>
                        </div>
                        @if($dueSoon > 0)
                        <span class="dz-badge down"><i class="bi bi-alarm-fill"></i>{{ $dueSoon }} this week</span>
                        @endif
                    </div>

                    @if(count($dues))
                    @foreach ($dues as $due)
                    <div class="dz-due">
                        <div class="dz-due-l">
                            <span class="ic {{ $due['class'] }}"><i class="bi bi-calendar-event"></i></span>
                            <div style="min-width:0">
                                <div class="dz-due-n">{{ $due['number'] }}</div>
                                <div class="dz-due-s">Due {{ $due['date']->format('d M, Y') }} · {{ $due['label'] }}</div>
                            </div>
                        </div>
                        <span class="dz-due-pill {{ $due['class'] }}">{{ $due['date']->format('d M') }}</span>
                    </div>
                    @endforeach
                    @else
                    <div class="dz-empty"><i class="bi bi-check2-circle"></i>No upcoming dues. You're all caught up!</div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ApexCharts Setup -->
    <script>
        if (window.jQuery) {
            $('.copyButton').on('click', function(e) {
                e.preventDefault();
                copyToClipboard($(this).attr('link'));
            });
        }

        (function() {
            var monthlyVals = @json($monthlyVals);
            var monthlyKeys = @json($monthlyKeys);
            var statusVals = @json(array_values($statusChart));
            var statusLabels = @json(array_keys($statusChart));
            var statusColorMap = {
                paid: '#10b981',
                pending: '#f59e0b',
                overdue: '#ef4444'
            };

            // Monthly Invoices Bar Chart
            var barEl = document.querySelector("#invoiceChart");
            if (barEl && monthlyVals.length) {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif',
                        animations: { easing: 'easeinout', speed: 500 }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            borderRadiusApplication: 'end',
                            columnWidth: '42%'
                        }
                    },
                    dataLabels: { enabled: false },
                    series: [{
                        name: 'Invoices',
                        data: monthlyVals
                    }],
                    xaxis: {
                        categories: monthlyKeys,
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: { style: { colors: '#64748b', fontSize: '12px' } }
                    },
                    yaxis: {
                        min: 0,
                        forceNiceScale: true,
                        labels: {
                            style: { colors: '#94a3b8', fontSize: '12px' },
                            formatter: function(v) { return Math.round(v); }
                        }
                    },
                    grid: {
                        borderColor: '#eef2f7',
                        strokeDashArray: 4,
                        padding: { left: 6, right: 6 }
                    },
                    colors: ['#4f46e5'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            gradientToColors: ['#7c3aed'],
                            opacityFrom: 1,
                            opacityTo: 0.85
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function(v) { return v + (v === 1 ? ' invoice' : ' invoices'); } }
                    },
                    states: { hover: { filter: { type: 'lighten', value: 0.06 } } }
                };
                new ApexCharts(barEl, options).render();
            }

            // KPI sparkline
            var sparkEl = document.querySelector("#dzSpark");
            if (sparkEl && monthlyVals.length >= 2) {
                new ApexCharts(sparkEl, {
                    chart: { type: 'area', height: 48, sparkline: { enabled: true }, fontFamily: 'Inter, sans-serif' },
                    series: [{ name: 'Invoices', data: monthlyVals }],
                    stroke: { curve: 'smooth', width: 2.5 },
                    colors: ['#4f46e5'],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.28, opacityTo: 0.02, stops: [0, 100] } },
                    tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
                }).render();
            }

            // Invoice Status Donut Chart
            var pieEl = document.querySelector("#statusPieChart");
            if (pieEl && statusVals.length) {
                var pieColors = statusLabels.map(function(l) { return statusColorMap[String(l).toLowerCase()] || '#94a3b8'; });
                var pieOptions = {
                    chart: {
                        type: 'donut',
                        height: 300,
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: statusVals.map(Number),
                    labels: statusLabels,
                    colors: pieColors,
                    stroke: { width: 3, colors: ['#ffffff'] },
                    legend: {
                        position: 'bottom',
                        fontSize: '13px',
                        markers: { width: 10, height: 10, radius: 10 },
                        itemMargin: { horizontal: 8 }
                    },
                    dataLabels: { enabled: false },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: { fontSize: '13px', color: '#64748b' },
                                    value: { fontSize: '26px', fontWeight: 700, color: '#0f172a', fontFamily: 'Outfit, sans-serif' },
                                    total: { show: true, label: 'Total', color: '#64748b' }
                                }
                            }
                        }
                    }
                };
                new ApexCharts(pieEl, pieOptions).render();
            }
        })();
    </script>

</x-default-layout>