<x-default-layout>
<!-- iz-report v1 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

<style>
    .iz-rep{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a}
    .iz-rep .container-fluid,.iz-rep .iz-wrap{max-width:1180px;margin:0 auto}

    /* header */
    .iz-top{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:22px}
    .iz-top h2{margin:0;font-size:26px;font-weight:800;letter-spacing:-.02em;color:var(--ink)}
    .iz-top p{margin:2px 0 0;color:var(--mut);font-size:14px}
    .iz-actions{display:flex;gap:10px;flex-wrap:wrap}
    .iz-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:46px;padding:0 24px;border:0;border-radius:12px;font-weight:700;font-size:14px;color:#fff;cursor:pointer;
        background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 12px 24px -12px rgba(79,70,229,.8);transition:.2s;text-decoration:none!important}
    .iz-btn:hover{transform:translateY(-2px);color:#fff;box-shadow:0 18px 30px -14px rgba(79,70,229,.9)}
    .iz-ghost{display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 18px;border-radius:12px;border:1.5px solid var(--bd);background:#fff;color:#334155;font-weight:600;font-size:14px;text-decoration:none!important;transition:.2s}
    .iz-ghost:hover{border-color:#c7d2fe;color:var(--i1);background:#f8f9ff}
    .iz-rep svg.lucide{width:17px;height:17px}

    /* GSTR-1 banner */
    .iz-gst{position:relative;overflow:hidden;border-radius:22px;padding:24px 28px;color:#fff;margin-bottom:24px;display:flex;align-items:center;gap:18px;flex-wrap:wrap;
        background:radial-gradient(600px 220px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(420px 220px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 24px 46px -26px rgba(79,70,229,.6)}
    .iz-gst::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:34px 34px;mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .iz-gst > *{position:relative;z-index:1}
    .iz-gst .gi{flex:none;width:52px;height:52px;border-radius:15px;display:grid;place-items:center;font-size:20px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25)}
    .iz-gst h4{margin:0 0 3px;color:#fff;font-size:18px;font-weight:700}
    .iz-gst p{margin:0;color:#c7d2fe;font-size:13.5px;line-height:1.6;max-width:520px}
    .iz-gst .go{margin-left:auto;display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 20px;border-radius:12px;border:0;background:#fff;color:var(--i1);font-weight:700;font-size:14px;text-decoration:none!important;transition:.2s;cursor:pointer}
    .iz-gst .go:hover{transform:translateY(-2px);background:#f5f3ff;color:var(--i1)}

    /* cards */
    .iz-card{background:#fff;border:1px solid var(--bd);border-radius:24px;box-shadow:0 10px 30px -20px rgba(15,23,42,.2);margin-bottom:24px}
    .iz-card-h{display:flex;align-items:center;gap:14px;padding:20px 26px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:24px 24px 0 0}
    .iz-ico{flex:none;width:42px;height:42px;border-radius:12px;display:grid;place-items:center;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-card-h h3{margin:0;font-size:16.5px;font-weight:700;color:var(--ink)}
    .iz-card-h p{margin:2px 0 0;font-size:13px;color:var(--mut)}
    .iz-card-b{padding:26px}
    .iz-card-f{display:flex;justify-content:flex-end;align-items:center;gap:12px;padding:18px 26px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 24px 24px}

    .iz-lbl{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px}
    .iz-sec{font-size:11.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin:0 0 12px}

    /* report type tabs */
    .iz-tabs{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:28px}
    .iz-tab{display:flex;align-items:center;gap:12px;padding:14px 16px;border:1.5px solid var(--bd);border-radius:16px;background:#fff;cursor:pointer;text-align:left;transition:.2s}
    .iz-tab:hover{border-color:#c7d2fe;background:#f8f9ff}
    .iz-tab .ti{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;font-size:16px;color:#94a3b8;background:#f1f5f9;transition:.2s}
    .iz-tab b{display:block;font-size:14px;color:var(--ink)}
    .iz-tab small{color:var(--mut);font-size:12px}
    .iz-tab.on{border-color:#6366f1;background:linear-gradient(135deg,#eef2ff,#f5f3ff);box-shadow:0 0 0 4px rgba(99,102,241,.12)}
    .iz-tab.on .ti{color:#fff;background:linear-gradient(135deg,var(--i1),var(--i2));box-shadow:0 8px 16px -8px rgba(79,70,229,.8)}

    /* inputs */
    .iz-rep .form-control,.iz-rep .form-select{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .iz-rep .form-control:focus,.iz-rep .form-select:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .iz-rep .input-group-text{border-radius:0 12px 12px 0;border:1.5px solid #e2e8f0;border-left:0;background:#f1f5f9;color:#64748b}
    .iz-rep .input-group .form-control{border-radius:12px 0 0 12px}
    .iz-rep .form-control.is-invalid,.iz-rep .form-select.is-invalid{border-color:#f43f5e}
    .iz-rep .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .iz-hint{font-size:12.5px;color:#6366f1;font-weight:600;margin-top:7px}

    /* period chips */
    .iz-chips{display:flex;gap:8px;flex-wrap:wrap}
    .iz-chip{padding:9px 16px;border-radius:99px;border:1.5px solid var(--bd);background:#fff;color:#475569;font-size:13px;font-weight:600;cursor:pointer;transition:.2s}
    .iz-chip:hover{border-color:#c7d2fe;color:var(--i1)}
    .iz-chip.on{background:linear-gradient(135deg,var(--i1),var(--i2));border-color:transparent;color:#fff;box-shadow:0 8px 16px -8px rgba(79,70,229,.8)}

    /* search dropdown */
    #clientList,#vendorList{border-radius:12px;overflow:hidden;margin-top:6px;border:1px solid var(--bd)}

    /* result area */
    .iz-empty{text-align:center;padding:50px 20px;border:2px dashed #dbe3f0;border-radius:24px;background:linear-gradient(180deg,#fcfcff,#fff)}
    .iz-empty .ei{width:70px;height:70px;border-radius:20px;display:grid;place-items:center;margin:0 auto 16px;font-size:28px;color:var(--i1);background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-empty h5{font-size:17px;font-weight:700;color:var(--ink);margin:0 0 5px}
    .iz-empty p{color:var(--mut);font-size:13.5px;margin:0}
    #report-result .table{border-collapse:separate;border-spacing:0;margin-bottom:0}
    #report-result .table thead th{background:#f8fafc;color:#64748b;font-size:11.5px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;border-bottom:1px solid var(--bd);padding:14px 18px;white-space:nowrap}
    #report-result .table td{padding:15px 18px;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:14px}
    #report-result .table tbody tr:hover{background:#fafaff}

    @media (max-width:767px){
        .iz-top h2{font-size:22px}
        .iz-actions{width:100%}
        .iz-actions > *{flex:1;justify-content:center}
        .iz-gst{padding:22px 20px}
        .iz-gst .go{margin-left:0;width:100%;justify-content:center}
        .iz-tabs{grid-template-columns:1fr}
        .iz-card-h,.iz-card-b,.iz-card-f{padding-left:20px;padding-right:20px}
        .iz-card-f .iz-btn{width:100%}
    }

    /* flatpickr modal ke upar dikhe */
    .flatpickr-calendar{z-index:2000!important}

    /* GSTR-1 modal */
    .iz-modal .modal-content{border:0;border-radius:24px;overflow:hidden;box-shadow:0 30px 80px -20px rgba(15,23,42,.35)}
    .iz-modal .modal-header{position:relative;border:0;padding:26px 28px;color:#fff;align-items:flex-start;
        background:radial-gradient(500px 200px at 0% 0%,#6366f1 0%,transparent 70%),linear-gradient(135deg,#4f46e5,#7c3aed)}
    .iz-modal .modal-title{font-size:20px;font-weight:700;color:#fff}
    .iz-modal .modal-sub{margin-top:5px;font-size:13.5px;color:rgba(255,255,255,.85)}
    .iz-modal .btn-close{filter:brightness(0) invert(1);opacity:.9;margin:0}
    .iz-modal .modal-body{padding:28px}
    .iz-modal .m-lbl{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px}
    .iz-modal #monthYearPicker{height:50px;border-radius:12px;border:1.5px solid #e2e8f0;background:#f8fafc;font-size:14.5px;padding-left:16px;cursor:pointer}
    .iz-modal #monthYearPicker:focus{border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14);background:#fff}
    .iz-modal .m-dl{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:52px;margin-top:18px;border-radius:14px;border:0;font-weight:700;font-size:15px;color:#fff;text-decoration:none!important;
        background:linear-gradient(135deg,#059669,#10b981);box-shadow:0 14px 26px -12px rgba(5,150,105,.7);transition:.2s}
    .iz-modal .m-dl:hover{transform:translateY(-2px);color:#fff}
    .iz-modal .modal-footer{border:0;background:#fafbff;padding:14px 28px}
</style>

<div class="iz-rep">
<div class="iz-wrap">

<form action="{{ route('report.get') }}" id="generate-report-form" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- HEADER -->
    <div class="iz-top">
        <div>
            <h2>Reports</h2>
            <p>Generate invoice, bill and input tax credit reports in seconds.</p>
        </div>
        <div class="iz-actions">
            <a href="{{ route('dashboard') }}" class="iz-ghost"><i data-lucide="arrow-left"></i> Back</a>
           <a href="#" class="iz-btn js-generate"><i data-lucide="sparkles"></i> Generate report</a>
        </div>
    </div>

    <!-- GSTR-1 BANNER -->
    <div class="iz-gst">
        <div class="gi"><i class="fas fa-file-invoice"></i></div>
        <div>
            <h4>GSTR-1 (Sales) filing</h4>
            <p>Export your sales data for any month in JSON format, ready for GST portal upload.</p>
        </div>
        <button type="button" class="go" data-bs-toggle="modal" data-bs-target="#gstr1Modal">
            <i class="fas fa-download"></i> Download GSTR-1
        </button>
    </div>

    <!-- FILTERS -->
    <div class="iz-card">
        <div class="iz-card-h">
            <span class="iz-ico"><i class="fas fa-sliders"></i></span>
            <div>
                <h3>Report filters</h3>
                <p>Choose what you want to see, then generate.</p>
            </div>
        </div>

        <div class="iz-card-b">

            <div class="iz-sec">Report type</div>
            <select name="report_type" id="report_type" class="d-none">
                <option value="invoice">Invoice</option>
                <option value="bill">Bill</option>
                <option value="itc">Input Tax Credit</option>
            </select>
            <div class="iz-tabs">
                <button type="button" class="iz-tab" data-v="invoice">
                    <span class="ti"><i class="fas fa-file-invoice-dollar"></i></span>
                    <span><b>Invoice</b><small>Sales to your clients</small></span>
                </button>
                <button type="button" class="iz-tab" data-v="bill">
                    <span class="ti"><i class="fas fa-receipt"></i></span>
                    <span><b>Bill</b><small>Purchases from vendors</small></span>
                </button>
                <button type="button" class="iz-tab" data-v="itc">
                    <span class="ti"><i class="fas fa-percent"></i></span>
                    <span><b>Input Tax Credit</b><small>GST you can claim</small></span>
                </button>
            </div>

            <div class="iz-sec">Filters</div>
            <div class="row g-5">

                <div class="col-md-6">
                    <label for="status" class="iz-lbl">Status</label>
                    <select id="status" name="status[]" class="form-select" multiple multiselect-max-items="2" multiselect-search="true">
                        <option value="pending" {{ in_array('pending', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ in_array('sent', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ in_array('paid', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ in_array('overdue', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ in_array('cancelled', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="currency" class="iz-lbl">Currency</label>
                    <select id="currency" name="currency[]" class="form-select" multiple multiselect-max-items="2" multiselect-search="true">
                        @foreach($data['currencies'] as $currency )
                        <option value="{{ $currency->currency_code }}" {{ old('currency', $data['setting']->currency ?? '') == $currency->currency_code ? 'selected' : '' }}> {{ $currency->currency_name }} | {{ $currency->currency_symbol }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Period -->
                <div class="col-12">
                    <label class="iz-lbl">Period</label>
                    <select name="period" id="period" class="d-none">
                        <option value="all_time">All Time</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="3_month">Last 3 Months</option>
                        <option value="custom">Custom</option>
                    </select>
                    <div class="iz-chips" id="periodChips">
                        <button type="button" class="iz-chip" data-v="all_time">All time</button>
                        <button type="button" class="iz-chip" data-v="this_month">This month</button>
                        <button type="button" class="iz-chip" data-v="last_month">Last month</button>
                        <button type="button" class="iz-chip" data-v="3_month">Last 3 months</button>
                        <button type="button" class="iz-chip" data-v="custom"><i class="fas fa-calendar-alt me-1"></i> Custom range</button>
                    </div>
                </div>

                <div class="col-md-6" id="custom-date-wrapper" style="display: none;">
                    <label class="iz-lbl">Custom date</label>
                    <div class="input-group">
                        <input type="text" name="date" id="date" value="{{ request('date') }}" class="form-control date-range" placeholder="Pick custom date range">
                        <span class="input-group-text date-range"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <div class="iz-hint" id="total_days"></div>
                </div>

                <!-- Client (invoice) -->
                <div class="col-md-6" id="client_type_wrapper">
                    <label for="client" class="iz-lbl">Client</label>
                    <select name="client" id="client" class="form-select">
                        <option value="all_client" selected>All Clients</option>
                        <option value="single_client">Single Client</option>
                    </select>
                </div>

                <div class="col-md-6" id="client_search_wrapper" style="display: none; position: relative;">
                    <label for="client_name" class="iz-lbl">Search client</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ request('client_name') }}" placeholder="Type to search client..." autocomplete="off">
                    <input type="hidden" name="client_id" id="client_id">
                    <div id="clientList" class="list-group shadow" style="position: absolute; top: 100%; width: 100%; z-index: 1050;"></div>
                </div>

                <!-- Vendor (bill / itc) -->
                <div class="col-md-6" id="vendor_type_wrapper" style="display:none;">
                    <label for="vendor" class="iz-lbl">Vendor</label>
                    <select name="vendor" id="vendor" class="form-select">
                        <option value="all_vendor" selected>All Vendors</option>
                        <option value="single_vendor">Single Vendor</option>
                    </select>
                </div>

                <div class="col-md-6" id="vendor_search_wrapper" style="display:none; position:relative;">
                    <label for="vendor_name" class="iz-lbl">Search vendor</label>
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name"
                        placeholder="Type to search vendor..." autocomplete="off">
                    <input type="hidden" name="vendor_id" id="vendor_id">
                    <div id="vendorList" class="list-group shadow"
                        style="position:absolute; top:100%; width:100%; z-index:1050;"></div>
                </div>

            </div>
        </div>

        <div class="iz-card-f">
            <button type="button" class="iz-btn js-generate"><i data-lucide="sparkles"></i> Generate report</button>
        </div>
    </div>

    <!-- RESULT -->
    <div id="report-result">
        <div class="iz-empty">
            <div class="ei"><i class="fas fa-chart-column"></i></div>
            <h5>Your report will appear here</h5>
            <p>Select your filters above and click <b>Generate report</b>.</p>
        </div>
    </div>

</form>
</div>
</div>

<!-- GSTR-1 Modal -->
<div class="modal fade iz-modal" id="gstr1Modal" tabindex="-1" aria-labelledby="gstr1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="gstr1ModalLabel">Download GSTR-1 (Sales)</h5>
                    <div class="modal-sub">Export your sales data in JSON format for GST filing.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="gstr1-form" onsubmit="return false;">
                    <label for="monthYearPicker" class="m-lbl">Select month &amp; year</label>
                    <input type="text" id="monthYearPicker" name="period" class="form-control" placeholder="Select month and year" readonly>
                </form>

                <a id="downloadGSTR1" href="#" class="m-dl">
                    <i class="fas fa-download"></i> Download JSON
                </a>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<script>
$(document).ready(function () {

    /* ---------- Report type tabs <-> select ---------- */
    function syncTabs() {
        const v = $('#report_type').val();
        $('.iz-tab').removeClass('on').filter('[data-v="' + v + '"]').addClass('on');
    }

    function toggleParty() {
        const type = $('#report_type').val();

        if (type === 'invoice') {
            $('#client_type_wrapper').show();
            $('#vendor_type_wrapper, #vendor_search_wrapper').hide();
            $('#vendor_name, #vendor_id').val('');
            $('#vendorList').hide();
            $('#client_search_wrapper').toggle($('#client').val() === 'single_client');
        } else {
            $('#vendor_type_wrapper').show();
            $('#client_type_wrapper, #client_search_wrapper').hide();
            $('#client_name, #client_id').val('');
            $('#clientList').hide();
            $('#vendor_search_wrapper').toggle($('#vendor').val() === 'single_vendor');
        }
    }

    $('.iz-tab').on('click', function () {
        $('#report_type').val($(this).data('v')).trigger('change');
    });
    $('#report_type').on('change', function () { syncTabs(); toggleParty(); });
    syncTabs();
    toggleParty();

    /* ---------- Period chips <-> select ---------- */
    function syncChips() {
        const v = $('#period').val();
        $('#periodChips .iz-chip').removeClass('on').filter('[data-v="' + v + '"]').addClass('on');
    }
    function toggleCustomDate() {
        if ($('#period').val() === 'custom') $('#custom-date-wrapper').slideDown();
        else $('#custom-date-wrapper').slideUp();
    }
    $('#periodChips').on('click', '.iz-chip', function () {
        $('#period').val($(this).data('v')).trigger('change');
    });
    $('#period').on('change', function () { syncChips(); toggleCustomDate(); });
    syncChips();
    toggleCustomDate();

    /* ---------- Vendor search ---------- */
    $('#vendor').on('change', function () {
        if ($(this).val() === 'single_vendor') {
            $('#vendor_search_wrapper').slideDown();
        } else {
            $('#vendor_search_wrapper').slideUp();
            $('#vendor_name, #vendor_id').val('');
            $('#vendorList').fadeOut();
        }
    });

    $('#vendor_name').on('keyup', function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('vendor.search2') }}",
                method: "GET",
                data: { query: query },
                success: function (data) { $('#vendorList').fadeIn().html(data); }
            });
        } else {
            $('#vendorList').fadeOut();
        }
    });

    $(document).on('click', '.vendor-item', function () {
        $('#vendor_name').val($(this).data('name'));
        $('#vendor_id').val($(this).data('id'));
        $('#vendorList').fadeOut();
    });

    /* ---------- Client search ---------- */
    $('#client').on('change', function () {
        if ($(this).val() === 'single_client') {
            $('#client_search_wrapper').slideDown();
        } else {
            $('#client_search_wrapper').slideUp();
            $('#client_name').val('');
            $('#client_id').val('');
            $('#clientList').fadeOut();
        }
    });

    $('#client_name').on('keyup', function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('client.search2') }}",
                method: "GET",
                data: { query: query },
                success: function (data) { $('#clientList').fadeIn().html(data); }
            });
        } else {
            $('#clientList').fadeOut();
        }
    });

    $(document).on('click', '.client-item', function (e) {
        e.preventDefault();
        $('#client_name').val($(this).data('name'));
        $('input[name="client_id"]').val($(this).data('id'));
        $('#clientList').fadeOut();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#client_name, #clientList').length) $('#clientList').fadeOut();
        if (!$(e.target).closest('#vendor_name, #vendorList').length) $('#vendorList').fadeOut();
    });

    // Pre-select if form reloads with single client
    @if(request('client') === 'single_client')
    $('#client').val('single_client').trigger('change');
    @endif
});
</script>

<script>
    /* ---------- GSTR-1 download ---------- */
    $('#downloadGSTR1').on('click', function (e) {
        e.preventDefault();

        let period = $('#monthYearPicker').val();

        if (!period) {
            Swal.fire('Please select a period!');
            return;
        }

        Swal.fire({
            title: "Generating File...",
            text: "Please wait while we prepare your GSTR-1 JSON file.",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const downloadUrl = "{{ route('gst.gstr1') }}?period=" + period;

        // Trigger file download
        window.location.href = downloadUrl;

        Swal.close();
    });

    flatpickr("#monthYearPicker", {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,   // Jan, Feb...
                dateFormat: "mY",  // Output: 072025
                altFormat: "F Y"
            })
        ]
    });
</script>

<script>
    /* ---------- Custom date range ---------- */
    $("#date").daterangepicker({
        autoUpdateInput: false,
        locale: { format: "YYYY-M-DD" }
    }, function (start, end) {
        $('#date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total days selected: " + daysSelected);
    });

    $('#date').on('cancel.daterangepicker', function () {
        $(this).val('');
        $("#total_days").text('');
    });

    /* ---------- Generate report (AJAX) ---------- */
    $('.js-generate').on('click', function (e) {
        e.preventDefault();
        let formData = new FormData(document.getElementById('generate-report-form'));
        Swal.fire({
            title: "Processing...",
            text: "Please wait while we preparing your report.",
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: "{{ route('report.get') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            beforeSend: function () {
                $('.error').remove();
                $('.is-invalid').removeClass('is-invalid');
            },
            success: function (response) {
                Swal.close();

                if (response.error == 1) {
                    $.each(response.errors, function (field, messages) {
                        let inputField = $('[name="' + field + '"], [name="' + field + '[]"]');
                        if (inputField.length > 0) {
                            inputField.addClass("is-invalid");

                            if (inputField.closest('.input-group').length > 0) {
                                inputField.closest('.input-group').after('<div class="text-danger error">' + messages[0] + '</div>');
                            } else if (inputField.hasClass('select2-hidden-accessible')) {
                                inputField.next('.select2-container').after('<div class="text-danger error">' + messages[0] + '</div>');
                            } else {
                                inputField.last().after('<div class="text-danger error">' + messages[0] + '</div>');
                            }
                        }
                    });

                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please check the form carefully!",
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 3000
                    });

                } else if (response.error == 0) {
                    $('#report-result').html(response.html);

                    Swal.fire({
                        icon: "success",
                        title: "Report Generated Successfully!",
                        text: response.message,
                        toast: false,
                        position: "center",
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        lucide.createIcons();
                        $('html, body').animate({ scrollTop: $('#report-result').offset().top - 100 }, 400);
                    });
                }
            },
            complete: function () {
                lucide.createIcons();
            },
            error: function (xhr) {
                Swal.close();
                console.log("Error:", xhr.responseText);
            }
        });
    });
</script>
</x-default-layout>