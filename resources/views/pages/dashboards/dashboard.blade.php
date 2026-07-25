<x-default-layout>
    @if( !empty($data['registration']) && $data['registration'] == 'success')

       <div class="alert alert-info alert-dismissible fade show shadow-sm border-start border-4 border-primary mt-3" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-bookmark-star-fill fs-4 text-primary me-2"></i>
            <div>
                <strong>Tip:</strong> Save your Admin URL for quick access next time!
                <div class="mt-1"><code>{{ url('/') }}</code> <a href="#" class="copyButton" link="{{ url('/') }}"><i class="fa-regular fa-copy copy-font"> </i></a> </div>
            </div>
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --iz-bg: #f4f6fb;
            --iz-ink: #10162f;
            --iz-muted: #6b7290;
            --iz-border: #e7e9f5;
            --iz-card: #ffffff;
            --iz-primary: #4f46e5;
            --iz-primary-2: #7c3aed;
            --iz-success: #10b981;
            --iz-success-bg: #e8faf3;
            --iz-warning: #f59e0b;
            --iz-warning-bg: #fef6e7;
            --iz-danger: #ef4444;
            --iz-danger-bg: #fdecec;
            --iz-info: #0ea5e9;
            --iz-info-bg: #e9f6fd;
            --iz-radius: 16px;
            --iz-shadow: 0 6px 24px rgba(16, 22, 47, 0.06);
            --iz-shadow-hover: 0 14px 34px rgba(79, 70, 229, 0.14);
        }

        .iz-wrap{
            font-family: 'Inter', sans-serif;
            color: var(--iz-ink);
        }
        .iz-wrap h1, .iz-wrap h2, .iz-wrap h3, .iz-wrap h4, .iz-wrap h5, .iz-wrap h6{
            font-family: 'Outfit', sans-serif;
        }
        .iz-wrap .tabular{
            font-variant-numeric: tabular-nums;
        }

        /* ---------- Header ---------- */
        .iz-header{
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 28px 32px;
            margin-top: 18px;
            margin-bottom: 24px;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(120deg, #14123a 0%, #29216e 45%, #4f46e5 100%);
            box-shadow: 0 16px 40px rgba(41, 33, 110, 0.28);
        }
        .iz-header::before{
            content:"";
            position:absolute;
            top:-60px; right:-60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }
        .iz-header::after{
            content:"";
            position:absolute;
            bottom:-80px; left:20%;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(124,58,237,0.35) 0%, rgba(124,58,237,0) 70%);
            border-radius: 50%;
        }
        .iz-header-text{ position:relative; z-index:1; }
        .iz-eyebrow{
            display:inline-flex;
            align-items:center;
            gap:6px;
            font-size: 0.72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-weight: 600;
            color: rgba(255,255,255,0.72);
            margin-bottom: 6px;
        }
        .iz-eyebrow .dot{
            width:6px; height:6px; border-radius:50%;
            background: #34d399;
            box-shadow: 0 0 0 3px rgba(52,211,153,0.25);
        }
        .iz-header h2{
            color:#fff;
            font-weight: 700;
            font-size: 1.9rem;
            margin: 0 0 4px 0;
        }
        .iz-header p{
            color: rgba(255,255,255,0.7);
            margin: 0;
            font-size: 0.92rem;
        }
        .iz-btn-create{
            position: relative;
            z-index: 1;
            display:inline-flex;
            align-items:center;
            gap: 10px;
            padding: 13px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #201a4d;
            background: #ffffff;
            border: none;
            text-decoration: none;
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
            transition: transform .18s ease, box-shadow .18s ease;
            white-space: nowrap;
        }
        .iz-btn-create:hover{
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0,0,0,0.22);
            color: #201a4d;
        }
        .iz-btn-create i{
            font-size: 1.15rem;
            color: var(--iz-primary);
        }

        /* ---------- Refresh notice ---------- */
        .iz-refresh{
            display:flex;
            align-items:center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 12px;
            background: var(--iz-info-bg);
            border: 1px solid #cdeefc;
            color: #0c5c7d;
            font-size: 0.86rem;
            margin-bottom: 24px;
        }
        .iz-refresh i{ font-size: 1.05rem; color: var(--iz-info); flex-shrink:0; }
        .iz-refresh strong{ color: #084a63; }

        /* ---------- Stat cards ---------- */
        .iz-stat-card{
            position: relative;
            background: var(--iz-card);
            border: 1px solid var(--iz-border);
            border-radius: var(--iz-radius);
            padding: 22px 22px;
            box-shadow: var(--iz-shadow);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            overflow: hidden;
            height: 100%;
        }
        .iz-stat-card:hover{
            transform: translateY(-4px);
            box-shadow: var(--iz-shadow-hover);
            border-color: rgba(79,70,229,0.25);
        }
        .iz-stat-icon{
            width: 52px; height: 52px;
            border-radius: 14px;
            display:flex; align-items:center; justify-content:center;
            font-size: 1.45rem;
            margin-bottom: 14px;
            color: #fff;
            transition: transform .25s ease;
        }
        .iz-stat-card:hover .iz-stat-icon{ transform: scale(1.07) rotate(-2deg); }
        .iz-stat-icon.bg-primary-soft{
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            box-shadow: 0 8px 18px rgba(79,70,229,0.32);
        }
        .iz-stat-icon.bg-success-soft{
            background: linear-gradient(135deg, #34d399 0%, #059669 100%);
            box-shadow: 0 8px 18px rgba(16,185,129,0.32);
        }
        .iz-stat-icon.bg-warning-soft{
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            box-shadow: 0 8px 18px rgba(217,119,6,0.30);
        }
        .iz-stat-icon.bg-danger-soft{
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
            box-shadow: 0 8px 18px rgba(225,29,72,0.30);
        }
        .iz-stat-label{
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--iz-muted);
            text-transform: uppercase;
            letter-spacing: .03em;
            margin-bottom: 6px;
        }
        .iz-stat-value{
            font-family: 'Outfit', sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--iz-ink);
            line-height: 1.2;
        }

        /* ---------- Chart cards ---------- */
        .iz-card{
            background: var(--iz-card);
            border: 1px solid var(--iz-border);
            border-radius: var(--iz-radius);
            box-shadow: var(--iz-shadow);
            padding: 24px;
            height: 100%;
        }
        .iz-card-header{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            margin-bottom: 18px;
        }
        .iz-card-title{
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0 0 2px 0;
        }
        .iz-card-subtitle{
            font-size: 0.8rem;
            color: var(--iz-muted);
            margin:0;
        }
        .iz-badge-soft{
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
            background: #eceafd;
            color: var(--iz-primary);
            white-space: nowrap;
        }

        /* ---------- Table ---------- */
        .iz-table thead th{
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--iz-muted);
            font-weight: 700;
            border-bottom: 1px solid var(--iz-border);
            background: transparent;
            padding: 10px 12px;
        }
        .iz-table tbody td{
            padding: 14px 12px;
            border-bottom: 1px solid var(--iz-border);
            font-size: 0.9rem;
            vertical-align: middle;
        }
        .iz-table tbody tr:last-child td{ border-bottom: none; }
        .iz-table tbody tr{ transition: background .15s ease; }
        .iz-table tbody tr:hover{ background: #f8f8ff; }
        .iz-inv-icon{
            width: 34px; height: 34px;
            border-radius: 9px;
            background: #eceafd;
            color: var(--iz-primary);
            display:inline-flex; align-items:center; justify-content:center;
            font-size: 0.9rem;
            margin-right: 10px;
        }
        .iz-pill{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 600;
        }
        .iz-pill .dot{ width:6px; height:6px; border-radius:50%; }
        .iz-pill.paid{ background: var(--iz-success-bg); color: #067a55; }
        .iz-pill.paid .dot{ background: var(--iz-success); }
        .iz-pill.pending{ background: var(--iz-warning-bg); color: #a15c07; }
        .iz-pill.pending .dot{ background: var(--iz-warning); }
        .iz-pill.overdue{ background: var(--iz-danger-bg); color: #b3271f; }
        .iz-pill.overdue .dot{ background: var(--iz-danger); }
        .iz-pill.default{ background:#eef0f6; color: var(--iz-muted); }
        .iz-pill.default .dot{ background: var(--iz-muted); }
        .iz-empty{
            text-align:center;
            color: var(--iz-muted);
            font-size: 0.85rem;
            padding: 28px 10px;
        }

        /* ---------- Upcoming dues ---------- */
        .iz-due-item{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
            padding: 13px 4px;
            border-bottom: 1px solid var(--iz-border);
        }
        .iz-due-item:last-child{ border-bottom:none; }
        .iz-due-left{
            display:flex;
            align-items:center;
            gap: 10px;
        }
        .iz-due-left .iz-inv-icon{
            background: var(--iz-warning-bg);
            color: #b45309;
        }
        .iz-due-name{
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--iz-ink);
        }
        .iz-due-sub{
            font-size: 0.76rem;
            color: var(--iz-muted);
        }
        .iz-due-pill{
            font-size: 0.74rem;
            font-weight: 700;
            padding: 5px 11px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .iz-due-pill.soon{ background: var(--iz-danger-bg); color: #b3271f; }
        .iz-due-pill.week{ background: var(--iz-warning-bg); color: #a15c07; }
        .iz-due-pill.later{ background: var(--iz-info-bg); color: #0c5c7d; }

        @media (max-width: 767px){
            .iz-header{ padding: 22px 20px; }
            .iz-header h2{ font-size: 1.5rem; }
            .iz-btn-create{ width: 100%; justify-content:center; }
        }
    </style>

    <div class="iz-wrap container-fluid {{ $data['registration'] ?? '' }}">

        <!-- Hero header -->
        <div class="iz-header">
            <div class="iz-header-text">
                <div class="iz-eyebrow"><span class="dot"></span> Live overview</div>
                <h2>Welcome back 👋</h2>
                <p>Here's what's happening with your invoices today.</p>
            </div>
            <a href="{{ route('invoice.add') }}" class="iz-btn-create">
                <i class="bi bi-lightning-charge-fill"></i>
                Create New Invoice
            </a>
        </div>

        <!-- Auto refresh notice -->
        <div class="iz-refresh">
            <i class="bi bi-arrow-repeat"></i>
            <div><strong>Auto-sync active</strong> — dashboard data refreshes every 10 minutes via backend process.</div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="iz-stat-card">
                    <div class="iz-stat-icon bg-primary-soft"><i class="bi bi-receipt-cutoff text-white"></i></div>
                    <div class="iz-stat-label">Total Invoices</div>
                    <div class="iz-stat-value tabular">{{ number_format($data['summary']->total_invoices ?? 0 ) }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="iz-stat-card">
                    <div class="iz-stat-icon bg-success-soft"><i class="bi bi-graph-up-arrow text-white"></i></div>
                    <div class="iz-stat-label">Revenue</div>
                    <div class="iz-stat-value tabular">{{ $data['currency_symbol'] }}{{ number_format($data['summary']->total_revenue ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="iz-stat-card">
                    <div class="iz-stat-icon bg-warning-soft"><i class="bi bi-clock-history text-white"></i></div>
                    <div class="iz-stat-label">Pending</div>
                    <div class="iz-stat-value tabular">{{ number_format($data['summary']->pending_invoices ?? 0) }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="iz-stat-card">
                    <div class="iz-stat-icon bg-danger-soft"><i class="bi bi-exclamation-triangle-fill text-white"></i></div>
                    <div class="iz-stat-label">Overdue</div>
                    <div class="iz-stat-value tabular">{{ number_format($data['summary']->overdue_invoices ?? 0) }}</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="iz-card">
                    <div class="iz-card-header">
                        <div>
                            <h5 class="iz-card-title">Monthly Invoice Summary</h5>
                            <p class="iz-card-subtitle">Invoice volume trend across recent months</p>
                        </div>
                        <span class="iz-badge-soft"><i class="bi bi-bar-chart-fill me-1"></i>Monthly</span>
                    </div>
                    <div id="invoiceChart" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="iz-card">
                    <div class="iz-card-header">
                        <div>
                            <h5 class="iz-card-title">Invoice Status</h5>
                            <p class="iz-card-subtitle">Breakdown by status</p>
                        </div>
                    </div>
                    <div id="statusPieChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="iz-card">
                    <div class="iz-card-header">
                        <div>
                            <h5 class="iz-card-title">Recent Invoices</h5>
                            <p class="iz-card-subtitle">Latest activity on your account</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table iz-table mb-0">
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
                                        <span class="iz-inv-icon"><i class="bi bi-file-earmark-text"></i></span>
                                        <span class="fw-semibold">{{ $invoice['invoice_number'] }}</span>
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
                                        <span class="iz-pill {{ $pillClass }}"><span class="dot"></span>{{ ucfirst($status) }}</span>
                                    </td>
                                    <td class="text-end fw-semibold tabular">${{ number_format($invoice['amount'], 2) }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="iz-empty">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No recent invoices yet.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="iz-card">
                    <div class="iz-card-header">
                        <div>
                            <h5 class="iz-card-title">Upcoming Dues</h5>
                            <p class="iz-card-subtitle">Invoices due soon</p>
                        </div>
                    </div>

                    @if(!empty($data['upcomingDues']))
                    @foreach ($data['upcomingDues'] as $due)
                        @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($due['due_date']), false);
                        $urgencyClass = $daysLeft <= 2 ? 'soon' : ($daysLeft <= 7 ? 'week' : 'later');
                        @endphp
                        <div class="iz-due-item">
                            <div class="iz-due-left">
                                <span class="iz-inv-icon"><i class="bi bi-calendar-event"></i></span>
                                <div>
                                    <div class="iz-due-name">{{ $due['invoice_number'] }}</div>
                                    <div class="iz-due-sub">Due {{ \Carbon\Carbon::parse($due['due_date'])->format('d M, Y') }}</div>
                                </div>
                            </div>
                            <span class="iz-due-pill {{ $urgencyClass }}">{{ \Carbon\Carbon::parse($due['due_date'])->format('d M') }}</span>
                        </div>
                    @endforeach
                    @else
                        <div class="iz-empty">
                            <i class="bi bi-check2-circle fs-3 d-block mb-2"></i>
                            No upcoming dues. You're all caught up!
                        </div>
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
        $('.copyButton').on('click', function(e) {
            e.preventDefault();
            copyToClipboard($(this).attr('link'));
        });

        // Monthly Invoices Bar Chart
        var options = {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%'
                }
            },
            dataLabels: { enabled: false },
            series: [{
                name: 'Invoices',
                data: @json(array_values($data['monthlyChart'] ?? []))
            }],
            xaxis: {
                categories: @json(array_keys($data['monthlyChart'] ?? [])),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            grid: {
                borderColor: '#eef0f7',
                strokeDashArray: 4
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
            }
        };
        new ApexCharts(document.querySelector("#invoiceChart"), options).render();

        // Invoice Status Donut Chart
        var pieOptions = {
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'Inter, sans-serif'
            },
            series: @json(array_values($data['statusChart'] ?? [])),
            labels: @json(array_keys($data['statusChart'] ?? [])),
            colors: ['#10b981', '#f59e0b', '#ef4444'],
            legend: {
                position: 'bottom',
                fontSize: '13px'
            },
            dataLabels: {
                style: { fontSize: '12px' }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%',
                        labels: {
                            show: true,
                            total: { show: true, label: 'Total' }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#statusPieChart"), pieOptions).render();
    </script>

</x-default-layout>