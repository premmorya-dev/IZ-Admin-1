<x-default-layout>

    @if( !empty($data['registration']) && $data['registration'] == 'success')
    <script>
        gtag('event', 'user_registered_create_invoice_page');
    </script>

    @endif
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <style>
        /* ==========================================================================
           Invoice add — premium SaaS look (scoped to .ie-page)
           Same design language as the invoice edit page + invoice listing
           Desktop: form (left) + sticky summary (right)  |  Mobile: single column
           ========================================================================== */
        .ie-page {
            --i1: #4f46e5;
            --i2: #7c3aed;
            --ink: #0f172a;
            --text: #334155;
            --mut: #64748b;
            --faint: #94a3b8;
            --bd: #e8ebf3;
            --soft: #f8fafc;
            margin-top: 4px;
        }

        /* ---------- layout ---------- */
        .ie-page .ie-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            grid-template-areas: "bill" "opts" "items" "sum" "notes";
            gap: 16px;
            align-items: start;
        }

        .ie-page .ie-area-bill { grid-area: bill; }
        .ie-page .ie-area-opts { grid-area: opts; }
        .ie-page .ie-area-items { grid-area: items; }
        .ie-page .ie-area-notes { grid-area: notes; }
        .ie-page .ie-area-sum { grid-area: sum; }

        @media (min-width: 1200px) {
            .ie-page .ie-grid {
                grid-template-columns: minmax(0, 1fr) 356px;
                grid-template-areas:
                    "bill  sum"
                    "opts  sum"
                    "items sum"
                    "notes sum";
            }

            .ie-page .ie-area-sum {
                position: sticky;
                top: 96px;
            }
        }

        /* ---------- card ---------- */
        .ie-page .ie-card {
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 18px;
            box-shadow: 0 10px 28px -22px rgba(15, 23, 42, .28);
        }

        .ie-page .ie-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid #eef0f7;
        }

        .ie-page .ie-card-ic {
            flex: none;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            color: var(--i1);
            background: #eef2ff;
        }

        .ie-page .ie-card-ic svg,
        .ie-page .ie-card-ic i { width: 17px; height: 17px; }

        .ie-page .ie-card-title { min-width: 0; flex: 1; }
        .ie-page .ie-card-title h3 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--ink);
        }
        .ie-page .ie-card-title p { margin: 1px 0 0; font-size: 12.5px; color: var(--mut); }
        .ie-page .ie-req { color: #e11d48; margin-left: 2px; }

        .ie-page .ie-card-body { padding: 18px; }

        @media (max-width: 575.98px) {
            .ie-page .ie-card-head { padding: 12px 14px; flex-wrap: wrap; }
            .ie-page .ie-card-body { padding: 14px; }
        }

        /* ---------- form controls (also restyles the shared x-invoice components inside the page) ---------- */
        .ie-page .form-label,
        .ie-page .ie-lbl {
            display: block;
            margin-bottom: 6px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        .ie-page .ie-lbl { font-size: 11.5px; color: var(--faint); margin-bottom: 5px; }

        .ie-page .form-control,
        .ie-page .form-select {
            min-height: 40px;
            padding: 8px 12px;
            border: 1px solid var(--bd);
            border-radius: 10px;
            background-color: #fff;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink);
            box-shadow: none;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }

        .ie-page .form-select { padding-right: 34px; }
        .ie-page textarea.form-control { min-height: 0; }
        .ie-page .form-control::placeholder { color: var(--faint); font-weight: 400; }

        .ie-page .form-control:focus,
        .ie-page .form-select:focus {
            border-color: var(--i1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14);
        }

        .ie-page .input-group > .form-select:not(:last-child) { border-top-right-radius: 0; border-bottom-right-radius: 0; }
        .ie-page .input-group > .input-group-text {
            min-height: 40px;
            padding: 0 12px;
            border: 1px solid var(--bd);
            border-left: 0;
            border-radius: 0 10px 10px 0;
            background: var(--soft);
            font-size: 12px;
            font-weight: 600;
            color: var(--mut);
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .ie-page .form-check-input:checked {
            background-color: var(--i1);
            border-color: var(--i1);
        }

        .ie-page .form-check-input:focus { box-shadow: 0 0 0 4px rgba(99, 102, 241, .18); border-color: var(--i1); }

        /* select2 / flatpickr */
        .ie-page .select2-container { width: 100% !important; }
        .ie-page .select2-container--default .select2-selection--single {
            height: 40px;
            border: 1px solid var(--bd);
            border-radius: 10px;
        }
        .ie-page .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px; padding-left: 12px; font-size: 13.5px; color: var(--ink); }
        .ie-page .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; }
        .ie-page .select2-container--default.select2-container--focus .select2-selection--single { border-color: var(--i1); }

        /* summernote */
        .ie-page .note-editor.note-frame {
            border: 1px solid var(--bd);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: none;
        }
        .ie-page .note-editor .note-toolbar { background: var(--soft); border-bottom: 1px solid var(--bd); padding: 4px 6px; }
        .ie-page .note-editor .note-editing-area .note-editable { font-size: 13.5px; color: var(--ink); }
        .ie-page .note-editor.note-frame.focused,
        .ie-page .note-editor.note-frame:focus-within { border-color: var(--i1); box-shadow: 0 0 0 4px rgba(99, 102, 241, .12); }

        /* ---------- item cards ---------- */
        .ie-page .ie-items { display: flex; flex-direction: column; gap: 12px; }
        .ie-page .ie-items { counter-reset: itm; }

        /* empty state (no items added yet) */
        .ie-page .ie-items:empty { display: grid; }
        .ie-page .ie-items:empty::before {
            content: "No items yet \2014  click \201CAdd Item\201D below to start";
            display: grid;
            place-items: center;
            min-height: 84px;
            padding: 16px;
            border: 1.5px dashed #d6dcf5;
            border-radius: 16px;
            background: var(--soft);
            font-size: 13px;
            font-weight: 500;
            color: var(--mut);
            text-align: center;
        }

        .ie-page .ie-item {
            position: relative;
            z-index: 0;
            container-type: inline-size;
            counter-increment: itm;
            padding: 12px 14px 14px;
            background: var(--soft);
            border: 1px solid var(--bd);
            border-radius: 16px;
            transition: border-color .18s, background .18s, box-shadow .18s;
        }

        .ie-page .ie-item:hover { border-color: #d6dcf5; background: #fbfbff; }
        .ie-page .ie-item:focus-within { z-index: 20; border-color: #c7d2fe; background: #fff; box-shadow: 0 14px 32px -22px rgba(79, 70, 229, .35); }

        .ie-page .ie-item-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .ie-page .ie-item-no {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text);
        }

        .ie-page .ie-item-no::before {
            content: counter(itm);
            display: grid;
            place-items: center;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 7px;
            font-size: 11.5px;
            color: var(--i1);
            background: #eef2ff;
        }

        .ie-page .ie-item-tools { display: inline-flex; align-items: center; gap: 6px; }

        .ie-page .ie-desc-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 30px;
            padding: 0 11px;
            border: 1px solid var(--bd);
            border-radius: 9px;
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            color: var(--mut);
            transition: .16s;
        }

        .ie-page .ie-desc-toggle svg,
        .ie-page .ie-desc-toggle i { width: 13px; height: 13px; }
        .ie-page .ie-desc-toggle:hover,
        .ie-page .ie-desc-toggle.is-open { border-color: #c7d2fe; background: #eef2ff; color: var(--i1); }

        .ie-page .ie-item .remove-item-btn {
            position: static !important;
            inset: auto !important;
            transform: none !important;
            display: inline-grid;
            place-items: center;
            width: 30px;
            height: 30px;
            padding: 0;
            border: 1px solid var(--bd);
            border-radius: 9px;
            background: #fff;
            color: var(--faint);
            transition: .16s;
        }

        .ie-page .ie-item .remove-item-btn svg,
        .ie-page .ie-item .remove-item-btn i { width: 14px; height: 14px; }
        .ie-page .ie-item .remove-item-btn:hover { border-color: #fecdd3; background: #fff1f2; color: #be123c; }

        .ie-page .ie-item-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .ie-page .f-name { grid-column: 1 / -1; position: relative; }
        .ie-page .f-hsn,
        .ie-page .f-qty,
        .ie-page .f-rate { grid-column: span 2; }
        .ie-page .f-disc,
        .ie-page .f-tax,
        .ie-page .f-amt { grid-column: 1 / -1; }

        @container (min-width: 520px) {
            .ie-page .ie-item-grid { grid-template-columns: repeat(12, minmax(0, 1fr)); }
            .ie-page .f-name { grid-column: span 5; }
            .ie-page .f-hsn { grid-column: span 2; }
            .ie-page .f-qty { grid-column: span 2; }
            .ie-page .f-rate { grid-column: span 3; }
            .ie-page .f-disc { grid-column: span 5; }
            .ie-page .f-tax { grid-column: span 4; }
            .ie-page .f-amt { grid-column: span 3; }
        }

        .ie-page .ie-item .amount {
            font-weight: 700;
            color: var(--ink);
            background: #fff;
            font-variant-numeric: tabular-nums;
        }

        .ie-page .ie-item-desc { display: none; margin-top: 10px; }
        .ie-page .ie-item-desc.is-open { display: block; }

        /* inventory suggestions */
        .ie-page .ie-suggest {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            z-index: 40;
            max-height: 260px;
            overflow-y: auto;
            border: 1px solid var(--bd);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 18px 38px -16px rgba(15, 23, 42, .3);
        }

        .ie-page .ie-suggest:empty { display: none !important; }

        .ie-page .ie-suggest .list-group-item {
            padding: 10px 14px;
            border: 0;
            border-bottom: 1px solid #eef0f7;
            font-size: 13px;
            color: var(--text);
            cursor: pointer;
        }

        .ie-page .ie-suggest .list-group-item:last-child { border-bottom: 0; }
        .ie-page .ie-suggest .list-group-item:hover { background: #f5f6ff; color: var(--i1); }

        /* add item button wrapper */
        .ie-page .ie-add { margin-top: 12px; }

        /* ---------- notes / terms tabs ---------- */
        .ie-page .ie-tabs {
            display: inline-flex;
            gap: 4px;
            padding: 4px;
            border: 1px solid var(--bd);
            border-radius: 12px;
            background: var(--soft);
        }

        .ie-page .ie-tab {
            padding: 6px 14px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--mut);
            transition: .15s;
        }

        .ie-page .ie-tab:hover { color: var(--i1); }
        .ie-page .ie-tab.is-active { background: #fff; color: var(--i1); box-shadow: 0 1px 3px rgba(15, 23, 42, .12); }
        .ie-page .ie-pane { display: none; }
        .ie-page .ie-pane.is-active { display: block; }

        /* ---------- summary ---------- */
        .ie-page .ie-sum-body { padding: 8px 18px 4px; }

        .ie-page .ie-sum-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px dashed var(--bd);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--mut);
        }

        .ie-page .ie-sum-row:last-child { border-bottom: 0; }
        .ie-page .ie-sum-row strong {
            font-weight: 600;
            color: var(--ink);
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .ie-page .ie-sum-due {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 10px 12px 12px;
            padding: 16px 18px;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 18px 30px -16px rgba(5, 150, 105, .7);
        }

        .ie-page .ie-sum-due span { font-size: 13px; font-weight: 600; color: rgba(255, 255, 255, .82); }
        .ie-page .ie-sum-due small { display: block; margin-top: 2px; font-size: 11.5px; font-weight: 500; color: rgba(255, 255, 255, .78); }
        .ie-page .ie-sum-due strong {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -.02em;
            font-variant-numeric: tabular-nums;
            word-break: break-all;
            text-align: right;
        }

        /* ---------- item colours: discount = red, tax = blue, amount = green ---------- */
        .ie-page .ie-item .amount {
            color: #047857;
            background: #ecfdf5;
            border-color: #a7f3d0;
            font-weight: 700;
        }

        .ie-page .ie-item .input-group-text.discount-amount { color: #e11d48; background: #fff1f2; }
        .ie-page .ie-item .input-group-text.tax-amount { color: #0369a1; background: #f0f9ff; }

        /* ---------- detailed summary ---------- */
        .ie-page .ie-sum-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin: 12px 0 4px;
        }

        .ie-page .ie-sum-meta div {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid var(--bd);
            border-radius: 12px;
            background: var(--soft);
            font-size: 12px;
            font-weight: 600;
            color: var(--mut);
        }

        .ie-page .ie-sum-meta strong { font-size: 14px; font-weight: 700; color: var(--ink); }

        .ie-page .ie-sum-lbl { display: flex; align-items: center; gap: 10px; min-width: 0; }
        .ie-page .ie-sum-lbl b { display: block; font-size: 13.5px; font-weight: 600; color: var(--text); }
        .ie-page .ie-sum-lbl small { display: block; margin-top: 1px; font-size: 11.5px; font-weight: 500; line-height: 1.35; color: var(--faint); }

        .ie-page .ie-op {
            flex: none;
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--mut);
            background: #f1f5f9;
        }

        /* sub rows (CGST / SGST / IGST) */
        .ie-page .ie-sum-row.is-child { padding: 8px 0 8px 34px; }
        .ie-page .ie-sum-row.is-child .ie-sum-lbl b { font-size: 12.5px; font-weight: 600; }

        /* colours */
        .ie-page .ie-sum-row.s-discount .ie-op { color: #e11d48; background: #fff1f2; }
        .ie-page .ie-sum-row.s-discount strong { color: #e11d48; }

        .ie-page .ie-sum-row.s-taxable .ie-op { color: var(--i1); background: #eef2ff; }
        .ie-page .ie-sum-row.s-taxable strong { color: var(--i1); }

        .ie-page .ie-sum-row.s-tax .ie-op { color: #0369a1; background: #e0f2fe; }
        .ie-page .ie-sum-row.s-tax strong { color: #0284c7; }

        .ie-page .ie-sum-row.s-grand { border-top: 1px solid var(--bd); border-bottom: 1px dashed var(--bd); }
        .ie-page .ie-sum-row.s-grand .ie-op { color: #047857; background: #ecfdf5; }
        .ie-page .ie-sum-row.s-grand .ie-sum-lbl b { font-weight: 700; color: var(--ink); }
        .ie-page .ie-sum-row.s-grand strong { font-size: 16px; font-weight: 700; color: #059669; }

        /* round off: green when added, red when subtracted */
        .ie-page .ie-sum-row.s-round.is-plus .ie-op { color: #047857; background: #ecfdf5; }
        .ie-page .ie-sum-row.s-round.is-plus strong { color: #059669; }
        .ie-page .ie-sum-row.s-round.is-minus .ie-op { color: #e11d48; background: #fff1f2; }
        .ie-page .ie-sum-row.s-round.is-minus strong { color: #e11d48; }

        /* amount in words */
        .ie-page .ie-sum-words {
            margin: 0 12px 12px;
            padding: 10px 14px;
            border: 1px dashed #a7f3d0;
            border-radius: 12px;
            background: #ecfdf5;
        }

        .ie-page .ie-sum-words span { display: block; font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; color: #059669; }
        .ie-page .ie-sum-words b { display: block; margin-top: 2px; font-size: 13px; font-weight: 600; line-height: 1.45; color: #065f46; }

        /* modals */
        .modal.fade .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .modal-header.bg-primary { background: linear-gradient(135deg, #4f46e5, #7c3aed) !important; }

        @media (prefers-reduced-motion: reduce) {
            .ie-page * { transition: none !important; }
        }
    </style>

    <x-page-heading
        title="Add Invoice"
        description=""
        :breadcrumbs="[
        ['label' => 'Invoices', 'url' => route('invoice.list')],
        ['label' => 'Add Invoice']
    ]" />

    <form action="#" id="invoice-generate" method="POST">
        @csrf


        <div class="page-header-fixed iz-actionbar mb-3">

            <a href="{{ route('invoice.list') }}" class="iz-bar-back" title="Back to invoices">
                <i data-lucide="arrow-left"></i> <span>Back</span>
            </a>

            <div class="iz-bar-right">

                <div class="iz-bar-primary">
                    @include('pages/invoice/actions.create_invoice_action')
                </div>

            </div>
        </div>


        <div class="ie-page">
            <div class="ie-grid">

                <!-- 1. Client & addresses -->
                <section class="ie-card ie-area-bill">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="users"></i></span>
                        <div class="ie-card-title">
                            <h3>Client &amp; Addresses</h3>
                            <p>Who you are billing and where it is from</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="row">
                            <x-invoice.header :data="$data" />

                            <!-- From Address Section -->
                            <x-invoice.address-section :setting="$data['setting']" />
                        </div>
                    </div>
                </section>

                <!-- 2. Schedule & options -->
                <section class="ie-card ie-area-opts">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="calendar"></i></span>
                        <div class="ie-card-title">
                            <h3>Schedule &amp; Options</h3>
                            <p>Dates, payment options and recurring settings</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="row g-3">

                            <div class="col-lg-6 col-md-6">
                                <x-date
                                    id="invoice_date"
                                    name="invoice_date"
                                    label="Invoice Date"
                                    icon="calendar-event"
                                    placeholder="Select invoice issue date"
                                    required />
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <x-date
                                    id="due_date"
                                    name="due_date"
                                    label="Due Date"
                                    icon="calendar-check"
                                    placeholder="Select invoice due date"
                                    required />
                            </div>

                        </div>

                        <div class="row mt-1">
                            <x-invoice.setting-switch />
                            <x-invoice.recurring-invoice />
                        </div>

                        <!-- UPI Dropdown (Hidden by default) -->
                        <div id="upiDropdownWrapper" class="mt-3" style="display: none;">
                            <label for="upi_id" class="form-label">Select UPI</label>
                            <select id="upi_id" name="upi_id" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['upi_payment_id'] as $upi_payment)
                                <option value="{{ $upi_payment->upi_id }}" {{ old('upi_id', setting('default_upi_id') ) == $upi_payment->upi_log_id ? 'selected' : '' }}>
                                    Name: {{ $upi_payment->upi_name }} | Id: {{ $upi_payment->upi_id }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <!-- 3. Items -->
                <section class="ie-card ie-area-items">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="package"></i></span>
                        <div class="ie-card-title">
                            <h3>Items <span class="ie-req">*</span></h3>
                            <p>Pick from inventory or type manually</p>
                        </div>
                    </div>
                    <div class="ie-card-body">

                        <div id="form-container" class="ie-items"></div>

                        <div class="ie-add">
                            <x-invoice.add-item-button
                                id="add-item-btn"
                                text="Add Item"
                                onclick="addItemRow()" />
                        </div>

                        <input type="hidden" name="hidden_sub_total" value="" id="hidden_sub_total">
                        <input type="hidden" name="hidden_total_discount" value="" id="hidden_total_discount">

                        <input type="hidden" name="hidden_total_taxable" value="" id="hidden_total_taxable">
                        <input type="hidden" name="hidden_total_cgst" value="" id="hidden_total_cgst">
                        <input type="hidden" name="hidden_total_sgst" value="" id="hidden_total_sgst">
                        <input type="hidden" name="hidden_total_igst" value="" id="hidden_total_igst">

                        <input type="hidden" name="hidden_total_tax" value="" id="hidden_total_tax">
                        <input type="hidden" name="hidden_grand_total" value="" id="hidden_grand_total">
                        <input type="hidden" name="hidden_round_off" value="" id="hidden_round_off">
                        <input type="hidden" name="hidden_total_due" value="" id="hidden_total_due">
                    </div>
                </section>

                <!-- 4. Notes & terms (tabs = less scrolling) -->
                <section class="ie-card ie-area-notes">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="file-text"></i></span>
                        <div class="ie-card-title">
                            <h3>Notes &amp; Terms</h3>
                            <p>Shown on the invoice</p>
                        </div>
                        <div class="ie-tabs" role="tablist">
                            <button type="button" class="ie-tab is-active" data-target="#notes-section" role="tab" aria-selected="true">Notes</button>
                            <button type="button" class="ie-tab" data-target="#terms-section" role="tab" aria-selected="false">Terms</button>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="ie-pane is-active bg-blue" id="notes-section">
                            <label for="id_invoice_notes" class="form-label visually-hidden">Notes:</label>
                            <textarea name="notes" id="id_invoice_notes" class="form-control" placeholder="Enter Notes">{{ old('notes', setting('notes') ) }}</textarea>
                        </div>

                        <div class="ie-pane bg-blue" id="terms-section">
                            <label for="id_invoice_terms" class="form-label visually-hidden">Terms and Conditions:</label>
                            <textarea name="terms" id="id_invoice_terms" class="form-control" placeholder="Enter Terms">{{ old('terms', setting('terms') ) }}</textarea>
                        </div>
                    </div>
                </section>

                <!-- Summary (sticky on desktop) -->
                <aside class="ie-area-sum">
                    <div class="ie-card">
                        <div class="ie-card-head">
                            <span class="ie-card-ic"><i data-lucide="receipt"></i></span>
                            <div class="ie-card-title">
                                <h3>Summary</h3>
                                <p>Step by step: how your total is calculated</p>
                            </div>
                        </div>

                        <div class="ie-sum-body">

                            <div class="ie-sum-meta">
                                <div><span>Items</span><strong id="sum-items">0</strong></div>
                                <div><span>Total qty</span><strong id="sum-qty">0</strong></div>
                            </div>

                            <div class="ie-sum-row s-subtotal">
                                <div class="ie-sum-lbl"><span class="ie-op">Σ</span>
                                    <div><b>Subtotal</b><small>Qty × Rate of all items, before discount</small></div>
                                </div>
                                <strong id="subtotal">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-discount">
                                <div class="ie-sum-lbl"><span class="ie-op">−</span>
                                    <div><b>Total Discount</b><small>Sum of discount given on every item</small></div>
                                </div>
                                <strong id="total-discount">−$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-taxable">
                                <div class="ie-sum-lbl"><span class="ie-op">=</span>
                                    <div><b>Taxable Value</b><small>Subtotal − Total Discount (tax is charged on this)</small></div>
                                </div>
                                <strong id="total-taxable">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-tax is-child same-state-class d-none">
                                <div class="ie-sum-lbl">
                                    <div><b>CGST</b><small>Half of the tax, on Taxable Value</small></div>
                                </div>
                                <strong id="total-cgst">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-tax is-child same-state-class d-none">
                                <div class="ie-sum-lbl">
                                    <div><b>SGST</b><small>Other half of the tax, on Taxable Value</small></div>
                                </div>
                                <strong id="total-sgst">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-tax is-child diffrent-state-class d-none">
                                <div class="ie-sum-lbl">
                                    <div><b>IGST</b><small>Full tax on Taxable Value (client in another state)</small></div>
                                </div>
                                <strong id="total-igst">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-tax">
                                <div class="ie-sum-lbl"><span class="ie-op">+</span>
                                    <div><b>Total Tax</b><small>CGST + SGST (or IGST)</small></div>
                                </div>
                                <strong id="total-tax">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-grand">
                                <div class="ie-sum-lbl"><span class="ie-op">=</span>
                                    <div><b>Grand Total</b><small>Taxable Value + Total Tax</small></div>
                                </div>
                                <strong id="grand-total">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-round" id="round-off-row">
                                <div class="ie-sum-lbl"><span class="ie-op">±</span>
                                    <div><b>Round off</b><small id="round-off-note">No rounding needed</small></div>
                                </div>
                                <strong id="round-off">$0.00</strong>
                            </div>

                        </div>

                        <div class="ie-sum-due">
                            <div>
                                <span>Total due</span>
                                <small>Grand Total ± Round off</small>
                            </div>
                            <strong id="remaining-balance">$0.00</strong>
                        </div>

                        <div class="ie-sum-words">
                            <span>Total due in words</span>
                            <b id="total-words">Zero Only</b>
                        </div>
                    </div>
                </aside>

            </div>
        </div>

        <!-- Invoice Mode Modal -->
        <div class="modal fade" id="invoiceModeModal" tabindex="-1" aria-labelledby="invoiceModeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Invoice Mode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="invoice_mode" id="auto_mode" value="auto" checked>
                            <label class="form-check-label" for="auto_mode">Auto</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="invoice_mode" id="custom_mode" value="custom">
                            <label class="form-check-label" for="custom_mode">Custom</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


    <!-- Add Client Model -->
    <div class="modal fade" id="client-modal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="clientModalLabel">Add Client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="client-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

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

    <!-- Add Tax Model -->
    <div class="modal fade" id="tax-modal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="taxModalLabel">Add Tax</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="tax-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



    <!-- Add Dicount Model -->
    <div class="modal fade" id="discount-modal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="discountModalLabel">Add Discount</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="discount-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

    <script>
        var onboarding_status = "{{ setting('invoice_onboarding') }}";
        document.addEventListener("DOMContentLoaded", function() {

            if (onboarding_status == 'N') {
                Swal.fire({
                    title: "Welcome to InvoiceZy!",
                    text: "We will guide you step-by-step to create your first invoice. This will take less than 20 seconds.",
                    icon: "info",
                    confirmButtonText: "Start Guide",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    startInvoiceOnboarding();
                });
            }




        });


        function startInvoiceOnboarding() {
            introJs().setOptions({
                steps: [{
                        element: '#company-logo-section',
                        intro: 'This is your company logo, which appears on all invoices. You can update it anytime from: Menu → Business Settings → Business Info → Company Logo.'
                    },
                    {
                        element: '#new-client-btn',
                        intro: 'Click here to add a new client. This helps you quickly create invoices for first-time customers.'
                    },
                    {
                        element: '#client',
                        intro: 'Start by selecting an existing client. Simply type the name, email, or mobile number to search.You can see all customer from: Menu → Client.'
                    },
                    {
                        element: '#add-item-btn',
                        intro: 'Add your first invoice item here — including product name, quantity, price, and taxes.'
                    },
                    {
                        element: '#invoice_date',
                        intro: 'Choose the invoice issue date. This is the date when the invoice becomes active.'
                    },
                    {
                        element: '#due_date',
                        intro: 'Select the payment due date. This helps your client know the last day to pay.'
                    },
                    {
                        element: '#invoiceModeSwitch',
                        intro: 'Switch to Custom Mode if you want to enter your own invoice number manually.'
                    },
                    {
                        element: '#template-section',
                        intro: 'Choose an invoice template. Pick the one that best matches your branding and business style.'
                    },
                    {
                        element: '#useUpiToggle',
                        intro: 'Enable this to show your UPI ID and QR Code on the invoice. Add or manage UPI IDs from the left menu’s UPI section.'
                    },
                    {
                        element: '#terms-section',
                        intro: 'Here you can review or update the Terms & Conditions for this invoice. When client-specific terms are not provided, Invoicezy automatically applies your default business Terms & Conditions.'
                    },
                    {
                        element: '#notes-section',
                        intro: 'Here you can review or update the Notes for this invoice. When client-specific notes are not provided, Invoicezy automatically applies your default business Notes.'
                    },
                    {
                        element: '#action-btn',
                        intro: 'Once everything is set, click here to save the invoice or send it directly to your client.'
                    }
                ],

                showProgress: true,
                exitOnOverlayClick: false,
                highlightClass: 'intro-highlight'
            }).onbeforechange(function(targetElement) {
                // Notes / Terms are tabs now: open the right tab before intro.js highlights it
                if (targetElement && targetElement.id === 'terms-section') {
                    $('.ie-tab[data-target="#terms-section"]').trigger('click');
                } else if (targetElement && targetElement.id === 'notes-section') {
                    $('.ie-tab[data-target="#notes-section"]').trigger('click');
                }
            }).oncomplete(function() {
                updateOnboardingStatus();
            }).start();
        }

        function updateOnboardingStatus() {
            $.ajax({
                url: "{{ route('settings.user.onboarding') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    onboarding_update: "invoice_onboarding"
                },
                success: function(response) {
                    console.log("Onboarding status updated in DB");
                }
            });
        }
    </script>


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
        $(document).on("change", ".discount-select", function() {
            let selectedVal = $(this).val();

            if (selectedVal === "new") {
                // Reset back to default (No Discount)
                $(this).val("0");
                // Open your modal
                $('.editDiscount-modal-body').empty();
                try {
                    $.ajax({
                        url: "{{ route('discount.add') }}",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $('.discount-modal-body').html(response);
                            $('#discount-modal').modal('show');

                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                }


            } else {
                // Call your calculation if needed
                calculateInvoice();
            }
        });


        $(document).on("change", ".tax-select", function() {
            let selectedVal = $(this).val();

            if (selectedVal === "new") {
                // Reset back to default (No Discount)
                $(this).val("0");
                // Open your modal
                $('.edittax-modal-body').empty();
                try {
                    $.ajax({
                        url: "{{ route('tax.add') }}",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $('.tax-modal-body').html(response);
                            $('#tax-modal').modal('show');

                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                }


            } else {
                // Call your calculation if needed
                calculateInvoice();
            }
        });

        $(document).on('click', '.new-client', function(e) {
            e.preventDefault();
            var client_id = 0;

            try {

                $.ajax({
                    url: "{{ route('client.add') }}",
                    data: {
                        client_id: client_id
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                        $('.client-modal-body').html(response);
                        $('#client-modal').modal('show');

                        $('#client-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)
                            ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
                                new Choices(selector, {
                                    searchEnabled: true,
                                    itemSelectText: '',
                                });
                            });
                        });


                        // Initialize CKEditor (destroy old if exists)

                        $('.client-modal-body #id_notes').summernote({
                            placeholder: 'Enter notes...',
                            height: 120,
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['link']],
                                ['view', ['codeview']]
                            ]
                        });


                        $('.client-modal-body #id_terms').summernote({
                            placeholder: 'Enter terms...',
                            height: 120,
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['link']],
                                ['view', ['codeview']]
                            ]
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
            $('#is_recurring').on('change', function() {
                if (this.checked) {
                    $('#recurringOptions').slideDown();
                } else {
                    $('#recurringOptions').slideUp();
                }
            });

            $('#frequency').on('change', function() {
                const value = $(this).val();

                $('#monthlyDay').hide();
                $('#weeklyDay').hide();
                $('#yearlySection').hide();

                if (value === 'monthly') {
                    $('#monthlyDay').fadeIn();
                } else if (value === 'weekly') {
                    $('#weeklyDay').fadeIn();
                } else if (value === 'yearly') {
                    $('#yearlySection').fadeIn();
                }
            });

            // Load initial state (edit mode)
            if ($('#is_recurring').is(':checked')) {
                $('#recurringOptions').show();
                $('#frequency').trigger('change');
            }
        });
    </script>


    <script>
        function toggleInvoiceMode(elem) {
            const input = document.getElementById('invoice_number');
            if (elem.checked) {
                input.removeAttribute('readonly');
                input.placeholder = "Enter manually";
                input.focus();
            } else {
                input.setAttribute('readonly', true);
                input.value = '';
                input.placeholder = "Auto-generated";
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            function generateInvoiceNumber() {
                let invoice_number = "{{ $data['invoice_number'] }}";

                return invoice_number;
            }

            function updateInvoiceField() {
                const isCustom = $("#invoiceModeSwitch").is(":checked");

                if (isCustom) {
                    let prefix = "{{ setting('invoice_prefix') }}";
                    $("#invoice_number")
                        .val(prefix)
                        .prop("readonly", false)
                        .removeClass("bg-light")
                        .attr("placeholder", "Enter manually");
                } else {
                    let autoValue = generateInvoiceNumber();
                    $("#invoice_number")
                        .val(autoValue)
                        .prop("readonly", false)
                        .addClass("bg-light")
                        .attr("placeholder", "Auto-generated");
                }

                $("#invoice_number").fadeOut(200).fadeIn(400);
            }

            // When the switch is toggled
            $("#invoiceModeSwitch").change(function() {
                updateInvoiceField();
            });

            // On page load
            updateInvoiceField();
        });
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('useUpiToggle');
            const dropdown = document.getElementById('upiDropdownWrapper');

            function updateDropdownVisibility() {
                if (toggle.checked) {
                    dropdown.style.display = 'block';
                    dropdown.classList.add('animate__animated', 'animate__fadeIn');
                } else {
                    dropdown.style.display = 'none';
                    dropdown.classList.remove('animate__animated', 'animate__fadeIn');
                }
            }

            setTimeout(() => {
                updateDropdownVisibility();
            }, 500); // Delay by 300ms
            // Run on DOM load


            // Run on toggle change
            toggle.addEventListener('change', updateDropdownVisibility);
        });
    </script>



    <script>
        $(document).ready(function() {
            var upi = "{{ setting('upi_id_status') == 'Y'  ? 1 : 0 }}";

            if (upi == '1') {
                $('#useUpiToggle').prop('checked', true);
            }
            $('#template_id, #upi_id, #currency_code').select2({
                placeholder: "Please select",
                allowClear: true
            });


        });
    </script>


    <script>
        // Notes / Terms tabs + item description toggle (UI only)
        $(document).on('click', '.ie-tab', function() {
            $('.ie-tab').removeClass('is-active').attr('aria-selected', 'false');
            $(this).addClass('is-active').attr('aria-selected', 'true');
            $('.ie-pane').removeClass('is-active');
            $($(this).data('target')).addClass('is-active');
        });

        $(document).on('click', '.ie-desc-toggle', function() {
            $(this).toggleClass('is-open');
            $(this).closest('.ie-item').find('.ie-item-desc').toggleClass('is-open');
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) lucide.createIcons();
        });
    </script>


    <script>
        // Keep CKEditor instances here
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {

            $('.change-client').hide();
            $('.new-client').show();

            $('#id_invoice_notes').summernote({
                placeholder: 'Enter notes...',
                height: 110,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('#id_invoice_terms').summernote({
                placeholder: 'Enter terms...',
                height: 110,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 90,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });


            $('.save-invoice').on('click', function(e) {
                e.preventDefault();

                $('#send_status').val($(this).attr('send-status'))

                let formData = new FormData(document.getElementById('invoice-generate'));

                formData.append('notes', $('#id_invoice_notes').summernote('code'));
                formData.append('terms', $('#id_invoice_terms').summernote('code'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your invoice.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('invoice.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('.error').remove();
                        $('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.error == 1) {
                            $.each(response.errors, function(field, messages) {
                                let inputField = $('[name="' + field + '"]');
                                if (inputField.length > 0) {
                                    inputField.addClass("is-invalid");

                                    if (inputField.closest('.input-group').length > 0) {
                                        inputField.closest('.input-group').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else if (inputField.hasClass('select2-hidden-accessible')) {
                                        inputField.next('.select2-container').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else {
                                        inputField.after('<div class="text-danger error">' + messages[0] + '</div>');
                                    }
                                }
                            });
                            if (response.errors && response.errors.item && response.errors.item[0]) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Please enter the invoice items details!",
                                    toast: true,
                                    position: "center",
                                    confirmButtonText: "OK"

                                });
                            } else {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Warning!",
                                    text: "Please check the form carefully!",
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }



                        } else if (response.error == 0) {
                            $('#invoice-download').show();
                            $('#invoice-download').attr('href', response.download_url);

                            Swal.fire({
                                icon: "success",
                                title: "Invoice Generated Successfully. You Can Download!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('invoice.list') }}";
                            });



                        } else if (response.error == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Stock Unavailable!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 403 && xhr.responseJSON?.redirect) {
                            window.location.href = xhr.responseJSON.redirect;
                        } else {
                            console.error("Error:", xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#client').on('keyup', function() {
                let query = $(this).val();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("client.search") }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#clientList').html('');
                            if (data.length > 0) {
                                $('#clientList').show();
                                $('#clientList').append(`<div class="p-2 rounded shadow-sm border" style="max-height:400px; overflow-y:auto; background-color:#f8f9fa;">`);
                                data.forEach(function(client) {
                                    $('#clientList').append(`
                <a href="javascript:void(0);" class="list-group-item list-group-item-action mb-2 rounded shadow-sm p-3 select-client"
                   data-id="${client.client_id}"
                     data-client_code="${client.client_code}"
                   data-company_name="${client.company_name ?? ''}"
                   data-client_name="${client.client_name ?? ''}"
                   data-address_1="${client.address_1 ?? ''}"
                   data-address_2="${client.address_2 ?? ''}"
                   data-city="${client.city ?? ''}"
                   data-state_name="${client.state_name ?? ''}"
                    data-state_id="${client.state_id ?? ''}"
                   data-country_name="${client.country_name ?? ''}"
                   data-currency_code="${client.currency_code ?? ''}"
                   data-notes="${client.notes ?? ''}"
                   data-terms="${client.terms ?? ''}"
                   data-zip="${client.zip ?? ''}"
                   data-email="${client.email ?? ''}"
                   data-phone="${client.phone ?? ''}"
                   style="cursor:pointer; transition: all 0.2s ease-in-out;">
                   
                   <div class="d-flex justify-content-between align-items-center">
                       <div>
                           <h6 class="mb-1 fw-bold text-primary">
                                <i class="bi bi-person-circle me-1"></i> ${client.client_name ?? ''}
                            </h6>

                            <p class="mb-1 text-dark small fw-semibold">
                                <i class="bi bi-buildings me-1"></i>
                                ${client.company_name || 'N/A'}
                            </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-geo-alt me-1"></i> ${client.address_1 ?? ''}, ${client.city ?? ''}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-envelope me-1"></i> ${client.email ?? 'N/A'}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-telephone me-1"></i> ${client.phone ?? 'N/A'}
                           </p>
                       </div>
                       <span class="badge bg-success rounded-pill align-self-start">${client.currency_code ?? ''}</span>
                   </div>
                </a>
            `);
                                });
                                $('#clientList').append(`</div>`);
                            } else {
                                $('#clientList').hide();
                            }
                        }

                    });
                } else {
                    $('#clientList').hide();
                }
            });

            // Select client
            $(document).on('click', '#clientList a', function(e) {
                e.preventDefault();

                let client = $(this).data();
                let addressHTML = '';

                if (client.company_name) {
                    addressHTML += client.company_name + '<br>';
                } else {
                    addressHTML += client.client_name + '<br>';
                }
                if (client.address_1) addressHTML += client.address_1 + '<br>';
                if (client.address_2) addressHTML += client.address_2 + '<br>';
                if (client.city) addressHTML += client.city + ' ';
                if (client.state_name) addressHTML += client.state_name + ' ';
                if (client.country_name) addressHTML += client.country_name + ' ';
                if (client.zip) addressHTML += client.zip;

                $('#client').val(client.client_name);
                $('#client_id').val(client.id);
                $('#client_state_id').val(client.state_id);
                $('#clientList').hide();

                let edit_client = `<button client-code="${client.client_code}"  class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center 
                   position-absolute shadow" style="width: 36px; height: 36px; bottom: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editClientAddressModal">
        <i class="bi bi-pencil-fill"></i>
    </button>`;

                $('#clientAddress').html(addressHTML + edit_client).show();



                $('#currency_code').val(client.currency_code).trigger('change');



                $('#clientSearchBox').hide();
                $('.change-client').show();
                $('.new-client').hide();

            });

            // Change / Edit client
            $('.change-client').on('click', function(e) {
                $('#client').val('');
                $('#client_id').val('');
                $('#clientAddress').hide().html('');
                $('#clientList').hide();
                $('#clientSearchBox').show();
                $('.change-client').hide();
                $('.new-client').show();


            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#client, #clientList').length) {
                    $('#clientList').hide();
                }
            });
        });
    </script>



    <script>
        flatpickr("#invoice_date", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format: 2025-04-17 14:00
            time_24hr: true,
            defaultDate: "today"
        });

        flatpickr("#due_date", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format: 2025-04-17 14:00
            time_24hr: true,
            defaultDate: "today"
        });
    </script>




    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const discountOptions = `{!! collect($data['discounts'])->map(function($d) {
        return "<option value='" . $d->percent . "' discount-id='" . $d->discount_id . "'>" . e($d->name) . " (" . $d->percent . "%)</option>";
    })
    ->prepend("<option value='0'>No Discount</option>")   // first option at top
    ->push("<option value='new'>➕ Add New Discount</option>") // last option at bottom
    ->implode('') !!}`;
    </script>


    <script>
        const taxOptions = `{!! collect($data['taxes'])->map(function($t) {
        return "<option value='" . $t->percent . "' tax-id='" . $t->tax_id . "'>" . e($t->name) . " (" . $t->percent . "%)</option>";
    })
    ->prepend("<option value='0'>No Tax</option>")   // Top option
    ->push("<option value='new'>➕ Add New Tax</option>") // Bottom option
    ->implode('') !!}`;
    </script>

    <script>
        const currencies = @json($data['currencies']);
        const currencySymbols = Object.fromEntries(
            currencies.map(cur => [cur.currency_code, cur.currency_symbol])
        );


        var itemCount = 0;
        let currencySymbol = '$'; // Default currency

        $(document).ready(function() {
            $(document).on("change", '#currency_code', function(e) {
                let symbol = currencySymbols[this.value] || '$';
                currencySymbol = symbol;
                calculateInvoice();
            });

            let symbol = currencySymbols[$('#currency_code').val()] || '$';
            currencySymbol = symbol;
            calculateInvoice();
        });

        function addItemRow() {
            itemCount++;
            const formContainer = document.getElementById('form-container');

            const itemRow = document.createElement('div');
            itemRow.classList.add('ie-item');
            itemRow.setAttribute('data-item-id', itemCount);

            itemRow.innerHTML = `
      <div class="ie-item-head">
        <span class="ie-item-no"></span>
        <div class="ie-item-tools">
          <button type="button" class="ie-desc-toggle" title="Add or hide description">
            <i data-lucide="align-left"></i><span>Description</span>
          </button>
          <button type="button" class="remove-item-btn" onclick="removeRow(this)" title="Remove Item">
            <i data-lucide="x"></i>
          </button>
        </div>
      </div>

      <div class="ie-item-grid">

        <div class="f-name">
          <label class="ie-lbl" for="item-${itemCount}">Item</label>
          <input type="text"
                 name="item[${itemCount}][name]"
                 class="form-control form-control-sm add-items"
                 autocomplete="off"
                 id="item-${itemCount}"
                 item-id="${itemCount}"
                 placeholder="Search product or type manually"
                 title="Select from inventory to auto-fill details (price, tax, discount etc.) or type manually.">
          <div id="item-list-${itemCount}" class="list-group ie-suggest"></div>
        </div>

        <div class="f-hsn">
          <label class="ie-lbl">HSN/SAC</label>
          <input type="text" name="item[${itemCount}][hsn]" placeholder="HSN/SAC" oninput="calculateInvoice()" class="form-control form-control-sm hsn">
        </div>

        <div class="f-qty">
          <label class="ie-lbl">Qty</label>
          <input type="number" name="item[${itemCount}][quantity]" placeholder="Quantity" oninput="calculateInvoice()" class="form-control form-control-sm quantity">
        </div>

        <div class="f-rate">
          <label class="ie-lbl">Rate</label>
          <input type="number" name="item[${itemCount}][rate]" placeholder="Rate" oninput="calculateInvoice()" class="form-control form-control-sm rate">
        </div>

        <div class="f-disc">
          <label class="ie-lbl">Discount</label>
          <div class="input-group input-group-sm w-100">
            <select name="item[${itemCount}][discount]" class="form-select discount-select flex-grow-1">
              ${discountOptions}
            </select>
            <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
          </div>
        </div>

        <div class="f-tax">
          <label class="ie-lbl">Tax</label>
          <div class="input-group input-group-sm w-100">
            <select name="item[${itemCount}][tax]" class="form-select tax-select flex-grow-1">
              ${taxOptions}
            </select>
            <span class="input-group-text tax-amount">+${currencySymbol}0.00</span>
          </div>
        </div>

        <div class="f-amt">
          <label class="ie-lbl">Amount</label>
          <input type="text" name="item[${itemCount}][amount]" placeholder="Amount" class="form-control form-control-sm amount" readonly>
        </div>

      </div>

      <div class="ie-item-desc">
        <textarea
          class="id_description form-control form-control-sm"
          name="item[${itemCount}][description]"
          placeholder="Item Description"
          rows="2"></textarea>
      </div>
    `;

            formContainer.appendChild(itemRow);
            lucide.createIcons();

            $(itemRow).find('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 90,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });
        }


        // ---- amount in words (Indian system for INR / ₹, international otherwise) ----
        const W_ONES = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const W_TENS = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        const W_CURRENCY = {
            INR: ['Rupees', 'Paise'],
            USD: ['Dollars', 'Cents'],
            EUR: ['Euros', 'Cents'],
            GBP: ['Pounds', 'Pence'],
            AED: ['Dirhams', 'Fils'],
            AUD: ['Australian Dollars', 'Cents'],
            CAD: ['Canadian Dollars', 'Cents']
        };

        function wordsBelow1000(n) {
            let s = '';
            if (n >= 100) {
                s += W_ONES[Math.floor(n / 100)] + ' Hundred';
                n %= 100;
                if (n) s += ' ';
            }
            if (n >= 20) {
                s += W_TENS[Math.floor(n / 10)];
                if (n % 10) s += ' ' + W_ONES[n % 10];
            } else if (n > 0) {
                s += W_ONES[n];
            }
            return s;
        }

        function intToWords(n, indian) {
            if (n === 0) return 'Zero';
            const units = indian ? [
                [10000000, 'Crore'],
                [100000, 'Lakh'],
                [1000, 'Thousand']
            ] : [
                [1000000000, 'Billion'],
                [1000000, 'Million'],
                [1000, 'Thousand']
            ];
            const parts = [];
            units.forEach(([value, label]) => {
                if (n >= value) {
                    parts.push(intToWords(Math.floor(n / value), indian) + ' ' + label);
                    n %= value;
                }
            });
            if (n > 0) parts.push(wordsBelow1000(n));
            return parts.join(' ');
        }

        function amountInWords(amount) {
            const code = ($('#currency_code').val() || '').toString().toUpperCase();
            const indian = code === 'INR' || currencySymbol === '₹';
            const names = W_CURRENCY[code] || (indian ? W_CURRENCY.INR : [code, '']);

            const abs = Math.abs(amount);
            let whole = Math.floor(abs + 1e-9);
            let minor = Math.round((abs - whole) * 100);
            if (minor >= 100) {
                whole += 1;
                minor = 0;
            }

            let text = intToWords(whole, indian);
            if (names[0]) text += ' ' + names[0];
            if (minor > 0 && names[1]) text += ' and ' + intToWords(minor, indian) + ' ' + names[1];
            text += ' Only';

            return (amount < 0 ? 'Minus ' : '') + text;
        }

        function calculateInvoice() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalTax = 0;

            let total_cgstAmount = 0;
            let total_sgstAmount = 0;
            let total_igstAmount = 0;
            let total_taxable = 0;

            const items = document.querySelectorAll('[data-item-id]');
            items.forEach((item) => {
                const quantity = parseFloat(item.querySelector('.quantity').value || 0);
                const rate = parseFloat(item.querySelector('.rate').value || 0);
                const discountPercent = parseFloat(item.querySelector('.discount-select').value || 0);
                const taxPercent = parseFloat(item.querySelector('.tax-select').value || 0);

                const base = quantity * rate;
                const discount = (discountPercent / 100) * base;
                const taxable = base - discount;

                let isSameState = $('#user_state_id').val() == $('#client_state_id').val();

                let cgstPercent = 0;
                let sgstPercent = 0;
                let igstPercent = 0;

                if (isSameState) {
                    $('.same-state-class').removeClass('d-none');
                    $('.diffrent-state-class').addClass('d-none');
                    // CGST + SGST
                    cgstPercent = taxPercent / 2;
                    sgstPercent = taxPercent / 2;
                    igstPercent = 0;
                } else {
                    $('.same-state-class').addClass('d-none');
                    $('.diffrent-state-class').removeClass('d-none');
                    // IGST only
                    cgstPercent = 0;
                    sgstPercent = 0;
                    igstPercent = taxPercent;
                }

                // Calculate GST amount
                let cgstAmount = (taxable * cgstPercent) / 100;
                let sgstAmount = (taxable * sgstPercent) / 100;
                let igstAmount = (taxable * igstPercent) / 100;


                const tax = (taxPercent / 100) * (base - discount);
                const amount = base - discount + tax;

                // Update discount and tax amount spans
                const discountSpan = item.querySelector('.discount-amount');
                const taxSpan = item.querySelector('.tax-amount');
                if (discountSpan) discountSpan.innerText = `−${currencySymbol}${discount.toFixed(2)}`;
                if (taxSpan) taxSpan.innerText = `+${currencySymbol}${tax.toFixed(2)}`;

                // Update each item's amount
                item.querySelector('.amount').value = `${currencySymbol}${amount.toFixed(2)}`;

                // Add to totals
                subtotal += base;
                totalDiscount += discount;
                totalTax += tax;

                total_taxable += taxable;
                total_cgstAmount += cgstAmount;
                total_sgstAmount += sgstAmount;
                total_igstAmount += igstAmount;

            });

            // Update summary
            const fmt = (n) => `${currencySymbol}${n.toFixed(2)}`;

            let totalQty = 0;
            document.querySelectorAll('[data-item-id] .quantity').forEach((q) => {
                totalQty += parseFloat(q.value || 0);
            });
            document.getElementById('sum-items').innerText = items.length;
            document.getElementById('sum-qty').innerText = Number.isInteger(totalQty) ? totalQty : totalQty.toFixed(2);

            document.getElementById('subtotal').innerText = fmt(subtotal);
            document.getElementById('total-discount').innerText = `−${fmt(totalDiscount)}`;
            document.getElementById('total-taxable').innerText = fmt(total_taxable);

            document.getElementById('total-cgst').innerText = fmt(total_cgstAmount);
            document.getElementById('total-sgst').innerText = fmt(total_sgstAmount);
            document.getElementById('total-igst').innerText = fmt(total_igstAmount);

            document.getElementById('total-tax').innerText = fmt(totalTax);
            const grandTotal = subtotal - totalDiscount + totalTax;
            document.getElementById('grand-total').innerText = fmt(grandTotal);

            // Round to nearest whole amount
            let roundedTotal = Math.round(grandTotal);

            // Round-off difference (+ = added, − = subtracted)
            let roundOff = (roundedTotal - grandTotal).toFixed(2);
            const roundOffNum = parseFloat(roundOff);

            const roundEl = document.getElementById('round-off');
            const roundRow = document.getElementById('round-off-row');
            const roundNote = document.getElementById('round-off-note');
            roundRow.classList.remove('is-plus', 'is-minus');

            if (roundOffNum > 0) {
                roundEl.innerText = `+${fmt(roundOffNum)}`;
                roundRow.classList.add('is-plus');
                roundNote.innerText = 'Added to reach the nearest whole amount';
            } else if (roundOffNum < 0) {
                roundEl.innerText = `−${fmt(Math.abs(roundOffNum))}`;
                roundRow.classList.add('is-minus');
                roundNote.innerText = 'Subtracted to reach the nearest whole amount';
            } else {
                roundEl.innerText = fmt(0);
                roundNote.innerText = 'No rounding needed';
            }

            // Total due = Grand Total ± Round off
            const remainingBalance = roundedTotal;
            document.getElementById('remaining-balance').innerText = fmt(remainingBalance);
            document.getElementById('total-words').innerText = amountInWords(remainingBalance);


            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));

            $("#hidden_total_taxable").val(total_taxable.toFixed(2));
            $("#hidden_total_cgst").val(total_cgstAmount.toFixed(2));
            $("#hidden_total_sgst").val(total_sgstAmount.toFixed(2));
            $("#hidden_total_igst").val(total_igstAmount.toFixed(2));

            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));
            $("#hidden_total_due").val(remainingBalance.toFixed(2));
            $("#hidden_round_off").val(roundOff);


        }

        function removeRow(button) {
            const itemBlock = button.closest('[data-item-id]');
            if (itemBlock) itemBlock.remove();
            calculateInvoice();
        }
    </script>


    <script>
        function validateInputNumber(input) {
            if (input.value < 0) {
                input.value = 0;
            }
        }
    </script>




    <script>
        // Inventory search (suggestions dropdown per item row)
        $(document).on('keyup', '.add-items', function() {

            let query = $(this).val();
            const row_id = $(this).attr('item-id');

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('item.search') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#item-list-' + row_id).fadeIn().html(data);
                    }
                });
            } else {
                $('#item-list-' + row_id).fadeOut();
            }

        });

        // Bound once (was re-bound on every keyup before)
        $(document).on('click', '.select-item', function(e) {
            e.preventDefault();

            // a) Find the parent .list-group to figure out which row to update:
            const $listDiv = $(this).closest('.list-group');
            const listDivId = $listDiv.attr('id'); // e.g. "item-list-3"
            const rowIdx = listDivId.replace('item-list-', ''); // "3"

            // b) Grab all data attributes from the clicked <a>:
            const dbItemId = $(this).data('item_id'); // actual DB ID
            const itemName = $(this).data('item_name'); // item name text
            const hsnVal = $(this).data('hsn_sac'); // HSN/SAC
            const rateVal = $(this).data('unit_price'); // unit price
            const taxIdVal = $(this).data('tax_id'); // tax ID
            const discountIdVal = $(this).data('discount_id');
            const description = $(this).data('description');

            // c) Set the input value (the <input id="item-3">) to the product name:
            $(`#item-${rowIdx}`).val(itemName);

            // d) Hide & clear that dropdown:
            $listDiv.fadeOut().empty();

            // e) Find the entire row container (<div data-item-id="3">) so we can fill HSN, rate, tax:
            const $row = $(`#item-${rowIdx}`).closest('[data-item-id]');

            // f) Auto-fill description, HSN, Rate, and set the correct tax / discount
            $row.find('.id_description').summernote('code', description);
            if (description) {
                $row.find('.ie-item-desc').addClass('is-open');
                $row.find('.ie-desc-toggle').addClass('is-open');
            }
            $row.find('.hsn').val(hsnVal);
            $row.find('.quantity').val(1);
            $row.find('.rate').val(rateVal).trigger('input');

            $row.find('.tax-select option[tax-id="' + taxIdVal + '"]').prop('selected', true);
            $row.find('.tax-select').trigger('change');

            $row.find('.discount-select option[discount-id="' + discountIdVal + '"]').prop('selected', true);
            $row.find('.discount-select').trigger('change');

            // g) Submit the actual DB item_id via hidden input:
            if ($(`#hidden-item-id-${rowIdx}`).length === 0) {
                // Insert a hidden field if it doesn’t exist yet:
                $(`<input type="hidden"
                  name="item[${rowIdx}][item_id]"
                  id="hidden-item-id-${rowIdx}"
                  value="${dbItemId}">`)
                    .appendTo($row);
            } else {
                $(`#hidden-item-id-${rowIdx}`).val(dbItemId);
            }

            // h) Recompute invoice totals:
            calculateInvoice();
        });

        // Click outside any suggestions list -> close them
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.ie-suggest, .add-items').length) {
                $('.ie-suggest').fadeOut();
            }
        });
    </script>





</x-default-layout>