<x-default-layout>

    <style>
        /* ==========================================================================
           Invoice listing — premium SaaS look (scoped to .inv-page)
           Mobile-first: card per invoice  ->  table layout from 768px
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
        }

        /* ---------- bulk action bar (toggled by existing JS via d-none) ---------- */
        .inv-page .inv-bulk {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            padding: 10px;
            margin-bottom: 14px;
            border-radius: 16px;
            border: 1px solid #c7d2fe;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
        }

        .inv-page .inv-bulk form { display: none; }

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
        }

        .inv-page .inv-bulk-btn svg,
        .inv-page .inv-bulk-btn i { width: 15px; height: 15px; }

        .inv-page .inv-bulk-btn:hover { border-color: #c7d2fe; color: var(--i1); transform: translateY(-1px); }
        .inv-page .inv-bulk-btn.danger { color: #be123c; }
        .inv-page .inv-bulk-btn.danger:hover { border-color: #fecdd3; background: #fff1f2; color: #be123c; }

        @media (max-width: 575.98px) {
            .inv-page .inv-bulk { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .inv-page .inv-bulk.d-none { display: none; }
            .inv-page .inv-bulk-btn { padding: 0 8px; }
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
        .inv-page .inv-selall { font-size: 12.5px; font-weight: 600; color: var(--text); }
        .inv-page .inv-hcell.inv-hactions { display: none; }

        /* ---------- row = card on mobile ---------- */
        .inv-page .inv-row {
            position: relative;
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            grid-template-areas:
                "check  main   actions"
                ".      status status"
                ".      amount date";
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
        .inv-page .inv-actions { grid-area: actions; display: flex; justify-content: flex-end; }

        .inv-page .inv-label {
            display: block;
            margin-bottom: 3px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--faint);
        }

        /* invoice number + quick icons */
        .inv-page .inv-numline { display: flex; align-items: center; flex-wrap: wrap; gap: 4px 10px; }

        .inv-page .inv-num {
            font-size: 15px;
            font-weight: 700;
            color: var(--i1);
            text-decoration: none;
            word-break: break-word;
        }

        .inv-page .inv-num:hover { color: #4338ca; text-decoration: underline; }

        .inv-page .inv-quick { display: inline-flex; align-items: center; gap: 2px; }

        .inv-page .inv-quick a {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            font-size: 12.5px;
            color: var(--faint);
            text-decoration: none;
            transition: .15s;
        }

        .inv-page .inv-quick a:hover { background: #eef2ff; color: var(--i1); }

        /* client line */
        .inv-page .inv-client {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            margin-top: 4px;
            font-size: 13px;
            color: var(--mut);
        }

        .inv-page .inv-client a.edit-client {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
        }

        .inv-page .inv-client a.edit-client:hover { color: var(--i1); }

        .inv-page .inv-mail { flex: none; font-size: 12px; cursor: help; }
        .inv-page .inv-mail.m-pending { color: #d97706; }
        .inv-page .inv-mail.m-submitted { color: #0284c7; }
        .inv-page .inv-mail.m-sent { color: #059669; }
        .inv-page .inv-mail.m-default { color: var(--faint); }

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
            white-space: nowrap;
        }

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

        .inv-page .inv-datev i { font-size: 12px; color: var(--faint); }
        .inv-page .inv-datev.is-overdue { color: #e11d48; }
        .inv-page .inv-datev.is-overdue i { color: #e11d48; }

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
                grid-template-columns: 44px minmax(0, 2.3fr) minmax(0, 1.15fr) minmax(0, 1.25fr) minmax(0, 1fr) auto;
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
            .inv-page .inv-hcell.inv-hactions { display: inline-flex; justify-content: flex-end; min-width: 84px; }
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
            .inv-page .inv-actions { min-width: 84px; }
        }

        /* ---------- item-category-specific ---------- */
        .inv-page .inv-toolbar-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-left: auto; }
        .inv-page .inv-toolbar-actions .inv-bulk-btn { height: 40px; }

        .inv-page .inv-who { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .inv-page .inv-who-text { display: flex; align-items: center; flex-wrap: wrap; gap: 6px 10px; min-width: 0; }

        .inv-page .inv-avatar {
            flex: none;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 15px;
            color: #4338ca;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
        }

        .inv-page .inv-avatar.is-system { color: #0369a1; background: #f0f9ff; border-color: #bae6fd; }

        /* category name (JS hook .item-category-name stays untouched) */
        .inv-page .item-category-name { display: block; min-width: 0; }

        .inv-page .item-category-name a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 100%;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            transition: color .15s;
        }

        .inv-page .item-category-name a:hover { color: var(--i1); }
        .inv-page .item-category-name a i { flex: none; font-size: 12px; color: #0ea5e9 !important; cursor: help; }

        .inv-page .inv-syspill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2px 9px;
            border-radius: 99px;
            border: 1px solid #bae6fd;
            background: #f0f9ff;
            font-size: 11.5px;
            font-weight: 600;
            color: #0369a1;
            white-space: nowrap;
        }

        .inv-page .inv-syspill i { font-size: 10px; }

        /* mobile: one compact line per category */
        @media (max-width: 767.98px) {
            .inv-page .inv-row {
                grid-template-columns: 28px minmax(0, 1fr) auto;
                grid-template-areas: "check main actions";
                align-items: center;
                padding: 12px 14px;
            }
        }

        /* table columns */
        @media (min-width: 768px) {
            .inv-page .inv-head,
            .inv-page .inv-row {
                grid-template-columns: 44px minmax(0, 1fr) auto;
                grid-template-areas: "check main actions";
            }

            .inv-page .inv-row { min-height: 68px; }
        }
    </style>

    <x-page-heading
        title="Manage Item Category"
        description=""
        :breadcrumbs="[
        ['label' => 'Item Category', 'url' => route('item.category.list')]
      
    ]" />

    @include('pages/item_category.filter')

    @php
    $hasCategories = !empty($data['item_categories']) && count($data['item_categories']) > 0;
    @endphp

    <div class="inv-page">

        <!-- Toolbar -->
        <div class="inv-toolbar">
            <div class="inv-count">
                <h3>All categories</h3>
                @if (!empty($data['totalRecords']))
                <span>{{ number_format($data['totalRecords']) }} total</span>
                @endif
            </div>

            <div class="inv-toolbar-actions">
                <a href="#" id="bulkDeleteBtn" title="Delete Category" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    class="inv-bulk-btn danger">
                    <i data-lucide="trash-2"></i> Delete
                </a>

                <!-- Add Button -->
                <a class="new-item-category btn btn-add-saas"
                    id="add-action" href="#"> <i data-lucide="plus-circle"></i> Add New</a>
            </div>
        </div>

        @if ($hasCategories)
        <div class="inv-card">

            <!-- Header (sort chip on mobile, column header on desktop) -->
            <div class="inv-head">
                <div class="inv-hcell inv-hcheck">
                    <input class="form-check-input item_id checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                    <span class="inv-selall"> Select All </span>
                </div>

                <div class="inv-hcell h-main sortable"><i data-lucide="file-text"></i> @sortablelink('item_category_name','Name') </div>

                <div class="inv-hcell inv-hactions"><span>Action</span></div>
            </div>

            @foreach ($data['item_categories'] as $index => $item_categories )

            @php
            $isSystem = $item_categories->user_id == '1';
            @endphp

            <div class="inv-row">

                <div class="inv-cell inv-check">
                    <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $item_categories->item_category_code }}" id="flexCheckDefault">
                </div>

                <!-- Name -->
                <div class="inv-cell inv-main">
                    <div class="inv-who">
                        <span class="inv-avatar {{ $isSystem ? 'is-system' : '' }}"><i class="fa-solid fa-folder"></i></span>
                        <div class="inv-who-text">
                            <span class="item-category-name" item-category-code="{{  $item_categories->item_category_code }}"> <a href="#"> @if( $item_categories->user_id == '1' )<i title="System Category cannot be edit and delete" class=" text-primary fa-solid fa-desktop"></i>@endif {{ $item_categories->item_category_name  }}</a></span>

                            @if ($isSystem)
                            <span class="inv-syspill"><i class="fa-solid fa-lock"></i> System</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="inv-cell inv-actions">
                    @include('pages/item_category/actions/edit_action')
                </div>

            </div>
            @endforeach

        </div>
        @else
        <div class="inv-empty">
            <div class="inv-empty-ic"><i class="fa-solid fa-folder-open"></i></div>
            <h4>No categories found</h4>
            <p>Try changing your filters, or add a new category to get started.</p>
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
                    Are you sure you want to delete the selected item category(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>


        <!-- Add Category Model -->
    <div class="modal fade" id="itemCategory-modal" tabindex="-1" aria-labelledby="itemCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="itemCategoryModalLabel">Add Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="itemCategory-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    @include('pages/item_category/modal.edit_modal')

    <script>
        $(document).on('click', '.new-item-category', function(e) {
            e.preventDefault();
            $('.itemCategory-modal-body').empty();


            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('item.category.add') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                        $('.itemCategory-modal-body').html(response);
                        $('#itemCategory-modal').modal('show');


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


        });
    </script>



    <script>
        $(document).ready(function() {
            let deleteIds = [];

            // Enable or disable bulk delete button
            function toggleBulkButton() {
                let selected = $('.form-check-input.selected:checked').length;
                $('#bulkDeleteBtn').prop('disabled', selected === 0);
            }

            // Select checkboxes
            $('.form-check-input.selected').on('change', function() {
                toggleBulkButton();
            });

            // Bulk Delete button click
            $('#bulkDeleteBtn').on('click', function() {
                deleteIds = $('.form-check-input.selected:checked').map(function() {
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
                    url: "{{ route('item.category.destroy') }}",
                    method: "POST",
                    data: {
                        ids: deleteIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteConfirmModal').modal('hide');


                        // Disable bulk delete button again
                        toggleBulkButton();

                        Swal.fire({
                            icon: "success",
                            title: 'Deleted!',
                            text: response.message,
                            position: "center",
                            toast: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('item.category.list') }}";
                        });



                    },
                    error: function(xhr) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: xhr.responseJSON.message ?? 'Something went wrong!',
                        });
                    }
                });
            });

        });
    </script>



</x-default-layout>