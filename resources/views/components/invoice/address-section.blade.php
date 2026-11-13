@php
    $fromLine = collect([
        $setting->city ?? '',
        $setting->state->state_name ?? '',
        $setting->country->country_name ?? '',
        $setting->pincode ?? '',
    ])->filter()->implode(', ');

    // Company logo: change the field name / path below if your settings table differs
    $logoRaw = $setting->logo_path ?? NULL;
    $logoUrl = null;
    if (!empty($logoRaw)) {
        $logoUrl = \Illuminate\Support\Str::startsWith($logoRaw, ['http://', 'https://', 'data:'])
            ? $logoRaw
            : asset( $setting->logo_path  ) ;
    }
    $initial = mb_strtoupper(mb_substr(trim((string) ($setting->company_name ?? '')) ?: 'C', 0, 1));

    $hasFrom = !empty($logoUrl) || !empty($setting->company_name ?? '') || !empty($setting->address_1 ?? '') || !empty($setting->address_2 ?? '') || $fromLine !== '';
@endphp

<style>
    /* ==========================================================================
       Invoice From / To address cards — premium SaaS look (scoped)
       ========================================================================== */
    .invoice-address-row {
        --i1: #4f46e5;
        --i2: #7c3aed;
        --ink: #0f172a;
        --text: #334155;
        --mut: #64748b;
        --faint: #94a3b8;
        --bd: #e8ebf3;
        --soft: #f8fafc;

        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
        width: 100%;
    }

    @media (min-width: 768px) {
        .invoice-address-row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* ---------- card ---------- */
    .invoice-address-row .addr-card,
    .invoice-address-row .addr-card.bg-blue {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-width: 0;
        padding: 14px;
        background: var(--soft);
        border: 1px solid var(--bd);
        border-radius: 16px;
        box-shadow: none;
        transition: border-color .18s, background .18s, box-shadow .18s;
    }

    .invoice-address-row .addr-card:hover { border-color: #d6dcf5; }

    .invoice-address-row .addr-card.addr-to,
    .invoice-address-row .addr-card.addr-to.bg-blue { background: #fff; }

    .invoice-address-row .addr-card.addr-to:focus-within {
        border-color: #c7d2fe;
        box-shadow: 0 14px 32px -22px rgba(79, 70, 229, .35);
    }

    /* ---------- header ---------- */
    .invoice-address-row .addr-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px 10px;
        margin: 0;
        padding: 0;
        border: 0;
    }

    .invoice-address-row .addr-head-l {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .invoice-address-row .addr-ic {
        flex: none;
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        font-size: 15px;
        color: var(--i1);
        background: #eef2ff;
    }

    .invoice-address-row .addr-to .addr-ic {
        color: #fff;
        background: linear-gradient(135deg, var(--i1), #818cf8);
        box-shadow: 0 10px 16px -10px rgba(79, 70, 229, .8);
    }

    .invoice-address-row .addr-label {
        display: block;
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        color: var(--ink);
    }

    .invoice-address-row .addr-label.required::after {
        content: "*";
        margin-left: 3px;
        color: #e11d48;
    }

    .invoice-address-row .addr-sub {
        display: block;
        margin-top: 1px;
        font-size: 12px;
        font-weight: 500;
        color: var(--mut);
    }

    .invoice-address-row .addr-actions { display: inline-flex; align-items: center; gap: 6px; }

    .invoice-address-row .addr-action-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 11px;
        border: 1px solid #e0e7ff;
        border-radius: 99px;
        background: #eef2ff;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.3;
        color: var(--i1);
        text-decoration: none;
        white-space: nowrap;
        transition: .16s;
    }

    .invoice-address-row .addr-action-link i { font-size: 11px; }

    .invoice-address-row .addr-action-link:hover,
    .invoice-address-row .addr-action-link:focus-visible {
        border-color: transparent;
        background: linear-gradient(135deg, var(--i1), #6366f1);
        color: #fff;
        box-shadow: 0 10px 18px -10px rgba(79, 70, 229, .75);
    }

    .invoice-address-row .addr-action-link.is-solid {
        border-color: transparent;
        background: linear-gradient(135deg, var(--i1), #6366f1);
        color: #fff;
        box-shadow: 0 10px 18px -12px rgba(79, 70, 229, .8);
    }

    .invoice-address-row .addr-action-link.is-solid i { color: #fff; }

    .invoice-address-row .addr-action-link.is-solid:hover,
    .invoice-address-row .addr-action-link.is-solid:focus-visible {
        background: linear-gradient(135deg, #4338ca, #4f46e5);
        color: #fff;
        transform: translateY(-1px);
    }

    /* ---------- from body ---------- */
    .invoice-address-row .addr-body {
        padding: 12px 14px;
        background: #fff;
        border: 1px solid var(--bd);
        border-radius: 12px;
        font-size: 13.5px;
        line-height: 1.6;
        color: var(--mut);
    }

    .invoice-address-row .addr-body strong {
        display: block;
        font-size: 14.5px;
        font-weight: 700;
        color: var(--ink);
    }

    .invoice-address-row .addr-body .addr-line { display: block; }

    .invoice-address-row .addr-empty {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border: 1px dashed #d6dcf5;
        border-radius: 12px;
        background: #fff;
        font-size: 13px;
        color: var(--mut);
    }

    .invoice-address-row .addr-empty i { color: var(--faint); font-size: 16px; }

    /* ---------- company logo ---------- */
    .invoice-address-row .addr-body {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .invoice-address-row .addr-info { flex: 1; min-width: 0; overflow-wrap: anywhere; }

    .invoice-address-row .addr-logo {
        flex: none;
        width: 60px;
        height: 60px;
        display: grid;
        place-items: center;
        padding: 6px;
        overflow: hidden;
        border: 1px solid var(--bd);
        border-radius: 14px;
        background: var(--soft);
    }

    .invoice-address-row .addr-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .invoice-address-row .addr-logo-fb {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        border-radius: 9px;
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--i1), #818cf8);
    }

    @media (max-width: 374.98px) {
        .invoice-address-row .addr-logo { width: 48px; height: 48px; }
        .invoice-address-row .addr-body { gap: 10px; }
    }

    /* ---------- client search ---------- */
    .invoice-address-row #clientSearchBox { position: relative; }

    .invoice-address-row .addr-search { position: relative; }

    .invoice-address-row .addr-search > i {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 42px;
        display: grid;
        place-items: center;
        font-size: 14px;
        line-height: 1;
        color: var(--faint);
        pointer-events: none;
        transition: color .15s;
    }

    .invoice-address-row .addr-search:focus-within > i { color: var(--i1); }

    /* make sure only ONE search icon ever shows (removes icons added by global styles) */
    .invoice-address-row #clientSearchBox::before,
    .invoice-address-row #clientSearchBox::after,
    .invoice-address-row .addr-search::before,
    .invoice-address-row .addr-search::after {
        content: none !important;
        display: none !important;
    }

    .invoice-address-row #client {
        padding-left: 40px;
        background-image: none !important;
    }

    .invoice-address-row #client {
        min-height: 42px;
        padding: 8px 12px 8px 38px;
        border: 1px solid var(--bd);
        border-radius: 12px;
        background: #fff;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--ink);
        box-shadow: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .invoice-address-row #client::placeholder { color: var(--faint); font-weight: 400; }

    .invoice-address-row #client:focus {
        border-color: var(--i1);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .14);
    }

    /* results dropdown (items are appended by the existing JS) */
    .invoice-address-row #clientList {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 50;
        padding: 6px;
        border: 1px solid var(--bd);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 22px 44px -18px rgba(15, 23, 42, .35);
    }

    /* the JS appends an empty bordered wrapper first — hide it */
    .invoice-address-row #clientList > div:empty { display: none; }

    .invoice-address-row #clientList .list-group-item {
        margin: 0 0 4px !important;
        padding: 10px 12px !important;
        border: 1px solid transparent;
        border-radius: 10px !important;
        background: #fff;
        box-shadow: none !important;
    }

    .invoice-address-row #clientList .list-group-item:last-child { margin-bottom: 0 !important; }

    .invoice-address-row #clientList .list-group-item:hover {
        border-color: #c7d2fe;
        background: #f5f6ff;
    }

    .invoice-address-row #clientList .list-group-item h6 {
        margin-bottom: 3px !important;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink) !important;
    }

    .invoice-address-row #clientList .list-group-item h6 i { color: var(--i1); }
    .invoice-address-row #clientList .list-group-item p { font-size: 12px !important; color: var(--mut) !important; }

    .invoice-address-row #clientList .list-group-item .badge {
        padding: 4px 9px;
        border: 1px solid #a7f3d0;
        background: #ecfdf5 !important;
        font-size: 11px;
        font-weight: 600;
        color: #047857;
    }

    /* ---------- selected client ---------- */
    .invoice-address-row #clientAddress {
        position: relative;
        padding: 12px 56px 12px 14px;
        background: #fff;
        border: 1px solid var(--bd);
        border-radius: 12px;
        font-size: 13.5px;
        line-height: 1.6;
        color: var(--mut);
    }

    .invoice-address-row #clientAddress::first-line {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--ink);
    }

    /* edit button created by the existing JS: blue + white icon by default */
    .invoice-address-row #clientAddress .edit-client {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        bottom: auto !important;
        width: 34px !important;
        height: 34px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border: 0 !important;
        border-radius: 10px !important;
        background: linear-gradient(135deg, #4f46e5, #6366f1) !important;
        color: #fff !important;
        box-shadow: 0 10px 18px -10px rgba(79, 70, 229, .8) !important;
        transition: .16s;
    }

    .invoice-address-row #clientAddress .edit-client i {
        font-size: 13px;
        line-height: 1;
        color: #fff !important;
    }

    .invoice-address-row #clientAddress .edit-client:hover,
    .invoice-address-row #clientAddress .edit-client:focus-visible {
        background: linear-gradient(135deg, #4338ca, #4f46e5) !important;
        color: #fff !important;
        transform: translateY(-1px);
    }

    @media (prefers-reduced-motion: reduce) {
        .invoice-address-row * { transition: none !important; }
    }
</style>

<div class="invoice-address-row mt-2">

    <!-- From Address Card -->
    <div class="addr-card addr-from bg-blue">
        <input type="hidden" name="user_state_id" id="user_state_id" value="{{ setting('state_id') }}">

        <div class="addr-card-header">
            <div class="addr-head-l">
                <span class="addr-ic"><i class="bi bi-building"></i></span>
                <div>
                    <span class="addr-label">From</span>
                    <span class="addr-sub">Your business</span>
                </div>
            </div>

            <div class="addr-actions">
                <a href="{{ route('settings.edit') }}" target="_blank" class="addr-action-link is-solid">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>

        @if($hasFrom)
        <div class="addr-body">
            <div class="addr-logo">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}"
                         alt="{{ $setting->company_name ?? 'Company' }} logo"
                         loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                @endif
                <span class="addr-logo-fb" @if($logoUrl) style="display:none;" @endif>{{ $initial }}</span>
            </div>

            <div class="addr-info">
                @if(!empty($setting->company_name ?? '' ))
                    <strong>{{ $setting->company_name ?? '' }}</strong>
                @endif

                @if(!empty($setting->address_1 ?? '' ))
                    <span class="addr-line">{{ $setting->address_1 ?? '' }}</span>
                @endif

                @if(!empty($setting->address_2 ?? '' ))
                    <span class="addr-line">{{ $setting->address_2 ?? '' }}</span>
                @endif

                @if($fromLine !== '')
                    <span class="addr-line">{{ $fromLine }}</span>
                @endif
            </div>
        </div>
        @else
        <div class="addr-empty">
            <i class="bi bi-info-circle"></i>
            <span>Add your business address in settings so it shows on the invoice.</span>
        </div>
        @endif
    </div>

    <!-- Client -->
    <div class="addr-card addr-to bg-blue">

        <div class="addr-card-header">

            <div class="addr-head-l">
                <span class="addr-ic"><i class="bi bi-person text-white"></i></span>
                <div>
                    <span class="addr-label required">To</span>
                    <span class="addr-sub">Client you are billing</span>
                </div>
            </div>

            <div class="addr-actions">

                <a href="{{ route('client.add') }}"
                   target="_blank"
                   class="addr-action-link clientActionBtn new-client"
                   id="new-client-btn"
                   style="display:none;">

                    <i class="bi bi-plus-lg"></i>
                    New Client

                </a>

                <a href="#"
                   onclick="event.preventDefault()"
                   class="addr-action-link clientActionBtn change-client">

                    <i class="bi bi-arrow-repeat"></i>
                    Change

                </a>

            </div>

        </div>

        <div id="clientSearchBox">

            <div class="addr-search">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    class="form-control"
                    id="client"
                    name="client_name"
                    placeholder="Search client by name, email or phone"
                    autocomplete="off">
            </div>

            <input type="hidden" id="client_id" name="client_id">
            <input type="hidden" id="client_state_id" name="client_state_id">

            <div
                id="clientList"
                class="list-group w-100 z-3"
                style="display:none;max-height:220px;overflow:auto;">
            </div>

        </div>

        <div id="clientAddress" style="display:none;"></div>

    </div>

</div>