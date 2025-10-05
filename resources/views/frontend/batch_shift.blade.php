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

                                    <div class="container mt-2">
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <label class="d-block mb-2 fw-bold text-start">
                                                    Please choose your preferred program:
                                                </label>

                                                @foreach($data['registration_data']['preferred_program_options'] as $preferred_program_options)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="preferred_program" {{ $data['preferred_program_exist'] ? 'checked' : '' }} id="preferred-program-{{ $preferred_program_options->program_id }}" value="{{ $preferred_program_options->program_id }}">
                                                    <label class="form-check-label" for="preferred-program-{{ $preferred_program_options->program_id }}">
                                                      {{ $preferred_program_options->program_name }} ( {{ $preferred_program_options->start_datetime }} {{ $preferred_program_options->day }} )
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>






                                </div>

                                <input type="hidden" name="registration_number" id="registration_number" value="{{ $data['registration_data']['registration_number'] ?? '' }}">

                                <div class="row mt-3">
                                    <div class="col-12 text-center">

                                        @if(empty($data['preferred_program_exist']) )
                                        <button type="submit" class="btn btn-primary" id="shift-program-btn">
                                            <i class="fa fa-paper-plane me-2"></i> Submit Request
                                        </button>
                                        @else

                                        <div class="alert alert-success mt-3">Thank you for your response regarding your workshop shift request. We have received your submission and will keep you updated as soon as any changes have been made!  </div>
                                        @endif


                                        <div class="alert mt-3" id="msg"> </div>
                                    </div>
                                </div>


                            </div>
                        </div>

        </section><!-- #registration section end -->

    </div>

    <script>
        $('#shift-program-btn').on('click', function(e) {
            e.preventDefault();
            const registration_number = "{{ $data['registration_data']['registration_number'] ?? '' }}";
            const preferred_program = $('input[name="preferred_program"]:checked').val();
            try {
                $.ajax({
                    url: "{{ route('preferred.batch.shift') }}",
                    data: {
                        registration_number: registration_number,
                        preferred_program: preferred_program
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