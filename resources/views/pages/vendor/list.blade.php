<x-default-layout>

    <style>
        /* ==========================================================================
           Vendor listing — premium SaaS look (scoped to .inv-page)
           Mobile-first: card per vendor  ->  table layout from 768px
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
            gap: 8px;
            margin-left: auto;
        }

        .inv-page .inv-toolbar-actions .inv-bulk-btn {
            height: 40px;
        }

        /* Mobile: actions (Add New) upar full width, niche title left + total right */
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

            /* Add New button (last child) takes remaining width */
            .inv-page .inv-toolbar-actions > *:last-child {
                flex: 1;
                justify-content: center;
            }
        }

        /* ---------- bulk delete button ---------- */
        .inv-page .inv-bulk-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 38px;
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

        .inv-page .inv-bulk-btn[hidden] {
            display: none !important;
        }

        .inv-page .inv-bulk-btn svg,
        .inv-page .inv-bulk-btn i {
            width: 15px;
            height: 15px;
        }

        .inv-page .inv-bulk-btn:hover {
            border-color: #c7d2fe;
            color: var(--i1);
            transform: translateY(-1px);
        }

        .inv-page .inv-bulk-btn.danger {
            color: #be123c;
        }

        .inv-page .inv-bulk-btn.danger:hover {
            border-color: #fecdd3;
            background: #fff1f2;
            color: #be123c;
        }

        /* ---------- list container ---------- */
        .inv-page .inv-card {
            background: transparent;
        }

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

        .inv-page .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .18);
            border-color: var(--i1);
        }

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
        .inv-page .inv-hcell > i {
            width: 13px;
            height: 13px;
            color: var(--faint);
            flex: none;
        }

        .inv-page .inv-hcell a {
            color: inherit;
            text-decoration: none;
        }

        .inv-page .inv-hcell a:hover {
            color: var(--i1);
        }

        .inv-page .inv-hcell.inv-hcheck {
            padding: 7px 14px 7px 10px;
            gap: 9px;
        }

        .inv-page .inv-selall {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        .inv-page .inv-hcell.inv-hactions {
            display: none;
        }

        .inv-page .inv-hgroup {
            display: contents;
        }

        /* ---------- row = card on mobile ---------- */
        .inv-page .inv-row {
            position: relative;
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            grid-template-areas:
                "check  main    actions"
                ".      contact contact"
                ".      status  date";
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

        .inv-page .inv-row:hover {
            border-color: #d6dcf5;
            box-shadow: 0 14px 32px -20px rgba(79, 70, 229, .3);
        }

        .inv-page .inv-row:has(.selected:checked) {
            background: #f7f8ff;
            border-color: #c7d2fe;
        }

        .inv-page .inv-cell {
            min-width: 0;
        }

        .inv-page .inv-check {
            grid-area: check;
            padding-top: 2px;
        }

        .inv-page .inv-main {
            grid-area: main;
        }

        .inv-page .inv-status {
            grid-area: status;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px 10px;
        }

        .inv-page .inv-date {
            grid-area: date;
            text-align: right;
        }

        .inv-page .inv-actions {
            grid-area: actions;
            display: flex;
            justify-content: flex-end;
        }

        .inv-page .inv-contact {
            grid-area: contact;
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 0;
        }

        .inv-page .inv-label {
            display: block;
            margin-bottom: 3px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--faint);
        }

        /* status badges */
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

        .inv-page .inv-badge.s-default { color: #334155; background: #f1f5f9; border-color: #e2e8f0; }
        .inv-page .inv-badge.s-active { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .inv-page .inv-badge.s-deactive { color: #be123c; background: #fff1f2; border-color: #fecdd3; }

        /* date */
        .inv-page .inv-datev {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
        }

        .inv-page .inv-datev i {
            font-size: 12px;
            color: var(--faint);
        }

        /* name + company */
        .inv-page .inv-who {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .inv-page .inv-who-text {
            min-width: 0;
        }

        .inv-page .inv-avatar {
            flex: none;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            font-size: 16px;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .inv-page .inv-avatar.av-0 { color: #4338ca; background: #eef2ff; border-color: #c7d2fe; }
        .inv-page .inv-avatar.av-1 { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .inv-page .inv-avatar.av-2 { color: #b45309; background: #fffbeb; border-color: #fde68a; }
        .inv-page .inv-avatar.av-3 { color: #be123c; background: #fff1f2; border-color: #fecdd3; }
        .inv-page .inv-avatar.av-4 { color: #0369a1; background: #f0f9ff; border-color: #bae6fd; }

        .inv-page .inv-who a.edit-vendor {
            display: block;
            max-width: 100%;
            text-decoration: none;
        }

        .inv-page .inv-who a.edit-vendor .text-truncate-custom {
            max-width: 100%;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            transition: color .15s;
        }

        .inv-page .inv-who a.edit-vendor:hover .text-truncate-custom {
            color: var(--i1);
        }

        .inv-page .inv-sub {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
            min-width: 0;
            font-size: 12.5px;
            color: var(--mut);
        }

        .inv-page .inv-sub i {
            flex: none;
            font-size: 11px;
            color: var(--faint);
        }

        .inv-page .inv-sub .text-truncate-custom {
            max-width: 100%;
        }

        .inv-page .inv-line {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .inv-page .inv-line i {
            flex: none;
            width: 14px;
            text-align: center;
            font-size: 11.5px;
            color: var(--faint);
        }

        .inv-page .inv-line .text-truncate-custom {
            max-width: 100%;
        }

        .inv-page .inv-line.is-muted {
            color: var(--mut);
        }

        .inv-page .na {
            color: var(--faint);
            font-weight: 500;
        }

        .text-truncate-custom {
            display: block;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .inv-page .inv-empty h4 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: var(--ink);
        }

        .inv-page .inv-empty p {
            margin: 0 0 14px;
            max-width: 360px;
            font-size: 13.5px;
            color: var(--mut);
        }

        /* ---------- pagination ---------- */
        .inv-page .inv-pager {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }

        .inv-page .inv-pager p {
            margin: 0;
            font-size: 13px;
            font-weight: 500;
            color: var(--mut);
        }

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

        .inv-page .inv-pager .page-link:hover {
            border-color: #c7d2fe;
            background: #eef2ff;
            color: var(--i1) !important;
        }

        .inv-page .inv-pager .page-item.active .page-link {
            border-color: transparent;
            background: linear-gradient(135deg, var(--i1), #6366f1);
            color: #fff !important;
            box-shadow: 0 10px 18px -10px rgba(79, 70, 229, .75);
        }

        .inv-page .inv-pager .page-item.disabled .page-link {
            background: var(--soft);
            color: #cbd5e1 !important;
        }

        @media (min-width: 768px) {
            .inv-page .inv-pager {
                flex-direction: row;
                justify-content: space-between;
            }
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
                grid-template-columns: 44px minmax(0, 2.2fr) minmax(0, .9fr) minmax(0, 2fr) minmax(0, 1.05fr) auto;
                grid-template-areas: "check main status contact date actions";
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

            .inv-page .inv-hcell.inv-hcheck { padding: 0; grid-area: check; }
            .inv-page .inv-hcell.inv-hactions { display: inline-flex; justify-content: flex-end; min-width: 84px; grid-area: actions; }
            .inv-page .inv-selall { display: none; }
            .inv-page .inv-hcell.h-status { grid-area: status; }
            .inv-page .inv-hcell.h-date { grid-area: date; }

            .inv-page .inv-hgroup {
                display: flex;
                align-items: center;
                gap: 18px;
                min-width: 0;
            }

            .inv-page .inv-hgroup.h-main { grid-area: main; }
            .inv-page .inv-hgroup.h-contact { grid-area: contact; }

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

            .inv-page .inv-row:last-child {
                border-bottom: 0;
                border-radius: 0 0 20px 20px;
            }

            .inv-page .inv-row:hover {
                background: #fafbff;
                border-color: #eef0f7;
                box-shadow: none;
            }

            .inv-page .inv-row:has(.selected:checked) {
                background: #f5f6ff;
                box-shadow: inset 3px 0 0 var(--i1);
            }

            .inv-page .inv-check { padding: 0; }
            .inv-page .inv-label { display: none; }
            .inv-page .inv-status { flex-direction: column; align-items: flex-start; gap: 5px; }
            .inv-page .inv-date { text-align: left; }
            .inv-page .inv-actions { min-width: 84px; }
        }
    </style>

    <x-page-heading
        title="Manage Vendor"
        description=""
        :breadcrumbs="[
        ['label' => 'Vendor', 'url' => route('vendor.list')]
    ]" />

    @include('pages/vendor.filter')

    @php
    $statusClass = [
        'active' => 's-active',
        'deactive' => 's-deactive',
    ];

    $hasVendors = !empty($data['vendors']) && count($data['vendors']) > 0;
    @endphp

    <div class="inv-page">

        <!-- Toolbar -->
        <div class="inv-toolbar">
            <div class="inv-count">
                <h3>All vendors</h3>
                @if (!empty($data['totalRecords']))
                <span>{{ number_format($data['totalRecords']) }} total</span>
                @endif
            </div>

            <div class="inv-toolbar-actions">
                <!-- Delete: sirf tab dikhega jab vendor select ho -->
                <a href="#" id="bulkDeleteBtn" title="Delete Selected Vendors" class="inv-bulk-btn danger" hidden>
                    <i data-lucide="trash-2"></i> Delete <span id="bulkCount"></span>
                </a>

                <x-invoice.saas-button :href="route('vendor.add')" class="new-vendor" id="add-action" icon="plus-circle"> Add New</x-invoice.saas-button>
            </div>
        </div>

        @if ($hasVendors)
        <div class="inv-card">

            <!-- Header (sort chips on mobile, column header on desktop) -->
            <div class="inv-head">
                <div class="inv-hcell inv-hcheck">
                    <input class="form-check-input checkbox-border-color" type="checkbox" value="" id="selectAllVendors">
                    <label for="selectAllVendors" class="inv-selall mb-0"> Select All </label>
                </div>

                <div class="inv-hgroup h-main">
                    <div class="inv-hcell sortable"><i data-lucide="file-text"></i> @sortablelink('vendor_name','Name') </div>
                    <div class="inv-hcell sortable"><i data-lucide="letter-text"></i> @sortablelink('company_name','Company') </div>
                </div>

                <div class="inv-hcell h-status sortable"><i data-lucide="shield-check"></i> @sortablelink('status','Status') </div>

                <div class="inv-hgroup h-contact">
                    <div class="inv-hcell sortable"><i data-lucide="letter-text"></i> @sortablelink('email','Email') </div>
                    <div class="inv-hcell sortable"><i data-lucide="file-digit"></i> @sortablelink('phone','Phone') </div>
                </div>

                <div class="inv-hcell h-date sortable"><i data-lucide="calendar"></i> @sortablelink('created_at','Created At') </div>

                <div class="inv-hcell inv-hactions"><span>Action</span></div>
            </div>

            @foreach ($data['vendors'] as $index => $vendor )

            @php
            $initial = mb_strtoupper(mb_substr(trim((string) (($vendor->vendor_name ?? null) ?: ($vendor->company_name ?? 'V'))), 0, 1)) ?: 'V';
            $avTone = 'av-' . (ord($initial) % 5);
            $stKey = $statusClass[$vendor->status] ?? 's-default';
            try {
                $createdLabel = \Carbon\Carbon::parse($vendor->created_at)->format('d M Y');
            } catch (\Throwable $e) {
                $createdLabel = $vendor->created_at;
            }
            @endphp

            <div class="inv-row">

                <div class="inv-cell inv-check">
                    <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $vendor->vendor_code }}">
                </div>

                <!-- Name + company -->
                <div class="inv-cell inv-main">
                    <div class="inv-who">
                        <span class="inv-avatar {{ $avTone }}">{{ $initial }}</span>
                        <div class="inv-who-text">
                            <a href="#" vendor-code="{{ $vendor->vendor_code }}" class="edit-vendor" title="Vendor Detail">
                                <span class="text-truncate-custom" title="{{ $vendor->vendor_name }}">{{ $vendor->vendor_name ?? 'N/A' }}</span>
                            </a>
                            <div class="inv-sub">
                                <i class="fa-regular fa-building"></i>
                                <span class="text-truncate-custom {{ empty($vendor->company_name) ? 'na' : '' }}" title="{{ $vendor->company_name }}">{{ $vendor->company_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="inv-cell inv-status">
                    <span class="inv-badge {{ $stKey }}">{{ ucfirst($vendor->status) }}</span>
                </div>

                <!-- Email + phone -->
                <div class="inv-cell inv-contact">
                    <div class="inv-line">
                        <i class="fa-regular fa-envelope"></i>
                        <span class="text-truncate-custom {{ empty($vendor->email) ? 'na' : '' }}" title="{{ $vendor->email }}">{{ $vendor->email ?? 'N/A' }}</span>
                    </div>
                    <div class="inv-line is-muted">
                        <i class="fa-solid fa-phone"></i>
                        <span class="text-truncate-custom {{ empty($vendor->phone) ? 'na' : '' }}" title="{{ $vendor->phone }}">{{ $vendor->phone ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Created at -->
                <div class="inv-cell inv-date">
                    <span class="inv-label">Created</span>
                    <span class="inv-datev" title="{{ $vendor->created_at }}"><i class="fa-regular fa-calendar"></i>{{ $createdLabel }}</span>
                </div>

                <!-- Actions -->
                <div class="inv-cell inv-actions">
                    @include('pages/vendor/actions/edit_action')
                </div>

            </div>
            @endforeach

        </div>
        @else
        <div class="inv-empty">
            <div class="inv-empty-ic"><i class="fa-regular fa-building"></i></div>
            <h4>No vendors found</h4>
            <p>Try changing your filters, or add a new vendor to get started.</p>
            <x-invoice.saas-button :href="route('vendor.add')" class="new-vendor" icon="plus-circle"> Add New</x-invoice.saas-button>
        </div>
        @endif

        @if($data['show_pagination'])
        <!-- Pagination Links -->
        <div class="inv-pager">
            {{-- Showing results text --}}
            <p>
                Showing {{ ($data['page'] - 1) * $data['perPage'] + 1 }}
                to {{ min($data['page'] * $data['perPage'], $data['totalRecords']) }}
                of {{ number_format($data['totalRecords']) }} results
            </p>

            {{-- Pagination UI --}}
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    {{-- First & Previous Buttons --}}
                    @if ($data['page'] > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url']}}1" aria-label="First">
                            <i class="bi bi-chevron-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url']}}{{ $data['page'] - 1 }}" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-double-left"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                    @endif

                    {{-- Show "..." before middle pages if needed --}}
                    @if ($data['page'] > 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- Page Number Links (Only 5 around the current page) --}}
                    @for ($i = max(1, $data['page'] - 2); $i <= min($data['totalPages'], $data['page'] + 2); $i++)
                    <li class="page-item {{ $i == $data['page'] ? 'active' : '' }}">
                        <a href="{{ $data['pagination_url']}}{{ $i }}" class="page-link">{{ $i }}</a>
                    </li>
                    @endfor

                    {{-- Show "..." after middle pages if needed --}}
                    @if ($data['page'] < $data['totalPages'] - 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- Next & Last Buttons --}}
                    @if ($data['page'] < $data['totalPages'])
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url']}}{{ $data['page'] + 1 }}" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['pagination_url']}}{{ $data['totalPages'] }}" aria-label="Last">
                            <i class="bi bi-chevron-double-right"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-double-right"></i></span>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif

    </div>



    <!-- Bootstrap 5 Delete Confirm Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected vendor(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Vendor Model -->
    <div class="modal fade" id="vendor-modal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="vendorModalLabel">New Vendor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="vendor-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Vendor Model -->
    <div class="modal fade" id="editvendor-modal" tabindex="-1" aria-labelledby="editvendorModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editvendorModalLabel">Edit Vendor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editvendor-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).on('click', '.edit-vendor', function(e) {
            e.preventDefault();
            $('.vendor-modal-body').empty();
            $('.editvendor-modal-body').empty();

            var vendor_code = $(this).attr('vendor-code');

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('vendor.edit') }}",
                    data: {
                        vendor_code: vendor_code
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Destroy any existing CKEditor instances before loading new HTML
                        for (let id in editors) {
                            if (editors[id]) {
                                editors[id].destroy().catch(() => {});
                                editors[id] = null;
                            }
                        }
                    },
                    success: function(response) {

                        $('.editvendor-modal-body').html(response);
                        $('#editvendor-modal').modal('show');

                        $('#editvendor-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)

                            ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
                                const el = document.querySelector(selector);
                                if (!el) return; // skip if element not found

                                if (!el.choices) {
                                    // Only initialize if not already done
                                    el.choices = new Choices(el, {
                                        searchEnabled: true,
                                        itemSelectText: '',
                                        shouldSort: false
                                    });
                                }
                            });


                            $('#id_notes').summernote({
                                placeholder: 'Enter notes...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['insert', ['link']],
                                    ['view', ['codeview']]
                                ]
                            });

                            $('#id_terms').summernote({
                                placeholder: 'Enter terms...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['insert', ['link']],
                                    ['view', ['codeview']]
                                ]
                            });

                        });

                    }
                });

            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>

    <script>
        $(document).on('click', '.new-vendor', function(e) {
            e.preventDefault();
            $('.vendor-modal-body').empty();
            $('.editvendor-modal-body').empty();
            var vendor_id = 0;

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('vendor.add') }}",
                    data: {
                        vendor_id: vendor_id
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Destroy any existing CKEditor instances before loading new HTML
                        for (let id in editors) {
                            if (editors[id]) {
                                editors[id].destroy().catch(() => {});
                                editors[id] = null;
                            }
                        }
                    },
                    success: function(response) {

                        $('.vendor-modal-body').html(response);
                        $('#vendor-modal').modal('show');

                        $('#vendor-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)
                            ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
                                const el = document.querySelector(selector);
                                if (!el) return; // skip if element not found

                                if (!el.choices) {
                                    // Only initialize if not already done
                                    el.choices = new Choices(el, {
                                        searchEnabled: true,
                                        itemSelectText: '',
                                        shouldSort: false
                                    });
                                }
                            });

                            $('#id_notes').summernote({
                                placeholder: 'Enter notes...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['insert', ['link']],
                                    ['view', ['codeview']]
                                ]
                            });

                            $('#id_terms').summernote({
                                placeholder: 'Enter terms...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['insert', ['link']],
                                    ['view', ['codeview']]
                                ]
                            });

                        });

                    }
                });

            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>

    <script>
        $(document).ready(function() {

            $('.copyButton').on('click', function(e) {
                e.preventDefault();
                copyToClipboard($(this).attr('link'));
            });

            let deleteIds = [];

            // Delete button show/hide + count + select-all state
            function syncBulk() {
                var $rows = $('.inv-row .selected');
                var count = $rows.filter(':checked').length;

                $('#bulkDeleteBtn').prop('hidden', count === 0);
                $('#bulkCount').text(count > 0 ? '(' + count + ')' : '');
                $('#selectAllVendors').prop('checked', $rows.length > 0 && count === $rows.length);
            }

            // Select All
            $('#selectAllVendors').on('change', function() {
                $('.inv-row .selected').prop('checked', this.checked);
                syncBulk();
            });

            // Single row checkbox
            $(document).on('change', '.inv-row .selected', syncBulk);

            syncBulk();

            // Bulk Delete button click
            $('#bulkDeleteBtn').on('click', function(e) {
                e.preventDefault();
                deleteIds = $('.inv-row .selected:checked').map(function() {
                    return $(this).val();
                }).get();

                if (deleteIds.length > 0) {
                    $('#deleteConfirmModal').modal('show');
                }
            });

            // Single Delete from dropdown
            $('.dropdown-menu a.deleteSingleBtn').on('click', function(e) {
                e.preventDefault();
                const vendorId = $(this).data('id');
                deleteIds = [vendorId];
                $('#deleteConfirmModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('vendor.destroy') }}",
                    method: "POST",
                    data: {
                        ids: deleteIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong!',
                        });
                    }
                });
            });

        });
    </script>

</x-default-layout>