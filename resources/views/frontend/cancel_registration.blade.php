@extends('frontend.master')
@section('content')
<style>
    .notes-text {
        font-size: 10px;
    }
</style>


<body style="overflow-x:hidden;">


    <div id="wrapper">
        <section id="registration-form-view">
            <div class="content-wrap content-wrap-workshop-registration">
                <div class="container">
                    <div class="mx-auto mb-0" id="tab-login-register" style="max-width: 700px;">
                        <div class="card mb-0s">
                            <div class="card-body" style="padding: 10px;">
                                <div class="row " style="border-bottom:var(--cnvs-themecolor) solid 5px;">
                                    <div>
                                        <img src="{{ asset($data['form_setting']['page_header_banner_image_url']) }}" alt="{{ asset($data['form_setting']['page_header_banner_image_alt']) }}">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6 col-md-5">
                                        <label for="Name">Name:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Name">
                                            {{ $data['registration_data']['first_name'] ?? '' }} {{ $data['registration_data']['last_name'] ?? '' }}
                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Email">Email:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Email Value">
                                            {{ $data['registration_data']['registered_email'] ?? '' }}
                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Mobile No">Mobile:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Mobile No Value">
                                            +{{ $data['registration_data']['country_code'] ?? '' }}-{{ $data['registration_data']['mobile_no'] ?? '' }}
                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Registration Number">Registration # :</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Registration Number Value" class="border border-1 border-success bg-success bg-opacity-10 p-1">
                                            {{ $data['registration_data']['registration_number'] ?? '' }}
                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Program Name">Program:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Name Value">
                                            <span> {{ $data['registration_data']['program_name'] ?? '' }} </span>
                                            <a href="{{ $data['registration_data']['direct_login_short_url'] ?? '' }}" target="_blank" class="badge bg-info text-dark">
                                                View More Details <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Program Name">Schedule:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Name Value">
                                            <span> {{ $data['registered_program_start_dates_month_txt'] }} ( {{ $data['registered_program_start_time_am_pm'] }} To {{ $data['registered_program_end_time_am_pm'] }} {{ $data['registered_program_duration'] }} {{ $data['registered_program_duration_time_unit'] }} ) (IST) </span>

                                        </label>
                                    </div>

                                    <div class="col-6 col-md-5">
                                        <label for="Program Name">Status:</label>
                                    </div>
                                    <div class="col-6 col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Name Value">
                                            <span class="{{ $data['registration_data']['selection_status'] == 'Cancelled' ? 'badge bg-danger' :'badge bg-success' }}">
                                                {{ $data['registration_data']['selection_status'] ?? '' }}
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" name="registration_number" id="registration_number" value="{{ $data['registration_data']['registration_number'] ?? '' }}">

                                <div class="row mt-3 text-center">
                                    <div class="col-12">

                                        @if($data['registration_data']['payment_status_id'] == '0' )
                                        <a href="#" class="btn btn-md {{ $data['status'] == 'Cancel Registration' ? 'btn-danger': 'btn-success' }} cancel-registration">
                                            <i class="fa-solid fa-right-to-bracket"></i> {{ $data['status'] }}
                                        </a>
                                        @else
                                         <div class="alert alert-danger mt-2 mx-5 text-center "  id="msg" role="alert"> You are not allow to change registration status</div>
                                        @endif

                                        <div class="alert mt-2 mx-5 text-center" style="display: none;" id="msg" role="alert"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

        </section><!-- #registration section end -->








    </div>


    <script>
        $('.cancel-registration').on('click', function(e) {
            e.preventDefault();
            const registration_number = "{{ $data['registration_data']['registration_number'] ?? '' }}";
            try {
                $.ajax({
                    url: "{{ $data['url'] }}",
                    data: {
                        registration_number: registration_number
                    },
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        console.log(response)
                        $('#msg').show();
                        $('#msg').text(response.message);

                        if (response.error == 0) {
                            $('#msg').addClass('alert-success');
                            $('#msg').removeClass('alert-danger');

                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }

                        if (response.error == 1) {
                            $('#msg').addClass('alert-danger');
                            $('#msg').removeClass('alert-success');
                        }


                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>


    @endsection