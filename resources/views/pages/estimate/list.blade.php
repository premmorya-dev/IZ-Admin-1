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

        /* ---------- estimate-specific ---------- */
        .inv-page .inv-badge.s-draft { color: #b45309; background: #fffbeb; border-color: #fde68a; }
        .inv-page .inv-badge.s-sent { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .inv-page .inv-badge.s-accepted { color: #1d4ed8; background: #eff6ff; border-color: #bfdbfe; }
        .inv-page .inv-badge.s-rejected { color: #be123c; background: #fff1f2; border-color: #fecdd3; }
        .inv-page .inv-badge.s-expired { color: #475569; background: #f1f5f9; border-color: #e2e8f0; }
        .inv-page .inv-badge.s-converted { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .inv-page .inv-badge.s-converted::before { content: none; }
        .inv-page .inv-badge i { font-size: 10px; }

        /* converted -> invoice link */
        .inv-page .inv-status a.invoice-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 100%;
            padding: 3px 10px;
            border-radius: 99px;
            border: 1px solid var(--bd);
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            transition: .15s;
        }

        .inv-page .inv-status a.invoice-link:hover { border-color: #c7d2fe; background: #eef2ff; color: var(--i1); }
        .inv-page .inv-status a.invoice-link i.text-success { color: #059669 !important; font-size: 11.5px; }
        .inv-page .inv-status a.invoice-link .small { font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* convert to invoice button */
        .inv-page .convert-invoice-btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
            padding: 5px 12px 5px 5px;
            border-radius: 12px;
            border: 1px solid #c7d2fe;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            text-decoration: none;
            transition: .18s;
        }

        .inv-page .convert-invoice-btn:hover {
            border-color: #a5b4fc;
            box-shadow: 0 10px 20px -14px rgba(79, 70, 229, .7);
            transform: translateY(-1px);
        }

        .inv-page .convert-invoice-btn .convert-icon {
            width: 30px;
            height: 30px;
            flex: none;
            display: grid;
            place-items: center;
            border-radius: 9px;
            font-size: 13px;
            color: #fff;
            background: linear-gradient(135deg, var(--i1), #818cf8);
            box-shadow: 0 8px 14px -8px rgba(79, 70, 229, .8);
        }

        .inv-page .convert-invoice-btn .convert-icon i { color: #fff; }

        .inv-page .convert-invoice-btn .convert-text { display: flex; flex-direction: column; line-height: 1.15; }
        .inv-page .convert-invoice-btn .convert-text small { font-size: 10.5px; font-weight: 500; color: var(--mut); }
        .inv-page .convert-invoice-btn .convert-text strong { font-size: 12.5px; font-weight: 700; color: var(--i1); }

        .inv-page .convert-invoice-btn .arrow {
            margin-left: 2px !important;
            font-size: 11px;
            color: var(--i1);
            transition: transform .18s;
        }

        .inv-page .convert-invoice-btn:hover .arrow { transform: translateX(3px); }
    </style>

    <x-page-heading
        title="Manage Estimate"
        description=""
        :breadcrumbs="[
        ['label' => 'Estimate', 'url' => route('estimate.list')]
      
    ]" />

    @include('pages/estimate.filter')

    @php
    $statusClass = [
        'draft' => 's-draft',
        'sent' => 's-sent',
        'accepted' => 's-accepted',
        'rejected' => 's-rejected',
        'expired' => 's-expired',
        'converted' => 's-converted',
    ];

    $mailClass = [
        'pending' => 'm-pending',
        'submitted' => 'm-submitted',
        'sent' => 'm-sent',
    ];

    $sentStatus = [
        'pending' => 'Estimate email not sent to customer',
        'submitted' => 'estimate email notification in queue or in processing',
        'sent' => 'Estimate email sent to customer',
    ];

    $hasEstimates = !empty($data['estimate']) && count($data['estimate']) > 0;
    @endphp

    <div class="inv-page">

        <!-- Toolbar -->
        <div class="inv-toolbar">
            <div class="inv-count">
                <h3>All estimates</h3>
                @if (!empty($data['totalRecords']))
                <span>{{ number_format($data['totalRecords']) }} total</span>
                @endif
            </div>

            <!-- Add Button -->
            <x-invoice.saas-button :href="route('estimate.add')" icon="plus-circle"> Add New</x-invoice.saas-button>
        </div>

        <!-- Bulk Action Section (shown by existing JS when rows are selected) -->
        <div id="bulk-action-section" class="d-none d-flex inv-bulk">
            <a href="#" id="bulk-delete" title="Delete estimate" data-bs-toggle="modal" data-bs-target="#deleteModal"
                class="inv-bulk-btn danger">
                <i data-lucide="trash-2"></i> Delete
            </a>

            <a href="#" id="bulk-estimate-download" title="Download estimate"
                class="inv-bulk-btn">
                <i data-lucide="download"></i> Download
            </a>

            <form id="download-form" method="POST" action="{{ route('estimate.bulk_download') }}">
                @csrf
            </form>

            <a href="#" title="Send Email To Client" data-bs-toggle="modal" data-bs-target="#emailConfirmModal"
                class="inv-bulk-btn">
                <i data-lucide="mail"></i> Email
            </a>
        </div>

        @if ($hasEstimates)
        <div class="inv-card">

            <!-- Header (sort chips on mobile, column header on desktop) -->
            <div class="inv-head">
                <div class="inv-hcell inv-hcheck">
                    <input class="form-check-input estimate_code checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                    <span class="inv-selall"> Select All </span>
                </div>

                <div class="inv-hcell h-main sortable"><i data-lucide="file-text"></i> @sortablelink('estimate_number','Estimate #') </div>
                <div class="inv-hcell h-status sortable"><i data-lucide="check-circle"></i> @sortablelink('status','Status') </div>
                <div class="inv-hcell h-amount sortable"><i data-lucide="dollar-sign"></i> @sortablelink('grand_total','Total') </div>
                <div class="inv-hcell h-date sortable"><i data-lucide="calendar"></i> @sortablelink('issue_date','Issue Date') </div>

                <div class="inv-hcell inv-hactions"><span>Action</span></div>
            </div>

            @foreach ($data['estimate'] as $index => $estimate )

            @php
            $clientLabel = ($estimate->company_name ?? null) ?: ($estimate->client_name ?? '');
            $stKey = $statusClass[$estimate->status] ?? 's-default';
            @endphp

            <div class="inv-row">

                <div class="inv-cell inv-check">
                    <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $estimate->estimate_code }}" id="flexCheckDefault">
                </div>

                <!-- Estimate number + client + convert -->
                <div class="inv-cell inv-main">
                    <div class="inv-numline">
                        <a class="inv-num" href="{{ route('estimate.edit',['estimate_code' => $estimate->estimate_code ]) }}" title="{{ $estimate->estimate_number }}">{{ $estimate->estimate_number }}</a>

                        <span class="inv-quick">
                            <a href="#" estimate-code="{{ $estimate->estimate_code }}" class="estimate-view-model" title="View Estimate"><i class="fa-regular fa-eye"></i></a>
                            <a href="{{ route('estimate.download',['estimate_code' => $estimate->estimate_code ]) }}?preview=true" target="_blank" rel="noopener" title="Print Estimate"><i class="fa-solid fa-print"></i></a>
                            <a href="{{ route('estimate.download',['estimate_code' => $estimate->estimate_code ]) }}" title="Download Estimate"><i class="fa-solid fa-download"></i></a>
                        </span>
                    </div>

                    <div class="inv-client">
                        <span>To:</span>
                        <a href="#" client-code="{{ $estimate->client_code }}" title="{{ $clientLabel }}" class="edit-client">{{ $clientLabel }}</a>
                        <i class="fa-solid fa-envelope inv-mail {{ $mailClass[$estimate->is_sent] ?? 'm-default' }}" title="{{ $sentStatus[$estimate->is_sent] ?? 'Estimate email status unknown' }}"></i>
                    </div>

                    @if($estimate->status != 'converted')
                    <a href="{{ route('estimate.convert_to_invoice',$estimate->estimate_code) }}"
                        class="convert-invoice-btn">
                        <span class="convert-icon">
                            <i class="fa-solid fa-file-invoice"></i>
                        </span>

                        <span class="convert-text">
                            <small>Convert to</small>
                            <strong>Invoice</strong>
                        </span>

                        <i class="fa-solid fa-arrow-right ms-2 arrow"></i>
                    </a>
                    @endif
                </div>

                <!-- Status -->
                <div class="inv-cell inv-status">
                    <span class="inv-badge {{ $stKey }}">
                        @if($estimate->status == 'converted')
                        <i class="fa-solid fa-check"></i>
                        @endif
                        {{ ucfirst($estimate->status) }}
                    </span>

                    @if($estimate->status == 'converted' && !empty($estimate->invoice_number) )
                    <a href="{{ route('invoice.edit',['invoice_code'=> $estimate->invoice_code]) }}"
                        class="invoice-link" title="Open invoice {{ $estimate->invoice_number }}">
                        <i class="fa-solid fa-file-invoice text-success"></i>
                        <span class="small">{{ $estimate->invoice_number }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square small opacity-50"></i>
                    </a>
                    @endif
                </div>

                <!-- Total -->
                <div class="inv-cell inv-amount">
                    <span class="inv-label">Total</span>
                    <span class="inv-total">{{ $estimate->symbol }} {{ number_format($estimate->grand_total, 2) }}</span>
                </div>

                <!-- Issue date -->
                <div class="inv-cell inv-date">
                    <span class="inv-label">Issue date</span>
                    <span class="inv-datev"><i class="fa-regular fa-calendar"></i>{{ $estimate->issue_date }}</span>
                </div>

                <!-- Actions -->
                <div class="inv-cell inv-actions">
                    @include('pages/estimate/actions/edit_action')
                </div>

            </div>
            @endforeach

        </div>
        @else
        <div class="inv-empty">
            <div class="inv-empty-ic"><i class="fa-regular fa-file-lines"></i></div>
            <h4>No estimates found</h4>
            <p>Try changing your filters, or create a new estimate to get started.</p>
            <x-invoice.saas-button :href="route('estimate.add')" icon="plus-circle"> Add New</x-invoice.saas-button>
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



    <!-- Bulk Modal -->
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
                <div class="bulk-modal-body py-5 px-5">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Single Delete Confirmation Modal -->
    <div class="modal fade" id="singleDeleteModal" tabindex="-1" aria-labelledby="singleDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="singleDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the estimates?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" estimate-code="" class="btn btn-danger" id="confirmed-single-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi Delete Confirmation Modal -->
    <div class="modal fade" id="multiDeleteModal" tabindex="-1" aria-labelledby="multiDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="multiDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the all selected estimates?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" estimate-code="" class="btn btn-danger" id="confirmed-multi-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Email Confirmation Modal -->
    <div class="modal fade" id="emailConfirmModal" tabindex="-1" aria-labelledby="emailConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title">Send Estimate Emails</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to send selected estimates to clients via email?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-email">
                        <i class="fa-solid fa-paper-plane text-white"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="singleEmailConfirmModal" tabindex="-1" aria-labelledby="singleEmailConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title">Send Estimate Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to send this estimates to clients via email?
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="single-estimate-email-estimate-code" id="single-estimate-email-estimate-code" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="single-send-estimate">
                        <i class="fa-solid fa-paper-plane text-white"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-3 mb-3">
                    <h5 class="modal-title" id="viewModalLabel">
                        View estimate
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body" class="px-5 mb-5">

                </div>
            </div>
        </div>
    </div>


    <!-- Edit Client Model -->
    <div class="modal fade" id="editClient-modal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editClientModalLabel">Edit Client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editClient-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.edit-client', function(e) {
            e.preventDefault();
            $('.client-modal-body').empty();
            $('.editClient-modal-body').empty();

            var client_code = $(this).attr('client-code');

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('client.edit') }}",
                    data: {
                        client_code: client_code
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

                        $('.editClient-modal-body').html(response);
                        $('#editClient-modal').modal('show');

                        $('#editClient-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)

                            ['#id_country_id', '#id_state_id', '#id_currency_code', '#id_shipping_state_id', '#id_shipping_country_id'].forEach(function(selector) {
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

            $(document).on('change', '.selected, .estimate_code', function() {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    document.getElementById('bulk-action-section')?.classList.remove('d-none');


                } else {

                    console.log("Checkbox unchecked: ");
                    var q_id = [];
                    $(".selected:checked").each(function() {
                        q_id.push($(this).val());
                    });
                    if (q_id === undefined || q_id === null || q_id === '' || q_id.length == 0) {
                        document.getElementById('bulk-action-section')?.classList.add('d-none');
                    }
                }
            });


            var estimates_code = [];
            $('#bulk-delete').on('click', function(e) {
                estimates_code = [];
                e.preventDefault();
                $('.selected:checked').each(function() {
                    estimates_code.push(this.value);
                });
                $('#multiDeleteModal').modal('show');

            });

            $('#confirmed-multi-delete').on('click', function(e) {
                $('#multiDeleteModal').modal('hide');
                try {
                    $.ajax({
                        url: "{{ route('estimate.bulk_delete') }}",
                        data: {
                            estimates_code: estimates_code
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
                        }

                    });
                } catch (error) {
                    console.error('Error:', error);
                }
            });




            $(document).on('click', '.estimate-view-model', function(e) {
                e.preventDefault();

                var estimate_code = $(this).attr('estimate-code');

                // Show SweetAlert loader
                Swal.fire({
                    title: 'Loading Estimate...',
                    text: 'Please wait while we fetch estimate details.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('estimate.view.model') }}",
                    type: 'POST',
                    data: {
                        estimate_code: estimate_code
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        $('#view-record-form-body').html(response.html);

                        // Close loader
                        Swal.close();

                        // Open modal after successful response
                        $('#viewModal').modal('show');
                    },

                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Unable to load estimate details. Please try again.',
                            confirmButtonText: 'OK'
                        });

                        console.error('Error loading estimate:', xhr.responseText);
                    }
                });
            });

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

            $('#bulk-estimate-download').on('click', function(e) {
                e.preventDefault();
                let selectedestimates = $(".selected:checked");
                let form = $('#download-form');

                form.find('input[name="estimates_code[]"]').remove(); // clear old values

                if (selectedestimates.length === 0) {
                    alert("Please select at least one estimate.");
                    return;
                }

                selectedestimates.each(function() {
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'estimates_code[]')
                        .val($(this).val())
                        .appendTo(form);
                });

                form.submit(); // Normal form POST → Laravel returns ZIP → Browser prompts download
            });


            function sendEstimateEmail(estimateCode) {
                $.ajax({
                    url: "{{ route('estimate.send_bulk_email') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        estimates_code: estimateCode
                    },
                    success: function(response) {
                        if (response.error === 0) {
                            $('#emailConfirmModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || "An error occurred. Please try again.");
                        }
                    },
                    error: function(xhr) {
                        alert("An error occurred. Please try again.");
                    }
                });
            }


            $('.single-send-estimate-model').click(function() {
                $("#single-estimate-email-estimate-code").val($(this).attr('estimate-code'))
                $('#singleEmailConfirmModal').modal('show');
            });

            $('#single-send-estimate').click(function() {
                $('#singleEmailConfirmModal').modal('hide');
                let estimateCode = $("#single-estimate-email-estimate-code").val() ? [$("#single-estimate-email-estimate-code").val()] : [];
                sendEstimateEmail(estimateCode);
            });



            $('#confirm-send-email').click(function() {
                let selected = [];
                $('input[name="selected[]"]:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    alert("Please select at least one estimate.");
                    return;
                }

                $.ajax({
                    url: "{{ route('estimate.send_bulk_email') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        estimates_code: selected
                    },
                    success: function(response) {
                        $('#emailConfirmModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });



            /*    bulk action end  */


        });
    </script>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $('#confirmed-delete').on('click', function() {
            let selected = $('.form-check-input.selected:checked').map(function() {
                return this.value;
            }).get();

            if (selected.length === 0) {
                alert("Please select at least one estimate.");
                return;
            }

            $.ajax({
                url: "{{ route('estimate.bulk_delete') }}",
                method: 'POST',
                data: {
                    estimate_codes: selected,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete estimates.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting estimates.");
                }
            });
        });

        $('#confirmed-single-delete').on('click', function(e) {
            e.preventDefault();
            var estimate_code = $(this).attr('estimate-code');
            $.ajax({
                url: "{{ route('estimate.destroy') }}",
                method: 'POST',
                data: {
                    estimate_code: estimate_code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete estimates.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting estimates.");
                }
            });
        });
    </script>



</x-default-layout>