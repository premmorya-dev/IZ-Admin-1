<x-default-layout>
    <!-- iz-settings v2 (fixed header) -->
    <style>
        .iz-set {
            --i1: #4f46e5;
            --i2: #7c3aed;
            --bd: #e8ebf3;
            --mut: #64748b;
            --ink: #0f172a;
            --iz-top: 0px;
            --iz-bar-h: 64px
        }

        .iz-set svg.lucide {
            width: 17px;
            height: 17px
        }

        /* ---------- fixed header ---------- */
        .iz-bar-wrap {
            margin-bottom: 24px
        }

        .iz-bar {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px
        }

        .iz-bar-t {
            min-width: 0;
            flex: 1
        }

        .iz-bar h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: var(--ink);
            transition: font-size .2s
        }

        .iz-bar p {
            margin: 2px 0 0;
            color: var(--mut);
            font-size: 14px
        }

        .iz-bar.is-fixed {
            position: fixed;
            z-index: 95;
            margin: 0;
            box-sizing: border-box;
            padding-top: 12px;
            padding-bottom: 12px;
            background: #fff;
            border-bottom: 1px solid var(--bd);
            box-shadow: 0 12px 24px -18px rgba(15, 23, 42, .4)
        }

        .iz-bar.is-fixed h2 {
            font-size: 20px
        }

        .iz-bar.is-fixed p {
            display: none
        }

        .iz-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex: none
        }

        .iz-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 46px;
            padding: 0 24px;
            border: 0;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
            white-space: nowrap;
            background: linear-gradient(135deg, var(--i1), var(--i2));
            box-shadow: 0 12px 24px -12px rgba(79, 70, 229, .8);
            transition: .2s;
            text-decoration: none !important
        }

        .iz-btn:hover {
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 18px 30px -14px rgba(79, 70, 229, .9)
        }

        .iz-btn:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none
        }

        .iz-btn .t-short {
            display: none
        }

        .iz-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 46px;
            padding: 0 18px;
            border-radius: 12px;
            border: 1.5px solid var(--bd);
            background: #fff;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            white-space: nowrap;
            text-decoration: none !important;
            transition: .2s
        }

        .iz-ghost:hover {
            border-color: #c7d2fe;
            color: var(--i1);
            background: #f8f9ff
        }

        /* ---------- sidebar ---------- */
        .iz-side {
            position: sticky;
            top: calc(var(--iz-top) + var(--iz-bar-h) + 16px)
        }

        .iz-org {
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 22px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 10px 30px -22px rgba(15, 23, 42, .25)
        }

        .iz-org-row {
            display: flex;
            align-items: center;
            gap: 14px
        }

        .iz-av {
            flex: none;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--i1), #a855f7);
            box-shadow: 0 10px 20px -10px rgba(79, 70, 229, .7)
        }

        .iz-org b {
            display: block;
            font-size: 15px;
            color: var(--ink);
            line-height: 1.25;
            word-break: break-word
        }

        .iz-org small {
            display: block;
            color: var(--mut);
            font-size: 12.5px;
            word-break: break-all
        }

        .iz-meter {
            margin-top: 16px
        }

        .iz-meter .m {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--mut);
            margin-bottom: 7px;
            font-weight: 600
        }

        .iz-meter .m b {
            display: inline;
            color: var(--i1);
            font-size: 12px
        }

        .iz-meter .bar {
            display: block;
            width: 100%;
            height: 8px;
            border-radius: 99px;
            background: #eef2ff;
            overflow: hidden
        }

        .iz-navlist {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            gap: 6px;
            padding: 10px;
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 22px;
            box-shadow: 0 10px 30px -22px rgba(15, 23, 42, .25)
        }

        .iz-set .iz-navlist .nav-link.iz-tab {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            text-align: left;
            padding: 12px 14px;
            border: 0;
            border-radius: 14px;
            background: transparent;
            color: #475569;
            transition: .2s
        }

        /* per-tab colors */
        .iz-tab.tc-1 {
            --c: #4f46e5;
            --c2: #818cf8;
            --rgb: 79, 70, 229;
            --soft: #eef2ff;
            --ring: #c7d2fe
        }

        .iz-tab.tc-2 {
            --c: #059669;
            --c2: #34d399;
            --rgb: 16, 185, 129;
            --soft: #ecfdf5;
            --ring: #a7f3d0
        }

        .iz-tab.tc-3 {
            --c: #d97706;
            --c2: #fbbf24;
            --rgb: 245, 158, 11;
            --soft: #fffbeb;
            --ring: #fde68a
        }

        .iz-tab.tc-4 {
            --c: #db2777;
            --c2: #f472b6;
            --rgb: 236, 72, 153;
            --soft: #fdf2f8;
            --ring: #fbcfe8
        }

        .iz-tab.tc-5 {
            --c: #0284c7;
            --c2: #38bdf8;
            --rgb: 14, 165, 233;
            --soft: #f0f9ff;
            --ring: #bae6fd
        }

        /* icon (hamesha colorful) */
        .iz-tab .ti {
            flex: none;
            width: 42px;
            height: 42px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            font-size: 19px;
            color: var(--c);
            background: var(--soft);
            border: 1.5px solid var(--ring);
            transition: .25s
        }

        .iz-set .iz-navlist .nav-link.iz-tab:hover {
            background: var(--soft);
            color: var(--c)
        }

        .iz-set .iz-navlist .nav-link.iz-tab:hover .ti {
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 8px 16px -8px rgba(var(--rgb), .6)
        }

        /* active: tab bg + icon outline glow */
        .iz-set .iz-navlist .nav-link.iz-tab.active {
            background: linear-gradient(135deg, var(--soft), #fff);
            color: var(--c);
            box-shadow: inset 0 0 0 1.5px var(--ring)
        }

        .iz-tab.active .ti {
            color: #fff;
            border-color: transparent;
            background: linear-gradient(135deg, var(--c), var(--c2));
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--c), 0 0 22px 4px rgba(var(--rgb), .55);
            animation: izGlow 2.4s ease-in-out infinite
        }

        .iz-tab.active .tx small {
            color: var(--c);
            opacity: .75
        }

        @keyframes izGlow {

            0%,
            100% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--c), 0 0 16px 2px rgba(var(--rgb), .45)
            }

            50% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--c), 0 0 26px 7px rgba(var(--rgb), .65)
            }
        }

        .iz-set .iz-navlist .nav-link.iz-tab.active {
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            color: var(--i1);
            box-shadow: inset 0 0 0 1.5px #c7d2fe
        }

        .iz-tab.active .ti {
            color: #fff;
            background: linear-gradient(135deg, var(--i1), var(--i2));
            box-shadow: 0 8px 16px -8px rgba(79, 70, 229, .8)
        }

        .iz-tab.active .tx small {
            color: #818cf8
        }

        .iz-tab .err-dot {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f43f5e;
            box-shadow: 0 0 0 3px #fff
        }

        /* ---------- cards ---------- */
        .iz-card,
        .iz-set .set-card {
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 22px;
            box-shadow: 0 10px 30px -22px rgba(15, 23, 42, .22);
            margin-bottom: 24px
        }

        .iz-card-h {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 26px;
            border-bottom: 1px solid var(--bd);
            background: linear-gradient(180deg, #fcfcff, #fff);
            border-radius: 22px 22px 0 0
        }

        .iz-ico {
            flex: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 18px;
            color: var(--i1);
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            border: 1px solid #e0e7ff
        }

        .iz-card-h h3 {
            margin: 0;
            font-size: 16.5px;
            font-weight: 700;
            color: var(--ink)
        }

        .iz-card-h p {
            margin: 2px 0 0;
            font-size: 13px;
            color: var(--mut)
        }

        .iz-card-b {
            padding: 26px
        }

        /* x-settings.document-sequence component ko bhi same look */
        .iz-set .set-card {
            padding: 24px 26px
        }

        .iz-set .set-card-title {
            font-size: 16.5px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 3px
        }

        .iz-set .set-card-desc {
            font-size: 13px;
            color: var(--mut);
            margin: 0 0 20px
        }

        .iz-set .set-hint {
            font-size: 12.5px;
            color: #94a3b8
        }

        /* ---------- fields ---------- */
        .iz-set .form-label,
        .iz-set .iz-lbl {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px
        }

        .iz-help {
            color: #a5b4fc;
            font-size: 13px;
            margin-left: 4px;
            cursor: help;
            transition: .2s
        }

        .iz-help:hover {
            color: var(--i1)
        }

        .iz-set .form-control,
        .iz-set .form-select {
            min-height: 48px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 14.5px;
            color: var(--ink);
            transition: .2s
        }

        .iz-set .form-control:focus,
        .iz-set .form-select:focus {
            background-color: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14)
        }

        .iz-set .form-control[readonly] {
            background-color: #f1f5f9;
            color: #64748b;
            cursor: not-allowed
        }

        .iz-set .form-control.is-invalid,
        .iz-set .form-select.is-invalid {
            border-color: #f43f5e;
            background-image: none
        }

        .iz-set .invalid-feedback {
            font-size: 12.5px;
            font-weight: 500
        }

        .iz-set .input-group {
            flex-wrap: nowrap
        }

        .iz-pre .input-group-text {
            border-radius: 12px 0 0 12px;
            border: 1.5px solid #e2e8f0;
            border-right: 0;
            background: #eef2ff;
            color: var(--i1);
            font-weight: 700;
            min-width: 62px;
            justify-content: center
        }

        .iz-pre .form-control {
            border-radius: 0 12px 12px 0
        }

        .iz-suf .form-control {
            border-radius: 12px 0 0 12px
        }

        .iz-suf .form-select {
            border-radius: 0 12px 12px 0;
            border-left: 0;
            max-width: 110px
        }

        /* select2 */
        .iz-set .select2-container {
            width: 100% !important
        }

        .iz-set .select2-container .select2-selection--single {
            height: 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            transition: .2s;
            outline: 0
        }

        .iz-set .select2-container .select2-selection__rendered {
            line-height: 46px !important;
            padding-left: 16px !important;
            padding-right: 44px !important;
            color: var(--ink);
            font-size: 14.5px
        }

        .iz-set .select2-container .select2-selection__placeholder {
            color: #94a3b8
        }

        .iz-set .select2-container .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important
        }

        .iz-set .select2-container--open .select2-selection--single,
        .iz-set .select2-container--focus .select2-selection--single {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14)
        }

        .select2-dropdown {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 22px 44px -18px rgba(15, 23, 42, .28) !important;
            overflow: hidden
        }

        .select2-search--dropdown .select2-search__field {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 8px 10px !important;
            outline: 0
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background: #4f46e5 !important;
            color: #fff !important
        }

        /* switch */
        .iz-switch {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 48px;
            padding: 10px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc
        }

        .iz-switch .form-check-input {
            width: 2.7em;
            height: 1.4em;
            margin: 0;
            cursor: pointer;
            flex: none
        }

        .iz-set .form-check-input:checked {
            background-color: var(--i1);
            border-color: var(--i1)
        }

        .iz-switch label {
            margin: 0;
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer
        }

        .rem-dep {
            transition: .2s
        }

        .rem-dep.is-off {
            opacity: .45;
            pointer-events: none;
            filter: grayscale(.4)
        }

        /* summernote */
        .iz-set .note-editor.note-frame {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: none
        }

        .iz-set .note-editor.note-frame .note-toolbar {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0
        }

        .iz-set .note-editor.note-frame.note-focus,
        .iz-set .note-editor.note-frame:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14)
        }

        /* upload */
        .iz-drop {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 180px;
            padding: 18px;
            margin: 0;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            background: #f8fafc;
            cursor: pointer;
            text-align: center;
            transition: .2s
        }

        .iz-drop:hover,
        .iz-drop.drag {
            border-color: #6366f1;
            background: #eef2ff
        }

        .iz-drop.image-selected {
            border-style: solid;
            border-color: #c7d2fe;
            background: #fff
        }

        .iz-drop img {
            max-height: 130px;
            max-width: 100%;
            object-fit: contain;
            border-radius: 8px
        }

        .iz-drop .ph {
            color: #64748b;
            font-size: 13.5px;
            line-height: 1.5
        }

        .iz-drop .ph i {
            display: block;
            font-size: 30px;
            color: #6366f1;
            margin-bottom: 4px
        }

        .iz-drop .ph small {
            display: block;
            color: #94a3b8;
            font-size: 12px
        }

        .iz-fileinfo {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 8px;
            min-height: 18px;
            word-break: break-all
        }

        .iz-fileinfo.warn {
            color: #b45309;
            font-weight: 600
        }

        .iz-rm {
            display: none;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            padding: 7px 14px;
            border-radius: 10px;
            border: 1.5px solid #fecdd3;
            background: #fff1f2;
            color: #be123c;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s
        }

        .iz-rm:hover {
            background: #ffe4e6
        }

        .iz-tip {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #f5f3ff;
            border: 1px solid #e0e7ff;
            font-size: 12.5px;
            color: #475569;
            line-height: 1.55
        }

        .iz-tip i {
            color: #f59e0b;
            margin-top: 2px
        }

        .iz-banner {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            border: 1px solid #e0e7ff;
            font-size: 13.5px;
            color: #475569;
            line-height: 1.6
        }

        .iz-banner i {
            color: var(--i1);
            font-size: 18px;
            margin-top: 1px
        }

        /* unsaved bar */
        .iz-savebar {
            display: none;
            position: sticky;
            bottom: 16px;
            z-index: 40;
            margin-top: 6px;
            padding: 12px 14px 12px 20px;
            border-radius: 16px;
            background: #0f172a;
            color: #fff;
            box-shadow: 0 24px 44px -16px rgba(15, 23, 42, .55);
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap
        }

        .iz-savebar.show {
            display: flex;
            animation: izup .25s ease both
        }

        .iz-savebar .msg {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600
        }

        .iz-savebar .dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #fbbf24;
            box-shadow: 0 0 0 4px rgba(251, 191, 36, .25)
        }

        .iz-savebar .acts {
            display: flex;
            gap: 10px
        }

        .iz-savebar .iz-btn,
        .iz-savebar .iz-ghost {
            height: 40px;
            padding: 0 18px;
            font-size: 13.5px
        }

        @keyframes izup {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* ---------- responsive ---------- */
        @media (max-width:991px) {
            .iz-side {
                position: static
            }

            .iz-navlist {
                flex-direction: row;
                overflow-x: auto;
                padding: 8px;
                gap: 8px;
                -webkit-overflow-scrolling: touch
            }

            .iz-set .iz-navlist .nav-link.iz-tab {
                width: auto;
                flex: none;
                white-space: nowrap
            }

            .iz-tab .tx small {
                display: none
            }

            .iz-org {
                display: none
            }
        }

        @media (max-width:767px) {
            .iz-bar h2 {
                font-size: 22px
            }

            .iz-card-h,
            .iz-card-b {
                padding-left: 20px;
                padding-right: 20px
            }

            .iz-savebar {
                padding: 12px 14px
            }

            .iz-savebar .acts {
                width: 100%
            }

            .iz-savebar .acts>* {
                flex: 1;
                justify-content: center
            }
        }

        @media (max-width:575px) {
            .iz-bar-wrap {
                margin-bottom: 18px
            }

            .iz-bar {
                gap: 10px
            }

            .iz-bar h2,
            .iz-bar.is-fixed h2 {
                font-size: 18px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }

            .iz-bar p {
                display: none
            }

            .iz-actions {
                gap: 8px
            }

            .iz-ghost {
                width: 42px;
                height: 42px;
                padding: 0
            }

            .iz-ghost .lbl {
                display: none
            }

            .iz-btn {
                height: 42px;
                padding: 0 16px
            }

            .iz-btn .t-full {
                display: none
            }

            .iz-btn .t-short {
                display: inline
            }

            .iz-bar.is-fixed::before {
                inset: -9px -10px;
                border-radius: 16px
            }
        }

        /* active tab ka icon hamesha white */
.iz-set .iz-navlist .nav-link.iz-tab.active .ti,
.iz-set .iz-navlist .nav-link.iz-tab.active .ti i,
.iz-set .iz-navlist .nav-link.iz-tab.active .ti i::before{
    color:#fff!important;
    -webkit-text-fill-color:#fff!important;
}
    </style>

    @php
    $st = $data['setting'];
    $au = Auth::user();

    // logo / signature
    $storedSignature = $st->signature ? asset($st->signature) : '';
    $showSignature = $storedSignature && !str_contains($storedSignature, 'no-image.png');
    $storedLogo = $st->logo_path ? asset($st->logo_path) : '';
    $showLogo = $storedLogo && !str_contains($storedLogo, 'no-image.png');

    // sidebar org card
    $display = $st->company_name ?: trim(($au->first_name ?? '') . ' ' . ($au->last_name ?? ''));
    $initials = collect(preg_split('/\s+/', trim($display)))->filter()->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('') ?: 'IZ';

    // profile completeness
    $checks = [
    !empty($st->company_name), !empty($st->user_gst_number), !empty($st->address_1),
    !empty($st->country_id), !empty($st->state_id), !empty($st->pincode),
    !empty($au->mobile_no), $showLogo, $showSignature,
    ];
    $done = collect($checks)->filter()->count();
    $pct = (int) round(($done / count($checks)) * 100);

    // tabs me validation error hai?
    $tabErr = function (array $fields, array $prefixes = []) use ($errors) {
    foreach ($fields as $f) { if ($errors->has($f)) return true; }
    foreach ($errors->keys() as $k) { foreach ($prefixes as $p) { if (str_starts_with($k, $p)) return true; } }
    return false;
    };
    $errGeneral = $tabErr(['mobile_country_code_id','email','mobile_no','company_name','is_company','user_gst_number','display_gst_number','address_1','address_2','country_id','state_id','pincode']);
    $errInvoice = $tabErr(['default_currency','default_tax_id','default_discount_id','default_upi_id','pagination_limit','date_format','shipping_status','notes','terms']);
    $errSequence = $tabErr([], ['invoice_sequence','estimate_sequence','bill_sequence','expense_sequence']);
    $errBrand = $tabErr(['logo_path','signature']);
    $errAlerts = $tabErr(['invoice_payment_reminder_status','reminder_before_due_days','everyday_reminder_after_due_day']);

    $firstErrTab = $errGeneral ? 'tab-general-btn' : ($errInvoice ? 'tab-invoicing-btn' : ($errSequence ? 'tab-sequence-btn' : ($errBrand ? 'tab-branding-btn' : ($errAlerts ? 'tab-alerts-btn' : null))));
    @endphp

    <div class="iz-set" id="izSet">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf

            <!-- FIXED HEADER (scroll karne par upar chipka rehta hai) -->
            <div class="iz-bar-wrap" id="izBarWrap">
                <div class="iz-bar" id="izBar">
                    <div class="iz-bar-t">
                        <h2>Business Settings</h2>
                        <p>Manage your company profile, invoicing rules, branding and alerts.</p>
                    </div>
                    <div class="iz-actions">
                        <a href="{{ route('dashboard') }}" class="iz-ghost" title="Back"><i data-lucide="arrow-left"></i><span class="lbl">Back</span></a>
                        <button type="submit" class="iz-btn js-save"><i data-lucide="save"></i><span class="t-full">Save settings</span><span class="t-short">Save</span></button>
                    </div>
                </div>
            </div>

            <div class="row g-6">

                <!-- ===================== SIDEBAR ===================== -->
                <div class="col-lg-3">
                    <div class="iz-side">

                        <div class="iz-org">
                            <div class="iz-org-row">
                                <div class="iz-av">{{ $initials }}</div>
                                <div>
                                    <b>{{ $display ?: 'Your business' }}</b>
                                    <small>{{ $st->email ?? $au->email }}</small>
                                </div>
                            </div>
                            <div class="iz-meter">
                                <div class="m"><span>Profile completeness</span><b>{{ $pct }}%</b></div>
                                <div class="bar"><span style="display:block;height:100%;width:{{ $pct }}%;border-radius:99px;background:linear-gradient(90deg,#818cf8,#34d399)"></span></div>
                            </div>
                        </div>

                        <div class="nav iz-navlist" id="settingsTab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link iz-tab tc-1 active" id="tab-general-btn" data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab">
                                <span class="ti"><i class="bi bi-briefcase-fill"></i></span>
                                <span class="tx"><b>Contact &amp; Company</b><br><small>Profile, address, GST</small></span>
                                @if($errGeneral)<span class="err-dot"></span>@endif
                            </button>
                            <button class="nav-link iz-tab tc-2" id="tab-invoicing-btn" data-bs-toggle="pill" data-bs-target="#tab-invoicing" type="button" role="tab">
                                <span class="ti"><i class="bi bi-file-earmark-text-fill"></i></span>
                                <span class="tx"><b>Invoicing</b><br><small>Currency, tax, defaults</small></span>
                                @if($errInvoice)<span class="err-dot"></span>@endif
                            </button>
                            <button class="nav-link iz-tab tc-3" id="tab-sequence-btn" data-bs-toggle="pill" data-bs-target="#tab-sequence" type="button" role="tab">
                                <span class="ti"><i class="bi bi-123"></i></span>
                                <span class="tx"><b>Automatic Numbering</b><br><small>Document number sequences</small></span>
                                @if($errSequence)<span class="err-dot"></span>@endif
                            </button>
                            <button class="nav-link iz-tab tc-4" id="tab-branding-btn" data-bs-toggle="pill" data-bs-target="#tab-branding" type="button" role="tab">
                                <span class="ti"><i class="bi bi-palette-fill"></i></span>
                                <span class="tx"><b>Branding</b><br><small>Logo &amp; signature</small></span>
                                @if($errBrand)<span class="err-dot"></span>@endif
                            </button>
                            <button class="nav-link iz-tab tc-5" id="tab-alerts-btn" data-bs-toggle="pill" data-bs-target="#tab-alerts" type="button" role="tab">
                                <span class="ti"><i class="bi bi-bell-fill"></i></span>
                                <span class="tx"><b>Alerts</b><br><small>Payment reminders</small></span>
                                @if($errAlerts)<span class="err-dot"></span>@endif
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ===================== CONTENT ===================== -->
                <div class="col-lg-9">
                    <div class="tab-content" id="settingsTabContent">

                        <!-- ===================== CONTACT + COMPANY ===================== -->
                        <div class="tab-pane fade show active" id="tab-general" role="tabpanel">

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-telephone"></i></span>
                                    <div>
                                        <h3>Contact info</h3>
                                        <p>How customers and the system reach your business.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-4">
                                            <label for="mobile_country_code_id" class="form-label">Country code
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select your country code for mobile number."></i></label>
                                            <select name="mobile_country_code_id" id="mobile_country_code_id" class="form-select @error('mobile_country_code_id') is-invalid @enderror">
                                                <option value="">-- Select Country Code --</option>
                                                @foreach($data['mobile_country_list'] as $country)
                                                <option
                                                    value="{{ $country->mobile_country_code_id }}"
                                                    data-code="{{ $country->country_code }}"
                                                    data-flag="{{ $country->flag_icon_class }}"
                                                    {{ old('mobile_country_code_id', Auth::user()->mobile_country_code_id ?? '') == $country->mobile_country_code_id ? 'selected' : '' }}>
                                                    {{ $country->country_name }} (+{{ $country->country_code }})
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('mobile_country_code_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="email" class="form-label">Email
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Your registered business email address. Cannot be changed."></i></label>
                                            <input type="email" name="email" id="email" readonly class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data['setting']->email ?? '') }}">
                                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="mobile_no" class="form-label">Mobile no
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter your valid business mobile number."></i></label>
                                            <div class="input-group iz-pre">
                                                <span class="input-group-text" id="country_code_prefix">+--</span>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no', Auth::user()->mobile_no ?? '') }}">
                                            </div>
                                            @error('mobile_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-building"></i></span>
                                    <div>
                                        <h3>Company info</h3>
                                        <p>Legal details shown on invoices and estimates.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-5">
                                            <label for="company_name" class="form-label">Company name
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter your registered business or company name."></i></label>
                                            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $data['setting']->company_name ?? '') }}">
                                            @error('company_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="is_company" class="form-label">Business type
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select whether you are an organisation or an individual."></i></label>
                                            <select name="is_company" id="is_company" class="form-select @error('is_company') is-invalid @enderror">
                                                <option value="Y" {{ old('is_company', $data['setting']->is_company ?? '') == 'Y' ? 'selected' : '' }}>Organisation</option>
                                                <option value="N" {{ old('is_company', $data['setting']->is_company ?? '') == 'N' ? 'selected' : '' }}>Individual</option>
                                            </select>
                                            @error('is_company')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="user_gst_number" class="form-label">Business GST number
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter your business GSTIN and select whether to display it on invoices and estimates."></i></label>
                                            <div class="input-group iz-suf">
                                                <input type="text" name="user_gst_number" id="user_gst_number" class="form-control @error('user_gst_number') is-invalid @enderror" placeholder="Enter your GSTIN" value="{{ old('user_gst_number', $data['setting']->user_gst_number ?? '') }}">
                                                <select name="display_gst_number" id="display_gst_number" class="form-select @error('display_gst_number') is-invalid @enderror" data-bs-toggle="tooltip" title="Choose whether to display the GST number on invoices and estimates.">
                                                    <option value="Y" {{ old('display_gst_number', $data['setting']->display_gst_number ?? '') == 'Y' ? 'selected' : '' }}>Show</option>
                                                    <option value="N" {{ old('display_gst_number', $data['setting']->display_gst_number ?? '') == 'N' ? 'selected' : '' }}>Hide</option>
                                                </select>
                                            </div>
                                            @error('user_gst_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                            @error('display_gst_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="address_1" class="form-label">Address line 1
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter the first line of your business address."></i></label>
                                            <input type="text" name="address_1" id="address_1" class="form-control @error('address_1') is-invalid @enderror" value="{{ old('address_1', $data['setting']->address_1 ?? '') }}">
                                            @error('address_1')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="address_2" class="form-label">Address line 2
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter additional address details, if any."></i></label>
                                            <input type="text" name="address_2" id="address_2" class="form-control @error('address_2') is-invalid @enderror" value="{{ old('address_2', $data['setting']->address_2 ?? '') }}">
                                            @error('address_2')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="country_id" class="form-label">Country
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select your business country."></i></label>
                                            <select name="country_id" id="country_id" class="form-select @error('country_id') is-invalid @enderror">
                                                <option value="">-- Select Country --</option>
                                                @foreach($data['countries'] as $country)
                                                <option value="{{ $country->country_id }}" {{ old('country_id', $data['setting']->country_id ?? '') == $country->country_id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('country_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="state_id" class="form-label">State
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select your business state or region."></i></label>
                                            <select name="state_id" id="state_id" class="form-select @error('state_id') is-invalid @enderror">
                                                <option value="">-- Select State --</option>
                                                @foreach($data['states']->where('country_id', $data['setting']->country_id) as $state)
                                                <option value="{{ $state->state_id }}" {{ old('state_id', $data['setting']->state_id ?? '') == $state->state_id ? 'selected' : '' }}>
                                                    {{ $state->state_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('state_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="pincode" class="form-label">Pincode
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enter the postal or ZIP code for your business address."></i></label>
                                            <input type="text" name="pincode" id="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $data['setting']->pincode ?? '') }}">
                                            @error('pincode')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===================== AUTOMATIC NUMBERING ===================== -->
                        <div class="tab-pane fade" id="tab-sequence" role="tabpanel">

                            <div class="iz-banner">
                                <i class="bi bi-info-circle-fill"></i>
                                <div>Set how your document numbers are generated. New documents pick the next number automatically using the prefix and sequence below.</div>
                            </div>

                            <x-settings.document-sequence
                                title="Invoice Numbering"
                                description="Configure how invoice numbers are automatically generated."
                                label="Invoice"
                                name="invoice_sequence"
                                placeholder="INV-"
                                :sequence="$invoiceSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Estimate Numbering"
                                description="Configure how estimate numbers are automatically generated."
                                label="Estimate"
                                name="estimate_sequence"
                                placeholder="EST-"
                                :sequence="$estimateSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Bill Numbering"
                                description="Configure how bill numbers are automatically generated."
                                label="Bill"
                                name="bill_sequence"
                                placeholder="BILL-"
                                :sequence="$billSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Expense Numbering"
                                description="Configure how expense numbers are automatically generated."
                                label="Expense"
                                name="expense_sequence"
                                placeholder="EXP-"
                                :sequence="$expenseSequence" />
                        </div>

                        <!-- ===================== INVOICING ===================== -->
                        <div class="tab-pane fade" id="tab-invoicing" role="tabpanel">

                            @php
                            $selectedFormat = old('date_format', $data['setting']->date_format ?? 'MdY');
                            $formats = [
                            'Y M d' => date('Y M d'),
                            'd M Y' => date('d M Y'),
                            'M d Y' => date('M d Y'),
                            'Y-m-d' => date('Y-m-d'),
                            'd-m-Y' => date('d-m-Y'),
                            'm-d-Y' => date('m-d-Y'),
                            'd.m.Y' => date('d.m.Y'),
                            ];
                            @endphp

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-sliders"></i></span>
                                    <div>
                                        <h3>Document defaults</h3>
                                        <p>Currency, tax, discount and UPI applied to new documents.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-6 col-xl-3">
                                            <label for="default_currency" class="form-label">Default currency
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select the currency that will be used by default for all invoices and estimates."></i></label>
                                            <select id="default_currency" name="default_currency" class="form-select">
                                                <option value="">Please Select</option>
                                                @foreach($data['currencies'] as $currency )
                                                <option value="{{ $currency->currency_code }}" {{ old('default_currency', $data['setting']->default_currency ?? '') == $currency->currency_code ? 'selected' : '' }}> {{ $currency->currency_name }} | {{ $currency->currency_symbol }}</option>
                                                @endforeach
                                            </select>
                                            @error('default_currency')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 col-xl-3">
                                            <label for="default_tax_id" class="form-label">Default tax %
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Choose a default tax percentage that will automatically apply to all new invoices."></i></label>
                                            <select id="default_tax_id" name="default_tax_id" class="form-select">
                                                <option value="0">No Tax</option>
                                                @foreach($data['taxes'] as $tax )
                                                <option value="{{ $tax->tax_id }}" {{ old('default_tax_id', $data['setting']->default_tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                                                @endforeach
                                            </select>
                                            @error('default_tax_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 col-xl-3">
                                            <label for="default_discount_id" class="form-label">Default discount %
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select a default discount percentage to apply automatically to new invoices."></i></label>
                                            <select id="default_discount_id" name="default_discount_id" class="form-select">
                                                <option value="0">No Discount</option>
                                                @foreach($data['discounts'] as $discount )
                                                <option value="{{ $discount->discount_id }}" {{ old('default_discount_id', $data['setting']->default_discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                                                @endforeach
                                            </select>
                                            @error('default_discount_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 col-xl-3">
                                            <label for="default_upi_id" class="form-label">Default UPI ID
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select your default UPI account that the UPI QR code will be shown on invoices for payment."></i></label>
                                            <select id="default_upi_id" name="default_upi_id" class="form-select">
                                                <option value="0">Please Select</option>
                                                @foreach($data['upi_payment_id'] as $upi_id )
                                                <option value="{{ $upi_id->upi_log_id }}" {{ old('default_upi_id', $data['setting']->default_upi_id ?? '') == $upi_id->upi_log_id ? 'selected' : '' }}>{{ $upi_id->upi_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('default_upi_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-layout-text-window"></i></span>
                                    <div>
                                        <h3>Display &amp; format</h3>
                                        <p>How lists, dates and addresses appear across the app.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-4">
                                            <label for="pagination_limit" class="form-label">Pagination limit
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Set how many records you want to display per page in list views."></i></label>
                                            <input type="number" name="pagination_limit" id="pagination_limit" class="form-control @error('pagination_limit') is-invalid @enderror" value="{{ old('pagination_limit', $data['setting']->pagination_limit ?? 10) }}">
                                            @error('pagination_limit')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="date_format" class="form-label">Default date format
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select the date format that will appear on your invoices, estimate and reports."></i></label>
                                            <select id="date_format" name="date_format" class="form-select">
                                                @foreach($formats as $key => $sample)
                                                <option value="{{ $key }}" {{ $selectedFormat == $key ? 'selected' : '' }}>{{ $sample }}</option>
                                                @endforeach
                                            </select>
                                            @error('date_format')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="shipping_status" class="form-label">Display shipping address
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enable this option to display the shipping address on invoices and estimates."></i></label>
                                            <select name="shipping_status" id="shipping_status" class="form-select @error('shipping_status') is-invalid @enderror">
                                                <option value="N" {{ old('shipping_status', $data['setting']->shipping_status ?? '') == 'N' ? 'selected' : '' }}>Hide</option>
                                                <option value="Y" {{ old('shipping_status', $data['setting']->shipping_status ?? '') == 'Y' ? 'selected' : '' }}>Show</option>
                                            </select>
                                            @error('shipping_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-card-text"></i></span>
                                    <div>
                                        <h3>Notes &amp; terms</h3>
                                        <p>Shown at the bottom of every invoice and estimate.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-6">
                                            <label class="form-label">Notes</label>
                                            <textarea name="notes" id="id_notes" class="form-control">{{ old('notes', $data['setting']->notes) }}</textarea>
                                            @error('notes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Terms and conditions</label>
                                            <textarea name="terms" id="id_terms" class="form-control">{{ old('terms', $data['setting']->terms) }}</textarea>
                                            @error('terms')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===================== BRANDING ===================== -->
                        <div class="tab-pane fade" id="tab-branding" role="tabpanel">

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-image"></i></span>
                                    <div>
                                        <h3>Branding</h3>
                                        <p>Your logo and signature appear on invoices and estimates.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-6">

                                        <!-- LOGO -->
                                        <div class="col-md-6">
                                            <label for="logo_path" class="form-label">Company logo
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Upload your business logo to appear on invoices and estimates. Recommended size: 200x200px."></i></label>

                                            <label class="iz-drop {{ $showLogo ? 'image-selected' : '' }}" id="upload-box-logo">
                                                <input type="file" class="image-upload d-none" name="logo_path" id="logo_path" accept="image/*" onchange="previewImage(event)">
                                                <img id="preview-logo_path" src="{{ $showLogo ? $storedLogo : '' }}" style="display: {{ $showLogo ? 'block' : 'none' }}" alt="Uploaded Logo">
                                                <span class="ph" style="display: {{ $showLogo ? 'none' : 'block' }};">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                    Click to upload or drag &amp; drop
                                                    <small>PNG, JPG up to 100 KB</small>
                                                </span>
                                            </label>
                                            <div class="iz-fileinfo" id="info-logo_path"></div>
                                            @error('logo_path')<div class="text-danger set-hint mt-1">{{ $message }}</div>@enderror

                                            <button type="button" class="iz-rm" id="rm-logo_path" style="display: {{ $showLogo ? 'inline-flex' : 'none' }}" onclick="izRemoveImage('logo_path')">
                                                <i class="bi bi-trash3"></i> Remove logo
                                            </button>
                                            @if ($showLogo)
                                            <input type="hidden" name="remove_logo_path" id="remove_logo_path" value="0">
                                            @endif

                                            <div class="iz-tip">
                                                <i class="bi bi-lightbulb-fill"></i>
                                                <div>Use a high-quality logo up to <strong>600×400 px</strong> and keep the file size below <strong>100 KB</strong>.</div>
                                            </div>
                                        </div>

                                        <!-- SIGNATURE -->
                                        <div class="col-md-6">
                                            <label for="signature" class="form-label">Digital signature
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Upload your authorized signature to be printed on invoices automatically. Recommended size: 200x100px."></i></label>

                                            <label class="iz-drop {{ $showSignature ? 'image-selected' : '' }}" id="upload-box-signature">
                                                <input type="file" class="image-upload d-none" name="signature" id="signature" accept="image/*" onchange="previewImage(event)">
                                                <img id="preview-signature" src="{{ $showSignature ? $storedSignature : '' }}" style="display: {{ $showSignature ? 'block' : 'none' }};" alt="Uploaded Signature">
                                                <span class="ph" style="display: {{ $showSignature ? 'none' : 'block' }};">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                    Click to upload or drag &amp; drop
                                                    <small>PNG with transparent background works best</small>
                                                </span>
                                            </label>
                                            <div class="iz-fileinfo" id="info-signature"></div>
                                            @error('signature')<div class="text-danger set-hint mt-1">{{ $message }}</div>@enderror

                                            <button type="button" class="iz-rm" id="rm-signature" style="display: {{ $showSignature ? 'inline-flex' : 'none' }}" onclick="izRemoveImage('signature')">
                                                <i class="bi bi-trash3"></i> Remove signature
                                            </button>
                                            @if ($showSignature)
                                            <input type="hidden" name="remove_signature" id="remove_signature" value="0">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===================== ALERTS ===================== -->
                        <div class="tab-pane fade" id="tab-alerts" role="tabpanel">

                            <div class="iz-card">
                                <div class="iz-card-h">
                                    <span class="iz-ico"><i class="bi bi-bell"></i></span>
                                    <div>
                                        <h3>Payment reminders</h3>
                                        <p>Automatically notify customers about upcoming or overdue invoices.</p>
                                    </div>
                                </div>
                                <div class="iz-card-b">
                                    <div class="row g-5">
                                        <div class="col-md-4">
                                            <label for="invoice_payment_reminder_status" class="form-label">Payment reminder
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Enable or disable payment reminders."></i></label>
                                            <select name="invoice_payment_reminder_status" id="invoice_payment_reminder_status" class="form-select">
                                                <option value="N" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'N' ? 'selected' : '' }}>No</option>
                                                <option value="Y" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'Y' ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 rem-dep">
                                            <label for="reminder_before_due_days" class="form-label">Before due days
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="Select how many days before due date the reminder should be sent."></i></label>
                                            <select name="reminder_before_due_days" id="reminder_before_due_days" class="form-select">
                                                <option value="0">Disable</option>
                                                @for ($i = 1; $i <= 30; $i++)
                                                    <option value="{{ $i }}" {{ old('reminder_before_due_days', $data['setting']->reminder_before_due_days ?? '') == $i ? 'selected' : '' }}>{{ $i }} day{{ $i > 1 ? 's' : '' }}</option>
                                                    @endfor
                                            </select>
                                        </div>

                                        <div class="col-md-4 rem-dep">
                                            <label class="form-label">Every day reminder after due date
                                                <i class="bi bi-question-circle-fill iz-help" data-bs-toggle="tooltip" title="If enabled, all invoices that are already past their due date will receive a reminder notification every day until they are paid."></i></label>
                                            <div class="iz-switch form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="everyday_reminder_after_due_day" name="everyday_reminder_after_due_day"
                                                    {{ !empty($data['setting']->everyday_reminder_after_due_day) && $data['setting']->everyday_reminder_after_due_day == 'Y' ? 'checked' : '' }}>
                                                <label for="everyday_reminder_after_due_day">Send reminder after due date</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- unsaved changes bar -->
                    <div class="iz-savebar" id="izSaveBar">
                        <div class="msg"><span class="dot"></span> You have unsaved changes</div>
                        <div class="acts">
                            <button type="button" class="iz-ghost" id="izDiscard">Discard</button>
                            <button type="submit" class="iz-btn js-save">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        /* ---------- image upload helpers ---------- */
        function izToast(msg) {
            if (window.Swal) Swal.fire({
                icon: 'warning',
                text: msg,
                confirmButtonText: 'Ok',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
            else alert(msg);
        }

        function izMarkDirty() {
            if (window.izMarkDirtyFn) window.izMarkDirtyFn();
        }

        function previewImage(event) {
            const input = event.target;
            const key = input.name; // logo_path | signature
            const file = input.files && input.files[0];
            if (!file) return;

            if (!file.type || file.type.indexOf('image/') !== 0) {
                izToast('Please select an image file (PNG or JPG).');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-' + key);
                preview.src = e.target.result;
                preview.style.display = 'block';

                const box = document.getElementById('upload-box-' + (key === 'logo_path' ? 'logo' : 'signature'));
                const ph = box.querySelector('.ph');
                if (ph) ph.style.display = 'none';
                box.classList.add('image-selected');

                const rm = document.getElementById('rm-' + key);
                if (rm) rm.style.display = 'inline-flex';

                // naya image aaya to purana "remove" flag cancel
                const removeInput = document.getElementById('remove_' + key);
                if (removeInput) removeInput.value = '0';

                const kb = Math.round(file.size / 1024);
                const info = document.getElementById('info-' + key);
                if (info) {
                    info.textContent = file.name + ' · ' + kb + ' KB' + ((key === 'logo_path' && kb > 100) ? ' (larger than 100 KB, consider compressing)' : '');
                    info.classList.toggle('warn', key === 'logo_path' && kb > 100);
                }
                izMarkDirty();
            };
            reader.readAsDataURL(file);
        }

        function izRemoveImage(key) {
            const input = document.querySelector('input[name="' + key + '"]');
            if (input) input.value = '';

            const preview = document.getElementById('preview-' + key);
            if (preview) {
                preview.removeAttribute('src');
                preview.style.display = 'none';
            }

            const box = document.getElementById('upload-box-' + (key === 'logo_path' ? 'logo' : 'signature'));
            const ph = box.querySelector('.ph');
            if (ph) ph.style.display = 'block';
            box.classList.remove('image-selected');

            const rm = document.getElementById('rm-' + key);
            if (rm) rm.style.display = 'none';

            const info = document.getElementById('info-' + key);
            if (info) {
                info.textContent = '';
                info.classList.remove('warn');
            }

            const removeInput = document.getElementById('remove_' + key);
            if (removeInput) removeInput.value = '1';

            izMarkDirty();
        }

        // purane naam compatible rakhe
        function removeSavedImage(type) {
            izRemoveImage(type);
        }
    </script>
    <script>
        /* ---------- FIXED HEADER (navbar se chipka, 0 gap) ----------
   Bar navbar ke theek neeche rehta hai. Agar navbar ke peeche chhup jaye ya gap dikhe
   to EXTRA badal do (px me, + neeche / - upar). */
        (function() {
            var EXTRA = 0;

            var wrap = document.getElementById('izBarWrap');
            var bar = document.getElementById('izBar');
            var root = document.getElementById('izSet');
            if (!wrap || !bar || !root) return;

            // content area jiske andar bar poori width me failega
            var main = document.getElementById('kt_app_main') || document.querySelector('.app-main');

            var fixed = false,
                raf = null;

            // layout ke fixed top header ki height (Metronic: #kt_app_header)
            function headerBottom() {
                var h = document.getElementById('kt_app_header') || document.querySelector('.app-header');
                if (h) {
                    var cs = getComputedStyle(h);
                    if (cs.display !== 'none' && (cs.position === 'fixed' || cs.position === 'sticky')) {
                        return Math.max(0, h.getBoundingClientRect().bottom);
                    }
                }
                var el = document.elementFromPoint(window.innerWidth / 2, 2);
                while (el && el !== document.body && el !== document.documentElement) {
                    if (!bar.contains(el)) {
                        var p = getComputedStyle(el).position;
                        if (p === 'fixed' || p === 'sticky') return Math.max(0, el.getBoundingClientRect().bottom);
                    }
                    el = el.parentElement;
                }
                return 0;
            }

            function unfix() {
                fixed = false;
                bar.classList.remove('is-fixed');
                bar.style.top = bar.style.left = bar.style.width = bar.style.paddingLeft = bar.style.paddingRight = '';
                wrap.style.height = '';
            }

            function update() {
                raf = null;
                var top = 0;
                var wr = wrap.getBoundingClientRect();

                if (!fixed) wrap.style.height = ''; // natural height measure

                if (wr.top <= top) {
                    if (!fixed) {
                        wrap.style.height = bar.offsetHeight + 'px'; // jagah reserve, content jump na kare
                        bar.classList.add('is-fixed');
                        fixed = true;
                    }
                    var mr = main ? main.getBoundingClientRect() : {
                        left: 0,
                        right: document.documentElement.clientWidth
                    };
                    var left = mr.left;
                    var right = mr.right;

                    bar.style.top = top + 'px';
                    bar.style.left = left + 'px';
                    bar.style.width = (right - left) + 'px';
                    bar.style.paddingLeft = Math.max(0, wr.left - left) + 'px'; // title content se align rahe
                    bar.style.paddingRight = Math.max(0, right - wr.right) + 'px';
                } else if (fixed) {
                    unfix();
                }

                root.style.setProperty('--iz-top', top + 'px');
                root.style.setProperty('--iz-bar-h', (fixed ? bar.offsetHeight : wrap.offsetHeight) + 'px');
            }

            function schedule() {
                if (!raf) raf = requestAnimationFrame(update);
            }

            window.addEventListener('scroll', schedule, {
                passive: true,
                capture: true
            });
            window.addEventListener('resize', function() {
                if (fixed) unfix();
                schedule();
            });
            window.addEventListener('load', schedule);
            document.addEventListener('shown.bs.tab', schedule);
            setTimeout(schedule, 300);
            schedule();
        })();
    </script>

    <script>
        $(function() {

            /* ---------- dirty tracking ---------- */
            var ready = false,
                dirty = false;
            var $bar = $('#izSaveBar');
            window.izMarkDirtyFn = function() {
                if (!ready || dirty) return;
                dirty = true;
                $bar.addClass('show');
            };
            setTimeout(function() {
                ready = true;
            }, 900);

            $('#settingsForm').on('input change', 'input, select, textarea', function() {
                izMarkDirtyFn();
            });
            $('#izDiscard').on('click', function() {
                dirty = false;
                window.location.reload();
            });

            /* ---------- save button loading ---------- */
            $('#settingsForm').on('submit', function() {
                dirty = false;
                var $btns = $('.js-save');
                setTimeout(function() {
                    $btns.prop('disabled', true);
                    $btns.find('span').text('Saving...');
                    $btns.filter('.iz-savebar .js-save').text('Saving...');
                }, 0);
            });

            /* ---------- summernote ---------- */
            var sn = {
                height: 130,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ],
                callbacks: {
                    onChange: function() {
                        izMarkDirtyFn();
                    }
                }
            };
            $('#id_notes').summernote($.extend({
                placeholder: 'Enter notes...'
            }, sn));
            $('#id_terms').summernote($.extend({
                placeholder: 'Enter terms...'
            }, sn));

            /* ---------- tooltips + icons ---------- */
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                if (window.bootstrap) new bootstrap.Tooltip(el);
            });
            if (window.lucide) lucide.createIcons();

            /* ---------- select2 ---------- */
            $('#mobile_country_code_id').select2({
                placeholder: "Choose Country Code",
                allowClear: true
            });
            $('#country_id').select2({
                placeholder: "Choose Country",
                allowClear: true
            });
            $('#state_id').select2({
                placeholder: "Choose State",
                allowClear: true
            });
            $('#default_currency').select2({
                placeholder: "Choose Default Currency",
                allowClear: true
            });
            $('#default_tax_id').select2({
                placeholder: "Choose Default Tax",
                allowClear: true
            });
            $('#default_discount_id').select2({
                placeholder: "Choose Default Discount",
                allowClear: true
            });
            $('#default_upi_id').select2({
                placeholder: "Choose UPI ID",
                allowClear: true
            });

            /* ---------- country -> states ---------- */
            $('#country_id').on('change', function() {
                var countryID = $(this).val();
                $('#state_id').html('<option value="">Loading...</option>').trigger('change.select2');
                if (countryID) {
                    $.ajax({
                        url: "{{ route('get.states.by.country') }}",
                        type: "GET",
                        data: {
                            country_id: countryID
                        },
                        success: function(res) {
                            $('#state_id').empty().append('<option value="">-- Select State --</option>');
                            $.each(res.states, function(key, state) {
                                $('#state_id').append('<option value="' + state.state_id + '">' + state.state_name + '</option>');
                            });
                            $('#state_id').val('').trigger('change');
                        },
                        error: function() {
                            $('#state_id').html('<option value="">-- Select State --</option>').trigger('change.select2');
                        }
                    });
                } else {
                    $('#state_id').html('<option value="">-- Select State --</option>').trigger('change.select2');
                }
            });

            /* ---------- mobile country code prefix ---------- */
            function updatePrefix() {
                var selectedOption = $('#mobile_country_code_id').find('option:selected');
                var code = selectedOption.data('code') || '--';
                $('#country_code_prefix').text('+' + code);
            }
            $('#mobile_country_code_id').on('change', updatePrefix);
            updatePrefix();

            /* ---------- reminder dependencies ---------- */
            function toggleReminder() {
                var on = $('#invoice_payment_reminder_status').val() === 'Y';
                $('.rem-dep').toggleClass('is-off', !on);
            }
            $('#invoice_payment_reminder_status').on('change', toggleReminder);
            toggleReminder();

            /* ---------- drag & drop uploads ---------- */
            document.querySelectorAll('.iz-drop').forEach(function(box) {
                var input = box.querySelector('input[type=file]');
                ['dragenter', 'dragover'].forEach(function(ev) {
                    box.addEventListener(ev, function(e) {
                        e.preventDefault();
                        box.classList.add('drag');
                    });
                });
                ['dragleave', 'drop'].forEach(function(ev) {
                    box.addEventListener(ev, function(e) {
                        e.preventDefault();
                        box.classList.remove('drag');
                    });
                });
                box.addEventListener('drop', function(e) {
                    if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                        input.files = e.dataTransfer.files;
                        previewImage({
                            target: input
                        });
                    }
                });
            });

            /* ---------- tab persistence (+ validation error tab) ---------- */
            var KEY = 'iz_settings_tab';
            var errTab = @json($firstErrTab);
            var target = errTab;
            if (!target) {
                try {
                    target = localStorage.getItem(KEY);
                } catch (e) {}
            }
            if (target) {
                var el = document.getElementById(target);
                if (el && window.bootstrap) bootstrap.Tab.getOrCreateInstance(el).show();
            }
            document.querySelectorAll('#settingsTab [data-bs-toggle="pill"]').forEach(function(b) {
                b.addEventListener('shown.bs.tab', function() {
                    try {
                        localStorage.setItem(KEY, b.id);
                    } catch (e) {}
                });
            });
        });
    </script>
</x-default-layout>