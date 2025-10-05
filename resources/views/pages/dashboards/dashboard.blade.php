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

    <h2 class="py-3">Dashboard</h2>
   
   
 

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        .card-summary {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-summary:hover {
            transform: translateY(-5px);
        }

        .card-summary i {
            font-size: 1.8rem;
            color: #0d6efd;
        }

        .chart-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container-fluid mt-4 {{ $data['registration'] }}">
        <div class="alert alert-info d-flex align-items-center shadow-sm p-3 rounded-3" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 1 .5.5v4.25l2.5 1.5a.5.5 0 0 1-.5.866L8 9V4a.5.5 0 0 1 .5-.5z" />
                <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zM8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1z" />
            </svg>
            <div>
                <strong>Note:</strong> All dashboard data is auto-refreshed every <strong>10 minutes</strong> via backend process.
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card card-summary p-3 text-center">
                    <i class="bi bi-receipt-cutoff mb-2"></i>
                    <h5 class="fw-bold">Total Invoices</h5>
                    <p class="fs-4 text-primary">{{ number_format($data['summary']->total_invoices ?? 0 ) }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-summary p-3 text-center">
                    <i class="bi bi-cash-coin mb-2"></i>
                    <h5 class="fw-bold">Revenue</h5>
                    <p class="fs-4 text-success">${{ number_format($data['summary']->total_revenue ?? 0, 2)  }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-summary p-3 text-center">
                    <i class="bi bi-hourglass-split mb-2"></i>
                    <h5 class="fw-bold">Pending</h5>
                    <p class="fs-4 text-warning">{{ number_format($data['summary']->pending_invoices ?? 0) }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-summary p-3 text-center">
                    <i class="bi bi-exclamation-circle mb-2"></i>
                    <h5 class="fw-bold">Overdue</h5>
                    <p class="fs-4 text-danger">{{ number_format($data['summary']->overdue_invoices ?? 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="card chart-card p-3">
                    <h5 class="section-title">Monthly Invoice Summary</h5>
                    <div id="invoiceChart" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card chart-card p-3">
                    <h5 class="section-title">Invoice Status</h5>
                    <div id="statusPieChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="card p-3">
                    <h5 class="section-title">Recent Invoices</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data['recentInvoices']))
                                @foreach ($data['recentInvoices'] as $index => $invoice)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $invoice['invoice_number'] }}</td>
                                    <td>{{ $invoice['date'] }}</td>
                                    <td>
                                        @php
                                        $status = strtolower($invoice['status']);
                                        $badge = match($status) {
                                        'paid' => 'success',
                                        'pending' => 'warning text-dark',
                                        'overdue' => 'danger',
                                        default => 'secondary'
                                        };
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>${{ number_format($invoice['amount'], 2) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card p-3">
                    <h5 class="section-title">Upcoming Dues</h5>
                    <ul class="list-group">

                        @if(!empty($data['upcomingDues']))
                        @foreach ($data['upcomingDues'] as $due)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $due['invoice_number'] }}
                            <span class="badge bg-info text-dark">Due: {{ \Carbon\Carbon::parse($due['due_date'])->format('d M') }}</span>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    </div>

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
                height: 300
            },
            series: [{
                name: 'Invoices',
                data: @json(array_values($data['monthlyChart'] ?? []))
            }],
            xaxis: {
                categories: @json(array_keys($data['monthlyChart'] ?? []))
            },
            colors: ['#0d6efd']
        };
        new ApexCharts(document.querySelector("#invoiceChart"), options).render();

        // Invoice Status Donut Chart
        var pieOptions = {
            chart: {
                type: 'donut',
                height: 300
            },
            series: @json(array_values($data['statusChart'] ?? [])),
            labels: @json(array_keys($data['statusChart'] ?? [])),
            colors: ['#198754', '#ffc107', '#dc3545']
        };
        new ApexCharts(document.querySelector("#statusPieChart"), pieOptions).render();
    </script>


</x-default-layout>