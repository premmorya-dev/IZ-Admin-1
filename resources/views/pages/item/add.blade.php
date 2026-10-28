<style>
    .item-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .item-form-wrap .ie-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:16px;flex-wrap:wrap;padding:20px 24px;border-radius:22px;color:#fff;margin-bottom:22px;
        background:radial-gradient(600px 220px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(420px 220px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .item-form-wrap .ie-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .item-form-wrap .ie-head > *{position:relative;z-index:1}
    .item-form-wrap .ie-av{flex:none;width:54px;height:54px;border-radius:16px;display:grid;place-items:center;font-size:20px;font-weight:800;color:#fff;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .item-form-wrap .ie-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .item-form-wrap .ie-head h4{margin:0;color:#fff;font-size:20px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .item-form-wrap .ie-chips{margin-left:auto;display:flex;gap:8px;flex-wrap:wrap}
    .item-form-wrap .ie-chip{display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:99px;font-size:12.5px;font-weight:600;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .item-form-wrap .ie-chip.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}
    .item-form-wrap .ie-chip.off{background:rgba(251,113,133,.18);border-color:rgba(251,113,133,.4);color:#fda4af}

    /* ---------- layout ---------- */
    .item-form-wrap .ie-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:24px;align-items:start}
    .item-form-wrap .ie-side{position:sticky;top:8px;display:grid;gap:24px}

    /* ---------- cards ---------- */
    .item-form-wrap .ie-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22);margin-bottom:24px}
    .item-form-wrap .ie-side .ie-card{margin-bottom:0}
    .item-form-wrap .ie-card-h{display:flex;align-items:center;gap:14px;padding:18px 24px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .item-form-wrap .ie-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;box-shadow:0 10px 18px -10px rgba(var(--rgb),.7)}
    .item-form-wrap .ie-chipi.c1{--rgb:79,70,229;background:linear-gradient(135deg,#4f46e5,#818cf8)}
    .item-form-wrap .ie-chipi.c2{--rgb:16,185,129;background:linear-gradient(135deg,#059669,#34d399)}
    .item-form-wrap .ie-chipi.c3{--rgb:14,165,233;background:linear-gradient(135deg,#0284c7,#38bdf8)}
    .item-form-wrap .ie-chipi.c4{--rgb:245,158,11;background:linear-gradient(135deg,#d97706,#fbbf24)}
    /* heading icons hamesha white (theme ka global icon color override na kar sake) */
    .item-form-wrap .ie-chipi,
    .item-form-wrap .ie-chipi i,
    .item-form-wrap .ie-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .item-form-wrap .ie-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .item-form-wrap .ie-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .item-form-wrap .ie-card-b{padding:24px}

    /* ---------- fields ---------- */
    .item-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .item-form-wrap .ie-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .item-form-wrap .req{color:#f43f5e;margin-left:-3px}
    .item-form-wrap .ie-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .item-form-wrap .ie-help:hover{background:#6366f1;color:#fff}
    .item-form-wrap .form-control,.item-form-wrap .form-select{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .item-form-wrap textarea.form-control{min-height:96px;resize:vertical;padding-top:12px}
    .item-form-wrap .form-control::placeholder{color:#a3b0c2}
    .item-form-wrap .form-control:focus,.item-form-wrap .form-select:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .item-form-wrap .form-control.is-invalid,.item-form-wrap .form-select.is-invalid{border-color:#f43f5e;background-image:none}
    .item-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .item-form-wrap input[type=number]::-webkit-outer-spin-button,.item-form-wrap input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .item-form-wrap input[type=number]{-moz-appearance:textfield}

    /* ---------- pricing grids ---------- */
    .item-form-wrap .ie-pricing{container-type:inline-size;container-name:iepricing}
    .item-form-wrap .ie-fgrid{display:grid;gap:22px 20px;align-items:start}
    .item-form-wrap .ie-fgrid.g2{grid-template-columns:repeat(2,minmax(0,1fr))}
    .item-form-wrap .ie-fgrid.g3{grid-template-columns:repeat(3,minmax(0,1fr))}
    .item-form-wrap .ie-fgrid + .ie-fgrid{margin-top:22px}
    .item-form-wrap .ie-pricing .form-label{white-space:nowrap}
    .item-form-wrap .ie-field{min-width:0}

    /* price input: ₹ chip + number ek hi box me */
    .item-form-wrap .ie-money{display:flex;align-items:stretch;height:48px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;overflow:hidden;transition:.2s}
    .item-form-wrap .ie-money .cur{flex:none;width:46px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:var(--i1);font-weight:800;font-size:15px;line-height:1;border-right:1.5px solid #e0e7ff}
    .item-form-wrap .ie-money .form-control{flex:1;min-width:0;height:100%;min-height:0;border:0;border-radius:0;background:transparent;box-shadow:none;padding:0 14px;font-weight:600;font-variant-numeric:tabular-nums;line-height:normal}
    .item-form-wrap .ie-money .form-control:focus{background:transparent;box-shadow:none;border:0}
    .item-form-wrap .ie-money .form-control.is-invalid{border:0;background-image:none}
    .item-form-wrap .ie-money:focus-within{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .item-form-wrap .ie-money:focus-within .cur{background:#e0e7ff}
    .item-form-wrap .ie-money.is-invalid{border-color:#f43f5e}

    /* margin box */
    .item-form-wrap .ie-margin{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-top:22px;padding:14px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .item-form-wrap .ie-margin .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;color:var(--i1);box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .item-form-wrap .ie-margin small{display:block;font-size:12px;color:var(--mut);font-weight:600}
    .item-form-wrap .ie-margin b{display:block;font-size:17px;font-weight:800;color:var(--ink);letter-spacing:-.01em}
    .item-form-wrap .ie-margin .pill{margin-left:auto;padding:6px 14px;border-radius:99px;font-size:13px;font-weight:800;background:#fff;color:#64748b}
    .item-form-wrap .ie-margin.pos .pill{background:#ecfdf5;color:#047857}
    .item-form-wrap .ie-margin.pos b{color:#047857}
    .item-form-wrap .ie-margin.neg .pill{background:#fff1f2;color:#be123c}
    .item-form-wrap .ie-margin.neg b{color:#be123c}

    /* segmented (type) */
    .item-form-wrap .ie-seg{display:grid;grid-template-columns:1fr 1fr;gap:6px;padding:5px;border-radius:14px;background:#f1f5f9}
    .item-form-wrap .ie-seg button{display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border:0;border-radius:10px;background:transparent;color:#64748b;font-weight:700;font-size:13.5px;cursor:pointer;transition:.2s}
    .item-form-wrap .ie-seg button:hover{color:var(--i1)}
    .item-form-wrap .ie-seg button.on{background:#fff;color:var(--i1);box-shadow:0 6px 14px -8px rgba(15,23,42,.35),inset 0 0 0 1.5px #c7d2fe}

    /* status switch */
    .item-form-wrap .ie-switch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 16px;border-radius:14px;border:1.5px solid #e2e8f0;background:#f8fafc;transition:.2s}
    .item-form-wrap .ie-switch.on{border-color:#a7f3d0;background:#ecfdf5}
    .item-form-wrap .ie-switch .tx b{display:block;font-size:14px;color:var(--ink)}
    .item-form-wrap .ie-switch .tx small{font-size:12px;color:var(--mut)}
    .item-form-wrap .ie-switch .form-check-input{width:2.9em;height:1.5em;margin:0;cursor:pointer;flex:none}
    .item-form-wrap .ie-switch .form-check-input:checked{background-color:#10b981;border-color:#10b981}

    .item-form-wrap .ie-hide{display:none!important}
    .item-form-wrap .ie-soft-off{opacity:.45;transition:.2s}
    .item-form-wrap .ie-note{display:none;margin-top:7px;font-size:12px;color:#b45309;font-weight:600;white-space:normal}
    .item-form-wrap .ie-soft-off .ie-note{display:block}

    /* ---------- responsive ---------- */
    @container iepricing (max-width:540px){
        .item-form-wrap .ie-fgrid.g2,
        .item-form-wrap .ie-fgrid.g3{grid-template-columns:1fr}
    }
    @media (max-width:991px){
        .item-form-wrap .ie-grid{grid-template-columns:1fr}
        .item-form-wrap .ie-side{position:static}
    }
    @media (max-width:575px){
        .item-form-wrap .ie-fgrid.g2,
        .item-form-wrap .ie-fgrid.g3{grid-template-columns:1fr}
        .item-form-wrap .ie-head{padding:18px}
        .item-form-wrap .ie-head h4{font-size:17px}
        .item-form-wrap .ie-chips{margin-left:0;width:100%}
        .item-form-wrap .ie-card-h,.item-form-wrap .ie-card-b{padding-left:18px;padding-right:18px}
        .item-form-wrap .ie-margin .pill{margin-left:0}
    }
</style>

@php
    $iType = old('item_type', 'product');
    $iStat = old('status', 'Y');
    $iName = old('item_name', '');
    $iInit = mb_strtoupper(mb_substr(trim($iName) ?: 'N', 0, 1));
@endphp

<div class="item-form-wrap">
    <form action="{{ route('item.store') }}" id="item-form" method="POST" enctype="multipart/form-data">

        <!-- HEADER -->
        <div class="ie-head">
            <div class="ie-av" id="ie_av">{{ $iInit }}</div>
            <div style="min-width:0">
                <small>New item</small>
                <h4 id="ie_title">{{ $iName ?: 'Untitled item' }}</h4>
            </div>
            <div class="ie-chips">
                <span class="ie-chip" id="ie_type_chip"><i class="fas fa-cube"></i> <span>{{ $iType == 'service' ? 'Service' : 'Product' }}</span></span>
                <span class="ie-chip {{ $iStat == 'Y' ? 'on' : 'off' }}" id="ie_status_chip"><i class="fas fa-circle" style="font-size:7px"></i> <span>{{ $iStat == 'Y' ? 'Active' : 'Inactive' }}</span></span>
            </div>
        </div>

        <div class="ie-grid">

            <!-- ============ LEFT: main fields ============ -->
            <div>

                <!-- Basic Info -->
                <div class="ie-card">
                    <div class="ie-card-h">
                        <div class="ie-chipi c1"><i class="fas fa-info-circle"></i></div>
                        <div><h6>Basic information</h6><span>Name, description &amp; category</span></div>
                    </div>
                    <div class="ie-card-b">
                        <div class="row g-4">
                            <div class="col-12 ie-field">
                                <label class="form-label" for="id_item_name">
                                    <i class="fas fa-tag ie-li"></i>Name<span class="req">*</span>
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="This name will appear on the invoice and item list shown to customers.">?</button>
                                </label>
                                <input type="text" name="item_name" id="id_item_name" value="{{ old('item_name') }}" class="form-control" placeholder="e.g. Premium Website Design">
                            </div>

                            <div class="col-md-6 ie-field">
                                <label for="item_category_id" class="form-label">
                                    <i class="fas fa-layer-group ie-li"></i>Category
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Group similar items together for easier organization.">?</button>
                                </label>
                                <select id="item_category_id" name="item_category_id" class="form-select">
                                    <option value="0">-- Select --</option>
                                    @foreach($data['item_categories'] as $item_categories )
                                    <option value="{{ $item_categories->item_category_id }}" {{ old('item_category_id') == $item_categories->item_category_id ? 'selected' : '' }}>{{ $item_categories->item_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 ie-field">
                                <label class="form-label" for="id_sku">
                                    <i class="fas fa-barcode ie-li"></i>SKU
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Your own internal stock or tracking code. Optional.">?</button>
                                </label>
                                <input type="text" name="sku" id="id_sku" value="{{ old('sku') }}" class="form-control" placeholder="e.g. SKU-00123">
                            </div>

                            <div class="col-12 ie-field">
                                <label class="form-label" for="id_description">
                                    <i class="fas fa-align-left ie-li"></i>Description
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Optional. A short detail about the item, may also appear on the invoice PDF.">?</button>
                                </label>
                                <textarea name="description" id="id_description" class="form-control" placeholder="Brief description of the item" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="ie-card">
                    <div class="ie-card-h">
                        <div class="ie-chipi c2"><i class="fas fa-tags"></i></div>
                        <div><h6>Pricing &amp; stock</h6><span>Tax code, price &amp; inventory</span></div>
                    </div>
                    <div class="ie-card-b">
                        <div class="ie-pricing">

                            <!-- HSN + Stock -->
                            <div class="ie-fgrid g2">
                                <div class="ie-field">
                                    <label class="form-label" for="id_hsn_sac">
                                        <i class="fas fa-hashtag ie-li"></i>HSN/SAC<span class="req">*</span>
                                        <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Required for GST invoices. Use HSN code for products, SAC code for services.">?</button>
                                    </label>
                                    <input type="number" name="hsn_sac" id="id_hsn_sac" value="{{ old('hsn_sac') }}" class="form-control" placeholder="HSN/SAC code">
                                </div>

                                <div class="ie-field {{ $iType == 'service' ? 'ie-soft-off' : '' }}" id="ie_stock_field">
                                    <label class="form-label" for="id_stock">
                                        <i class="fas fa-boxes-stacked ie-li"></i>Stock<span class="req">*</span>
                                        <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Current available quantity. Updates automatically as sales happen.">?</button>
                                    </label>
                                    <input type="number" name="stock" id="id_stock" value="{{ old('stock') }}" class="form-control" placeholder="Available quantity">
                                    <div class="ie-note"><i class="fas fa-circle-info"></i> Stock is not tracked for services.</div>
                                </div>
                            </div>

                            <!-- Unit / Purchase / Selling price -->
                            <div class="ie-fgrid g3">
                                <div class="ie-field">
                                    <label class="form-label" for="id_unit_price">
                                        <i class="fas fa-indian-rupee-sign ie-li"></i>Unit price<span class="req">*</span>
                                        <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="The default rate used when this item is added to an invoice.">?</button>
                                    </label>
                                    <div class="ie-money">
                                        <span class="cur">₹</span>
                                        <input type="number" step="any" name="unit_price" id="id_unit_price" value="{{ old('unit_price') }}" class="form-control" placeholder="0.00">
                                    </div>
                                </div>

                                <div class="ie-field">
                                    <label class="form-label" for="id_cost_price">
                                        <i class="fas fa-cart-shopping ie-li"></i>Purchase price
                                        <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="What this item costs you. Used to calculate your profit margin.">?</button>
                                    </label>
                                    <div class="ie-money">
                                        <span class="cur">₹</span>
                                        <input type="number" step="any" name="cost_price" id="id_cost_price" value="{{ old('cost_price') }}" class="form-control" placeholder="0.00">
                                    </div>
                                </div>

                                <div class="ie-field">
                                    <label class="form-label" for="id_selling_price">
                                        <i class="fas fa-money-bill-trend-up ie-li"></i>Selling price
                                        <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Use this if you want a selling price different from the unit price.">?</button>
                                    </label>
                                    <div class="ie-money">
                                        <span class="cur">₹</span>
                                        <input type="number" step="any" name="selling_price" id="id_selling_price" value="{{ old('selling_price') }}" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                            </div>

                            <!-- live margin -->
                            <div class="ie-margin" id="ie_margin">
                                <span class="mi"><i class="fas fa-chart-line"></i></span>
                                <div>
                                    <small id="ie_margin_label">Estimated profit per unit</small>
                                    <b id="ie_margin_val">Add purchase price to see your margin</b>
                                </div>
                                <span class="pill" id="ie_margin_pill" style="display:none"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ RIGHT: sidebar ============ -->
            <div class="ie-side">

                <div class="ie-card">
                    <div class="ie-card-h">
                        <div class="ie-chipi c3"><i class="fas fa-sliders-h"></i></div>
                        <div><h6>Type &amp; status</h6><span>Item type &amp; visibility</span></div>
                    </div>
                    <div class="ie-card-b">
                        <div class="row g-4">
                            <div class="col-12 ie-field">
                                <label class="form-label">
                                    <i class="fas fa-cube ie-li"></i>Type
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose Service to hide or ignore stock tracking for this item.">?</button>
                                </label>
                                <div class="ie-seg" id="ie_seg">
                                    <button type="button" data-v="product" class="{{ $iType != 'service' ? 'on' : '' }}"><i class="fas fa-box"></i> Product</button>
                                    <button type="button" data-v="service" class="{{ $iType == 'service' ? 'on' : '' }}"><i class="fas fa-screwdriver-wrench"></i> Service</button>
                                </div>
                                <select name="item_type" id="id_item_type" class="ie-hide">
                                    <option value="product" {{ $iType == 'product' ? 'selected' : '' }}>Product</option>
                                    <option value="service" {{ $iType == 'service' ? 'selected' : '' }}>Service</option>
                                </select>
                            </div>

                            <div class="col-12 ie-field">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on ie-li"></i>Status
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivated items will not appear in the invoice creation list.">?</button>
                                </label>
                                <div class="ie-switch form-check form-switch {{ $iStat == 'Y' ? 'on' : '' }}" id="ie_switch">
                                    <div class="tx">
                                        <b id="ie_status_txt">{{ $iStat == 'Y' ? 'Active' : 'Inactive' }}</b>
                                        <small>Shown in invoice item list</small>
                                    </div>
                                    <input class="form-check-input" type="checkbox" id="ie_status_switch" {{ $iStat == 'Y' ? 'checked' : '' }}>
                                </div>
                                <select name="status" id="id_status" class="ie-hide">
                                    <option value="Y" {{ $iStat == 'Y' ? 'selected' : '' }}>Active</option>
                                    <option value="N" {{ $iStat == 'N' ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ie-card">
                    <div class="ie-card-h">
                        <div class="ie-chipi c4"><i class="fas fa-percentage"></i></div>
                        <div><h6>Tax &amp; discount</h6><span>Applicable tax slab and discount</span></div>
                    </div>
                    <div class="ie-card-b">
                        <div class="row g-4">
                            <div class="col-12 ie-field">
                                <label for="id_tax_id" class="form-label">
                                    <i class="fas fa-receipt ie-li"></i>Tax
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="This tax rate will be auto-applied to this item on invoices.">?</button>
                                </label>
                                <select id="id_tax_id" name="tax_id" class="form-select">
                                    <option value="0">No Tax</option>
                                    @foreach($data['taxes'] as $tax )
                                    <option value="{{ $tax->tax_id }}" {{ old('tax_id') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 ie-field">
                                <label for="id_discount_id" class="form-label">
                                    <i class="fas fa-ticket ie-li"></i>Discount
                                    <button type="button" class="ie-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Optional. A pre-defined discount that will auto-apply to this item.">?</button>
                                </label>
                                <select id="id_discount_id" name="discount_id" class="form-select">
                                    <option value="0">No Discount</option>
                                    @foreach($data['discounts'] as $discount )
                                    <option value="{{ $discount->discount_id }}" {{ old('discount_id') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky save bar -->
        <x-invoice.sticky-actions
            submitText="Add Item"
            submitClass="add-item" />

    </form>
</div>

<script>
(function () {
    var all  = document.querySelectorAll('.item-form-wrap');
    var root = all[all.length - 1];
    if (!root) return;
    var $ = window.jQuery;

    // root ke andar hi dhundo, taaki edit form ke saath ID clash na ho
    function el(id) { return root.querySelector('#' + id); }

    /* ---------- tooltips ---------- */
    if (window.bootstrap) {
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (t) { new bootstrap.Tooltip(t); });
    }

    /* ---------- header live update ---------- */
    el('id_item_name').addEventListener('input', function () {
        var v = this.value.trim();
        el('ie_title').textContent = v || 'Untitled item';
        el('ie_av').textContent = (v ? v.charAt(0) : 'N').toUpperCase();
    });

    /* ---------- type segmented ---------- */
    function setType(v) {
        el('id_item_type').value = v;
        root.querySelectorAll('#ie_seg button').forEach(function (b) { b.classList.toggle('on', b.dataset.v === v); });
        el('ie_type_chip').querySelector('span').textContent = v === 'service' ? 'Service' : 'Product';
        el('ie_stock_field').classList.toggle('ie-soft-off', v === 'service');
    }
    root.querySelectorAll('#ie_seg button').forEach(function (b) {
        b.addEventListener('click', function () { setType(b.dataset.v); });
    });

    /* ---------- status switch ---------- */
    el('ie_status_switch').addEventListener('change', function () {
        var on = this.checked;
        el('id_status').value = on ? 'Y' : 'N';
        el('ie_switch').classList.toggle('on', on);
        el('ie_status_txt').textContent = on ? 'Active' : 'Inactive';
        var chip = el('ie_status_chip');
        chip.classList.toggle('on', on);
        chip.classList.toggle('off', !on);
        chip.querySelector('span').textContent = on ? 'Active' : 'Inactive';
    });

    /* ---------- live profit margin ---------- */
    function num(v) { var n = parseFloat(v); return isNaN(n) ? 0 : n; }
    function money(n) { return '₹' + n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

    function calcMargin() {
        var cost = num(el('id_cost_price').value);
        var sell = num(el('id_selling_price').value) > 0 ? num(el('id_selling_price').value) : num(el('id_unit_price').value);
        var box = el('ie_margin'), val = el('ie_margin_val'), pill = el('ie_margin_pill');

        box.classList.remove('pos', 'neg');
        if (cost > 0 && sell > 0) {
            var profit = sell - cost;
            var pct = (profit / sell) * 100;
            val.textContent = (profit < 0 ? '-' : '') + money(Math.abs(profit));
            pill.style.display = '';
            pill.textContent = (profit < 0 ? '' : '+') + pct.toFixed(1) + '% margin';
            box.classList.add(profit >= 0 ? 'pos' : 'neg');
        } else {
            val.textContent = 'Add purchase price to see your margin';
            pill.style.display = 'none';
        }
    }
    ['id_cost_price', 'id_selling_price', 'id_unit_price'].forEach(function (id) {
        el(id).addEventListener('input', calcMargin);
    });
    calcMargin();

    /* ---------- Enter key => add ---------- */
    el('item-form').addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = root.querySelector('.add-item') || document.querySelector('.add-item');
        if (btn) btn.click();
    });

    /* ---------- AJAX store ---------- */
    if (!$) return;
    $(document).off('click.ieAdd').on('click.ieAdd', '.add-item', function (e) {
        var form = document.getElementById('item-form');
        if (!form) return;
        e.preventDefault();

        var formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your Item.",
            allowOutsideClick: false,
            didOpen: function () { Swal.showLoading(); }
        });

        $.ajax({
            url: form.action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            beforeSend: function () {
                $('#item-form .error').remove();
                $('#item-form .is-invalid').removeClass('is-invalid');
            },
            success: function (response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function (field, messages) {
                        var inputField = $('#item-form #id_' + field);
                        if (!inputField.length) inputField = $('#item-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.ie-money').addClass('is-invalid');

                        var errorHtml = '<div class="text-danger error">' + messages[0] + '</div>';
                        var holder = inputField.closest('.ie-field');
                        if (holder.length) holder.append(errorHtml); else inputField.after(errorHtml);
                    });

                    var first = $('#item-form .error').first();
                    if (first.length && first[0].scrollIntoView) first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please check the form carefully!",
                        position: "center",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Item Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $('#editItem-modal').modal('hide');
                        location.reload();
                    });
                }
            },
            error: function (xhr) {
                Swal.close();

                if (xhr.status === 403 && xhr.responseJSON && xhr.responseJSON.redirect) {
                    window.location.href = xhr.responseJSON.redirect;
                } else {
                    console.error("Error:", xhr.responseText);
                }
            }
        });
    });
})();
</script>