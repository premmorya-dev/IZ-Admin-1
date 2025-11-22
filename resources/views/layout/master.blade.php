<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->

<head>

<script>
    // Load Google Analytics only on pro.invoicezy.com
    if (window.location.hostname === "pro.invoicezy.com") {

        // Load GA script dynamically
        let gaTag = document.createElement("script");
        gaTag.async = true;
        gaTag.src = "https://www.googletagmanager.com/gtag/js?id=G-E0NH65K8GD";
        document.head.appendChild(gaTag);

        // Initialize GA
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }

        gtag('js', new Date());
        gtag('config', 'G-E0NH65K8GD');

        console.log("Google Analytics loaded for: pro.invoicezy.com");
    } else {
        console.log("Google Analytics NOT loaded (not pro.invoicezy.com)");
    }
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




    <style>
        a {
            pointer-events: auto;
            /* Ensures links are clickable */
            z-index: 1;
            /* Makes sure the anchor tag is above other elements */
        }

        [readonly] {
            background-color: #eeeeee;
        }

        .slider-checkbox {
            position: relative;
            display: inline-block;
            width: 34px;
            /* Reduced width */
            height: 17px;
            /* Reduced height */
        }

        /* Hide default checkbox */
        .slider-checkbox input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Slider background */
        .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 17px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Circle inside slider */
        .slider:before {
            position: absolute;
            content: "";
            height: 13px;
            /* Reduced size */
            width: 13px;
            /* Reduced size */
            left: 2px;
            /* Adjusted position */
            bottom: 2px;
            /* Adjusted position */
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        /* When checkbox is checked, change the background color */
        input:checked+.slider {
            background-color: #007bff;
        }

        /* Move the circle when the checkbox is checked */
        input:checked+.slider:before {
            transform: translateX(17px);
            /* Adjusted for the smaller size */
        }

        @media (min-width: 992px) {
            .device-setion-margin {
                margin-bottom: 0px !important;
            }

        }

        .device-setion-margin {
            margin-bottom: 120px;
            ;
        }

        .notification-field-set {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            background-color: #ffffff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            background-color: #0d0e12;
            border: none !important;
            opacity: 80%;

        }

        .select-all-notification-checkbox {
            font-size: 10px;
        }

        .ls-1 {
            letter-spacing: 0.5px;
        }

        .ls-2 {
            letter-spacing: 1px;
        }

        .ls-3 {
            letter-spacing: 2px;
        }

        .custom-alert-danger {
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .custom-alert-danger li {
            padding: 5px 0;
        }

        .spinner-format {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50px;
            height: 50px;
        }

        .divider {
            border: 0;
            height: 2px;
            background-color: #007bff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-header-fixed {
            position: sticky;
            top: 0;
            z-index: 1030;
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
        }

        .page-header-fixed.scrolled {
            background-color: rgba(248, 249, 250, 0.6);
            /* More transparent */
            backdrop-filter: blur(1px);
        }

        .page-header-fixed .btn {
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @livewireStyles

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">




</head>
<!--end::Head-->
<!-- Modal -->

<div class="spinner-border text-primary spinner-format" id="loader" style="display:none;" role="status">
    <span class="visually-hidden"></span>
</div>

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
    <div class="modal fade" id="invoiceDemoModal" tabindex="-1" aria-labelledby="invoiceDemoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="invoiceDemoModalLabel">Invoice Demo Video</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="stopLocalVideo()"></button>
                </div>
                <div class="modal-body p-0">
                    <video id="invoiceVideo" class="w-100 rounded" controls>
                        <source src="{{ asset('video/invoicezy_demo.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <script>
        const videoEl = document.getElementById('invoiceVideo');
        const invoiceDemoModal = document.getElementById('invoiceDemoModal');

        invoiceDemoModal.addEventListener('shown.bs.modal', () => {
            videoEl.currentTime = 0;
            videoEl.play();
        });

        function stopLocalVideo() {
            videoEl.pause();
            videoEl.currentTime = 0;
        }
    </script>
    <!-- <script>
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.page-header-fixed');
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script> -->


    <script>
        lucide.createIcons();
    </script>

    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
<!--end::Body-->

</html>