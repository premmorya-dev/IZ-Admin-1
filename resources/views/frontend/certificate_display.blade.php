<html dir="ltr" lang="en-US">

<head>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PRPWMF9');
    </script>
    <!-- End Google Tag Manager -->





    <!-- Document Title
	============================================= -->
    <title>Workshop Registration Portal : Rendezvous 2024 IIT Delhi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="technocon.org">
    <meta name="description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi">
    <meta property="fb:app_id" content="" />
    <meta property="og:type" content="event" />
    <meta property="og:title" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta property="og:url" content="{{ url('/') }}/event/registration/test" />
    <meta property="og:image" content="{{ url('/') }}/assets/images/og-images/rdv-iit-delhi-og-image.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="650" />
    <meta property="og:description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@" />
    <meta name="twitter:title" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi" />
    <meta name="twitter:description" content="Workshop Registration Portal : Rendezvous 2024 IIT Delhi">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/og-images/rdv-iit-delhi-og-image.jpg" />
    <meta name="twitter:image:width" content="1200" />
    <meta name="twitter:image:height" content="600" />

    <link rel="icon" href="{{ url('/') }}/assets/images/favicons/favicon.png">






    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&family=Cookie&display=swap" rel="stylesheet">

    <!-- Core Style -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css ">

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/registration/font-icons.css">

    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/registration/swiper.css">

    <!-- Saas Page Module Specific Stylesheet -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/saas-2.css">
    <!-- select2 CSS -->
    <link href="{{ url('/') }}/assets/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/custom.css">

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2539478636234421');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=2539478636234421&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <script src="{{ url('/') }}/assets/js/jquery.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

</head>

<body style="overflow-x:hidden;">


    <div id="wrapper">
        <section id="content">
            <div class="content-wrap bg-light">
                <div class="container">

                    <div class="row col-mb-80">
                        <main class="postcontent col-lg-12">

                            <div class="row g-4 mb-5">

                                <article class="entry event col-12 mb-0">
                                    <div class="grid-inner bg-white row g-0 p-3 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">

                                        <div class="heading-block text-center">
                                            <h1> {{ !empty($data['certificate_data']) ? 'Certificate Validated' : 'Certificate Not Found' }} </h1>

                                        </div>

                                        <div class="card border-0 mx-auto" style="max-width: 800px;">

                                            <div class="card-body p-4">

                                                <div class="form-widget">

                                                    <div class="form-result"></div>
                                                    @if(!empty($data['certificate_data']))
                                                    <form class="mb-0 position-relative" id="modal-health" name="modal-health" action="include/form.php" method="post" enctype="multipart/form-data" novalidate="novalidate">


                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label for="Workshop Name">Certificate Code</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Certificate Code Value">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Certificate Code Value">
                                                                    {{ $data['certificate_data']->certificate_code }}
                                                                </label>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <label for="Certificate Title">Certificate Title</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Certificate Title">
                                                                    {{ $data['certificate_data']->certificate_title }}

                                                                </label>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <label for="Event Name">Event Name</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Event Name Value">
                                                                    {{ $data['certificate_data']->event_name }}


                                                                </label>
                                                            </div>






                                                            <div class="col-md-4">
                                                                <label for="Registration Number">Registration Number</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Registration Number Value">
                                                                    {{ $data['certificate_data']->registration_number }}


                                                                </label>
                                                            </div>



                                                            <div class="col-md-4">
                                                                <label for="Candidate First Name">Candidate First Name</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Candidate First Name Value">
                                                                    {{ $data['certificate_data']->first_name }}


                                                                </label>
                                                            </div>






                                                            <div class="col-md-4">
                                                                <label for="Candidate Last Name">Candidate Last Name</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Candidate Last Name Value">
                                                                    {{ $data['certificate_data']->last_name }}


                                                                </label>
                                                            </div>



                                                            <div class="col-md-4">
                                                                <label for="Candidate Last Name">Candidate Email</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Candidate Email Value">
                                                                    {{ $data['certificate_data']->registered_email }}


                                                                </label>
                                                            </div>




                                                            <div class="col-md-4">
                                                                <label for="Candidate Mobile">Candidate Mobile</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Candidate Mobile Value">
                                                                    +{{ $data['certificate_data']->mobile_contry_code }}-{{ $data['certificate_data']->mobile_no }}


                                                                </label>
                                                            </div>




                                                            <div class="col-md-4">
                                                                <label for="Course Name">Program Name</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Course Name Value">
                                                                    {{ $data['certificate_data']->program_name }}


                                                                </label>
                                                            </div>




                                                            <div class="col-md-4">
                                                                <label for="Course Type">Program Type</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Course Types Value">
                                                                    {{ $data['certificate_data']->program_type }}


                                                                </label>
                                                            </div>



                                                            <div class="col-md-4">
                                                                <label for="Course Date">Program Start Date</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>


                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Course Date Value">
                                                                    {{ $data['certificate_data']->program_start_datetime }}


                                                                </label>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <label for="Course Date">Program End Date</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>


                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Course Date Value">
                                                                    {{ $data['certificate_data']->program_end_datetime }}


                                                                </label>
                                                            </div>







                                                            <div class="col-md-4">
                                                                <label for="Course Duration">Program Duration</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Course Duration Value">
                                                                    {{ $data['certificate_data']->program_duration }} {{ $data['certificate_data']->program_duration_time_unit }}


                                                                </label>
                                                            </div>




                                                            <div class="col-md-4">
                                                                <label for="Certificate Status">Certificate Status</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Certificate Status Value">
                                                                    <span class="badge {{ 
                                                                                        $data['certificate_data']->student_certificate_status == 'Pending' ? 'text-bg-warning' :  
                                                                                        ($data['certificate_data']->student_certificate_status == 'Granted' ? 'text-bg-success' : 'text-bg-danger') 
                                                                                    }}">
                                                                        {{ $data['certificate_data']->student_certificate_status }}
                                                                    </span>

                                                                </label>
                                                            </div>









                                                            <div class="col-md-4">
                                                                <label for="Certificate Published On:">Certificate Published On:</label>
                                                            </div>
                                                            <div class="col-md-1" style="font-family:Courier New,Courier,monospace">
                                                                <label for=":">
                                                                    :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                                                <label for="Certificate Published On Value">
                                                                    {{ $data['certificate_data']->date_added }}

                                                                </label>
                                                            </div>






                                                        </div>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </article>



                            </div>


                        </main>


                    </div>

                </div>
            </div>
            <div class="content-wrap py-0">
                <div class="clear"></div>
                <div id="section-blog" class="page-section pb-5" style="background: linear-gradient(to bottom, transparent 40%, rgba(var(--bs-primary-rgb), .1) 40%);">
                    <div class="container py-5"></div>
                </div>
            </div>

        </section>
    </div>


</body>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ url('/') }}/assets/js/functions.bundle.js"></script>

<script src="{{ url('/') }}/assets/js/plugins.min.js"></script>

<script src="{{ url('/') }}/assets/js/select2.js"></script>