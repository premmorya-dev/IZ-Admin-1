<style>
    .rp{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a}

    /* header */
    .rp-head{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:18px}
    .rp-head h3{margin:0;font-size:20px;font-weight:800;letter-spacing:-.02em;color:var(--ink)}
    .rp-head p{margin:2px 0 0;font-size:13px;color:var(--mut)}
    .rp-dl{display:inline-flex;align-items:center;gap:8px;height:44px;padding:0 20px;border-radius:12px;font-weight:700;font-size:14px;color:#fff;text-decoration:none!important;
        background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 12px 24px -12px rgba(79,70,229,.8);transition:.2s}
    .rp-dl:hover{transform:translateY(-2px);color:#fff}

    .rp-warn{display:flex;gap:10px;align-items:flex-start;padding:12px 16px;border-radius:14px;margin-bottom:18px;font-size:13px;font-weight:500;color:#b45309;background:#fffbeb;border:1px solid #fde68a}

    /* hero */
    .rp-hero{position:relative;overflow:hidden;border-radius:22px;padding:26px 28px;color:#fff;margin-bottom:16px;
        background:radial-gradient(600px 240px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(420px 240px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 24px 46px -26px rgba(79,70,229,.6)}
    .rp-hero::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:34px 34px;mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);pointer-events:none}
    .rp-hero > *{position:relative;z-index:1}
    .rp-hero-row{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap}
    .rp-hero small{display:block;color:#c7d2fe;font-size:12px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:6px}
    .rp-hero .big{font-size:40px;font-weight:800;letter-spacing:-.04em;line-height:1}
    .rp-hero .cnt{display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:12px;font-size:13px;font-weight:600;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22)}
    .rp-prog{margin-top:22px}
    .rp-prog .meta{display:flex;justify-content:space-between;gap:10px;font-size:12.5px;color:#c7d2fe;margin-bottom:8px;flex-wrap:wrap}
    .rp-prog .meta b{color:#fff}

    /* stat cards */
    .rp-stats{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:24px}
    .rp-stat{padding:18px 20px;border-radius:18px;background:#fff;border:1px solid var(--bd);box-shadow:0 10px 30px -24px rgba(15,23,42,.3)}
    .rp-stat .ic{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;font-size:14px;margin-bottom:12px;color:var(--i1);background:#eef2ff;border:1px solid #e0e7ff}
    .rp-stat small{display:block;font-size:12.5px;color:var(--mut);font-weight:500}
    .rp-stat b{display:block;font-size:19px;font-weight:800;letter-spacing:-.02em;color:var(--ink);margin-top:2px;word-break:break-word}
    .rp-stat.good .ic{color:#047857;background:#ecfdf5;border-color:#a7f3d0}
    .rp-stat.good b{color:#047857}
    .rp-stat.bad .ic{color:#be123c;background:#fff1f2;border-color:#fecdd3}
    .rp-stat.bad b{color:#be123c}

    /* table card */
    .rp-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -20px rgba(15,23,42,.2);overflow:hidden}
    .rp-card-h{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;padding:18px 24px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff)}
    .rp-card-h h4{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .rp-search{position:relative;width:260px;max-width:100%}
    .rp-search i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px}
    .rp-search input{width:100%;height:42px;padding:0 14px 0 38px;border-radius:12px;border:1.5px solid #e2e8f0;background:#f8fafc;font-size:14px;outline:0;transition:.2s}
    .rp-search input:focus{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.14)}

    .rp-wrap{overflow-x:auto}
    .rp-tbl{width:100%;min-width:900px;border-collapse:separate;border-spacing:0;margin:0}
    .rp-tbl th{padding:13px 18px;text-align:left;font-size:11.5px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:#94a3b8;background:#f8fafc;border-bottom:1px solid var(--bd);white-space:nowrap}
    .rp-tbl td{padding:15px 18px;border-bottom:1px solid #f1f5f9;font-size:14px;color:#334155;vertical-align:middle;white-space:nowrap}
    .rp-tbl tbody tr{transition:.15s}
    .rp-tbl tbody tr:hover{background:#fafaff}
    .rp-tbl .num,.rp-tbl th.num{text-align:right}
    .rp-tbl .idx{color:#94a3b8;font-size:13px}
    .rp-inv{font-weight:700;color:var(--ink)}
    .rp-cur{display:inline-block;padding:2px 9px;border-radius:8px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569}
    .rp-grand{font-weight:800;color:var(--ink)}
    .rp-due{font-weight:700}
    .rp-due.zero{color:#94a3b8;font-weight:500}
    .rp-due.owe{color:#be123c}
    .rp-st{display:inline-flex;align-items:center;gap:7px;padding:5px 12px;border-radius:99px;font-size:12.5px;font-weight:700}
    .rp-st::before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}
    .rp-st.paid{background:#ecfdf5;color:#047857}
    .rp-st.sent,.rp-st.received{background:#eff6ff;color:#1d4ed8}
    .rp-st.pending,.rp-st.unpaid,.rp-st.partial,.rp-st.draft{background:#fffbeb;color:#b45309}
    .rp-st.overdue{background:#fff1f2;color:#be123c}
    .rp-st.cancelled{background:#f1f5f9;color:#64748b}
    .rp-tbl tfoot th{padding:16px 18px;background:#f5f3ff;color:var(--ink);font-size:14px;font-weight:800;letter-spacing:0;text-transform:none;border-top:2px solid #e0e7ff;border-bottom:0}
    .rp-tbl tfoot th.lbl{text-align:right;color:var(--i1);text-transform:uppercase;font-size:12px;letter-spacing:.1em}

    .rp-empty{text-align:center;padding:48px 20px;color:var(--mut)}
    .rp-empty .ei{width:64px;height:64px;border-radius:18px;display:grid;place-items:center;margin:0 auto 14px;font-size:26px;color:var(--i1);background:#eef2ff;border:1px solid #e0e7ff}
    .rp-empty b{display:block;color:var(--ink);font-size:16px;margin-bottom:4px}
    .rp-none{display:none;text-align:center;padding:30px;color:var(--mut);font-size:14px}

    @media (max-width:1199px){.rp-stats{grid-template-columns:repeat(3,1fr)}}
    @media (max-width:767px){
        .rp-stats{grid-template-columns:1fr 1fr}
        .rp-hero{padding:22px 20px}
        .rp-hero .big{font-size:32px}
        .rp-search{width:100%}
        .rp-dl{width:100%;justify-content:center}
    }
</style>

@php
    $f = fn($n) => number_format((float) $n, 2);

    $grand = (float) $summary['total_grand'];
    $due   = (float) $summary['total_due'];

    // bills me paid field nahi hai, isliye paid = grand total - due
    $paid    = max(0, $grand - $due);
    $paidPct = $grand > 0 ? max(0, min(100, round(($paid / $grand) * 100, 1))) : 0;
    $pctText = rtrim(rtrim(number_format($paidPct, 1), '0'), '.');

    $currencies = collect($bills)->pluck('currency_code')->filter()->unique();
@endphp

<div class="rp">

    <!-- HEADER -->
    <div class="rp-head">
        <div>
            <h3>Bill Summary</h3>
            <p>{{ $summary['total_bills'] }} bill{{ $summary['total_bills'] == 1 ? '' : 's' }} matched your filters.</p>
        </div>
        <a href="{{ route('download.report') }}" class="rp-dl"><i class="fas fa-download"></i> Download report</a>
    </div>

    @if($currencies->count() > 1)
    <div class="rp-warn">
        <i class="fas fa-triangle-exclamation mt-1"></i>
        <div>This report has bills in multiple currencies ({{ $currencies->implode(', ') }}). Totals above add up amounts as they are, without conversion.</div>
    </div>
    @endif

    <!-- HERO -->
    <div class="rp-hero">
        <div class="rp-hero-row">
            <div>
                <small>Total payable</small>
                <div class="big">{{ $f($summary['total_grand']) }}</div>
            </div>
            <span class="cnt"><i class="fas fa-receipt"></i> {{ $summary['total_bills'] }} bills</span>
        </div>
        <div class="rp-prog">
            <div class="meta">
                <span>Paid <b>{{ $f($paid) }}</b> ({{ $pctText }}%)</span>
                <span>Outstanding <b>{{ $f($summary['total_due']) }}</b></span>
            </div>
            <div class="bar" style="display:block;width:100%;height:10px;border-radius:99px;background:rgba(255,255,255,.18);overflow:hidden">
                <span class="fill" style="display:block;height:100%;width:{{ $paidPct }}%;{{ $paidPct > 0 ? 'min-width:8px;' : '' }}border-radius:99px;background:linear-gradient(90deg,#818cf8,#34d399)"></span>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="rp-stats">
        <div class="rp-stat"><div class="ic"><i class="fas fa-layer-group"></i></div><small>Subtotal</small><b>{{ $f($summary['total_sub_total']) }}</b></div>
        <div class="rp-stat"><div class="ic"><i class="fas fa-percent"></i></div><small>Total tax</small><b>{{ $f($summary['total_tax']) }}</b></div>
        <div class="rp-stat"><div class="ic"><i class="fas fa-tag"></i></div><small>Total discount</small><b>{{ $f($summary['total_discount']) }}</b></div>
        <div class="rp-stat"><div class="ic"><i class="fas fa-file-invoice-dollar"></i></div><small>Grand total</small><b>{{ $f($summary['total_grand']) }}</b></div>
        <div class="rp-stat {{ $due > 0 ? 'bad' : 'good' }}"><div class="ic"><i class="fas fa-clock"></i></div><small>Total due</small><b>{{ $f($summary['total_due']) }}</b></div>
    </div>

    <!-- TABLE -->
    <div class="rp-card">
        <div class="rp-card-h">
            <h4>Bill details</h4>
            <div class="rp-search">
                <i class="fas fa-search"></i>
                <input type="text" id="rpSearch" placeholder="Search bill, status, currency..." autocomplete="off">
            </div>
        </div>

        <div class="rp-wrap report">
            <table class="rp-tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bill #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Currency</th>
                        <th class="num">Subtotal</th>
                        <th class="num">Tax</th>
                        <th class="num">Discount</th>
                        <th class="num">Grand Total</th>
                        <th class="num">Due</th>
                    </tr>
                </thead>
                <tbody id="rpBody">
                    @forelse ($bills as $key => $bill)
                    @php $st = strtolower($bill->bill_status ?? ''); @endphp
                    <tr>
                        <td class="idx">{{ $key + 1 }}</td>
                        <td><span class="rp-inv">{{ $bill->bill_number }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d-M-Y') }}</td>
                        <td><span class="rp-st {{ in_array($st, ['paid','sent','received','pending','unpaid','partial','draft','overdue','cancelled']) ? $st : 'cancelled' }}">{{ ucfirst($bill->bill_status) }}</span></td>
                        <td><span class="rp-cur">{{ $bill->currency_code }}</span></td>
                        <td class="num">{{ $f($bill->sub_total) }}</td>
                        <td class="num">{{ $f($bill->total_tax) }}</td>
                        <td class="num">{{ $f($bill->total_discount) }}</td>
                        <td class="num rp-grand">{{ $f($bill->grand_total) }}</td>
                        <td class="num rp-due {{ $bill->total_due > 0 ? 'owe' : 'zero' }}">{{ $f($bill->total_due) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="padding:0">
                            <div class="rp-empty">
                                <div class="ei"><i class="fas fa-folder-open"></i></div>
                                <b>No bills found</b>
                                No bills found for the selected criteria.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if(collect($bills)->count())
                <tfoot>
                    <tr>
                        <th colspan="5" class="lbl">Total</th>
                        <th class="num">{{ $f($summary['total_sub_total']) }}</th>
                        <th class="num">{{ $f($summary['total_tax']) }}</th>
                        <th class="num">{{ $f($summary['total_discount']) }}</th>
                        <th class="num">{{ $f($summary['total_grand']) }}</th>
                        <th class="num">{{ $f($summary['total_due']) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
            <div class="rp-none" id="rpNone">No bills match your search.</div>
        </div>
    </div>
</div>

<script>
    // live search (client-side)
    (function () {
        var input = document.getElementById('rpSearch');
        if (!input) return;
        var rows = document.querySelectorAll('#rpBody tr');
        var none = document.getElementById('rpNone');
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), shown = 0;
            rows.forEach(function (r) {
                var ok = !q || r.textContent.toLowerCase().indexOf(q) > -1;
                r.style.display = ok ? '' : 'none';
                if (ok) shown++;
            });
            none.style.display = shown ? 'none' : 'block';
        });
    })();
</script>