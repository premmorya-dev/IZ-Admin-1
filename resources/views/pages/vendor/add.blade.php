<style>
    .vendor-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .vendor-form-wrap .ve-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:16px;flex-wrap:wrap;padding:20px 24px;border-radius:22px;color:#fff;margin-bottom:20px;
        background:radial-gradient(600px 220px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(420px 220px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .vendor-form-wrap .ve-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .vendor-form-wrap .ve-head > *{position:relative;z-index:1}
    .vendor-form-wrap .ve-av{flex:none;width:54px;height:54px;border-radius:16px;display:grid;place-items:center;font-size:20px;font-weight:800;color:#fff;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .vendor-form-wrap .ve-htext{min-width:0}
    .vendor-form-wrap .ve-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .vendor-form-wrap .ve-head h4{margin:0;color:#fff;font-size:20px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .vendor-form-wrap .ve-sub{margin:3px 0 0;color:#c7d2fe;font-size:13px;word-break:break-word}
    .vendor-form-wrap .ve-hright{margin-left:auto;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .vendor-form-wrap .ve-chip{display:inline-flex;align-items:center;gap:7px;padding:8px 13px;border-radius:99px;font-size:12.5px;font-weight:600;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .vendor-form-wrap .ve-chip i{color:inherit!important;font-size:12px}
    .vendor-form-wrap .ve-dot{flex:none;width:7px;height:7px;border-radius:50%;background:currentColor}
    .vendor-form-wrap .ve-stat{display:inline-flex;align-items:center;gap:10px;margin:0;padding:5px 8px 5px 14px;border-radius:99px;font-size:12.5px;font-weight:700;cursor:pointer;
        background:rgba(251,113,133,.18);border:1px solid rgba(251,113,133,.4);color:#fda4af;transition:.2s}
    .vendor-form-wrap .ve-stat.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}

    /* ---------- custom switch ---------- */
    .vendor-form-wrap .ve-sw{-webkit-appearance:none;appearance:none;flex:none;position:relative;width:46px;height:26px;margin:0;padding:0;border:0;border-radius:99px;background:#cbd5e1;cursor:pointer;transition:.2s;outline:0}
    .vendor-form-wrap .ve-sw::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.3);transition:.2s}
    .vendor-form-wrap .ve-sw:checked{background:#10b981}
    .vendor-form-wrap .ve-sw:checked::after{transform:translateX(20px)}
    .vendor-form-wrap .ve-sw:focus-visible{box-shadow:0 0 0 4px rgba(99,102,241,.28)}
    .vendor-form-wrap .ve-sw.sm{width:40px;height:24px;background:rgba(255,255,255,.28)}
    .vendor-form-wrap .ve-sw.sm::after{top:3px;left:3px;width:18px;height:18px}
    .vendor-form-wrap .ve-sw.sm:checked{background:#10b981}
    .vendor-form-wrap .ve-sw.sm:checked::after{transform:translateX(16px)}

    /* ---------- tabs ---------- */
    .vendor-form-wrap .ve-tabs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:6px;padding:6px;margin-bottom:20px;border-radius:18px;background:#f1f5f9}
    .vendor-form-wrap .ve-tab{position:relative;display:flex;align-items:center;gap:12px;min-width:0;padding:10px 14px;border:0;border-radius:13px;background:transparent;text-align:left;cursor:pointer;transition:.2s}
    .vendor-form-wrap .ve-tab:hover{background:rgba(255,255,255,.6)}
    .vendor-form-wrap .ve-tab.active{background:#fff;box-shadow:0 8px 18px -12px rgba(15,23,42,.4),inset 0 0 0 1.5px #c7d2fe}
    .vendor-form-wrap .ve-tabi{flex:none;width:36px;height:36px;border-radius:11px;display:grid;place-items:center;font-size:14px;background:#e2e8f0;transition:.2s}
    .vendor-form-wrap .ve-tabi,.vendor-form-wrap .ve-tabi i{color:#64748b!important}
    .vendor-form-wrap .ve-tab.active .ve-tabi{background:linear-gradient(135deg,#4f46e5,#818cf8);box-shadow:0 10px 18px -10px rgba(79,70,229,.7)}
    .vendor-form-wrap .ve-tab.active .ve-tabi,.vendor-form-wrap .ve-tab.active .ve-tabi i{color:#fff!important}
    .vendor-form-wrap .ve-tabt{min-width:0;flex:1}
    .vendor-form-wrap .ve-tabt b{display:block;font-size:13.5px;font-weight:700;color:#334155;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .vendor-form-wrap .ve-tabt small{display:block;margin-top:1px;font-size:11.5px;color:var(--mut);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .vendor-form-wrap .ve-tab.active .ve-tabt b{color:var(--i1)}
    .vendor-form-wrap .ve-tab.has-error::after{content:"";position:absolute;top:9px;right:9px;width:9px;height:9px;border-radius:50%;background:#f43f5e;box-shadow:0 0 0 3px #fff}

    /* ---------- panels & cards ---------- */
    .vendor-form-wrap .ve-panel{display:none}
    .vendor-form-wrap .ve-panel.active{display:block;animation:veIn .25s ease}
    @keyframes veIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
    @media (prefers-reduced-motion:reduce){.vendor-form-wrap .ve-panel.active{animation:none}}
    .vendor-form-wrap .ve-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .vendor-form-wrap .ve-card-h{display:flex;align-items:center;gap:14px;padding:18px 24px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .vendor-form-wrap .ve-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;box-shadow:0 10px 18px -10px rgba(var(--rgb),.7)}
    .vendor-form-wrap .ve-chipi.c1{--rgb:79,70,229;background:linear-gradient(135deg,#4f46e5,#818cf8)}
    .vendor-form-wrap .ve-chipi.c2{--rgb:16,185,129;background:linear-gradient(135deg,#059669,#34d399)}
    .vendor-form-wrap .ve-chipi,
    .vendor-form-wrap .ve-chipi i,
    .vendor-form-wrap .ve-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .vendor-form-wrap .ve-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .vendor-form-wrap .ve-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .vendor-form-wrap .ve-card-b{padding:24px;container-type:inline-size;container-name:vebody}
    .vendor-form-wrap .ve-card-f{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 24px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}
    .vendor-form-wrap .ve-card-f .ve-next{margin-left:auto}

    /* ---------- grid & fields ---------- */
    .vendor-form-wrap .ve-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px 20px;align-items:start}
    .vendor-form-wrap .ve-field{min-width:0}
    .vendor-form-wrap .ve-full{grid-column:1/-1}
    .vendor-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .vendor-form-wrap .ve-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .vendor-form-wrap .req{color:#f43f5e;margin-left:-3px}
    .vendor-form-wrap .ve-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .vendor-form-wrap .ve-help:hover{background:#6366f1;color:#fff}
    .vendor-form-wrap .form-control,.vendor-form-wrap .form-select{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .vendor-form-wrap textarea.form-control{min-height:88px;resize:vertical;padding-top:12px}
    .vendor-form-wrap .form-control::placeholder{color:#a3b0c2}
    .vendor-form-wrap .form-control:focus,.vendor-form-wrap .form-select:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .vendor-form-wrap .form-control.is-invalid,.vendor-form-wrap .form-select.is-invalid{border-color:#f43f5e;background-image:none}
    .vendor-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}

    /* ---------- Choices.js (state dropdown) ---------- */
    .vendor-form-wrap .choices{margin:0;position:relative}
    .vendor-form-wrap .choices.is-open{z-index:6}
    .vendor-form-wrap .choices[data-type*=select-one] .choices__inner{display:flex;align-items:center;min-height:48px;padding:0 14px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .vendor-form-wrap .choices[data-type*=select-one]::after{right:16px;border-color:#94a3b8 transparent transparent}
    .vendor-form-wrap .choices[data-type*=select-one].is-open::after{border-color:transparent transparent #94a3b8}
    .vendor-form-wrap .choices.is-focused .choices__inner,
    .vendor-form-wrap .choices.is-open .choices__inner{border-color:#6366f1;background:#fff;border-radius:12px;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .vendor-form-wrap .choices .choices__list--single{display:block;width:100%;padding:0 22px 0 0}
    .vendor-form-wrap .choices .choices__placeholder{color:#a3b0c2;opacity:1}
    .vendor-form-wrap .choices .choices__list--dropdown{margin-top:6px;border:1.5px solid #e0e7ff;border-radius:14px;box-shadow:0 18px 40px -18px rgba(15,23,42,.35);z-index:20;word-break:normal;overflow:hidden}
    .vendor-form-wrap .choices .choices__list--dropdown.is-flipped,
    .vendor-form-wrap .choices.is-flipped .choices__list--dropdown{margin-top:0;margin-bottom:6px;border-radius:14px}
    .vendor-form-wrap .choices .choices__list--dropdown .choices__item{padding:10px 14px;font-size:14px}
    .vendor-form-wrap .choices .choices__list--dropdown .choices__item--selectable.is-highlighted{background:#eef2ff;color:var(--i1)}
    .vendor-form-wrap .choices .choices__list--dropdown .choices__input{padding:11px 14px;margin:0;border:0;border-bottom:1.5px solid #eef2ff;border-radius:0;background:#fff;font-size:14px;color:var(--ink)}
    .vendor-form-wrap .choices.is-invalid .choices__inner{border-color:#f43f5e}

    /* ---------- buttons ---------- */
    .vendor-form-wrap .ve-btn{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 18px;border-radius:12px;border:1.5px solid transparent;font-size:13.5px;font-weight:700;cursor:pointer;transition:.2s}
    .vendor-form-wrap .ve-btn i{font-size:12px;color:inherit!important}
    .vendor-form-wrap .ve-btn.ghost{background:#fff;border-color:#e2e8f0;color:#475569}
    .vendor-form-wrap .ve-btn.ghost:hover{border-color:#c7d2fe;color:var(--i1)}
    .vendor-form-wrap .ve-btn.primary{background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;box-shadow:0 12px 20px -12px rgba(79,70,229,.7)}
    .vendor-form-wrap .ve-btn.primary:hover{transform:translateY(-1px);box-shadow:0 16px 24px -12px rgba(79,70,229,.75)}

    .vendor-form-wrap .ve-hide{display:none!important}

    /* ---------- responsive ---------- */
    @container vebody (max-width:560px){
        .vendor-form-wrap .ve-grid{grid-template-columns:1fr}
    }
    @media (max-width:767px){
        .vendor-form-wrap .ve-tabt small{display:none}
    }
    @media (max-width:575px){
        .vendor-form-wrap .ve-grid{grid-template-columns:1fr}
        .vendor-form-wrap .ve-head{padding:18px}
        .vendor-form-wrap .ve-head h4{font-size:17px}
        .vendor-form-wrap .ve-hright{margin-left:0;width:100%}
        .vendor-form-wrap .ve-tab{flex-direction:column;justify-content:center;gap:6px;padding:10px 6px;text-align:center}
        .vendor-form-wrap .ve-tabt{flex:none;width:100%}
        .vendor-form-wrap .ve-tabt b{font-size:12px;white-space:normal}
        .vendor-form-wrap .ve-tab.has-error::after{right:auto;left:8px}
        .vendor-form-wrap .ve-card-h,.vendor-form-wrap .ve-card-b,.vendor-form-wrap .ve-card-f{padding-left:18px;padding-right:18px}
    }
</style>

@php
    $vd      = $data['vendor'] ?? null;
    $vName   = old('vendor_name', optional($vd)->vendor_name);
    $vComp   = old('company_name', optional($vd)->company_name);
    $vMail   = old('email', optional($vd)->email);
    $vActive = optional($vd)->status !== 'deactive';
    $vInit   = mb_strtoupper(mb_substr(trim((string) $vName) ?: 'V', 0, 1));
@endphp

<div class="vendor-form-wrap">
    <form action="{{ route('vendor.store') }}" id="add-vendor-form" method="POST" enctype="multipart/form-data">

        {{-- ===================== HEADER ===================== --}}
        <div class="ve-head">
            <div class="ve-av" id="ve_av">{{ $vInit }}</div>
            <div class="ve-htext">
                <small>New vendor</small>
                <h4 id="ve_title">{{ $vName ?: 'New vendor' }}</h4>
                <p class="ve-sub" id="ve_sub">{{ $vComp ?: ($vMail ?: 'Add contact details, address and billing info') }}</p>
            </div>
            <div class="ve-hright">
                <label class="ve-stat {{ $vActive ? 'on' : '' }}" id="ve_stat" for="ve_status_switch">
                    <span class="ve-dot"></span>
                    <span id="ve_status_txt">{{ $vActive ? 'Active' : 'Inactive' }}</span>
                    <input type="checkbox" class="ve-sw sm" id="ve_status_switch" {{ $vActive ? 'checked' : '' }}>
                </label>
                <select name="status" id="id_status" class="ve-hide">
                    <option value="active" {{ $vActive ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ !$vActive ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>
        </div>

        {{-- ===================== TABS ===================== --}}
        <div class="ve-tabs" role="tablist">
            <button type="button" class="ve-tab active" data-tab="basic" role="tab" aria-selected="true">
                <span class="ve-tabi"><i class="fas fa-user"></i></span>
                <span class="ve-tabt"><b>Basic info</b><small>Contact, GST &amp; currency</small></span>
            </button>
            <button type="button" class="ve-tab" data-tab="address" role="tab" aria-selected="false">
                <span class="ve-tabi"><i class="fas fa-map-marker-alt"></i></span>
                <span class="ve-tabt"><b>Address</b><small>Vendor location</small></span>
            </button>
        </div>

        {{-- ===================== TAB 1: BASIC INFO ===================== --}}
        <div class="ve-panel active" data-panel="basic">
            <div class="ve-card">
                <div class="ve-card-h">
                    <div class="ve-chipi c1"><i class="fas fa-id-card"></i></div>
                    <div><h6>Basic information</h6><span>Who this vendor is and how to reach them</span></div>
                </div>
                <div class="ve-card-b">
                    <div class="ve-grid">
                        <div class="ve-field">
                            <label class="form-label" for="id_vendor_name">
                                <i class="fas fa-user ve-li"></i>Vendor name
                            </label>
                            <input type="text" name="vendor_name" id="id_vendor_name" class="form-control"
                                value="{{ old('vendor_name', optional($vd)->vendor_name) }}"
                                placeholder="Enter vendor name">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_company_name">
                                <i class="fas fa-building ve-li"></i>Company name
                            </label>
                            <input type="text" name="company_name" id="id_company_name" class="form-control"
                                value="{{ old('company_name', optional($vd)->company_name) }}"
                                placeholder="Enter company name">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_email">
                                <i class="fas fa-envelope ve-li"></i>Email
                            </label>
                            <input type="email" name="email" id="id_email" class="form-control"
                                value="{{ old('email', optional($vd)->email) }}"
                                placeholder="Enter email address">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_phone">
                                <i class="fas fa-phone ve-li"></i>Phone
                            </label>
                            <input type="text" name="phone" id="id_phone" class="form-control"
                                value="{{ old('phone', optional($vd)->phone) }}"
                                placeholder="Enter phone number">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_gst_number">
                                <i class="fas fa-receipt ve-li"></i>GST number
                                <button type="button" class="ve-help" data-bs-toggle="tooltip" data-bs-placement="top" title="The vendor's GST registration number (GSTIN).">?</button>
                            </label>
                            <input type="text" name="gst_number" id="id_gst_number" class="form-control"
                                value="{{ old('gst_number', optional($vd)->gst_number) }}"
                                placeholder="Enter GST number">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_currency_code">
                                <i class="fas fa-money-bill-wave ve-li"></i>Currency
                                <button type="button" class="ve-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Currency used for this vendor's bills.">?</button>
                            </label>
                            <select name="currency_code" id="id_currency_code" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['currencies'] as $currency)
                                <option value="{{ $currency->currency_code }}" {{ optional($vd)->currency_code == $currency->currency_code ? 'selected' : '' }}>
                                    {{ $currency->currency_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ve-field ve-full">
                            <label class="form-label" for="id_notes">
                                <i class="fas fa-sticky-note ve-li"></i>Notes
                            </label>
                            <textarea name="notes" id="id_notes" class="form-control" rows="3" placeholder="Enter notes">{{ old('notes', optional($vd)->notes) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="ve-card-f">
                    <button type="button" class="ve-btn primary ve-next" data-next="address">
                        Next: Address <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== TAB 2: ADDRESS ===================== --}}
        <div class="ve-panel" data-panel="address">
            <div class="ve-card">
                <div class="ve-card-h">
                    <div class="ve-chipi c2"><i class="fas fa-map-marker-alt"></i></div>
                    <div><h6>Address</h6><span>Where this vendor is located</span></div>
                </div>
                <div class="ve-card-b">
                    <div class="ve-grid">
                        <div class="ve-field">
                            <label class="form-label" for="id_address_1">
                                <i class="fas fa-map-marker-alt ve-li"></i>Address 1
                            </label>
                            <textarea name="address_1" id="id_address_1" class="form-control" rows="2" placeholder="Enter primary address">{{ old('address_1', optional($vd)->address_1) }}</textarea>
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_address_2">
                                <i class="fas fa-map-pin ve-li"></i>Address 2
                            </label>
                            <textarea name="address_2" id="id_address_2" class="form-control" rows="2" placeholder="Enter secondary address">{{ old('address_2', optional($vd)->address_2) }}</textarea>
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_country_id">
                                <i class="fas fa-globe-asia ve-li"></i>Country
                            </label>
                            <select name="country_id" id="id_country_id" class="form-select">
                                <option value="">Please Select</option>
                                @foreach($data['countries'] as $country)
                                <option value="{{ $country->country_id }}" {{ optional($vd)->country_id == $country->country_id ? 'selected' : '' }}>
                                    {{ $country->country_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_state_id">
                                <i class="fas fa-map ve-li"></i>State
                            </label>
                            <select name="state_id" id="id_state_id" class="form-select">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_city">
                                <i class="fas fa-city ve-li"></i>City
                            </label>
                            <input type="text" name="city" id="id_city" class="form-control"
                                value="{{ old('city', optional($vd)->city) }}"
                                placeholder="Enter city">
                        </div>

                        <div class="ve-field">
                            <label class="form-label" for="id_zip">
                                <i class="fas fa-mail-bulk ve-li"></i>Zip code
                            </label>
                            <input type="text" name="zip" id="id_zip" class="form-control"
                                value="{{ old('zip', optional($vd)->zip) }}"
                                placeholder="Enter zip code">
                        </div>
                    </div>
                </div>
                <div class="ve-card-f">
                    <button type="button" class="ve-btn ghost ve-prev" data-prev="basic">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="vendor_code" id="id_vendor_code" value="{{ optional($vd)->vendor_code }}">

        <x-invoice.sticky-actions
            submitText="Save Vendor"
            submitClass="save-vendor" />

    </form>
</div>

<script>
(function () {
    var form = document.getElementById('add-vendor-form');
    if (!form) return;
    var root = form.closest('.vendor-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }
    function qa(sel) { return root.querySelectorAll(sel); }

    var tabBtns = qa('.ve-tab');
    var panels  = qa('.ve-panel');

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
    qa('.ve-next').forEach(function (btn) { btn.addEventListener('click', function () { goToTab(btn.dataset.next); }); });
    qa('.ve-prev').forEach(function (btn) { btn.addEventListener('click', function () { goToTab(btn.dataset.prev); }); });

    /* ---------- header live update ---------- */
    var nameInp = q('#id_vendor_name'), compInp = q('#id_company_name'), mailInp = q('#id_email');
    function refreshHead() {
        var n = nameInp.value.trim();
        q('#ve_title').textContent = n || 'New vendor';
        q('#ve_av').textContent = (n ? n.charAt(0) : 'V').toUpperCase();
        q('#ve_sub').textContent = compInp.value.trim() || mailInp.value.trim() || 'Add contact details, address and billing info';
    }
    [nameInp, compInp, mailInp].forEach(function (i) { i.addEventListener('input', refreshHead); });

    /* ---------- status switch (hidden select stays the source of truth) ---------- */
    var stSw = q('#ve_status_switch');
    stSw.addEventListener('change', function () {
        var on = this.checked;
        q('#id_status').value = on ? 'active' : 'deactive';
        q('#ve_status_txt').textContent = on ? 'Active' : 'Inactive';
        q('#ve_stat').classList.toggle('on', on);
    });

    /* ---------- tooltips (scoped to this form) ---------- */
    if (window.bootstrap) {
        qa('[data-bs-toggle="tooltip"]').forEach(function (el) { new bootstrap.Tooltip(el); });
    }

    /* ---------- Enter key => update ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.save-vendor');
        if (btn) btn.click();
    });

    /* ---------- AJAX update ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.veSave').on('click.veSave', '.save-vendor', function (e) {
        var f = document.getElementById('add-vendor-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your vendor.",
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
                $('#add-vendor-form .error').remove();
                $('#add-vendor-form .is-invalid').removeClass('is-invalid');
                $('#add-vendor-form .ve-tab').removeClass('has-error');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#add-vendor-form #id_' + field);
                        if (!inputField.length) inputField = $('#add-vendor-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.choices').addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.ve-field');
                        if (holder.length) holder.append(errorHtml); else inputField.after(errorHtml);
                    });

                    // red dot on tabs that contain errors + jump to the first one
                    $('#add-vendor-form .ve-panel').each(function() {
                        if ($(this).find('.error').length) {
                            $('#add-vendor-form .ve-tab[data-tab="' + $(this).attr('data-panel') + '"]').addClass('has-error');
                        }
                    });
                    const firstError = $('#add-vendor-form .error').first();
                    if (firstError.length) {
                        const panel = firstError.closest('.ve-panel');
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
                        title: "Vendor Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#vendor-modal').modal('hide');

                        // On invoice add/edit pages the page must not reload
                        if (!(window.location.href.includes("/invoice/add") || window.location.href.includes("/invoice/edit"))) {
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
        // Create Choices instance ONCE

        const stateChoices = new Choices('#id_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        function refreshStates(selectedCountryId, selectedStateId = null) {
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    country_id: selectedCountryId
                },
                dataType: "json",
                success: function(response) {
                    console.log("States:", response.states);

                    // Clear old options, keep instance
                    stateChoices.clearChoices();
                    stateChoices.removeActiveItems();

                    // Add new options
                    const options = response.states.map(state => ({
                        value: String(state.state_id),
                        label: state.state_name,
                        selected: selectedStateId ? String(state.state_id) === String(selectedStateId) : false,
                    }));

                    stateChoices.setChoices(options, 'value', 'label', true);

                    // Explicitly select state if provided
                    if (selectedStateId) {
                        stateChoices.setChoiceByValue(String(selectedStateId));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }

        // When country changes
        $('#id_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId);
            } else {
                stateChoices.clearChoices();
                stateChoices.removeActiveItems();
            }
        });

        // On page load: preload country + states
        const initialCountryId = "{{ optional($data['vendor'] ?? null)->country_id ?? request('country_id') }}";
        const initialStateId = "{{ optional($data['vendor'] ?? null)->state_id ?? request('state_id') }}";

        if (initialCountryId) {
            refreshStates(initialCountryId, initialStateId);
        }
    });
</script>