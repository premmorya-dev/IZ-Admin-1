<style>
    .client-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .client-form-wrap .ce-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:16px;flex-wrap:wrap;padding:20px 24px;border-radius:22px;color:#fff;margin-bottom:20px;
        background:radial-gradient(600px 220px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(420px 220px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .client-form-wrap .ce-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .client-form-wrap .ce-head > *{position:relative;z-index:1}
    .client-form-wrap .ce-av{flex:none;width:54px;height:54px;border-radius:16px;display:grid;place-items:center;font-size:20px;font-weight:800;color:#fff;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .client-form-wrap .ce-av i{color:#fff!important;font-size:18px}
    .client-form-wrap .ce-htext{min-width:0}
    .client-form-wrap .ce-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .client-form-wrap .ce-head h4{margin:0;color:#fff;font-size:20px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .client-form-wrap .ce-sub{margin:3px 0 0;color:#c7d2fe;font-size:13px;word-break:break-word}
    .client-form-wrap .ce-hright{margin-left:auto;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .client-form-wrap .ce-chip{display:inline-flex;align-items:center;gap:7px;padding:8px 13px;border-radius:99px;font-size:12.5px;font-weight:600;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .client-form-wrap .ce-chip i{color:inherit!important;font-size:12px}
    .client-form-wrap .ce-dot{flex:none;width:7px;height:7px;border-radius:50%;background:currentColor}
    .client-form-wrap .ce-stat{display:inline-flex;align-items:center;gap:10px;margin:0;padding:5px 8px 5px 14px;border-radius:99px;font-size:12.5px;font-weight:700;cursor:pointer;
        background:rgba(251,113,133,.18);border:1px solid rgba(251,113,133,.4);color:#fda4af;transition:.2s}
    .client-form-wrap .ce-stat.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}

    /* ---------- custom switch ---------- */
    .client-form-wrap .ce-sw{-webkit-appearance:none;appearance:none;flex:none;position:relative;width:46px;height:26px;margin:0;padding:0;border:0;border-radius:99px;background:#cbd5e1;cursor:pointer;transition:.2s;outline:0}
    .client-form-wrap .ce-sw::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.3);transition:.2s}
    .client-form-wrap .ce-sw:checked{background:#10b981}
    .client-form-wrap .ce-sw:checked::after{transform:translateX(20px)}
    .client-form-wrap .ce-sw:focus-visible{box-shadow:0 0 0 4px rgba(99,102,241,.28)}
    .client-form-wrap .ce-sw.ind:checked{background:var(--i1)}
    .client-form-wrap .ce-sw.sm{width:40px;height:24px;background:rgba(255,255,255,.28)}
    .client-form-wrap .ce-sw.sm::after{top:3px;left:3px;width:18px;height:18px}
    .client-form-wrap .ce-sw.sm:checked{background:#10b981}
    .client-form-wrap .ce-sw.sm:checked::after{transform:translateX(16px)}

    /* ---------- tabs ---------- */
    .client-form-wrap .ce-tabs{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:6px;padding:6px;margin-bottom:20px;border-radius:18px;background:#f1f5f9}
    .client-form-wrap .ce-tab{position:relative;display:flex;align-items:center;gap:12px;min-width:0;padding:10px 14px;border:0;border-radius:13px;background:transparent;text-align:left;cursor:pointer;transition:.2s}
    .client-form-wrap .ce-tab:hover{background:rgba(255,255,255,.6)}
    .client-form-wrap .ce-tab.active{background:#fff;box-shadow:0 8px 18px -12px rgba(15,23,42,.4),inset 0 0 0 1.5px #c7d2fe}
    .client-form-wrap .ce-tabi{flex:none;width:36px;height:36px;border-radius:11px;display:grid;place-items:center;font-size:14px;background:#e2e8f0;transition:.2s}
    .client-form-wrap .ce-tabi,.client-form-wrap .ce-tabi i{color:#64748b!important}
    .client-form-wrap .ce-tab.active .ce-tabi{background:linear-gradient(135deg,#4f46e5,#818cf8);box-shadow:0 10px 18px -10px rgba(79,70,229,.7)}
    .client-form-wrap .ce-tab.active .ce-tabi,.client-form-wrap .ce-tab.active .ce-tabi i{color:#fff!important}
    .client-form-wrap .ce-tabt{min-width:0;flex:1}
    .client-form-wrap .ce-tabt b{display:block;font-size:13.5px;font-weight:700;color:#334155;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .client-form-wrap .ce-tabt small{display:block;margin-top:1px;font-size:11.5px;color:var(--mut);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .client-form-wrap .ce-tab.active .ce-tabt b{color:var(--i1)}
    .client-form-wrap .ce-badge{flex:none;padding:3px 9px;border-radius:99px;font-size:11px;font-weight:800;background:#e2e8f0;color:#64748b}
    .client-form-wrap .ce-badge.on{background:#ecfdf5;color:#047857}
    .client-form-wrap .ce-tab.has-error::after{content:"";position:absolute;top:9px;right:9px;width:9px;height:9px;border-radius:50%;background:#f43f5e;box-shadow:0 0 0 3px #fff}

    /* ---------- panels & cards ---------- */
    .client-form-wrap .ce-panel{display:none}
    .client-form-wrap .ce-panel.active{display:block;animation:ceIn .25s ease}
    @keyframes ceIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
    @media (prefers-reduced-motion:reduce){.client-form-wrap .ce-panel.active{animation:none}}
    .client-form-wrap .ce-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .client-form-wrap .ce-card-h{display:flex;align-items:center;gap:14px;padding:18px 24px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .client-form-wrap .ce-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;box-shadow:0 10px 18px -10px rgba(var(--rgb),.7)}
    .client-form-wrap .ce-chipi.c1{--rgb:79,70,229;background:linear-gradient(135deg,#4f46e5,#818cf8)}
    .client-form-wrap .ce-chipi.c2{--rgb:16,185,129;background:linear-gradient(135deg,#059669,#34d399)}
    .client-form-wrap .ce-chipi.c4{--rgb:245,158,11;background:linear-gradient(135deg,#d97706,#fbbf24)}
    .client-form-wrap .ce-chipi,
    .client-form-wrap .ce-chipi i,
    .client-form-wrap .ce-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .client-form-wrap .ce-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .client-form-wrap .ce-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .client-form-wrap .ce-card-b{padding:24px;container-type:inline-size;container-name:cebody}
    .client-form-wrap .ce-card-f{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 24px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}
    .client-form-wrap .ce-card-f .ce-next{margin-left:auto}

    /* ---------- grid & fields ---------- */
    .client-form-wrap .ce-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px 20px;align-items:start}
    .client-form-wrap .ce-field{min-width:0}
    .client-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .client-form-wrap .ce-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .client-form-wrap .req{color:#f43f5e;margin-left:-3px}
    .client-form-wrap .ce-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .client-form-wrap .ce-help:hover{background:#6366f1;color:#fff}
    .client-form-wrap .form-control,.client-form-wrap .form-select{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .client-form-wrap textarea.form-control{min-height:88px;resize:vertical;padding-top:12px}
    .client-form-wrap .form-control::placeholder{color:#a3b0c2}
    .client-form-wrap .form-control:focus,.client-form-wrap .form-select:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .client-form-wrap .form-control.is-invalid,.client-form-wrap .form-select.is-invalid{border-color:#f43f5e;background-image:none}
    .client-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .client-form-wrap input[type=number]::-webkit-outer-spin-button,.client-form-wrap input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .client-form-wrap input[type=number]{-moz-appearance:textfield}

    /* ---------- Choices.js (state dropdowns) ---------- */
    .client-form-wrap .choices{margin:0;position:relative}
    .client-form-wrap .choices.is-open{z-index:6}
    .client-form-wrap .choices[data-type*=select-one] .choices__inner{display:flex;align-items:center;min-height:48px;padding:0 14px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .client-form-wrap .choices[data-type*=select-one]::after{right:16px;border-color:#94a3b8 transparent transparent}
    .client-form-wrap .choices[data-type*=select-one].is-open::after{border-color:transparent transparent #94a3b8}
    .client-form-wrap .choices.is-focused .choices__inner,
    .client-form-wrap .choices.is-open .choices__inner{border-color:#6366f1;background:#fff;border-radius:12px;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .client-form-wrap .choices .choices__list--single{display:block;width:100%;padding:0 22px 0 0}
    .client-form-wrap .choices .choices__placeholder{color:#a3b0c2;opacity:1}
    .client-form-wrap .choices .choices__list--dropdown{margin-top:6px;border:1.5px solid #e0e7ff;border-radius:14px;box-shadow:0 18px 40px -18px rgba(15,23,42,.35);z-index:20;word-break:normal;overflow:hidden}
    .client-form-wrap .choices .choices__list--dropdown.is-flipped,
    .client-form-wrap .choices.is-flipped .choices__list--dropdown{margin-top:0;margin-bottom:6px;border-radius:14px}
    .client-form-wrap .choices .choices__list--dropdown .choices__item{padding:10px 14px;font-size:14px}
    .client-form-wrap .choices .choices__list--dropdown .choices__item--selectable.is-highlighted{background:#eef2ff;color:var(--i1)}
    .client-form-wrap .choices .choices__list--dropdown .choices__input{padding:11px 14px;margin:0;border:0;border-bottom:1.5px solid #eef2ff;border-radius:0;background:#fff;font-size:14px;color:var(--ink)}
    .client-form-wrap .choices.is-invalid .choices__inner{border-color:#f43f5e}

    /* ---------- shipping toggle ---------- */
    .client-form-wrap .ce-ship{display:flex;align-items:center;gap:14px;padding:16px 18px;margin-bottom:24px;border-radius:16px;border:1.5px solid #e2e8f0;background:#f8fafc;transition:.2s}
    .client-form-wrap .ce-ship.on{border-color:#c7d2fe;background:linear-gradient(135deg,#eef2ff,#f5f3ff)}
    .client-form-wrap .ce-ship .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .client-form-wrap .ce-ship .mi,.client-form-wrap .ce-ship .mi i{color:var(--i1)!important}
    .client-form-wrap .ce-ship .tx{flex:1;min-width:0}
    .client-form-wrap .ce-ship .tx b{display:block;font-size:14px;color:var(--ink)}
    .client-form-wrap .ce-ship .tx small{display:block;margin-top:2px;font-size:12px;color:var(--mut)}
    .client-form-wrap .ce-shipfields{opacity:.5;transition:.2s}
    .client-form-wrap .ce-shipfields.enabled{opacity:1}

    /* ---------- buttons ---------- */
    .client-form-wrap .ce-btn{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 18px;border-radius:12px;border:1.5px solid transparent;font-size:13.5px;font-weight:700;cursor:pointer;transition:.2s}
    .client-form-wrap .ce-btn i{font-size:12px;color:inherit!important}
    .client-form-wrap .ce-btn.ghost{background:#fff;border-color:#e2e8f0;color:#475569}
    .client-form-wrap .ce-btn.ghost:hover{border-color:#c7d2fe;color:var(--i1)}
    .client-form-wrap .ce-btn.primary{background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;box-shadow:0 12px 20px -12px rgba(79,70,229,.7)}
    .client-form-wrap .ce-btn.primary:hover{transform:translateY(-1px);box-shadow:0 16px 24px -12px rgba(79,70,229,.75)}

    .client-form-wrap .ce-hide{display:none!important}

    /* ---------- responsive ---------- */
    @container cebody (max-width:560px){
        .client-form-wrap .ce-grid{grid-template-columns:1fr}
    }
    @media (max-width:767px){
        .client-form-wrap .ce-tabt small{display:none}
    }
    @media (max-width:575px){
        .client-form-wrap .ce-grid{grid-template-columns:1fr}
        .client-form-wrap .ce-head{padding:18px}
        .client-form-wrap .ce-head h4{font-size:17px}
        .client-form-wrap .ce-hright{margin-left:0;width:100%}
        .client-form-wrap .ce-tab{flex-direction:column;justify-content:center;gap:6px;padding:10px 6px;text-align:center}
        .client-form-wrap .ce-tabt{flex:none;width:100%}
        .client-form-wrap .ce-tabt b{font-size:12px;white-space:normal}
        .client-form-wrap .ce-badge{position:absolute;top:6px;right:6px;padding:2px 7px;font-size:10px}
        .client-form-wrap .ce-tab.has-error::after{right:auto;left:8px}
        .client-form-wrap .ce-card-h,.client-form-wrap .ce-card-b,.client-form-wrap .ce-card-f{padding-left:18px;padding-right:18px}
        .client-form-wrap .ce-ship{flex-wrap:wrap}
    }
</style>

@php
    $cl      = $data['client'] ?? null;
    $cName   = old('client_name', optional($cl)->client_name);
    $cComp   = old('company_name', optional($cl)->company_name);
    $cMail   = old('email', optional($cl)->email);
    $cActive = optional($cl)->status !== 'deactive';
    $cInit   = mb_strtoupper(mb_substr(trim((string) $cName), 0, 1));
@endphp

<div class="client-form-wrap">
    <form action="{{ route('client.store') }}" id="add-client-form" method="POST" enctype="multipart/form-data">

        {{-- ===================== HEADER ===================== --}}
        <div class="ce-head">
            <div class="ce-av" id="ce_av">@if($cInit !== ''){{ $cInit }}@else<i class="fas fa-user-plus"></i>@endif</div>
            <div class="ce-htext">
                <small>New client</small>
                <h4 id="ce_title">{{ $cName ?: 'Untitled client' }}</h4>
                <p class="ce-sub" id="ce_sub">{{ $cComp ?: ($cMail ?: 'Fill in the details for the new client') }}</p>
            </div>
            <div class="ce-hright">
                <span class="ce-chip" id="ce_ship_chip"><i class="fas fa-shipping-fast"></i> <span>Ships to billing address</span></span>
                <label class="ce-stat {{ $cActive ? 'on' : '' }}" id="ce_stat" for="ce_status_switch">
                    <span class="ce-dot"></span>
                    <span id="ce_status_txt">{{ $cActive ? 'Active' : 'Inactive' }}</span>
                    <input type="checkbox" class="ce-sw sm" id="ce_status_switch" {{ $cActive ? 'checked' : '' }}>
                </label>
                <select name="status" id="id_status" class="ce-hide">
                    <option value="active" {{ $cActive ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ !$cActive ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>
        </div>

        {{-- ===================== TABS ===================== --}}
        <div class="ce-tabs" role="tablist">
            <button type="button" class="ce-tab active" data-tab="basic" role="tab" aria-selected="true">
                <span class="ce-tabi"><i class="fas fa-user"></i></span>
                <span class="ce-tabt"><b>Basic info</b><small>Name, contact &amp; currency</small></span>
            </button>
            <button type="button" class="ce-tab" data-tab="address" role="tab" aria-selected="false">
                <span class="ce-tabi"><i class="fas fa-map-marker-alt"></i></span>
                <span class="ce-tabt"><b>Address &amp; billing</b><small>Billing location</small></span>
            </button>
            <button type="button" class="ce-tab" data-tab="shipping" role="tab" aria-selected="false">
                <span class="ce-tabi"><i class="fas fa-shipping-fast"></i></span>
                <span class="ce-tabt"><b>Shipping</b><small>Delivery address</small></span>
                <span class="ce-badge" id="shipBadge">Off</span>
            </button>
        </div>

        {{-- ===================== TAB 1: BASIC INFO ===================== --}}
        <div class="ce-panel active" data-panel="basic">
            <div class="ce-card">
                <div class="ce-card-h">
                    <div class="ce-chipi c1"><i class="fas fa-id-card"></i></div>
                    <div><h6>Basic information</h6><span>Who this client is and how to reach them</span></div>
                </div>
                <div class="ce-card-b">
                    <div class="ce-grid">
                        <div class="ce-field">
                            <label class="form-label" for="id_client_name">
                                <i class="fas fa-user ce-li"></i>Client name<span class="req">*</span>
                                <button type="button" class="ce-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Name shown on invoices and estimates for this client.">?</button>
                            </label>
                            <input type="text" name="client_name" id="id_client_name" class="form-control"
                                value="{{ old('client_name', optional($cl)->client_name) }}"
                                placeholder="Enter client name">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_company_name">
                                <i class="fas fa-building ce-li"></i>Company name
                                <button type="button" class="ce-help" data-bs-toggle="tooltip" data-bs-placement="top" title="If filled, the company name is shown first in the client's address block.">?</button>
                            </label>
                            <input type="text" name="company_name" id="id_company_name" class="form-control"
                                value="{{ old('company_name', optional($cl)->company_name) }}"
                                placeholder="Enter company name">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_email">
                                <i class="fas fa-envelope ce-li"></i>Email
                            </label>
                            <input type="email" name="email" id="id_email" class="form-control"
                                value="{{ old('email', optional($cl)->email) }}"
                                placeholder="Enter email address">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_phone">
                                <i class="fas fa-phone ce-li"></i>Phone
                            </label>
                            <input type="text" name="phone" id="id_phone" class="form-control"
                                value="{{ old('phone', optional($cl)->phone) }}"
                                placeholder="Enter phone number">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_gst_number">
                                <i class="fas fa-receipt ce-li"></i>GST number
                                <button type="button" class="ce-help" data-bs-toggle="tooltip" data-bs-placement="top" title="The client's GSTIN, used on GST invoices.">?</button>
                            </label>
                            <input type="text" name="gst_number" id="id_gst_number" class="form-control"
                                value="{{ old('gst_number', optional($cl)->gst_number) }}"
                                placeholder="Enter GST number">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_currency_code">
                                <i class="fas fa-money-bill-wave ce-li"></i>Currency<span class="req">*</span>
                                <button type="button" class="ce-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Currency used for this client's invoices and estimates.">?</button>
                            </label>
                            <select name="currency_code" id="id_currency_code" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['currencies'] as $currency)
                                <option value="{{ $currency->currency_code }}" {{ optional($cl)->currency_code == $currency->currency_code ? 'selected' : '' }}>
                                    {{ $currency->currency_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="ce-card-f">
                    <button type="button" class="ce-btn primary ce-next" data-next="address">
                        Next: Address &amp; billing <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== TAB 2: ADDRESS & BILLING ===================== --}}
        <div class="ce-panel" data-panel="address">
            <div class="ce-card">
                <div class="ce-card-h">
                    <div class="ce-chipi c2"><i class="fas fa-map-marker-alt"></i></div>
                    <div><h6>Address &amp; billing</h6><span>Where invoices and estimates are addressed</span></div>
                </div>
                <div class="ce-card-b">
                    <div class="ce-grid">
                        <div class="ce-field">
                            <label class="form-label" for="id_address_1">
                                <i class="fas fa-map-marker-alt ce-li"></i>Address 1<span class="req">*</span>
                            </label>
                            <textarea name="address_1" id="id_address_1" class="form-control" rows="2" placeholder="Enter primary address">{{ old('address_1', optional($cl)->address_1) }}</textarea>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_address_2">
                                <i class="fas fa-map-pin ce-li"></i>Address 2
                            </label>
                            <textarea name="address_2" id="id_address_2" class="form-control" rows="2" placeholder="Enter secondary address">{{ old('address_2', optional($cl)->address_2) }}</textarea>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_country_id">
                                <i class="fas fa-globe-asia ce-li"></i>Country<span class="req">*</span>
                            </label>
                            <select name="country_id" id="id_country_id" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['countries'] as $country)
                                <option value="{{ $country->country_id }}" {{ optional($cl)->country_id == $country->country_id ? 'selected' : '' }}>
                                    {{ $country->country_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_state_id">
                                <i class="fas fa-map ce-li"></i>State<span class="req">*</span>
                            </label>
                            <select name="state_id" id="id_state_id" class="form-select">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_city">
                                <i class="fas fa-city ce-li"></i>City
                            </label>
                            <input type="text" name="city" id="id_city" class="form-control"
                                value="{{ old('city', optional($cl)->city) }}"
                                placeholder="Enter city">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_zip">
                                <i class="fas fa-mail-bulk ce-li"></i>Pincode
                            </label>
                            <input type="text" name="zip" id="id_zip" class="form-control"
                                value="{{ old('zip', optional($cl)->zip) }}"
                                placeholder="Enter pincode">
                        </div>
                    </div>
                </div>
                <div class="ce-card-f">
                    <button type="button" class="ce-btn ghost ce-prev" data-prev="basic">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="ce-btn primary ce-next" data-next="shipping">
                        Next: Shipping <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== TAB 3: SHIPPING ===================== --}}
        <div class="ce-panel" data-panel="shipping">
            <div class="ce-card">
                <div class="ce-card-h">
                    <div class="ce-chipi c4"><i class="fas fa-shipping-fast"></i></div>
                    <div><h6>Shipping details</h6><span>Delivery address, if different from billing</span></div>
                </div>
                <div class="ce-card-b">
                    <div class="ce-ship" id="ce_ship">
                        <span class="mi"><i class="fas fa-shipping-fast"></i></span>
                        <div class="tx">
                            <b>Different shipping address?</b>
                            <small id="ce_ship_txt">Turn this on if shipping address is not the same as the billing address.</small>
                        </div>
                        <input class="ce-sw ind" name="edit_shipping_address" type="checkbox" id="toggleShippingAddress">
                    </div>

                    <div id="shippingFields" class="ce-grid ce-shipfields">
                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_client_name">
                                <i class="fas fa-user ce-li"></i>Shipping client name<span class="req">*</span>
                            </label>
                            <input type="text" name="shipping_client_name" id="id_shipping_client_name" class="form-control"
                                value="{{ old('shipping_client_name', optional($cl)->shipping_client_name) }}"
                                placeholder="Enter shipping client name">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_phone">
                                <i class="fas fa-phone ce-li"></i>Phone
                            </label>
                            <input type="text" name="shipping_phone" id="id_shipping_phone" class="form-control"
                                value="{{ old('shipping_phone', optional($cl)->shipping_phone) }}"
                                placeholder="Enter phone number">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_address_1">
                                <i class="fas fa-map-marker-alt ce-li"></i>Shipping address 1<span class="req">*</span>
                            </label>
                            <textarea name="shipping_address_1" id="id_shipping_address_1" class="form-control" rows="2"
                                placeholder="Enter shipping address 1">{{ old('shipping_address_1', optional($cl)->shipping_address_1) }}</textarea>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_address_2">
                                <i class="fas fa-map-pin ce-li"></i>Shipping address 2
                            </label>
                            <textarea name="shipping_address_2" id="id_shipping_address_2" class="form-control" rows="2"
                                placeholder="Enter shipping address 2">{{ old('shipping_address_2', optional($cl)->shipping_address_2) }}</textarea>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_country_id">
                                <i class="fas fa-globe-asia ce-li"></i>Shipping country<span class="req">*</span>
                            </label>
                            <select name="shipping_country_id" id="id_shipping_country_id" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['countries'] as $country)
                                <option value="{{ $country->country_id }}" {{ optional($cl)->shipping_country_id == $country->country_id ? 'selected' : '' }}>
                                    {{ $country->country_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_state_id">
                                <i class="fas fa-map ce-li"></i>Shipping state<span class="req">*</span>
                            </label>
                            <select name="shipping_state_id" id="id_shipping_state_id" class="form-select">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_city">
                                <i class="fas fa-city ce-li"></i>Shipping city
                            </label>
                            <input type="text" name="shipping_city" id="id_shipping_city" class="form-control"
                                value="{{ old('shipping_city', optional($cl)->shipping_city) }}"
                                placeholder="Enter city">
                        </div>

                        <div class="ce-field">
                            <label class="form-label" for="id_shipping_zip">
                                <i class="fas fa-mail-bulk ce-li"></i>Shipping pincode
                            </label>
                            <input type="number" name="shipping_zip" id="id_shipping_zip" class="form-control"
                                value="{{ old('shipping_zip', optional($cl)->shipping_zip) }}"
                                placeholder="Enter shipping pincode">
                        </div>
                    </div>
                </div>
                <div class="ce-card-f">
                    <button type="button" class="ce-btn ghost ce-prev" data-prev="address">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="client_code" id="id_client_code" value="{{ optional($cl)->client_code }}">

        <x-invoice.sticky-actions
            submitText="Save Client"
            submitClass="save-client" />

    </form>
</div>

<script>
(function () {
    var form = document.getElementById('add-client-form');
    if (!form) return;
    var root = form.closest('.client-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }
    function qa(sel) { return root.querySelectorAll(sel); }

    var tabBtns    = qa('.ce-tab');
    var panels     = qa('.ce-panel');
    var shipToggle = q('#toggleShippingAddress');
    var shipFields = q('#shippingFields');
    var shipBadge  = q('#shipBadge');

    /* ---------- tabs ---------- */
    function goToTab(name) {
        tabBtns.forEach(function (b) {
            var on = b.dataset.tab === name;
            b.classList.toggle('active', on);
            b.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        panels.forEach(function (p) { p.classList.toggle('active', p.dataset.panel === name); });
    }
    tabBtns.forEach(function (btn) { btn.addEventListener('click', function () { goToTab(btn.dataset.tab); }); });
    qa('.ce-next').forEach(function (btn) { btn.addEventListener('click', function () { goToTab(btn.dataset.next); }); });
    qa('.ce-prev').forEach(function (btn) { btn.addEventListener('click', function () { goToTab(btn.dataset.prev); }); });

    /* ---------- header live update ---------- */
    var nameInp = q('#id_client_name'), compInp = q('#id_company_name'), mailInp = q('#id_email');
    function refreshHead() {
        var n = nameInp.value.trim();
        q('#ce_title').textContent = n || 'Untitled client';
        if (n) { q('#ce_av').textContent = n.charAt(0).toUpperCase(); }
        else { q('#ce_av').innerHTML = '<i class="fas fa-user-plus"></i>'; }
        q('#ce_sub').textContent = compInp.value.trim() || mailInp.value.trim() || 'Fill in the details for the new client';
    }
    [nameInp, compInp, mailInp].forEach(function (i) { i.addEventListener('input', refreshHead); });

    /* ---------- status switch (hidden select stays the source of truth) ---------- */
    q('#ce_status_switch').addEventListener('change', function () {
        var on = this.checked;
        q('#id_status').value = on ? 'active' : 'deactive';
        q('#ce_status_txt').textContent = on ? 'Active' : 'Inactive';
        q('#ce_stat').classList.toggle('on', on);
    });

    /* ---------- shipping toggle ---------- */
    function syncShipping() {
        var on = shipToggle.checked;
        shipFields.classList.toggle('enabled', on);
        shipBadge.textContent = on ? 'On' : 'Off';
        shipBadge.classList.toggle('on', on);
        q('#ce_ship').classList.toggle('on', on);
        q('#ce_ship_txt').textContent = on
            ? 'Using a separate shipping address for this client.'
            : 'Turn this on if shipping address is not the same as the billing address.';
        q('#ce_ship_chip span').textContent = on ? 'Separate shipping' : 'Ships to billing address';
    }
    if (shipToggle) {
        shipToggle.addEventListener('change', syncShipping);
        syncShipping();
    }

    /* ---------- tooltips (scoped to this form) ---------- */
    if (window.bootstrap) {
        qa('[data-bs-toggle="tooltip"]').forEach(function (el) { new bootstrap.Tooltip(el); });
    }

    /* ---------- Enter key => save ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.save-client');
        if (btn) btn.click();
    });

    /* ---------- AJAX save ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.ceSave').on('click.ceSave', '.save-client', function (e) {
        var f = document.getElementById('add-client-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        formData.append('notes', $('#id_notes').summernote('code'));
        formData.append('terms', $('#id_terms').summernote('code'));

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your client.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: f.action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#add-client-form .error').remove();
                $('#add-client-form .is-invalid').removeClass('is-invalid');
                $('#add-client-form .ce-tab').removeClass('has-error');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#add-client-form #id_' + field);
                        if (!inputField.length) inputField = $('#add-client-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.choices').addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.ce-field');
                        if (holder.length) holder.append(errorHtml); else inputField.after(errorHtml);
                    });

                    // errors wale tabs par red dot + pehle error wale tab par jump
                    $('#add-client-form .ce-panel').each(function() {
                        if ($(this).find('.error').length) {
                            $('#add-client-form .ce-tab[data-tab="' + $(this).attr('data-panel') + '"]').addClass('has-error');
                        }
                    });
                    const firstError = $('#add-client-form .error').first();
                    if (firstError.length) {
                        const panel = firstError.closest('.ce-panel');
                        if (panel.length) goToTab(panel.attr('data-panel'));
                        if (firstError[0].scrollIntoView) firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

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
                        title: "Client Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#client-modal').modal('hide');

                        if ( window.location.href.includes("/invoice/add") || window.location.href.includes("/invoice/edit") ||
                        window.location.href.includes("/estimate/add") || window.location.href.includes("/estimate/edit")

                        ) {

                            let addressHTML = '';

                            if ($('#id_company_name').val() ) {
                                addressHTML += $('#id_company_name').val()  + '<br>';
                            } else {
                                addressHTML += $('#id_client_name').val() + '<br>';
                            }
                            if ($('#id_address_1').val()) addressHTML += $('#id_address_1').val() + '<br>';
                            if ($('#id_address_2').val()) addressHTML += $('#id_address_2').val() + '<br>';
                            if ($('#id_state_id option:selected').text()) addressHTML += $('#id_state_id option:selected').text() + ' ';
                            if ($('#id_country_id option:selected').text()) addressHTML += $('#id_country_id option:selected').text() + ' ';
                            if ($('#id_zip').val()) addressHTML += $('#id_zip').val();

                            $('#client').val($('#id_client_name').val());
                            $('#client_id').val(response.client_id);
                            $('#clientList').hide();

                            $('#clientAddress').html(addressHTML).show();

                            $('#id_currency_code').val( $('#client_id').val(response.client_id)).trigger('change');
                            if ($('#id_notes').val()) {
                                $('#id_invoice_terms').summernote('code', $('#id_notes').val());

                            }
                            if ($('#id_notes').val()) {
                                $('#id_invoice_notes').summernote('code', $('#id_notes').val());
                            }
                            $('#clientSearchBox').hide();
                            $('.change-client').show();
                            $('.new-client').hide();


                        } else {
                            location.reload();
                        }


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
})();
</script>

<script>
    $(document).ready(function() {

        // === Initialize Choices.js for both state selects ===
        const billingStateChoices = new Choices('#id_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        const shippingStateChoices = new Choices('#id_shipping_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        // === Function to load states dynamically ===
        function refreshStates(selectedCountryId, stateChoicesInstance, selectedStateId = null) {
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    country_id: selectedCountryId
                },
                dataType: "json",
                success: function(response) {
                    // Clear old options
                    stateChoicesInstance.clearChoices();
                    stateChoicesInstance.removeActiveItems();

                    // Map new state options
                    const options = response.states.map(state => ({
                        value: String(state.state_id),
                        label: state.state_name,
                        selected: selectedStateId ? String(state.state_id) === String(selectedStateId) : false,
                    }));

                    // Set new choices
                    stateChoicesInstance.setChoices(options, 'value', 'label', true);

                    // Select specific state if available
                    if (selectedStateId) {
                        stateChoicesInstance.setChoiceByValue(String(selectedStateId));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }

        // === Billing Country Change ===
        $('#id_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId, billingStateChoices);
            } else {
                billingStateChoices.clearChoices();
                billingStateChoices.removeActiveItems();
            }
        });

        // === Shipping Country Change ===
        $('#id_shipping_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId, shippingStateChoices);
            } else {
                shippingStateChoices.clearChoices();
                shippingStateChoices.removeActiveItems();
            }
        });

        // === On Page Load: preload both billing and shipping ===
        const initialBillingCountryId = "{{ optional($data['client'] ?? null)->country_id ?? request('country_id') }}";
        const initialBillingStateId = "{{ optional($data['client'] ?? null)->state_id ?? request('state_id') }}";

        const initialShippingCountryId = "{{ optional($data['client'] ?? null)->shipping_country_id ?? request('shipping_country_id') }}";
        const initialShippingStateId = "{{ optional($data['client'] ?? null)->shipping_state_id ?? request('shipping_state_id') }}";

        if (initialBillingCountryId) {
            refreshStates(initialBillingCountryId, billingStateChoices, initialBillingStateId);
        }

        if (initialShippingCountryId) {
            refreshStates(initialShippingCountryId, shippingStateChoices, initialShippingStateId);
        }
    });
</script>