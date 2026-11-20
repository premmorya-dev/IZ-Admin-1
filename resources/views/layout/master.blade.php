<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->

<head>
    <link rel="manifest" href="/manifest.json">

    <meta name="theme-color" content="#0A0E1A">

    <meta name="mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style"
        content="black-translucent">

    <meta name="apple-mobile-web-app-title"
        content="InvoiceZy">

    <link rel="apple-touch-icon"
        href="/icons/icon-192.png">

    <script>
        (function() {
            if (window.location.hostname !== 'pro.invoicezy.com') {
                return;
            }

            window.dataLayer = window.dataLayer || [];

            // Load Google Tag Manager
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });

                var f = d.getElementsByTagName(s)[0];
                var j = d.createElement(s);
                var dl = l !== 'dataLayer' ? '&l=' + l : '';

                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' +
                    i + dl;

                f.parentNode.insertBefore(j, f);
            })(
                window,
                document,
                'script',
                'dataLayer',
                'GTM-P4H69F72'
            );
        })();
    </script>


    <base href="" />
    <title>InvoiceZy</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="app-version" content="{{ config('app.version') }}">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>



    {!! sprintf('<script src="%s"></script>', asset('assets/js/jquery.js')) !!}
    {!! sprintf('<script src="%s"></script>', asset('assets/js/multiselect-dropdown.js')) !!}

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach

    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->

    <!-- jQuery (must be first) -->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @livewireStyles

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



    <style>
        :root {
            /* ---- Typography ---- */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-mono: 'SFMono-Regular', Consolas, 'Liberation Mono', monospace;

            --fs-xs: 0.75rem;
            /* 12px - captions, badges */
            --fs-sm: 0.8125rem;
            /* 13px - table text, helper text */
            --fs-base: 0.9375rem;
            /* 15px - body / inputs */
            --fs-md: 1.0625rem;
            /* 17px - card titles */
            --fs-lg: 1.375rem;
            /* 22px - section headings */
            --fs-xl: 1.75rem;
            /* 28px - page titles */

            --fw-regular: 400;
            --fw-medium: 500;
            --fw-semibold: 600;
            --fw-bold: 700;

            /* ---- Color — neutral slate + single indigo accent ---- */
            --c-primary: #4F46E5;
            --c-primary-hover: #4338CA;
            --c-primary-soft: #EEF2FF;

            --c-success: #16A34A;
            --c-success-soft: #F0FDF4;
            --c-danger: #DC2626;
            --c-danger-soft: #FEF2F2;
            --c-warning: #D97706;
            --c-warning-soft: #FFFBEB;

            --c-text: #0F172A;
            --c-text-muted: #64748B;
            --c-border: #E2E8F0;
            --c-border-strong: #CBD5E1;
            --c-bg: #F8FAFC;
            --c-surface: #FFFFFF;

            /* ---- Shape / elevation ---- */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;

            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 12px 32px rgba(15, 23, 42, 0.12);
        }


        .badge {
            font-weight: var(--fw-medium);
            font-size: var(--fs-xs);
            border-radius: 999px;
            padding: 0.3em 0.7em;
        }

        .badge.bg-success {
            background-color: var(--c-success-soft) !important;
            color: var(--c-success) !important;
        }

        .badge.bg-danger {
            background-color: var(--c-danger-soft) !important;
            color: var(--c-danger) !important;
        }

        .badge.bg-warning {
            background-color: var(--c-warning-soft) !important;
            color: var(--c-warning) !important;
        }

        /* NOTE: kept on purpose — other pages/components may still use this keyframe */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, .45);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        .modal-header.bg-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;
        }

        /* ===== Universal modal header: text/icons always white ===== */
        .modal-header,
        .modal-header .modal-title,
        .modal-header h1,
        .modal-header h2,
        .modal-header h3,
        .modal-header h4,
        .modal-header h5,
        .modal-header h6,
        .modal-header p,
        .modal-header span,
        .modal-header small,
        .modal-header i,
        .modal-header svg,
        .modal-header.text-dark,
        .modal-header .text-dark {
            color: #fff !important;
        }

        /* Close (X) button: always a white X on a transparent background,
   even where the markup uses class="btn-close bg-white" */
        .modal-header .btn-close {
            background-color: transparent !important;
            filter: brightness(0) invert(1);
            opacity: .9;
            box-shadow: none;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        /* Yellow header par white text unreadable hota hai, isliye warning ko darker amber gradient */
        .modal-header.bg-warning {
            background: linear-gradient(135deg, #d97706, #b45309) !important;
        }
    </style>
</head>
<!--end::Head-->

<div class="spinner-border text-primary spinner-format" id="loader" style="display:none;" role="status">
    <span class="visually-hidden"></span>
</div>

<!-- Modal -->
<div class="modal fade " id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm text-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyModalLabel">Copy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Copy To Clipboard Successfully
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--begin::Body-->

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    @foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used by this page)-->
    @foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(optional)-->
    @foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('success', (message) => {
                toastr.success(message);
            });
            Livewire.on('error', (message) => {
                toastr.error(message);
            });

            Livewire.on('swal', (message, icon, confirmButtonText) => {
                if (typeof icon === 'undefined') {
                    icon = 'success';
                }
                if (typeof confirmButtonText === 'undefined') {
                    confirmButtonText = 'Ok, got it!';
                }
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            });
        });
    </script>

    @livewireScripts

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "500",
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif

        @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
        @endif

        function copyToClipboard(value) {

            if (navigator.clipboard && window.isSecureContext) {

                navigator.clipboard.writeText(value)
                    .then(() => {
                        showCopyStatus();
                    })
                    .catch((err) => {
                        showCopyStatus();
                        console.error('Clipboard API error:', err);
                    });
            }

            function showCopyStatus() {
                //$('#copyModal').modal('show');
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "100",
                    "hideDuration": "100",
                    "timeOut": "800",
                    "extendedTimeOut": "800",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.success("Copy To Clipboard Successfully");
            }

        }
    </script>

    <script>
        lucide.createIcons();
    </script>


    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/invoice.bundle.js') }}"></script>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                }).catch(function(error) {
                    console.error('Service Worker Error:', error);
                });
            });
        }
    </script>
</body>
<!--end::Body-->

</html>