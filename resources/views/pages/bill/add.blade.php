<x-default-layout>

    <style>
        /* ==========================================================================
           Bill add — premium SaaS look (scoped to .ie-page)
           Same design language as the bill edit page
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
            grid-template-areas: "det" "par" "gst" "rec" "items" "sum" "notes";
            gap: 16px;
            align-items: start;
        }

        .ie-page .ie-area-det { grid-area: det; }
        .ie-page .ie-area-par { grid-area: par; }
        .ie-page .ie-area-gst { grid-area: gst; }
        .ie-page .ie-area-rec { grid-area: rec; }
        .ie-page .ie-area-items { grid-area: items; }
        .ie-page .ie-area-notes { grid-area: notes; }
        .ie-page .ie-area-sum { grid-area: sum; }

        @media (min-width: 1200px) {
            .ie-page .ie-grid {
                grid-template-columns: minmax(0, 1fr) 356px;
                grid-template-areas:
                    "det   sum"
                    "par   sum"
                    "gst   sum"
                    "rec   sum"
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
        .ie-page .ie-req,
        .ie-page .req { color: #e11d48; margin-left: 2px; }

        .ie-page .ie-card-body { padding: 18px; }

        @media (max-width: 575.98px) {
            .ie-page .ie-card-head { padding: 12px 14px; }
            .ie-page .ie-card-body { padding: 14px; }
        }

        /* ---------- form controls ---------- */
        .ie-page .form-label,
        .ie-page .ie-lbl {
            display: block;
            margin-bottom: 6px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        .ie-page .ie-lbl { font-size: 11.5px; color: var(--faint); margin-bottom: 5px; }

        .ie-page .ie-hint { margin-top: 6px; font-size: 12px; color: var(--mut); }

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
        .ie-page .form-control[readonly] { background: var(--soft); color: var(--mut); }

        .ie-page .form-control:focus,
        .ie-page .form-select:focus {
            border-color: var(--i1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14);
        }

        .ie-page .form-control.is-invalid,
        .ie-page .form-select.is-invalid { border-color: #e11d48; background-image: none; }

        .ie-page .error { margin-top: 6px; font-size: 12px; font-weight: 500; color: #e11d48 !important; }

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

        /* ---------- small links / switch rows ---------- */
        .ie-page .ie-link { font-size: 12.5px; font-weight: 600; color: var(--i1); text-decoration: none; }
        .ie-page .ie-link:hover { color: var(--i2); }

        .ie-page .ie-switch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--bd);
            border-radius: 12px;
            background: var(--soft);
            height: 100%;
        }

        .ie-page .ie-switch__title { margin: 0; font-size: 13px; font-weight: 600; color: var(--ink); }
        .ie-page .ie-switch__desc { margin: 0; font-size: 12px; color: var(--mut); }
        .ie-page .ie-switch .form-check-input { float: none; margin: 0; width: 2.6em; height: 1.4em; cursor: pointer; }

        /* ---------- parties ---------- */
        .ie-page .ie-party {
            height: 100%;
            padding: 16px;
            border: 1px dashed #d6dcf5;
            border-radius: 14px;
            background: var(--soft);
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--text);
        }

        .ie-page .ie-party__logo { height: 44px; margin-bottom: 10px; }

        .ie-page .ie-gstin,
        .ie-page .bz-gstin {
            display: inline-block;
            margin-top: 6px;
            padding: 2px 10px;
            border-radius: 999px;
            background: #eef2ff;
            color: var(--i1);
            font-size: 12px;
            font-weight: 600;
        }

        .ie-page #vendorAddress {
            position: relative;
            padding: 16px 56px 16px 16px;
            border: 1px solid var(--bd);
            border-radius: 14px;
            background: var(--soft);
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--text);
        }

        .ie-page .ie-vendor-list {
            max-height: 320px;
            overflow-y: auto;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid var(--bd);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 18px 38px -16px rgba(15, 23, 42, .3);
        }

        .ie-page .ie-vendor-opt {
            display: block;
            padding: 12px 14px;
            margin-bottom: 6px;
            border: 1px solid var(--bd) !important;
            border-radius: 12px !important;
            transition: background .15s ease, border-color .15s ease;
        }

        .ie-page .ie-vendor-opt:hover { background: #f5f6ff; border-color: #c7d2fe !important; }

        /* ---------- item cards ---------- */
        .ie-page .ie-items { display: flex; flex-direction: column; gap: 12px; }
        .ie-page .ie-items { counter-reset: itm; }

        /* empty state (no items yet) */
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

        /* ---------- item colours: discount = red, tax = blue, amount = green ---------- */
        .ie-page .ie-item .amount {
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            color: #047857;
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .ie-page .ie-item .input-group-text.discount-amount { color: #e11d48; background: #fff1f2; }
        .ie-page .ie-item .input-group-text.tax-amount { color: #0369a1; background: #f0f9ff; }

        /* ---------- summary ---------- */
        .ie-page .ie-sum-body { padding: 8px 18px 4px; }

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

        .ie-page .ie-sum-row.rcm-class .ie-op { color: #b45309; background: #fef3c7; }
        .ie-page .ie-sum-row.rcm-class strong { color: #b45309; }

        .ie-page .ie-sum-row.s-grand { border-top: 1px solid var(--bd); border-bottom: 1px dashed var(--bd); }
        .ie-page .ie-sum-row.s-grand .ie-op { color: #047857; background: #ecfdf5; }
        .ie-page .ie-sum-row.s-grand .ie-sum-lbl b { font-weight: 700; color: var(--ink); }
        .ie-page .ie-sum-row.s-grand strong { font-size: 16px; font-weight: 700; color: #059669; }

        /* round off: green when added, red when subtracted */
        .ie-page .ie-sum-row.s-round.is-plus .ie-op { color: #047857; background: #ecfdf5; }
        .ie-page .ie-sum-row.s-round.is-plus strong { color: #059669; }
        .ie-page .ie-sum-row.s-round.is-minus .ie-op { color: #e11d48; background: #fff1f2; }
        .ie-page .ie-sum-row.s-round.is-minus strong { color: #e11d48; }

        /* final payable */
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

        /* draft autosave indicator */
        #draft-status {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            white-space: nowrap;
        }

        #draft-status:empty { display: none; }

        #draft-status::before {
            content: "";
            width: 7px;
            height: 7px;
            margin-right: 6px;
            border-radius: 50%;
            background: #10b981;
        }

        /* modals */
        .modal.fade .modal-content { border: 0; border-radius: 18px; overflow: hidden; }
        .modal-header.bg-primary { background: linear-gradient(135deg, #4f46e5, #7c3aed) !important; }

        @media (prefers-reduced-motion: reduce) {
            .ie-page * { transition: none !important; }
        }
    </style>

    <x-page-heading
        title="Add Bill"
        description=""
        :breadcrumbs="[
            ['label' => 'Bills', 'url' => route('bill.list')],
            ['label' => 'Add Bill']
        ]" />

    <form action="#" id="bill-generate" method="POST">
        @csrf

        {{-- ===== Action bar ===== --}}
        <div class="page-header-fixed iz-actionbar mb-3">

            <a href="{{ route('bill.list') }}" class="iz-bar-back" title="Back to bills">
                <i data-lucide="arrow-left"></i> <span>Back</span>
            </a>

            <div class="iz-bar-right">

                {{-- Draft autosave indicator --}}
                <small id="draft-status" class="me-2"></small>

                <div class="iz-bar-primary">
                    <button type="button" id="save-bill" class="btn btn-primary save-bill">
                        <i class="bi bi-check2-circle"></i> Save Bill
                    </button>
                </div>
            </div>
        </div>

        <div class="ie-page">
            <div class="ie-grid">

                {{-- ===== 1. Bill details ===== --}}
                <section class="ie-card ie-area-det">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="receipt"></i></span>
                        <div class="ie-card-title">
                            <h3>Bill Details</h3>
                            <p>Number, dates, currency and template</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-xl-4">
                                <label class="form-label" for="bill_number">Bill Number <span class="req">*</span></label>
                                <input type="text" class="form-control" id="bill_number" name="bill_number"
                                    value="{{ old('bill_number', $data['bill_number'] ?? '') }}" placeholder="Auto-generated" readonly>
                                <div class="ie-hint">Final number save karte waqt assign hoga.</div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <x-date id="bill_date" name="bill_date" label="Bill Date" icon="calendar-event"
                                    placeholder="Select bill issue date"
                                    value="{{ old('bill_date', now()->format('Y-m-d')) }}" required />
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <x-date id="due_date" name="due_date" label="Due Date" icon="calendar-check"
                                    placeholder="Select bill due date"
                                    value="{{ old('due_date', now()->format('Y-m-d')) }}" required />
                            </div>

                            <div class="col-12 col-md-6 col-xl-6">
                                <label class="form-label" for="currency_code">Currency <span class="req">*</span></label>
                                <select name="currency_code" id="currency_code" class="form-select">
                                    <option value="">Please Select</option>
                                    @foreach($data['currencies'] as $currency)
                                    <option value="{{ $currency->currency_code }}" {{ old('currency_code', setting('default_currency')) == $currency->currency_code ? 'selected' : '' }}>
                                        {{ $currency->currency_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-xl-6">
                                <label class="form-label" for="template_id">Template <span class="req">*</span></label>
                                <select class="form-select" id="template_id" name="template_id">
                                    <option value="">Please Select</option>
                                    @foreach($data['templates'] as $template)
                                    <option value="{{ $template->template_id }}" {{ old('template_id', setting('default_template_id')) == $template->template_id ? 'selected' : '' }}>
                                        {{ $template->template_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ===== 2. Vendor & Business ===== --}}
                <section class="ie-card ie-area-par">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="users"></i></span>
                        <div class="ie-card-title">
                            <h3>Parties</h3>
                            <p>Who is billing you, and your business details</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="row g-4">

                            {{-- Vendor (Billed From) --}}
                            <div class="col-12 col-lg-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Vendor (Billed From) <span class="req">*</span></label>
                                    <a href="{{ route('vendor.add') }}" target="_blank" class="vendorActionBtn new-vendor ie-link">
                                        <i class="bi bi-plus-circle"></i> New vendor
                                    </a>
                                    <a href="#" onclick="event.preventDefault()" class="vendorActionBtn change-vendor ie-link" style="display:none;">
                                        <i class="bi bi-arrow-repeat"></i> Change vendor
                                    </a>
                                </div>

                                <div id="vendorSearchBox" class="position-relative">
                                    <input type="text" class="form-control" id="vendor" name="vendor_name"
                                        placeholder="Type vendor name, email or phone to search" autocomplete="off">
                                    <input type="hidden" name="vendor_id" id="vendor_id">
                                    <input type="hidden" name="vendor_state_id" id="vendor_state_id">
                                    <div id="vendorList" class="ie-vendor-list position-absolute w-100" style="display:none; z-index:1050;"></div>
                                </div>

                                <div id="vendorAddress" style="display:none;"></div>
                            </div>

                            {{-- Your business (Billed To) --}}
                            <div class="col-12 col-lg-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Billed To (Your Business)</label>
                                    <a href="{{ route('settings.edit') }}" target="_blank" class="ie-link">
                                        <i class="bi bi-pencil"></i> Edit business profile
                                    </a>
                                </div>

                                <input type="hidden" name="user_state_id" id="user_state_id" value="{{ setting('state_id') }}">

                                @php $myGstin = $data['setting']->gstin ?? $data['setting']->gst_number ?? null; @endphp
                                <div class="ie-party">
                                    @if(!empty($data['setting']->logo_path))
                                    <img src="{{ asset($data['setting']->logo_path) }}" class="ie-party__logo" alt="Logo"><br>
                                    @endif

                                    <strong>{{ !empty($data['setting']->company_name) ? $data['setting']->company_name : ($data['setting']->vendor_name ?? '') }}</strong><br>
                                    @if(!empty($data['setting']->address_1)) {{ $data['setting']->address_1 }}<br> @endif
                                    @if(!empty($data['setting']->address_2)) {{ $data['setting']->address_2 }}<br> @endif
                                    @if(!empty($data['setting']->state->state_name)) {{ $data['setting']->state->state_name }} @endif
                                    @if(!empty($data['setting']->country->country_name)) {{ $data['setting']->country->country_name }} @endif
                                    @if(!empty($data['setting']->pincode)) {{ $data['setting']->pincode }} @endif
                                    @if($myGstin)<br><span class="ie-gstin">GSTIN: {{ $myGstin }}</span>@endif
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                {{-- ===== 3. GST & Compliance ===== --}}
                <section class="ie-card ie-area-gst">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="badge-check"></i></span>
                        <div class="ie-card-title">
                            <h3>GST &amp; Compliance</h3>
                            <p>Vendor invoice reference, place of supply and ITC</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="row g-3">

                            <div class="col-12 col-md-6 col-xl-3">
                                <label class="form-label" for="vendor_invoice_number">Vendor Invoice No. <span class="req">*</span></label>
                                <input type="text" class="form-control" id="vendor_invoice_number" name="vendor_invoice_number"
                                    value="{{ old('vendor_invoice_number', '') }}"
                                    placeholder="Supplier's invoice number">
                            </div>

                            <div class="col-12 col-md-6 col-xl-3">
                                <x-date id="vendor_invoice_date" name="vendor_invoice_date" label="Vendor Invoice Date" icon="calendar-event"
                                    placeholder="Date on supplier's invoice"
                                    value="{{ old('vendor_invoice_date', '') }}" />
                            </div>

                            <div class="col-12 col-md-6 col-xl-3">
                                <label class="form-label" for="place_of_supply">Place of Supply</label>
                                <select name="place_of_supply" id="place_of_supply" class="form-select">
                                    <option value="">Please Select</option>
                                    @foreach(($data['states'] ?? []) as $st)
                                    <option value="{{ $st->state_id }}" {{ old('place_of_supply', $data['setting']->state_id ?? '') == $st->state_id ? 'selected' : '' }}>
                                        {{ $st->state_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-xl-3">
                                <label class="form-label" for="itc_eligibility">ITC Eligibility</label>
                                @php $itc = old('itc_eligibility', 'input'); @endphp
                                <select name="itc_eligibility" id="itc_eligibility" class="form-select">
                                    <option value="input" {{ $itc == 'input' ? 'selected' : '' }}>Inputs</option>
                                    <option value="capital_goods" {{ $itc == 'capital_goods' ? 'selected' : '' }}>Capital goods</option>
                                    <option value="input_services" {{ $itc == 'input_services' ? 'selected' : '' }}>Input services</option>
                                    <option value="ineligible" {{ $itc == 'ineligible' ? 'selected' : '' }}>Ineligible (blocked)</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="ie-switch">
                                    <div>
                                        <p class="ie-switch__title">Reverse Charge (RCM)</p>
                                        <p class="ie-switch__desc">Enable if you are liable to pay GST on this purchase instead of the vendor. Vendor ko sirf taxable amount pay hoga.</p>
                                    </div>
                                    <div class="form-check form-switch m-0 p-0">
                                        <input type="hidden" name="reverse_charge" value="N">
                                        <input class="form-check-input" type="checkbox" id="reverse_charge" name="reverse_charge" value="Y"
                                            {{ old('reverse_charge', 'N') == 'Y' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                {{-- ===== 4. Recurring ===== --}}
                <section class="ie-card ie-area-rec">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="repeat"></i></span>
                        <div class="ie-card-title">
                            <h3>Recurring Bill</h3>
                            <p>Auto-generate this bill on a schedule</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <div class="ie-switch">
                            <div>
                                <p class="ie-switch__title">Enable recurring bill</p>
                                <p class="ie-switch__desc">A copy of this bill will be created automatically.</p>
                            </div>
                            <div class="form-check form-switch m-0 p-0">
                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring"
                                    {{ old('is_recurring') ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div id="recurringOptions" style="display:none;">
                            <div class="row g-3 mt-1">

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="frequency">Frequency</label>
                                    <select name="frequency" id="frequency" class="form-select">
                                        @foreach(['monthly' => 'Monthly', 'weekly' => 'Weekly', 'yearly' => 'Yearly'] as $fv => $fl)
                                        <option value="{{ $fv }}" {{ old('frequency', 'monthly') == $fv ? 'selected' : '' }}>{{ $fl }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4" id="monthlyDay">
                                    <label class="form-label">Day of Month (1–31)</label>
                                    <select name="day_of_month" class="form-select">
                                        @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('day_of_month', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-12 col-md-4" id="weeklyDay" style="display:none;">
                                    <label class="form-label">Day of Week</label>
                                    <select name="day_of_week" class="form-select">
                                        @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $day)
                                        <option value="{{ $day }}" {{ old('day_of_week', 'monday') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-8" id="yearlySection" style="display:none;">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Month of Year</label>
                                            <select name="month_of_year" class="form-select">
                                                @foreach([1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'] as $num => $month)
                                                <option value="{{ $num }}" {{ old('month_of_year', now()->month) == $num ? 'selected' : '' }}>{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Day of Month</label>
                                            <select name="yearly_day_of_month" class="form-select">
                                                @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}" {{ old('yearly_day_of_month', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label">Time to Generate</label>
                                    <input type="time" name="time_of_day" class="form-control" value="{{ old('time_of_day', '09:00') }}">
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                {{-- ===== 5. Items ===== --}}
                <section class="ie-card ie-area-items">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="package"></i></span>
                        <div class="ie-card-title">
                            <h3>Bill Items <span class="ie-req">*</span></h3>
                            <p>Search from inventory to auto-fill HSN, rate, GST and discount</p>
                        </div>
                    </div>
                    <div class="ie-card-body">

                        {{-- Rows are added by JS (first row is added automatically on load) --}}
                        <div id="form-container" class="ie-items"></div>

                        <div class="ie-add">
                            <x-invoice.add-item-button id="add-item-btn" text="Add Item" onclick="addItemRow()" />
                        </div>
                    </div>
                </section>

                {{-- ===== 6. Notes ===== --}}
                <section class="ie-card ie-area-notes">
                    <div class="ie-card-head">
                        <span class="ie-card-ic"><i data-lucide="file-text"></i></span>
                        <div class="ie-card-title">
                            <h3>Notes</h3>
                            <p>Internal remarks for this purchase</p>
                        </div>
                    </div>
                    <div class="ie-card-body">
                        <label for="id_bill_notes" class="form-label visually-hidden">Notes:</label>
                        <textarea id="id_bill_notes" name="notes" class="form-control" placeholder="Enter Notes">{{ old('notes') }}</textarea>
                    </div>
                </section>

                {{-- ===== Summary (sticky on desktop) ===== --}}
                <aside class="ie-area-sum">
                    <div class="ie-card">
                        <div class="ie-card-head">
                            <span class="ie-card-ic"><i data-lucide="receipt"></i></span>
                            <div class="ie-card-title">
                                <h3>Bill Summary</h3>
                                <p>Step by step: how your total is calculated</p>
                            </div>
                        </div>

                        <div class="ie-sum-body">

                            <div id="rcm-note" class="alert alert-warning py-2 px-3 small d-none mt-3 mb-0" style="border-radius:12px;">
                                <i class="bi bi-info-circle"></i>
                                Reverse charge applies. Vendor ko sirf taxable amount dena hai, GST aap seedha govt ko pay karoge.
                            </div>

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
                                <strong id="taxable-value">$0.00</strong>
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
                                    <div><b>IGST</b><small>Full tax on Taxable Value (vendor in another state)</small></div>
                                </div>
                                <strong id="total-igst">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-tax">
                                <div class="ie-sum-lbl"><span class="ie-op">+</span>
                                    <div><b id="total-tax-label">Total Tax</b><small>CGST + SGST (or IGST)</small></div>
                                </div>
                                <strong id="total-tax">$0.00</strong>
                            </div>

                            <div class="ie-sum-row s-grand">
                                <div class="ie-sum-lbl"><span class="ie-op">=</span>
                                    <div><b id="grand-total-label">Grand Total</b><small>Taxable Value + Total Tax</small></div>
                                </div>
                                <strong id="grand-total">$0.00</strong>
                            </div>

                            <div class="ie-sum-row rcm-class d-none">
                                <div class="ie-sum-lbl"><span class="ie-op">!</span>
                                    <div><b>GST payable to Govt (RCM)</b><small>Paid directly by you, not to the vendor</small></div>
                                </div>
                                <strong id="rcm-tax">$0.00</strong>
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
                                <span id="payable-label">Amount Payable</span>
                                <small>Payable amount ± Round off</small>
                            </div>
                            <strong id="remaining-balance">$0.00</strong>
                        </div>

                        <div class="ie-sum-words">
                            <span>Amount payable in words</span>
                            <b id="total-words">Zero Only</b>
                        </div>
                    </div>
                </aside>

            </div>
        </div>

        <input type="hidden" name="hidden_sub_total" value="" id="hidden_sub_total">
        <input type="hidden" name="hidden_total_discount" value="" id="hidden_total_discount">
        <input type="hidden" name="hidden_total_taxable" value="" id="hidden_total_taxable">
        <input type="hidden" name="hidden_total_cgst" value="" id="hidden_total_cgst">
        <input type="hidden" name="hidden_total_sgst" value="" id="hidden_total_sgst">
        <input type="hidden" name="hidden_total_igst" value="" id="hidden_total_igst">
        <input type="hidden" name="hidden_total_tax" value="" id="hidden_total_tax">
        <input type="hidden" name="hidden_grand_total" value="" id="hidden_grand_total">
        <input type="hidden" name="hidden_rcm_tax" value="" id="hidden_rcm_tax">
        <input type="hidden" name="hidden_round_off" value="" id="hidden_round_off">
        <input type="hidden" name="hidden_total_due" value="" id="hidden_total_due">

    </form>

    {{-- ===== Modals ===== --}}
    <div class="modal fade" id="vendor-modal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
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

    <div class="modal fade" id="tax-modal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="taxModalLabel">Add Tax</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="tax-modal-body py-3 px-3"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discount-modal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="discountModalLabel">Add Discount</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="discount-modal-body py-3 px-3"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ===== Data from server ===== --}}
    <script>
        const discountOptions = `{!! collect($data['discounts'])->map(function($d) {
            return "<option value='" . $d->percent . "' discount-id='" . $d->discount_id . "'>" . e($d->name) . " (" . $d->percent . "%)</option>";
        })->prepend("<option value='0'>No Discount</option>")->implode('') !!}`;

        const taxOptions = `{!! collect($data['taxes'])->map(function($t) {
            return "<option value='" . $t->percent . "' tax-id='" . $t->tax_id . "'>" . e($t->name) . " (" . $t->percent . "%)</option>";
        })->prepend("<option value='0'>No Tax</option>")->implode('') !!}`;

        const currencies = @json($data['currencies']);
        const currencySymbols = Object.fromEntries(currencies.map(cur => [cur.currency_code, cur.currency_symbol]));

        var itemCount = 0;
        let currencySymbol = '$';

        const SN_TOOLBAR = [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ];

        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));
    </script>

    {{-- ===== UI helpers (description toggle + icons) ===== --}}
    <script>
        $(document).on('click', '.ie-desc-toggle', function() {
            $(this).toggleClass('is-open');
            $(this).closest('.ie-item').find('.ie-item-desc').toggleClass('is-open');
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) lucide.createIcons();
        });
    </script>

    {{-- ===== Page init ===== --}}
    <script>
        $(function() {

            // ---- Select2 / flatpickr / summernote ----
            $('#template_id, #currency_code, #place_of_supply, #itc_eligibility').select2({
                placeholder: "Please select",
                allowClear: true,
                width: '100%'
            });

            ['#bill_date', '#due_date', '#vendor_invoice_date'].forEach(function(sel) {
                if (document.querySelector(sel)) flatpickr(sel, { enableTime: false, dateFormat: "Y-m-d" });
            });

            $('#id_bill_notes').summernote({ placeholder: 'Enter notes...', height: 110, toolbar: SN_TOOLBAR });

            // ---- Recurring ----
            $('#is_recurring').on('change', function() {
                this.checked ? $('#recurringOptions').slideDown() : $('#recurringOptions').slideUp();
            });

            $('#frequency').on('change', function() {
                const v = $(this).val();
                $('#monthlyDay, #weeklyDay, #yearlySection').hide();
                if (v === 'monthly') $('#monthlyDay').fadeIn();
                else if (v === 'weekly') $('#weeklyDay').fadeIn();
                else if (v === 'yearly') $('#yearlySection').fadeIn();
            });

            if ($('#is_recurring').is(':checked')) {
                $('#recurringOptions').show();
                $('#frequency').trigger('change');
            }

            // ---- Currency / place of supply / RCM ----
            $(document).on('change', '#currency_code', function() {
                currencySymbol = currencySymbols[this.value] || '$';
                calculatebill();
            });
            $(document).on('change', '#place_of_supply', calculatebill);
            $(document).on('change', '#reverse_charge', calculatebill);

            currencySymbol = currencySymbols[$('#currency_code').val()] || '$';

            // First empty item row
            addItemRow();
            calculatebill();

            // ---- Vendor search ----
            $('#vendor').on('keyup', function() {
                let query = $(this).val();

                if (query.length < 2) {
                    $('#vendorList').hide();
                    return;
                }

                $.ajax({
                    url: '{{ route("vendor.search") }}',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        if (!data.length) {
                            $('#vendorList').hide().empty();
                            return;
                        }

                        const html = data.map(function(v) {
                            const gstin = v.gstin ?? v.gst_number ?? '';
                            return `
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action ie-vendor-opt select-vendor"
                               data-id="${esc(v.vendor_id)}"
                               data-vendor_code="${esc(v.vendor_code)}"
                               data-company_name="${esc(v.company_name)}"
                               data-vendor_name="${esc(v.vendor_name)}"
                               data-address_1="${esc(v.address_1)}"
                               data-address_2="${esc(v.address_2)}"
                               data-city="${esc(v.city)}"
                               data-state_name="${esc(v.state_name)}"
                               data-state_id="${esc(v.state_id)}"
                               data-country_name="${esc(v.country_name)}"
                               data-currency_code="${esc(v.currency_code)}"
                               data-notes="${esc(v.notes)}"
                               data-terms="${esc(v.terms)}"
                               data-zip="${esc(v.zip)}"
                               data-email="${esc(v.email)}"
                               data-phone="${esc(v.phone)}"
                               data-gstin="${esc(gstin)}">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary"><i class="bi bi-building me-1"></i> ${esc(v.vendor_name)}</h6>
                                        <p class="mb-0 text-muted small"><i class="bi bi-geo-alt me-1"></i> ${esc(v.address_1)}, ${esc(v.city)}</p>
                                        <p class="mb-0 text-muted small"><i class="bi bi-envelope me-1"></i> ${esc(v.email || 'N/A')}</p>
                                        <p class="mb-0 text-muted small"><i class="bi bi-telephone me-1"></i> ${esc(v.phone || 'N/A')}</p>
                                        ${gstin ? `<span class="ie-gstin">GSTIN: ${esc(gstin)}</span>` : ''}
                                    </div>
                                    <span class="badge bg-success rounded-pill">${esc(v.currency_code)}</span>
                                </div>
                            </a>`;
                        }).join('');

                        $('#vendorList').html(html).show();
                    }
                });
            });

            // ---- Select vendor ----
            $(document).on('click', '#vendorList a', function(e) {
                e.preventDefault();
                let vendor = $(this).data();
                let addressHTML = '<strong>' + esc(vendor.company_name || vendor.vendor_name) + '</strong><br>';

                if (vendor.address_1) addressHTML += esc(vendor.address_1) + '<br>';
                if (vendor.address_2) addressHTML += esc(vendor.address_2) + '<br>';
                if (vendor.city) addressHTML += esc(vendor.city) + ' ';
                if (vendor.state_name) addressHTML += esc(vendor.state_name) + ' ';
                if (vendor.country_name) addressHTML += esc(vendor.country_name) + ' ';
                if (vendor.zip) addressHTML += esc(vendor.zip);
                if (vendor.gstin) addressHTML += '<br><span class="ie-gstin">GSTIN: ' + esc(vendor.gstin) + '</span>';

                $('#vendor').val(vendor.vendor_name);
                $('#vendor_id').val(vendor.id);
                $('#vendor_state_id').val(vendor.state_id);
                $('#vendorList').hide();

                let edit_vendor = `<button type="button" vendor-code="${esc(vendor.vendor_code)}"
                    class="edit-vendor btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute shadow"
                    style="width:36px;height:36px;bottom:10px;right:10px;"><i class="bi bi-pencil-fill"></i></button>`;

                $('#vendorAddress').html(addressHTML + edit_vendor).show();
                $('#currency_code').val(vendor.currency_code).trigger('change');

                if (vendor.notes && String(vendor.notes).replace(/<[^>]*>/g, '').trim() !== '') {
                    $('#id_bill_notes').summernote('code', vendor.notes);
                }

                $('#vendorSearchBox').hide();
                $('.change-vendor').show();
                $('.new-vendor').hide();
                calculatebill();
            });

            // ---- Change vendor ----
            $('.change-vendor').on('click', function() {
                $('#vendor').val('');
                $('#vendor_id').val('');
                $('#vendor_state_id').val('');
                $('#vendorAddress').hide().html('');
                $('#vendorList').hide();
                $('#vendorSearchBox').show();
                $('.change-vendor').hide();
                $('.new-vendor').show();
                calculatebill();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#vendor, #vendorList').length) $('#vendorList').hide();
                if (!$(e.target).closest('.ie-suggest, .add-items').length) $('.ie-suggest').fadeOut();
            });

            // ---- Item search (single delegated handlers) ----
            $(document).on('keyup', '.add-items', function() {
                let query = $(this).val();
                const row_id = $(this).attr('item-id');

                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('item.search') }}",
                        method: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#item-list-' + row_id).html(data).fadeIn();
                        }
                    });
                } else {
                    $('#item-list-' + row_id).fadeOut();
                }
            });

            $(document).on('click', '.select-item', function(e) {
                e.preventDefault();

                const $listDiv = $(this).closest('.list-group');
                const rowIdx = $listDiv.attr('id').replace('item-list-', '');

                const dbItemId = $(this).data('item_id');
                const itemName = $(this).data('item_name');
                const description = $(this).data('description');
                const hsnVal = $(this).data('hsn_sac');
                const rateVal = $(this).data('unit_price');
                const taxIdVal = $(this).data('tax_id');
                const discountIdVal = $(this).data('discount_id');

                $(`#item-${rowIdx}`).val(itemName);
                $listDiv.fadeOut().empty();

                const $row = $(`#item-${rowIdx}`).closest('[data-item-id]');

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

                if ($(`#hidden-item-id-${rowIdx}`).length === 0) {
                    $(`<input type="hidden" name="item[${rowIdx}][item_id]" id="hidden-item-id-${rowIdx}" value="${dbItemId}">`).appendTo($row);
                } else {
                    $(`#hidden-item-id-${rowIdx}`).val(dbItemId);
                }

                calculatebill();
            });

            // ---- Save bill ----
            $('.save-bill').on('click', function(e) {
                e.preventDefault();

                let formData = new FormData(document.getElementById('bill-generate'));
                formData.set('notes', $('#id_bill_notes').summernote('code'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we save your bill.",
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: "{{ route('bill.store') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    beforeSend: function() {
                        $('.error').remove();
                        $('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.error == 1) {
                            $.each(response.errors || {}, function(field, messages) {
                                let inputField = $('[name="' + field + '"]').not('[type="hidden"]');
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
                                    text: "Please enter the bill items details!",
                                    toast: true,
                                    position: "center",
                                    confirmButtonText: "OK"
                                });
                            } else {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Warning!",
                                    text: response.message || "Please check the form carefully!",
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }

                        } else if (response.error == 0) {
                            // Bill saved successfully -> remove the autosaved draft
                            if (typeof clearBillDraft === 'function') clearBillDraft();

                            Swal.fire({
                                icon: "success",
                                title: "Bill Saved Successfully!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                window.location.href = "{{ route('bill.list') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 403 && xhr.responseJSON?.redirect) {
                            window.location.href = xhr.responseJSON.redirect;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Something went wrong.'
                            });
                            console.error("Error:", xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>

    {{-- ===== Modals / ajax helpers ===== --}}
    <script>
        $(document).on('click', '.edit-vendor', function(e) {
            e.preventDefault();
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
                        ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
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

        $(document).on('click', '.new-vendor', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('vendor.add') }}",
                data: { vendor_id: 0 },
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(response) {
                    $('.vendor-modal-body').html(response);
                    $('#vendor-modal').modal('show');

                    $('#vendor-modal').one('shown.bs.modal', function() {
                        ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
                            if (document.querySelector(selector)) {
                                new Choices(selector, { searchEnabled: true, itemSelectText: '' });
                            }
                        });
                    });

                    $('#id_notes').summernote({ placeholder: 'Enter notes...', height: 120, toolbar: SN_TOOLBAR });
                    $('#id_terms').summernote({ placeholder: 'Enter terms...', height: 120, toolbar: SN_TOOLBAR });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

        // "Add New Discount / Tax" options inside item rows
        $(document).on("change", ".discount-select", function() {
            if ($(this).val() === "new") {
                $(this).val("0");
                $.ajax({
                    url: "{{ route('discount.add') }}",
                    type: 'GET',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(response) {
                        $('.discount-modal-body').html(response);
                        $('#discount-modal').modal('show');
                    }
                });
            } else {
                calculatebill();
            }
        });

        $(document).on("change", ".tax-select", function() {
            if ($(this).val() === "new") {
                $(this).val("0");
                $.ajax({
                    url: "{{ route('tax.add') }}",
                    type: 'GET',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(response) {
                        $('.tax-modal-body').html(response);
                        $('#tax-modal').modal('show');
                    }
                });
            } else {
                calculatebill();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ===== Items + calculation ===== --}}
    <script>
        function addItemRow() {
            itemCount++;
            const n = itemCount;

            const row = document.createElement('div');
            row.className = 'ie-item';
            row.setAttribute('data-item-id', n);

            row.innerHTML = `
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
          <label class="ie-lbl" for="item-${n}">Item / Service</label>
          <input type="text" name="item[${n}][name]" class="form-control form-control-sm add-items" autocomplete="off"
                 id="item-${n}" item-id="${n}" placeholder="Search product or type manually">
          <div id="item-list-${n}" class="list-group ie-suggest"></div>
        </div>

        <div class="f-hsn">
          <label class="ie-lbl">HSN/SAC</label>
          <input type="text" name="item[${n}][hsn]" placeholder="HSN/SAC" oninput="calculatebill()" class="form-control form-control-sm hsn">
        </div>

        <div class="f-qty">
          <label class="ie-lbl">Qty</label>
          <input type="number" name="item[${n}][quantity]" placeholder="Qty" oninput="calculatebill()" class="form-control form-control-sm quantity">
        </div>

        <div class="f-rate">
          <label class="ie-lbl">Rate</label>
          <input type="number" name="item[${n}][rate]" placeholder="Rate" oninput="calculatebill()" class="form-control form-control-sm rate">
        </div>

        <div class="f-disc">
          <label class="ie-lbl">Discount</label>
          <div class="input-group input-group-sm w-100">
            <select name="item[${n}][discount]" class="form-select discount-select flex-grow-1">
              ${discountOptions}
              <option value="new">➕ Add New Discount</option>
            </select>
            <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
          </div>
        </div>

        <div class="f-tax">
          <label class="ie-lbl">GST</label>
          <div class="input-group input-group-sm w-100">
            <select name="item[${n}][tax]" class="form-select tax-select flex-grow-1">
              ${taxOptions}
              <option value="new">➕ Add New Tax</option>
            </select>
            <span class="input-group-text tax-amount">+${currencySymbol}0.00</span>
          </div>
        </div>

        <div class="f-amt">
          <label class="ie-lbl">Amount</label>
          <input type="text" name="item[${n}][amount]" placeholder="Amount" class="form-control form-control-sm amount" readonly>
        </div>

      </div>

      <div class="ie-item-desc">
        <textarea class="id_description form-control form-control-sm" name="item[${n}][description]" placeholder="Item Description" rows="2"></textarea>
      </div>

      <input type="hidden" name="item[${n}][item_id]" id="hidden-item-id-${n}" value="">
    `;

            document.getElementById('form-container').appendChild(row);
            if (window.lucide) lucide.createIcons();

            $(row).find('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 90,
                toolbar: [['style', ['bold', 'italic', 'underline']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]]
            });

            calculatebill();
        }

        function removeRow(button) {
            const itemBlock = button.closest('[data-item-id]');
            if (itemBlock) itemBlock.remove();
            calculatebill();
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

        function calculatebill() {
            let subtotal = 0, totalDiscount = 0, totalTax = 0, totalTaxable = 0;
            let totalCgst = 0, totalSgst = 0, totalIgst = 0;
            let totalQty = 0;

            const isRcm = $('#reverse_charge').is(':checked');

            // Supplier state vs Place of Supply (falls back to your own state)
            const pos = $('#place_of_supply').val() || $('#user_state_id').val();
            const isSameState = String(pos) === String($('#vendor_state_id').val());

            $('.same-state-class').toggleClass('d-none', !isSameState);
            $('.diffrent-state-class').toggleClass('d-none', isSameState);

            const items = document.querySelectorAll('[data-item-id]');
            items.forEach((item) => {
                const quantity = parseFloat(item.querySelector('.quantity').value || 0);
                const rate = parseFloat(item.querySelector('.rate').value || 0);
                const discountPercent = parseFloat(item.querySelector('.discount-select').value || 0);
                const taxPercent = parseFloat(item.querySelector('.tax-select').value || 0);

                const base = quantity * rate;
                const discount = (discountPercent / 100) * base;
                const taxable = base - discount;

                const cgstPercent = isSameState ? taxPercent / 2 : 0;
                const sgstPercent = isSameState ? taxPercent / 2 : 0;
                const igstPercent = isSameState ? 0 : taxPercent;

                const cgst = (taxable * cgstPercent) / 100;
                const sgst = (taxable * sgstPercent) / 100;
                const igst = (taxable * igstPercent) / 100;

                const tax = (taxPercent / 100) * taxable;
                // RCM mein vendor ki line amount = sirf taxable
                const amount = isRcm ? taxable : taxable + tax;

                const discountSpan = item.querySelector('.discount-amount');
                const taxSpan = item.querySelector('.tax-amount');
                if (discountSpan) discountSpan.innerText = `−${currencySymbol}${discount.toFixed(2)}`;
                if (taxSpan) taxSpan.innerText = `${isRcm ? 'RCM ' : '+'}${currencySymbol}${tax.toFixed(2)}`;

                item.querySelector('.amount').value = `${currencySymbol}${amount.toFixed(2)}`;

                subtotal += base;
                totalDiscount += discount;
                totalTax += tax;
                totalTaxable += taxable;
                totalCgst += cgst;
                totalSgst += sgst;
                totalIgst += igst;
                totalQty += quantity;
            });

            // Total purchase value (GST shamil) aur vendor ko dena wala amount alag hain
            const grandTotal = totalTaxable + totalTax;
            const vendorPayable = isRcm ? totalTaxable : grandTotal;
            const roundedPayable = Math.round(vendorPayable);
            const roundOff = (roundedPayable - vendorPayable).toFixed(2);
            const roundOffNum = parseFloat(roundOff);
            const rcmTax = isRcm ? totalTax : 0;

            const fmt = (n) => `${currencySymbol}${n.toFixed(2)}`;

            $('.rcm-class').toggleClass('d-none', !isRcm);
            $('#rcm-note').toggleClass('d-none', !isRcm);
            $('#grand-total-label').text(isRcm ? 'Total Purchase Value (incl. RCM GST)' : 'Grand Total');
            $('#total-tax-label').text(isRcm ? 'Total Tax (RCM)' : 'Total Tax');
            $('#payable-label').text(isRcm ? 'Payable to Vendor' : 'Amount Payable');

            $('#sum-items').text(items.length);
            $('#sum-qty').text(Number.isInteger(totalQty) ? totalQty : totalQty.toFixed(2));

            $('#subtotal').text(fmt(subtotal));
            $('#total-discount').text(`−${fmt(totalDiscount)}`);
            $('#taxable-value').text(fmt(totalTaxable));
            $('#total-cgst').text(fmt(totalCgst));
            $('#total-sgst').text(fmt(totalSgst));
            $('#total-igst').text(fmt(totalIgst));
            $('#total-tax').text(fmt(totalTax));
            $('#grand-total').text(fmt(grandTotal));
            $('#rcm-tax').text(fmt(rcmTax));

            // Round-off (+ = added, − = subtracted)
            const $roundRow = $('#round-off-row').removeClass('is-plus is-minus');
            if (roundOffNum > 0) {
                $('#round-off').text(`+${fmt(roundOffNum)}`);
                $roundRow.addClass('is-plus');
                $('#round-off-note').text('Added to reach the nearest whole amount');
            } else if (roundOffNum < 0) {
                $('#round-off').text(`−${fmt(Math.abs(roundOffNum))}`);
                $roundRow.addClass('is-minus');
                $('#round-off-note').text('Subtracted to reach the nearest whole amount');
            } else {
                $('#round-off').text(fmt(0));
                $('#round-off-note').text('No rounding needed');
            }

            $('#remaining-balance').text(fmt(roundedPayable));
            $('#total-words').text(amountInWords(roundedPayable));

            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));
            $("#hidden_total_taxable").val(totalTaxable.toFixed(2));
            $("#hidden_total_cgst").val(totalCgst.toFixed(2));
            $("#hidden_total_sgst").val(totalSgst.toFixed(2));
            $("#hidden_total_igst").val(totalIgst.toFixed(2));
            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));
            $("#hidden_rcm_tax").val(rcmTax.toFixed(2));
            $("#hidden_total_due").val(roundedPayable.toFixed(2));
            $("#hidden_round_off").val(roundOff);
        }

        function validateInputNumber(input) {
            if (input.value < 0) input.value = 0;
        }
    </script>

    {{-- ===== Bill draft autosave (localStorage) ===== --}}
    <script>
        // ======================================================================
        // - saves the form automatically while the user types
        // - on next visit asks: Restore Draft / Start Fresh
        // - cleared automatically after the bill is saved successfully
        // ======================================================================
        (function() {
            const DRAFT_KEY = 'invoicezy_add_bill_draft_v1_{{ auth()->id() }}';
            const DRAFT_TTL = 7 * 24 * 60 * 60 * 1000; // draft expires after 7 days
            let restoring = false;
            let lastSaved = '';
            let timer = null;

            // summernote returns <p><br></p> when empty -> treat as empty string
            const cleanHtml = (h) => (!h || h === '<p><br></p>' || h === '<br>') ? '' : h;

            function collectItems() {
                return $('#form-container [data-item-id]').map(function() {
                    const $r = $(this);
                    return {
                        name: $r.find('.add-items').val() || '',
                        hsn: $r.find('.hsn').val() || '',
                        qty: $r.find('.quantity').val() || '',
                        rate: $r.find('.rate').val() || '',
                        discount: $r.find('.discount-select').val() || '0',
                        discount_id: $r.find('.discount-select option:selected').attr('discount-id') || '',
                        tax: $r.find('.tax-select').val() || '0',
                        tax_id: $r.find('.tax-select option:selected').attr('tax-id') || '',
                        description: cleanHtml($r.find('.id_description').summernote('code')),
                        item_id: $r.find('input[type="hidden"][name$="[item_id]"]').val() || ''
                    };
                }).get();
            }

            function collectRecurring() {
                const out = {};
                $('#recurringOptions :input').each(function() {
                    const key = this.name || this.id;
                    if (!key) return;
                    out[key] = (this.type === 'checkbox' || this.type === 'radio') ? this.checked : $(this).val();
                });
                return out;
            }

            function collectDraft() {
                return {
                    ts: Date.now(),
                    vendor: {
                        text: $('#vendor').val() || '',
                        id: $('#vendor_id').val() || '',
                        state_id: $('#vendor_state_id').val() || '',
                        address_html: $('#vendorAddress').is(':visible') ? $('#vendorAddress').html() : ''
                    },
                    currency_code: $('#currency_code').val() || '',
                    template_id: $('#template_id').val() || '',
                    bill_date: $('#bill_date').val() || '',
                    due_date: $('#due_date').val() || '',
                    vendor_invoice_number: $('#vendor_invoice_number').val() || '',
                    vendor_invoice_date: $('#vendor_invoice_date').val() || '',
                    place_of_supply: $('#place_of_supply').val() || '',
                    itc_eligibility: $('#itc_eligibility').val() || '',
                    reverse_charge: $('#reverse_charge').is(':checked'),
                    is_recurring: $('#is_recurring').is(':checked'),
                    recurring: collectRecurring(),
                    notes: cleanHtml($('#id_bill_notes').summernote('code')),
                    items: collectItems()
                };
            }

            // only save when the user has actually entered something meaningful
            function isMeaningful(d) {
                return !!(d.vendor && d.vendor.id) ||
                    !!d.vendor_invoice_number ||
                    (d.items || []).some(function(i) {
                        return i.name || i.rate || i.qty || i.description;
                    });
            }

            function setStatus(text) {
                $('#draft-status').text(text);
            }

            function saveDraftNow() {
                if (restoring) return;
                try {
                    const d = collectDraft();
                    if (!isMeaningful(d)) {
                        localStorage.removeItem(DRAFT_KEY);
                        lastSaved = '';
                        setStatus('');
                        return;
                    }
                    const json = JSON.stringify(Object.assign({}, d, {
                        ts: 0
                    })); // compare without timestamp
                    if (json === lastSaved) return; // nothing changed
                    lastSaved = json;
                    localStorage.setItem(DRAFT_KEY, JSON.stringify(d));
                    setStatus('Draft saved ' + new Date().toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }));
                } catch (e) {
                    console.warn('Draft save failed', e); // storage full / private mode
                }
            }

            function scheduleSave() {
                clearTimeout(timer);
                timer = setTimeout(saveDraftNow, 500);
            }

            // called after the bill is saved successfully
            window.clearBillDraft = function() {
                clearTimeout(timer);
                restoring = true; // block any further autosave
                try {
                    localStorage.removeItem(DRAFT_KEY);
                } catch (e) {}
            };

            function setDate(selector, value) {
                const el = document.querySelector(selector);
                if (!el || !value) return;
                if (el._flatpickr) el._flatpickr.setDate(value, true);
                else el.value = value;
            }

            function restoreDraft(d) {
                restoring = true;
                try {
                    // vendor
                    if (d.vendor && d.vendor.id) {
                        $('#vendor').val(d.vendor.text);
                        $('#vendor_id').val(d.vendor.id);
                        $('#vendor_state_id').val(d.vendor.state_id);
                        $('#vendorAddress').html(d.vendor.address_html).show();
                        $('#vendorSearchBox').hide();
                        $('.change-vendor').show();
                        $('.new-vendor').hide();
                    }

                    if (d.currency_code) $('#currency_code').val(d.currency_code).trigger('change');
                    if (d.template_id) $('#template_id').val(d.template_id).trigger('change');

                    // dates
                    setDate('#bill_date', d.bill_date);
                    setDate('#due_date', d.due_date);
                    setDate('#vendor_invoice_date', d.vendor_invoice_date);

                    // GST & compliance
                    $('#vendor_invoice_number').val(d.vendor_invoice_number || '');
                    if (d.place_of_supply) $('#place_of_supply').val(d.place_of_supply).trigger('change');
                    if (d.itc_eligibility) $('#itc_eligibility').val(d.itc_eligibility).trigger('change');
                    $('#reverse_charge').prop('checked', !!d.reverse_charge);

                    // recurring: set the fields first, then fire the change handlers
                    if (d.recurring) {
                        $('#recurringOptions :input').each(function() {
                            const key = this.name || this.id;
                            if (!key || !(key in d.recurring)) return;
                            if (this.type === 'checkbox' || this.type === 'radio') this.checked = !!d.recurring[key];
                            else $(this).val(d.recurring[key]);
                        });
                    }
                    if (d.is_recurring) {
                        $('#is_recurring').prop('checked', true).trigger('change');
                        $('#frequency').trigger('change');
                    }

                    // notes
                    if (d.notes) $('#id_bill_notes').summernote('code', d.notes);

                    // items: replace the empty starter row with the saved rows
                    $('#form-container').empty();
                    (d.items || []).forEach(function(it) {
                        addItemRow();
                        const $r = $('#form-container [data-item-id]').last();

                        $r.find('.add-items').val(it.name);
                        $r.find('.hsn').val(it.hsn);
                        $r.find('.quantity').val(it.qty);
                        $r.find('.rate').val(it.rate);

                        if (it.discount_id) $r.find('.discount-select option[discount-id="' + it.discount_id + '"]').prop('selected', true);
                        else $r.find('.discount-select').val(it.discount);

                        if (it.tax_id) $r.find('.tax-select option[tax-id="' + it.tax_id + '"]').prop('selected', true);
                        else $r.find('.tax-select').val(it.tax);

                        if (it.description) {
                            $r.find('.id_description').summernote('code', it.description);
                            $r.find('.ie-item-desc, .ie-desc-toggle').addClass('is-open');
                        }

                        // keep the inventory item link (hidden input already exists in each row)
                        if (it.item_id) {
                            $r.find('input[type="hidden"][name$="[item_id]"]').val(it.item_id);
                        }
                    });

                    // always keep at least one row available
                    if ($('#form-container [data-item-id]').length === 0) addItemRow();

                    calculatebill();
                } catch (e) {
                    console.error('Draft restore failed', e);
                } finally {
                    setTimeout(function() {
                        restoring = false;
                        lastSaved = '';
                        saveDraftNow();
                    }, 900);
                }
            }

            function loadDraft() {
                let raw = null;
                try {
                    raw = localStorage.getItem(DRAFT_KEY);
                } catch (e) {
                    return null;
                }
                if (!raw) return null;
                try {
                    const d = JSON.parse(raw);
                    if (!d.ts || Date.now() - d.ts > DRAFT_TTL || !isMeaningful(d)) {
                        localStorage.removeItem(DRAFT_KEY);
                        return null;
                    }
                    return d;
                } catch (e) {
                    localStorage.removeItem(DRAFT_KEY);
                    return null;
                }
            }

            $(window).on('load', function() {
                const draft = loadDraft();

                if (draft) {
                    setTimeout(function() {
                        const when = new Date(draft.ts).toLocaleString([], {
                            day: '2-digit',
                            month: 'short',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        Swal.fire({
                            icon: 'question',
                            title: 'Unsaved Bill Found',
                            text: 'You have an unfinished bill draft from ' + when + '. Do you want to restore it?',
                            showDenyButton: true,
                            confirmButtonText: 'Restore Draft',
                            denyButtonText: 'Start Fresh',
                            allowOutsideClick: false
                        }).then(function(res) {
                            if (res.isConfirmed) {
                                restoreDraft(draft);
                            } else {
                                try {
                                    localStorage.removeItem(DRAFT_KEY);
                                } catch (e) {}
                            }
                        });
                    }, 600);
                }

                // autosave triggers
                $(document).on('input change keyup', '#bill-generate :input', scheduleSave);
                $(document).on('summernote.change', '.id_description, #id_bill_notes', scheduleSave);
                $(document).on('click', '#vendorList a, .change-vendor, .remove-item-btn, #add-item-btn, .select-item', function() {
                    setTimeout(scheduleSave, 300);
                });

                // safety net: check every 4 sec (writes only if something changed)
                setInterval(saveDraftNow, 4000);

                // browser close / tab switch / mobile app going to background
                document.addEventListener('visibilitychange', function() {
                    if (document.visibilityState === 'hidden') saveDraftNow();
                });
                window.addEventListener('pagehide', saveDraftNow);
            });
        })();
    </script>

</x-default-layout>