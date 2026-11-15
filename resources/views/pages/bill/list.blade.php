<x-default-layout>

    <style>
        /* ==========================================================================
           Bill listing — premium SaaS look (scoped to .inv-page)
           Mobile-first: card per bill  ->  table layout from 768px
           ========================================================================== */
        .inv-page {
            --i1: #4f46e5;
            --i2: #7c3aed;
            --ink: #0f172a;
            --text: #334155;
            --mut: #64748b;
            --faint: #94a3b8;
            --bd: #e8ebf3;
            --soft: #f8fafc;
        }

        /* ---------- filter ---------- */
        .inv-page .inv-filter { margin-bottom: 4px; }

        /* ---------- toolbar ---------- */
        .inv-page .inv-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 20px 0 14px;
        }

        .inv-page .inv-count {
            display: flex;
            align-items: baseline;
            gap: 8px;
            min-width: 0;
        }

        .inv-page .inv-count h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--ink);
        }

        .inv-page .inv-count span {
            font-size: 13px;
            font-weight: 500;
            color: var(--mut);
            white-space: nowrap;
        }

        .inv-page .inv-toolbar-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-left: auto;
        }

        /* bulk buttons group (shown by JS when rows are selected) */
        .inv-page .inv-bulk-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .inv-page .inv-bulk-group form { display: none; }

        .inv-page .inv-bulk-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 40px;
            padding: 0 16px;
            border-radius: 10px;
            border: 1px solid var(--bd);
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .05);
            transition: .18s;
            white-space: nowrap;
        }

        .inv-page .inv-bulk-btn svg,
        .inv-page .inv-bulk-btn i { width: 15px; height: 15px; }

        .inv-page .inv-bulk-btn:hover { border-color: #c7d2fe; color: var(--i1); transform: translateY(-1px); }
        .inv-page .inv-bulk-btn.danger { color: #be123c; }
        .inv-page .inv-bulk-btn.danger:hover { border-color: #fecdd3; background: #fff1f2; color: #be123c; }

        /* Mobile: Add New upar full width, uske niche bulk buttons; title left + total right sabse neeche */
        @media (max-width: 767.98px) {
            .inv-page .inv-toolbar {
                flex-direction: column-reverse;
                align-items: stretch;
                gap: 14px;
            }

            .inv-page .inv-count {
                width: 100%;
                justify-content: space-between;
                align-items: center;
            }

            .inv-page .inv-toolbar-actions {
                width: 100%;
                margin-left: 0;
            }

            /* Add New button (last child) full width, first row */
            .inv-page .inv-toolbar-actions > *:last-child {
                flex: 1 1 100%;
                order: -1;
                justify-content: center;
            }

            .inv-page .inv-bulk-group { flex: 1 1 100%; }
            .inv-page .inv-bulk-group .inv-bulk-btn { flex: 1; padding: 0 8px; }
        }

        /* ---------- list container ---------- */
        .inv-page .inv-card { background: transparent; }

        /* checkbox */
        .inv-page .form-check-input {
            flex: none;
            width: 18px;
            height: 18px;
            margin: 0;
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            background-color: #fff;
            cursor: pointer;
            transition: .15s;
        }

        .inv-page .form-check-input:checked {
            background-color: var(--i1);
            border-color: var(--i1);
        }

        .inv-page .form-check-input:focus { box-shadow: 0 0 0 4px rgba(99, 102, 241, .18); border-color: var(--i1); }

        /* ---------- header (sort chips on mobile, column header on desktop) ---------- */
        .inv-page .inv-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .inv-page .inv-hcell {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 99px;
            border: 1px solid var(--bd);
            background: #fff;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--mut);
            line-height: 1.2;
        }

        .inv-page .inv-hcell svg,
        .inv-page .inv-hcell > i { width: 13px; height: 13px; color: var(--faint); flex: none; }

        .inv-page .inv-hcell a { color: inherit; text-decoration: none; }
        .inv-page .inv-hcell a:hover { color: var(--i1); }

        .inv-page .inv-hcell.inv-hcheck { padding: 7px 14px 7px 10px; gap: 9px; }
        .inv-page .inv-selall { margin: 0; font-size: 12.5px; font-weight: 600; color: var(--text); cursor: pointer; }
        .inv-page .inv-hcell.inv-hactions { display: none; }

        /* ---------- row = card on mobile ---------- */
        .inv-page .inv-row {
            position: relative;
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            grid-template-areas:
                "check  main   main"
                ".      status status"
                ".      amount date"
                ".      actions actions";
            gap: 12px 12px;
            align-items: start;
            padding: 16px;
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 18px;
            box-shadow: 0 10px 28px -22px rgba(15, 23, 42, .28);
            transition: border-color .18s, box-shadow .18s, background .18s;
        }

        .inv-page .inv-row:hover { border-color: #d6dcf5; box-shadow: 0 14px 32px -20px rgba(79, 70, 229, .3); }

        .inv-page .inv-row:has(.selected:checked) {
            background: #f7f8ff;
            border-color: #c7d2fe;
        }

        .inv-page .inv-cell { min-width: 0; }
        .inv-page .inv-check { grid-area: check; padding-top: 2px; }
        .inv-page .inv-main { grid-area: main; }
        .inv-page .inv-status { grid-area: status; }
        .inv-page .inv-amount { grid-area: amount; }
        .inv-page .inv-date { grid-area: date; text-align: right; }

        /* actions = quick icons (view / print / download) + existing action menu */
        .inv-page .inv-actions {
            grid-area: actions;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-top: 12px;
            border-top: 1px dashed var(--bd);
        }

        .inv-page .inv-label {
            display: block;
            margin-bottom: 3px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--faint);
        }

        /* bill number */
        .inv-page .inv-numline { display: flex; align-items: center; flex-wrap: wrap; gap: 4px 8px; }

        .inv-page .inv-num {
            font-size: 15px;
            font-weight: 700;
            color: var(--i1);
            text-decoration: none;
            word-break: break-word;
        }

        .inv-page .inv-num:hover { color: #4338ca; text-decoration: underline; }

        .inv-page .inv-tag {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .04em;
            color: #b45309;
            background: #fef3c7;
        }

        /* quick action buttons (icon-only) */
        .inv-page .inv-quick {
            flex: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .inv-page .inv-qbtn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 11px;
            border: 1px solid var(--bd);
            background: var(--soft);
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1;
            color: var(--text);
            text-decoration: none;
            white-space: nowrap;
            transition: .16s;
        }

        .inv-page .inv-qbtn i { font-size: 15px; color: var(--mut); transition: .16s; }

        .inv-page .inv-qbtn:hover,
        .inv-page .inv-qbtn:focus-visible {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: var(--i1);
            transform: translateY(-1px);
            box-shadow: 0 8px 14px -10px rgba(79, 70, 229, .6);
        }

        .inv-page .inv-qbtn:hover i,
        .inv-page .inv-qbtn:focus-visible i { color: var(--i1); }

        .inv-page .inv-qbtn.q-print:hover,
        .inv-page .inv-qbtn.q-print:focus-visible { background: #fffbeb; border-color: #fde68a; color: #b45309; box-shadow: 0 8px 14px -10px rgba(217, 119, 6, .6); }
        .inv-page .inv-qbtn.q-print:hover i,
        .inv-page .inv-qbtn.q-print:focus-visible i { color: #b45309; }

        .inv-page .inv-qbtn.q-download:hover,
        .inv-page .inv-qbtn.q-download:focus-visible { background: #ecfdf5; border-color: #a7f3d0; color: #047857; box-shadow: 0 8px 14px -10px rgba(5, 150, 105, .6); }
        .inv-page .inv-qbtn.q-download:hover i,
        .inv-page .inv-qbtn.q-download:focus-visible i { color: #047857; }

        .inv-page .inv-menu { flex: none; display: flex; align-items: center; }

        /* vendor line */
        .inv-page .inv-client {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            margin-top: 4px;
            font-size: 13px;
            color: var(--mut);
        }

        .inv-page .inv-client a.edit-vendor {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
        }

        .inv-page .inv-client a.edit-vendor:hover { color: var(--i1); }

        .inv-page .inv-meta {
            display: block;
            margin-top: 2px;
            font-size: 12px;
            color: var(--faint);
        }

        /* status badges */
        .inv-page .inv-status { display: flex; flex-wrap: wrap; align-items: center; gap: 6px 10px; }

        .inv-page .inv-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 99px;
            border: 1px solid transparent;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
        }

        .inv-page .inv-badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .inv-page .inv-badge.s-pending { color: #b45309; background: #fffbeb; border-color: #fde68a; }
        .inv-page .inv-badge.s-sent { color: #1d4ed8; background: #eff6ff; border-color: #bfdbfe; }
        .inv-page .inv-badge.s-paid { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .inv-page .inv-badge.s-cancelled { color: #475569; background: #f1f5f9; border-color: #e2e8f0; }
        .inv-page .inv-badge.s-overdue { color: #be123c; background: #fff1f2; border-color: #fecdd3; }
        .inv-page .inv-badge.s-default { color: #334155; background: #f1f5f9; border-color: #e2e8f0; }

        .inv-page .inv-duetxt { font-size: 12px; font-weight: 600; }
        .inv-page .inv-duetxt.d-overdue { color: #e11d48; }
        .inv-page .inv-duetxt.d-upcoming { color: #d97706; }
        .inv-page .inv-duetxt.d-today { color: var(--i1); }
        .inv-page .inv-duetxt.d-default { color: var(--mut); }

        /* amount */
        .inv-page .inv-total {
            display: block;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--ink);
            white-space: nowrap;
        }

        .inv-page .inv-dueamt {
            display: inline-block;
            margin-top: 4px;
            padding: 2px 9px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
            color: #be123c;
            background: #fff1f2;
            border: 1px solid #fecdd3;
        }

        .inv-page .inv-settled {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            font-weight: 600;
            color: #16a34a;
        }

        .inv-page .inv-rcm {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            font-weight: 500;
            color: #b45309;
        }

        /* dates */
        .inv-page .inv-datev {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
        }

        .inv-page .inv-datev i { font-size: 12px; color: var(--faint); }

        .inv-page .inv-datesub {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            color: var(--mut);
            white-space: nowrap;
        }

        /* ---------- empty state ---------- */
        .inv-page .inv-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 56px 20px;
            text-align: center;
            background: #fff;
            border: 1px dashed #d6dcf5;
            border-radius: 22px;
        }

        .inv-page .inv-empty-ic {
            width: 64px;
            height: 64px;
            margin-bottom: 8px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            font-size: 24px;
            color: #fff;
            background: linear-gradient(135deg, var(--i1), #818cf8);
            box-shadow: 0 16px 28px -14px rgba(79, 70, 229, .7);
        }

        .inv-page .inv-empty h4 { margin: 0; font-size: 17px; font-weight: 700; color: var(--ink); }
        .inv-page .inv-empty p { margin: 0 0 14px; max-width: 360px; font-size: 13.5px; color: var(--mut); }

        /* ---------- pagination ---------- */
        .inv-page .inv-pager {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }

        .inv-page .inv-pager p { margin: 0; font-size: 13px; font-weight: 500; color: var(--mut); }

        .inv-page .inv-pager .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            margin: 0;
            padding: 0;
        }

        .inv-page .inv-pager .page-link {
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--bd);
            border-radius: 10px !important;
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            color: var(--text) !important;
            box-shadow: none;
            transition: .15s;
        }

        .inv-page .inv-pager .page-link:hover { border-color: #c7d2fe; background: #eef2ff; color: var(--i1) !important; }

        .inv-page .inv-pager .page-item.active .page-link {
            border-color: transparent;
            background: linear-gradient(135deg, var(--i1), #6366f1);
            color: #fff !important;
            box-shadow: 0 10px 18px -10px rgba(79, 70, 229, .75);
        }

        .inv-page .inv-pager .page-item.disabled .page-link { background: var(--soft); color: #cbd5e1 !important; }

        @media (min-width: 768px) {
            .inv-page .inv-pager { flex-direction: row; justify-content: space-between; }
        }

        /* very small phones: slightly smaller buttons */
        @media (max-width: 374.98px) {
            .inv-page .inv-row { padding: 14px; gap: 10px; }
            .inv-page .inv-qbtn { width: 38px; height: 38px; }
            .inv-page .inv-quick { gap: 6px; }
        }

        /* ==========================================================================
           Table layout (tablet landscape and up)
           ========================================================================== */
        @media (min-width: 768px) {
            .inv-page .inv-card {
                background: #fff;
                border: 1px solid var(--bd);
                border-radius: 20px;
                box-shadow: 0 14px 36px -26px rgba(15, 23, 42, .3);
            }

            .inv-page .inv-head,
            .inv-page .inv-row {
                display: grid;
                grid-template-columns: 44px minmax(0, 2.2fr) minmax(0, 1.1fr) minmax(0, 1.3fr) minmax(0, 1fr) 152px;
                grid-template-areas: "check main status amount date actions";
                gap: 0 14px;
                align-items: center;
                padding: 0 20px;
            }

            /* header */
            .inv-page .inv-head {
                height: 50px;
                margin: 0;
                border-bottom: 1px solid var(--bd);
                border-radius: 20px 20px 0 0;
                background: var(--soft);
            }

            .inv-page .inv-hcell {
                padding: 0;
                gap: 7px;
                border: 0;
                border-radius: 0;
                background: transparent;
                font-size: 12px;
                font-weight: 600;
                color: var(--mut);
            }

            .inv-page .inv-hcell.inv-hcheck { padding: 0; }
            .inv-page .inv-hcell.inv-hactions { display: inline-flex; justify-content: flex-end; }
            .inv-page .inv-selall { display: none; }
            .inv-page .inv-hcell.h-main { grid-area: main; }
            .inv-page .inv-hcell.h-status { grid-area: status; }
            .inv-page .inv-hcell.h-amount { grid-area: amount; }
            .inv-page .inv-hcell.h-date { grid-area: date; }
            .inv-page .inv-hcell.inv-hcheck { grid-area: check; }
            .inv-page .inv-hcell.inv-hactions { grid-area: actions; }

            /* rows */
            .inv-page .inv-row {
                min-height: 76px;
                margin: 0;
                padding-top: 14px;
                padding-bottom: 14px;
                border: 0;
                border-bottom: 1px solid #eef0f7;
                border-radius: 0;
                box-shadow: none;
            }

            .inv-page .inv-row:last-child { border-bottom: 0; border-radius: 0 0 20px 20px; }
            .inv-page .inv-row:hover { background: #fafbff; border-color: #eef0f7; box-shadow: none; }
            .inv-page .inv-row:has(.selected:checked) { background: #f5f6ff; box-shadow: inset 3px 0 0 var(--i1); }

            .inv-page .inv-check { padding: 0; }
            .inv-page .inv-label { display: none; }
            .inv-page .inv-status { flex-direction: column; align-items: flex-start; gap: 5px; }
            .inv-page .inv-date { text-align: left; }

            /* actions: compact icon buttons on desktop */
            .inv-page .inv-actions {
                padding: 0;
                border-top: 0;
                justify-content: flex-end;
                gap: 6px;
            }

            .inv-page .inv-quick { gap: 4px; }

            .inv-page .inv-qbtn {
                width: 32px;
                height: 32px;
                border-radius: 9px;
                border-color: transparent;
                background: transparent;
            }

            .inv-page .inv-qbtn i { font-size: 14px; color: var(--faint); }
            .inv-page .inv-qbtn:hover,
            .inv-page .inv-qbtn:focus-visible { box-shadow: none; transform: none; }
        }
    </style>

    <x-page-heading
        title="Bills"
        description=""
        :breadcrumbs="[['label' => 'Bills']]" />

    @php
        $bills = $data['bill'] ?? [];
        $hasBills = !empty($bills) && count($bills) > 0;
        $fmtDate = fn($d) => !empty($d) ? \Carbon\Carbon::parse($d)->format('d M Y') : '—';
        $knownStatus = ['pending', 'sent', 'paid', 'cancelled', 'overdue'];
    @endphp

    <div class="inv-page">

        {{-- Filter --}}
        <div class="inv-filter">
            @include('pages/bill.filter')
        </div>

        {{-- Toolbar --}}
        <div class="inv-toolbar">
            <div class="inv-count">
                <h3>All bills</h3>
                @if (!empty($data['totalRecords']))
                <span>{{ number_format($data['totalRecords']) }} total</span>
                @endif
            </div>

            <div class="inv-toolbar-actions">
                {{-- Bulk actions: sirf tab dikhenge jab bill select ho --}}
                <div id="bulk-action-section" class="inv-bulk-group d-none">
                    <a href="#" id="bulk-delete" title="Delete Selected Bills" class="inv-bulk-btn danger">
                        <i data-lucide="trash-2"></i> Delete <span id="bulkCount"></span>
                    </a>

                    <a href="#" id="bulk-bill-download" title="Download Selected Bills" class="inv-bulk-btn">
                        <i data-lucide="download"></i> Download
                    </a>

                    <form id="download-form" method="POST" action="{{ route('bill.bulk_download') }}">
                        @csrf
                    </form>
                </div>

                <x-invoice.saas-button :href="route('bill.add')" id="add-action" icon="plus-circle"> Add New</x-invoice.saas-button>
            </div>
        </div>

        @if ($hasBills)
        <div class="inv-card">

            <!-- Header (sort chips on mobile, column header on desktop) -->
            <div class="inv-head">
                <div class="inv-hcell inv-hcheck">
                    <input class="form-check-input bill_code" type="checkbox" id="select-all">
                    <label for="select-all" class="inv-selall">Select All</label>
                </div>

                <div class="inv-hcell h-main sortable"><i data-lucide="file-text"></i> @sortablelink('bill_number', 'Bill #')</div>
                <div class="inv-hcell h-status sortable"><i data-lucide="check-circle"></i> @sortablelink('bill_status', 'Status')</div>
                <div class="inv-hcell h-amount sortable"><i data-lucide="dollar-sign"></i> @sortablelink('total', 'Total')</div>
                <div class="inv-hcell h-date sortable"><i data-lucide="calendar"></i> @sortablelink('bill_date', 'Bill Date')</div>

                <div class="inv-hcell inv-hactions"><span>Action</span></div>
            </div>

            @foreach ($bills as $index => $bill)

            @php
                $vendorName = $bill->company_name ?? $bill->vendor_name ?? 'Vendor';
                $status     = in_array($bill->bill_status ?? '', $knownStatus) ? $bill->bill_status : 'default';
                $isRcm      = ($bill->reverse_charge ?? 'N') === 'Y';
                $symbol     = $bill->symbol ?? '';
                $dueType    = $bill->due_type ?? '';
                $dueClass   = in_array($dueType, ['overdue', 'upcoming', 'today']) ? 'd-' . $dueType : 'd-default';
            @endphp

            <div class="inv-row">

                {{-- Checkbox --}}
                <div class="inv-cell inv-check">
                    <input class="form-check-input selected" name="selected[]" type="checkbox" value="{{ $bill->bill_code }}">
                </div>

                {{-- Bill number + vendor --}}
                <div class="inv-cell inv-main">
                    <div class="inv-numline">
                        <a class="inv-num" href="{{ route('bill.edit', ['bill_code' => $bill->bill_code]) }}" title="{{ $bill->bill_number }}">{{ $bill->bill_number }}</a>
                        @if($isRcm)
                        <span class="inv-tag" title="Reverse charge applicable">RCM</span>
                        @endif
                    </div>

                    <div class="inv-client">
                        <span>From:</span>
                        <a href="#" vendor-code="{{ $bill->vendor_code }}" class="edit-vendor" title="{{ $vendorName }}">{{ $vendorName }}</a>
                    </div>

                    @if(!empty($bill->vendor_invoice_number))
                    <span class="inv-meta">Vendor inv. {{ $bill->vendor_invoice_number }}</span>
                    @endif
                </div>

                {{-- Status --}}
                <div class="inv-cell inv-status">
                    <span class="inv-badge s-{{ $status }}">{{ ucfirst($bill->bill_status ?? 'pending') }}</span>

                    @if (!empty($bill->due_status_text) && ($bill->bill_status ?? '') != 'paid')
                    <span class="inv-duetxt {{ $dueClass }}">{{ $bill->due_status_text }}</span>
                    @endif
                </div>

                {{-- Amount --}}
                <div class="inv-cell inv-amount">
                    <span class="inv-label">Total</span>
                    <span class="inv-total">{{ $symbol }} {{ number_format($bill->grand_total, 2) }}</span>

                    @if(($bill->total_due ?? 0) > 0)
                    <span class="inv-dueamt">{{ $symbol }} {{ number_format($bill->total_due, 2) }} {{ $isRcm ? 'payable to vendor' : 'due' }}</span>
                    @elseif(($bill->bill_status ?? '') == 'paid')
                    <span class="inv-settled"><i class="bi bi-check-circle-fill"></i> Settled</span>
                    @endif

                    @if($isRcm && ($bill->rcm_tax_amount ?? 0) > 0)
                    <span class="inv-rcm">GST to govt {{ $symbol }} {{ number_format($bill->rcm_tax_amount, 2) }}</span>
                    @endif
                </div>

                {{-- Dates --}}
                <div class="inv-cell inv-date">
                    <span class="inv-label">Bill date</span>
                    <span class="inv-datev" title="{{ $bill->bill_date }}"><i class="fa-regular fa-calendar"></i>{{ $fmtDate($bill->bill_date) }}</span>
                    @if(!empty($bill->due_date))
                    <span class="inv-datesub">Due {{ $fmtDate($bill->due_date) }}</span>
                    @endif
                </div>

                {{-- Actions: View / Print / Download + existing action menu --}}
                <div class="inv-cell inv-actions">
                    <span class="inv-quick">
                        <a href="#" bill-code="{{ $bill->bill_code }}" class="inv-qbtn q-view bill-view-model" title="View Bill" aria-label="View Bill">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <a href="{{ route('bill.download', ['bill_code' => $bill->bill_code]) }}?preview=true" target="_blank" rel="noopener" class="inv-qbtn q-print" title="Print Bill" aria-label="Print Bill">
                            <i class="fa-solid fa-print"></i>
                        </a>
                        <a href="{{ route('bill.download', ['bill_code' => $bill->bill_code]) }}" class="inv-qbtn q-download" title="Download Bill" aria-label="Download Bill">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </span>

                    <div class="inv-menu">
                        @include('pages/bill/actions/edit_action')
                    </div>
                </div>

            </div>
            @endforeach

        </div>
        @else
        <div class="inv-empty">
            <div class="inv-empty-ic"><i class="bi bi-receipt"></i></div>
            <h4>No bills found</h4>
            <p>Record your first purchase bill to start tracking GST, ITC and payments.</p>
            <x-invoice.saas-button :href="route('bill.add')" icon="plus-circle"> Add New</x-invoice.saas-button>
        </div>
        @endif

        {{-- Pagination --}}
        @if(!empty($data['show_pagination']))
        <div class="inv-pager">
            <p>
                Showing {{ ($data['page'] - 1) * $data['perPage'] + 1 }}
                to {{ min($data['page'] * $data['perPage'], $data['totalRecords']) }}
                of {{ number_format($data['totalRecords']) }} results
            </p>

            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    @if ($data['page'] > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url'] }}1" aria-label="First"><i class="bi bi-chevron-double-left"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url'] }}{{ $data['page'] - 1 }}" aria-label="Previous"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    @else
                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-double-left"></i></span></li>
                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></li>
                    @endif

                    @if ($data['page'] > 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    @for ($i = max(1, $data['page'] - 2); $i <= min($data['totalPages'], $data['page'] + 2); $i++)
                    <li class="page-item {{ $i == $data['page'] ? 'active' : '' }}">
                        <a href="{{ $data['pagination_url'] }}{{ $i }}" class="page-link">{{ $i }}</a>
                    </li>
                    @endfor

                    @if ($data['page'] < $data['totalPages'] - 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    @if ($data['page'] < $data['totalPages'])
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url'] }}{{ $data['page'] + 1 }}" aria-label="Next"><i class="bi bi-chevron-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url'] }}{{ $data['totalPages'] }}" aria-label="Last"><i class="bi bi-chevron-double-right"></i></a>
                    </li>
                    @else
                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></li>
                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-double-right"></i></span></li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif

    </div>

    {{-- ===== Modals ===== --}}
    <div class="modal fade" id="bulk-modal" tabindex="-1" aria-labelledby="bulkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="bulkModalLabel">Bulk Action</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="spinner-border text-primary spinner-format" id="bulk-loader" style="display:none;" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <div class="bulk-modal-body py-5 px-5"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="singleDeleteModal" tabindex="-1" aria-labelledby="singleDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="singleDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete this bill?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" bill-code="" class="btn btn-danger" id="confirmed-single-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="multiDeleteModal" tabindex="-1" aria-labelledby="multiDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="multiDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete all the selected bills?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" bill-code="" class="btn btn-danger" id="confirmed-multi-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="emailConfirmModal" tabindex="-1" aria-labelledby="emailConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title">Send Bill Emails</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to send selected bills to vendors via email?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-email">
                        <i class="fa-solid fa-paper-plane text-white"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title" id="paymentModalLabel">Record Payment</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="payment-record-form-body"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-3 mb-3">
                    <h5 class="modal-title" id="viewModalLabel">View Bill</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body" class="px-3 px-md-5 mb-5"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vendor-modal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="vendorModalLabel">Add Vendor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="vendor-modal-body py-3 px-3"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editvendor-modal" tabindex="-1" aria-labelledby="editvendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editvendorModalLabel">Edit Vendor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editvendor-modal-body py-3 px-3"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    {{-- ===== Scripts ===== --}}
    <script>
        const SN_TOOLBAR = [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ];

        // ---- Edit vendor ----
        $(document).on('click', '.edit-vendor', function(e) {
            e.preventDefault();
            $('.vendor-modal-body').empty();
            $('.editvendor-modal-body').empty();

            var vendor_code = $(this).attr('vendor-code');

            $.ajax({
                url: "{{ route('vendor.edit') }}",
                data: { vendor_code: vendor_code },
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(response) {
                    $('.editvendor-modal-body').html(response);
                    $('#editvendor-modal').modal('show');

                    $('#editvendor-modal').one('shown.bs.modal', function() {
                        ['#id_country_id', '#id_state_id', '#id_currency_code', '#id_shipping_state_id', '#id_shipping_country_id'].forEach(function(selector) {
                            const el = document.querySelector(selector);
                            if (!el) return;
                            if (!el.choices) {
                                el.choices = new Choices(el, { searchEnabled: true, itemSelectText: '', shouldSort: false });
                            }
                        });

                        $('#id_notes').summernote({ placeholder: 'Enter notes...', height: 120, toolbar: SN_TOOLBAR });
                        $('#id_terms').summernote({ placeholder: 'Enter terms...', height: 120, toolbar: SN_TOOLBAR });
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    </script>

    <script>
        $(function() {

            // ---- Selection + bulk buttons (show only when selected, with count) ----
            function updateBulkBar() {
                const total = $('.selected').length;
                const count = $('.selected:checked').length;

                $('#bulk-action-section').toggleClass('d-none', count === 0);
                $('#bulkCount').text(count > 0 ? '(' + count + ')' : '');
                $('.bill_code').prop('checked', total > 0 && count === total);
            }

            $(document).on('change', '.selected', updateBulkBar);

            $(document).on('change', '.bill_code', function() {
                $('.selected').prop('checked', this.checked);
                updateBulkBar();
            });

            // ---- Bulk delete ----
            var bills_code = [];

            $('#bulk-delete').on('click', function(e) {
                e.preventDefault();
                bills_code = [];
                $('.selected:checked').each(function() {
                    bills_code.push(this.value);
                });
                if (bills_code.length === 0) return;
                $('#multiDeleteModal').modal('show');
            });

            $('#confirmed-multi-delete').on('click', function() {
                $('#multiDeleteModal').modal('hide');

                $.ajax({
                    url: "{{ route('bill.bulk_delete') }}",
                    data: { bills_code: bills_code },
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error!', text: 'An error occurred while deleting bills.' });
                    }
                });
            });

            // ---- Single delete ----
            $('#confirmed-single-delete').on('click', function(e) {
                e.preventDefault();
                var bill_code = $(this).attr('bill-code');

                $.ajax({
                    url: "{{ route('bill.destroy') }}",
                    method: 'POST',
                    data: { bill_code: bill_code, _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.error === 0) {
                            location.reload();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error!', text: 'Failed to delete bill.' });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error!', text: 'An error occurred while deleting the bill.' });
                    }
                });
            });

            // ---- Bulk download ----
            $('#bulk-bill-download').on('click', function(e) {
                e.preventDefault();
                let selectedBills = $(".selected:checked");
                let form = $('#download-form');

                form.find('input[name="bills_code[]"]').remove();

                if (selectedBills.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'Select bills', text: 'Please select at least one bill.' });
                    return;
                }

                selectedBills.each(function() {
                    $('<input>').attr({ type: 'hidden', name: 'bills_code[]' }).val($(this).val()).appendTo(form);
                });

                form.submit(); // Laravel returns ZIP -> browser downloads
            });

            // ---- View bill ----
            $(document).on('click', '.bill-view-model', function(e) {
                e.preventDefault();
                var bill_code = $(this).attr('bill-code');

                Swal.fire({
                    title: 'Loading Bill...',
                    text: 'Please wait while we fetch bill details.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: "{{ route('bill.view.model') }}",
                    type: 'POST',
                    data: { bill_code: bill_code },
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(response) {
                        $('#view-record-form-body').html(response.html);
                        Swal.close();
                        $('#viewModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Error!', text: 'Unable to load bill details. Please try again.' });
                        console.error('Error loading bill:', xhr.responseText);
                    }
                });
            });

            // ---- Record payment ----
            $(document).on('click', '.record-payment-form', function(e) {
                e.preventDefault();
                $('#paymentModal').modal('show');
                var bill_code = $(this).attr('bill-code');

                $.ajax({
                    url: "{{ route('bill.get_payment_form') }}",
                    data: { bill_code: bill_code },
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function() { $('.loader').show(); },
                    complete: function() { $('.loader').hide(); },
                    success: function(response) {
                        $('#payment-record-form-body').html(response);
                        $('#paymentModal').modal('show');
                    }
                });
            });

            // ---- Bulk modal scheduler ----
            $('#bulk-modal').on('shown.bs.modal', function() {
                flatpickr("#scheduled_datetime", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:s",
                    time_24hr: true,
                    minuteIncrement: 1,
                    defaultHour: 12,
                    defaultMinute: 0
                });
            });

            updateBulkBar();
        });
    </script>

</x-default-layout>