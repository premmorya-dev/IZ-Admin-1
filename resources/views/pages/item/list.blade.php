<x-default-layout>

    <style>
        /* ==========================================================================
           Item listing — premium SaaS look (scoped to .inv-page)
           Mobile-first: card per item  ->  table layout from 768px
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

        /* ---------- row = card on mobile ---------- */
        .inv-page .inv-row {
            position: relative;
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) minmax(0, 1.3fr) auto;
            grid-template-areas:
                "check main   main   actions"
                ".     type   status stock";
            gap: 14px 14px;
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

        .inv-page .inv-itype {
            grid-area: type;
        }

        .inv-page .inv-istatus {
            grid-area: status;
        }

        .inv-page .inv-stock {
            grid-area: stock;
            text-align: right;
        }

        .inv-page .inv-actions {
            grid-area: actions;
            display: flex;
            justify-content: flex-end;
        }

        .inv-page .inv-label {
            display: block;
            margin-bottom: 4px;
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
        .inv-page .inv-badge.s-instock { color: #047857; background: #ecfdf5; border-color: #a7f3d0; min-width: 44px; justify-content: center; }
        .inv-page .inv-badge.s-outstock { color: #be123c; background: #fff1f2; border-color: #fecdd3; min-width: 44px; justify-content: center; }

        /* name + category */
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
            border: 1px solid transparent;
        }

        .inv-page .inv-avatar.av-product { color: #4338ca; background: #eef2ff; border-color: #c7d2fe; }
        .inv-page .inv-avatar.av-service { color: #0369a1; background: #f0f9ff; border-color: #bae6fd; }
        .inv-page .inv-avatar.av-other { color: #b45309; background: #fffbeb; border-color: #fde68a; }

        /* item name (JS hooks on .item-name / .item-category-name stay untouched) */
        .inv-page .item-name {
            display: block;
            min-width: 0;
        }

        .inv-page .item-name a {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            transition: color .15s;
        }

        .inv-page .item-name a:hover {
            color: var(--i1);
        }

        .inv-page .inv-sub {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
            min-width: 0;
            font-size: 12.5px;
            color: var(--faint);
        }

        .inv-page .inv-sub i {
            flex: none;
            font-size: 11px;
        }

        .inv-page .item-category-name {
            min-width: 0;
        }

        .inv-page .item-category-name a {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 600;
            color: var(--mut);
            text-decoration: none;
        }

        .inv-page .item-category-name a:hover {
            color: var(--i1);
        }

        /* type chip */
        .inv-page .inv-type {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 11px;
            border-radius: 10px;
            border: 1px solid var(--bd);
            background: var(--soft);
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
        }

        .inv-page .inv-type i { font-size: 11px; color: var(--faint); }
        .inv-page .inv-type.t-product { color: #4338ca; background: #eef2ff; border-color: #c7d2fe; }
        .inv-page .inv-type.t-product i { color: #6366f1; }
        .inv-page .inv-type.t-service { color: #0369a1; background: #f0f9ff; border-color: #bae6fd; }
        .inv-page .inv-type.t-service i { color: #0ea5e9; }

        /* mobile: compact type chip so it never touches the status badge */
        @media (max-width: 767.98px) {
            .inv-page .inv-type {
                padding: 4px 9px;
                font-size: 12px;
            }

            .inv-page .inv-type i {
                display: none;
            }
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
                grid-template-columns: 44px minmax(0, 2.8fr) minmax(0, 1fr) minmax(0, 1fr) minmax(0, .9fr) auto;
                grid-template-areas: "check main type status stock actions";
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
            .inv-page .inv-hcell.h-main { grid-area: main; }
            .inv-page .inv-hcell.h-type { grid-area: type; }
            .inv-page .inv-hcell.h-status { grid-area: status; }
            .inv-page .inv-hcell.h-stock { grid-area: stock; }

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
            .inv-page .inv-stock { text-align: left; }
            .inv-page .inv-actions { min-width: 84px; }
        }
    </style>

    <x-page-heading
        title="Manage Items"
        description=""
        :breadcrumbs="[
        ['label' => 'Items', 'url' => route('item.list')]
    ]" />

    @include('pages/item.filter')

    @php
    $statusClass = [
        'Y' => 's-active',
        'N' => 's-deactive',
    ];

    $hasItems = !empty($data['items']) && count($data['items']) > 0;
    @endphp

    <div class="inv-page">

        <!-- Toolbar -->
        <div class="inv-toolbar">
            <div class="inv-count">
                <h3>All items</h3>
                @if (!empty($data['totalRecords']))
                <span>{{ number_format($data['totalRecords']) }} total</span>
                @endif
            </div>

            <div class="inv-toolbar-actions">
                <!-- Delete: sirf tab dikhega jab item select ho -->
                <a href="#" id="bulkDeleteBtn" title="Delete Selected Items" class="inv-bulk-btn danger" hidden>
                    <i data-lucide="trash-2"></i> Delete <span id="bulkCount"></span>
                </a>

                <x-invoice.saas-button class="new-item btn btn-add-saas" id="add-action" icon="plus-circle"> Add New</x-invoice.saas-button>
            </div>
        </div>

        @if ($hasItems)
        <div class="inv-card">

            <!-- Header (sort chips on mobile, column header on desktop) -->
            <div class="inv-head">
                <div class="inv-hcell inv-hcheck">
                    <input class="form-check-input checkbox-border-color" type="checkbox" value="" id="selectAllItems">
                    <label for="selectAllItems" class="inv-selall mb-0"> Select All </label>
                </div>

                <div class="inv-hcell h-main sortable"><i data-lucide="file-text"></i> @sortablelink('item_name','Name') </div>
                <div class="inv-hcell h-type sortable"><i data-lucide="file-text"></i> @sortablelink('item_type','Type') </div>
                <div class="inv-hcell h-status sortable"><i data-lucide="shield-check"></i> @sortablelink('status','Status') </div>
                <div class="inv-hcell h-stock sortable"><i data-lucide="shield-check"></i> @sortablelink('stock','Stock') </div>

                <div class="inv-hcell inv-hactions"><span>Action</span></div>
            </div>

            @foreach ($data['items'] as $index => $item )

            @php
            $typeKey = strtolower((string) ($item->item_type ?? ''));
            $typeClass = in_array($typeKey, ['product', 'service']) ? $typeKey : 'other';
            $typeIcon = match ($typeKey) {
                'product' => 'fa-cube',
                'service' => 'fa-concierge-bell',
                default => 'fa-tag',
            };
            $stockQty = $item->stock ?? 0;
            @endphp

            <div class="inv-row">

                <div class="inv-cell inv-check">
                    <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $item->item_code }}">
                </div>

                <!-- Name + category -->
                <div class="inv-cell inv-main">
                    <div class="inv-who">
                        <span class="inv-avatar av-{{ $typeClass }}"><i class="fa-solid {{ $typeIcon }}"></i></span>
                        <div class="inv-who-text">
                            <span class="item-name" item-code="{{ $item->item_code }}"> <a href="#"> {{ $item->item_name }}</a></span>

                            <div class="inv-sub">
                                <i class="fas fa-folder"></i>
                                @if( !empty( $item->item_category_code ) )
                                <span class="item-category-name" item-category-code="{{ $item->item_category_code }}"> <a href="#">{{ $item->item_category_name ?? 'N/A' }}</a></span>
                                @else
                                <span>N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type -->
                <div class="inv-cell inv-itype">
                    <span class="inv-label">Type</span>
                    <span class="inv-type t-{{ $typeClass }}"><i class="fa-solid {{ $typeIcon }}"></i>{{ ucfirst($item->item_type) }}</span>
                </div>

                <!-- Status -->
                <div class="inv-cell inv-istatus">
                    <span class="inv-label">Status</span>
                    <span class="inv-badge {{ $statusClass[$item->status] ?? 's-default' }}">{{ $item->status == 'Y' ? 'Active' : 'De-Active' }}</span>
                </div>

                <!-- Stock -->
                <div class="inv-cell inv-stock">
                    <span class="inv-label">Stock</span>
                    <span class="inv-badge {{ $stockQty > 0 ? 's-instock' : 's-outstock' }}">{{ $stockQty }}</span>
                </div>

                <!-- Actions -->
                <div class="inv-cell inv-actions">
                    @include('pages/item/actions/edit_action')
                </div>

            </div>
            @endforeach

        </div>
        @else
        <div class="inv-empty">
            <div class="inv-empty-ic"><i class="fa-solid fa-cube"></i></div>
            <h4>No items found</h4>
            <p>Try changing your filters, or add a new item to get started.</p>
            <x-invoice.saas-button class="new-item btn btn-add-saas" icon="plus-circle"> Add New</x-invoice.saas-button>
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
                    Are you sure you want to delete the selected item(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Item Model -->
    <div class="modal fade" id="item-modal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="itemModalLabel">Add Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="item-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- Edit Item Model -->
    <div class="modal fade" id="editItem-modal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editItemModalLabel">Edit Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editItem-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    @include('pages/item_category/modal.edit_modal')

    <script>
        $(document).ready(function() {

            $('.copyButton').on('click', function(e) {
                e.preventDefault();
                copyToClipboard($(this).attr('link'));
            });

        });
    </script>

    <script>
        $(document).on('click', '.edit-item, .item-name', function(e) {
            e.preventDefault();
            $('.editItem-modal-body').empty();

            var item_code = $(this).attr('item-code');

            try {

                $.ajax({
                    url: "{{ route('item.edit') }}",
                    data: {
                        item_code: item_code
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        $('.editItem-modal-body').html(response);

                        $('#editItem-modal').modal('show');
                        $('#editItem-modal').one('shown.bs.modal', function() {
                            $('#id_description').summernote({
                                placeholder: 'Enter Description...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
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
        $(document).on('click', '.new-item', function(e) {
            e.preventDefault();
            $('.item-modal-body').empty();

            try {

                $.ajax({
                    url: "{{ route('item.add') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        $('.item-modal-body').html(response);
                        $('#item-modal').modal('show');

                        $('#item-modal').one('shown.bs.modal', function() {
                            $('#id_description').summernote({
                                placeholder: 'Enter Description...',
                                height: 120,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline']],
                                    ['para', ['ul', 'ol', 'paragraph']],
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
            let deleteIds = [];

            // Delete button show/hide + count + select-all state
            function syncBulk() {
                var $rows = $('.inv-row .selected');
                var count = $rows.filter(':checked').length;

                $('#bulkDeleteBtn').prop('hidden', count === 0);
                $('#bulkCount').text(count > 0 ? '(' + count + ')' : '');
                $('#selectAllItems').prop('checked', $rows.length > 0 && count === $rows.length);
            }

            // Select All
            $('#selectAllItems').on('change', function() {
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
                const itemId = $(this).data('id');
                deleteIds = [itemId];
                $('#deleteConfirmModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('item.destroy') }}",
                    method: "POST",
                    data: {
                        ids: deleteIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: "success",
                            title: 'Deleted!',
                            text: response.message,
                            position: "center",
                            toast: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('item.list') }}";
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