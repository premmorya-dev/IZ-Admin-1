@extends('frontend.master')
@section('content')

<body class="stretched">
    <div class="loader">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Document Wrapper
	============================================= -->
    {!! $data['form_setting']['start_body_script'] !!}
    <div id="wrapper">

        <!-- Header
		============================================= -->

        <!-- #header end -->




        <!-- Registration section start
		============================================= -->


        <section id="registration-form">
            <div class="content-wrap content-wrap-workshop-registration">
                <div class="container">
                    <div class="mx-auto mb-0" id="tab-login-register">
                        <div class="card mb-0s">
                            <div class="card-body" style="padding: 10px;">
                                <div class="row " style="border-bottom:var(--cnvs-themecolor) solid 5px;">
                                    <div>
                                        <img src="{{ asset($data['form_setting']['page_header_banner_image_url']) }}" alt="{{ asset($data['form_setting']['page_header_banner_image_alt']) }}">
                                    </div>
                                </div>

                                <form id="user_signup" name="user_signup" method="post" class="mb-0" method="post" target="_top">

                                    @if( $data['form_setting']['registration_form_show_importants_notes'] == 'Y')
                                    <div data-readmore="true" data-readmore-trigger-open="Read More <i class='fa-solid fa-chevron-down'></i>" data-readmore-trigger-close="Read Less <i class='fa-solid fa-chevron-up'></i>" class="read-more-wrap" style="transition-duration: 500ms; height: 10rem;">
                                        {!! $data['form_setting']['registration_form_importants_notes'] !!}


                                        <a href="#" class="btn btn-link text-primary read-more-trigger center">Read More <i class="fa-solid fa-chevron-down"></i></a>
                                        <div class="read-more-mask op-ts op-0 op-1" style="height: 100%; background-image: linear-gradient(rgba(255, 255, 255, 0), rgb(255, 255, 255));"></div>
                                    </div>


                                    @endif



                                    @if($data['form_setting']['registration_show_support_contacts'] == 'Y' )

                                    <div class="row">
                                        <div class="col-md-12 center">
                                            <strong>For Help & Support</strong>
                                        </div>

                                        @if($data['form_setting']['support_contacts_json'])

                                        @foreach($data['form_setting']['support_contacts_json'] as $position => $number)
                                        <div class="col-md-6">
                                            <span>{{ $position }} : {{$number}}</span>
                                        </div>

                                        @endforeach

                                        @endif

                                    </div>
                                    @endif

                                    <div class="promo promo-light">
                                        <h4 class="mt-3 center"> {{ $data['form_setting']['registration_page_form_heading'] }} </h4>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 form-group mt-1">


                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>
                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="name" class="mt-2">{{$data['form_setting']['lable_first_name_field']}}*:</label>
                                                @endif
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;" >
                                                        <a href="" id="help-first-name-modal-btn" onclick="event.preventDefault();$('#help-first-name-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>
                                            </div>

                                            <input type="text" value="" title="{{$data['form_setting']['placeholder_text_first_name']}}" placeholder="{{$data['form_setting']['placeholder_text_first_name']}}" onKeyUp="return check_fist_name_error(this.value)" id="first_name" name="first_name" class="form-control mt-1">
                                            <span class="text-danger" id="error-msgname"></span>

                                        </div>

                                        <div class="col-md-12 form-group mt-1">

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>
                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="last_name" class="mt-2">{{$data['form_setting']['lable_last_name_field']}}:</label>
                                                @endif
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;" >
                                                        <a href="" id="help-last-name-modal-btn" onclick="event.preventDefault();$('#help-last-name-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>

                                            <input type="text" value="" title="{{$data['form_setting']['placeholder_text_last_name']}}" onKeyUp="return check_last_name_error(this.value)" placeholder="{{$data['form_setting']['placeholder_text_last_name']}}" id="last_name" name="last_name" class="form-control mt-1">
                                            <span class="text-danger" id="error-msglname"></span>

                                        </div>


                                        @if( $data['form_setting']['registration_enable_gender_field'] == 'Y')
                                        <div class="col-md-12 form-group mt-1">

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>

                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="gender" class="mt-2">{{$data['form_setting']['label_gender_field']}}*:</label>
                                                @endif


                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <a href="" id="help-gender-modal-btn" onclick="event.preventDefault();$('#help-gender-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>

                                            <select name="gender" id="gender" onChange="return check_gender_error(this.value)" class=" form-select mt-1">
                                                <option value="0">[ {{$data['form_setting']['placeholder_text_gender']}} ]</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

                                            </select>


                                            <span class="text-danger" id="error-msgGender"></span>

                                        </div>

                                        @endif


                                        @if( $data['form_setting']['registration_enable_age_field'] == 'Y')
                                        <div class="col-md-12 form-group mt-1">

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>

                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="age" class="mt-2">{{$data['form_setting']['lable_age_field']}}*:</label>
                                                @endif


                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <a href="" id="help-age-modal-btn" onclick="event.preventDefault();$('#help-age-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>

                                            <select name="age" id="age" onChange="return check_age_error(this.value)" class=" form-select mt-1">
                                                <option value="0">[ {{$data['form_setting']['placeholder_text_age']}} ]</option>
                                                @foreach( $data['allowed_age'] as $age)
                                                <option value="{{ $age }}">{{ $age }}</option>
                                                @endforeach
                                            </select>


                                            <span class="text-danger" id="error-msgAge"></span>

                                        </div>

                                        @endif






                                        <div class="col-md-12 form-group mt-1">



                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fas fa-envelope"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>
                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="email" class="mt-2">{{$data['form_setting']['lable_email_field']}}*:</label>
                                                @endif
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <a href="" id="help-email-modal-btn" onclick="event.preventDefault();$('#help-email-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>


                                            <input type="email" id="email_id" onKeyUp="return check_mail1_error(this.value)" name="email_id" title="{{$data['form_setting']['placeholder_text_email']}}" placeholder="{{$data['form_setting']['placeholder_text_email']}}" value="" class="form-control mt-1">

                                            <span class="text-danger" id="error-msgemail"></span>

                                        </div>


                                        <div class="col-md-12 form-group mt-1" style="margin-bottom:0px !important;">
                                            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                            <label for="mobile">{{$data['form_setting']['lable_mobile_no_field']}}*:</label>

                                            @endif

                                        </div>


                                        <div class="col-md-4 form-group" id="select-error-mobile_country_code_id">
                                            <div class="input-group">


                                                <select name="mobile_country_code_id" id="mobile_country_code_id" onChange="return check_mobile_country_code_id_error(this.value)" class=" form-select">
                                                    <option value="0">[Country Code]</option>
                                                    @foreach( $data['mobile_country_list'] as $mobile_country_code)
                                                    <option value="{{ $mobile_country_code->mobile_country_code_id }}" {{ old('mobile_country_code_id', $data['form_setting']['registration_default_mobile_country']) == $mobile_country_code->mobile_country_code_id ? 'selected' : '' }}>{{ $mobile_country_code->country_name  }} ( +{{ $mobile_country_code->country_code }} )</option>
                                                    @endforeach
                                                </select>
                                                <!--!select start! -->
                                                <span class="text-danger" id="error-msgmobile_country_code_id"></span>

                                            </div>


                                        </div>

                                        <div class="col-md-8  form-group">
                                            <input type="text" maxlength="10" id="mobile" onKeyUp="return check_mobile_error(this.value)" name="mobile" title="{{$data['form_setting']['placeholder_text_mobile']}}" placeholder="{{$data['form_setting']['placeholder_text_mobile']}}" value="" class="form-control">
                                            <span class="text-danger" id="error-msgmobile"></span>

                                        </div>


                                        @if( $data['form_setting']['registration_enable_college_insitute_field'] == 'Y')
                                        <div class="col-md-12 form-group mt-1">



                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fas fa-university"></i><!-- FontAwesome icon -->
                                                    </span>
                                                </div>
                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="college_name" class="mt-2">{{$data['form_setting']['lable_college_field']}}*:</label>
                                                @endif
                                                <div class="input-group-append" >
                                                    <span class="input-group-text" style="border: none;background-color: white;" >
                                                        <a href="" id="help-college-modal-btn" onclick="event.preventDefault();$('#help-college-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>



                                            <input type="text" value="" title="{{$data['form_setting']['placeholder_text_college']}}" placeholder="{{$data['form_setting']['placeholder_text_college']}}" onKeyUp="return check_collage_name_error(this.value)" id="c_name" name="college_name" class="form-control mt-1">
                                            <span class="text-danger" id="error-msgcollege"></span>
                                        </div>
                                        @endif


                                        @if( $data['form_setting']['registration_enable_city_field'] == 'Y')
                                        <div class="col-md-12 form-group mt-1">


                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa-solid fa-city"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>
                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="city" class="mt-2">{{$data['form_setting']['lable_city_field']}}*:</label>
                                                @endif

                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <a href="" id="help-city-modal-btn" onclick="event.preventDefault();$('#help-city-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>


                                            <input type="text" value="" title="{{$data['form_setting']['placeholder_text_city']}}" placeholder="{{$data['form_setting']['placeholder_text_city']}}" onKeyUp="return check_city_name_error(this.value)" id="city" name="city" class="form-control mt-1">
                                            <span class="text-danger" id="error-msgcity"></span>
                                        </div>
                                        @endif




                                        @if( $data['form_setting']['registration_enable_country_field'] == 'Y')

                                        <div class="col-md-12 form-group mt-1" id="select-error-country_id">
                                            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                            <label for="Select Country"  >Select Country*:</label>
                                            @endif

                                            <div class="input-group">
                                                <!-- <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> 
                                                    </span>
                                                </div> -->

                                                <select name="country_id" id="country_id" seo-url={{ $data['form_setting']['seo_url'] }} onChange="return check_country_id_error(this.value)" class="form-select">
                                                    <option value="0">[Select Country Type]</option>
                                                    @foreach( $data['country'] as $country)
                                                    <option value="{{ $country->country_id }}" {{ old('country_id', $data['form_setting']['registration_default_country_field']) == $country->country_id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>

                                                <!-- <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <i class="fas fa-question-circle"></i> 
                                                    </span>
                                                </div> -->

                                            </div>




                                            <span class="text-danger" id="error-msgcountry_id"></span>

                                        </div>


                                        @endif




                                        @if( $data['form_setting']['registration_enable_state_field'] == 'Y')

                                        <div class="col-md-12 form-group mt-1 load-state" id="select-error-state_id">
                                            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                            <label for="Select State" >Select State*:</label>
                                            @endif
                                            <!--!select start! -->
                                            <select name="state_id" id="state_id" onChange="return check_state_id_error(this.value)" class="form-select">
                                                <option value="0">[Select State Type]</option>
                                                @foreach( $data['country_to_state_code'] as $state)
                                                <option value="{{ $state->country_state_id }}" {{ old('country_state_id') == $state->country_state_id ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                            <!--!select start! -->

                                            <span class="text-danger" id="error-msgstate_id"></span>

                                        </div>


                                        @endif





                                        <div class="col-md-12 form-group mt-1" id="select-error-program">



                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text me-1">
                                                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                                                    </span>
                                                </div>


                                                @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                                <label for="Select Program" class="mt-2">Select Program*:</label>
                                                @endif
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="border: none;background-color: white;">
                                                        <a href="" id="help-program-model-btn" onclick="event.preventDefault();$('#help-program-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                                                    </span>
                                                </div>

                                            </div>






                                            <select name="program_id" id="program" onChange="return check_program_error(this.value)" class="form-select mt-1">
                                                <option value="0">[Select Program Type]</option>
                                                @foreach( $data['event_program'] as $program)
                                                <option {{ $program->rstatus == 0 ? "disabled='disabled'" : '' }} value="{{ $program->program_id }}" {{ old('program_id') == $program->program_id ? 'selected' : '' }}>{{ $program->program_name }} ( {{ $program->start_datetime }} ) {{ $program->program_duration }} {{ $program->program_duration_time_unit }} {{ $program->rstatus == 0 ? '[ ' . $program->rstatus_disable_reason . ' ]' : '' }}
                                                </option>

                                                @endforeach

                                            </select>

                                            <span class="text-danger" id="error-msgworktype"></span>

                                        </div>


                                        <div class="col-md-12 form-group mt-1" id="seat-container">



                                            @if( $data['event_program_max_count'] == 'show_seat')
                                            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
                                            <label for="login-form-password" class="mt-2" >Seats*:</label>
                                            @endif
                                            <select name="seats" id="seats" onChange="return check_seats_error(this.value)" style="font-size:14px;" class=" form-select ">
                                                <option value="">[Select Seats]</option>

                                            </select>
                                            <span class="text-danger" id="error-msgseat"></span>
                                            @endif





                                            <input type="hidden" value="1" name="currency_id">
                                            <input type="hidden" value="{{ $data['form_setting']['seo_url'] }}" name="seo_handle">

                                            <input type="hidden" value="0" name="country_state_id">
                                            <input type="hidden" name="college" id="workshop_level" value="college">




                                        </div>


                                        @if( $data['form_setting']['registration_enable_terms_condition_checkbox'] == 'Y')
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" id="agree" class="" name="">
                                            <label>Agree Term and Condition</label> <br>
                                            <span class="text-danger" id="error-msgagree"></span>
                                        </div>
                                        @endif

                                        <div class="col-md-12 form-group">

                                            <span class="text-danger" id="error-user_exist"></span>
                                        </div>




                                        <div class="col-md-12 form-group">

                                            <div class="mb-2 mt-2 center">
                                                <span style="text-align:center"><button href="javascript:;" title="Register" class="button button-large px-lg-5 py-lg-3  m-0 mb-4 g-recaptcha" data-sitekey="6LeAVEgpAAAAADDlL2Ozqy8Sfqzj3FsxSFyAATSV" data-callback='register_workshop' id="register-btn" data-action='submit'><i class="fa-solid fa-right-to-bracket"></i>Register</button></span>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="utm_source" type="hidden" name="utm_source" value="{{ request('utm_source', '') }}">
                                    <input id="rff" type="hidden" name="referrer" value="{{ request('referrer', '') }}">
                                    <input id="utm_medium" type="hidden" name="utm_medium" value="{{ request('utm_medium', '') }}">
                                    <input id="utm_campaign" type="hidden" name="utm_campaign" value="{{ request('utm_campaign', '') }}">
                                    <input id="utm_term" type="hidden" name="utm_term" value="{{ request('utm_term', '') }}">
                                    <input id="utm_content" type="hidden" name="utm_content" value="{{ request('utm_content', '') }}">
                                    <input id="full_url" type="hidden" name="full_url" value="{{ request('full_url', '') }}">

                                </form>


                            </div>
                        </div>
                    </div>
        </section><!-- #registration section end -->



        <!-- sample certificate area -->
        @if( $data['form_setting']['registration_show_sample_certificate'] == 'Y')
        <section id="#sample-certificate">
            <div class="content-wrap content-wrap-workshop-registration">
                <div class="container">
                    <div class="mx-auto mb-0" id="tab-login-register" style="max-width: 700px;">
                        <div class="card mb-0s">
                            <div class="card-body" style="padding: 10px;">
                                <div class="promo promo-light">
                                    <h5 class="center">Sample Certificate</h5>
                                </div>
                                <div class="col-md-12 center">
                                    <img src="{{ asset($data['form_setting']['sample_certificate_url']) }}" width="400px;" alt="sample certificate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!-- sample certificate area end -->



        <!-- program tiles area -->

        @if($data['program_tiles'] && $data['form_setting']['show_program_tiles_registration_page'] =='Y' )

        <section id="workshop-grid-list">
            <div class="content-wrap content-wrap-workshop-registration">
                <div class="container">
                    <div class="mx-auto mb-0" id="tab-login-register" style="max-width: 700px;">
                        <div class="card mb-0">
                            <div class="card-body" style="padding: 10px;">

                                <div class="promo promo-light">
                                    <h4 class="mt-3 center">All Other Program Under Same Event</h4>

                                </div>
                                <div class="row g-4 mb-5">

                                    @foreach($data['program_tiles'] as $program)

                                    @if($program->status == 'active')
                                    <article class="entry event col-md-6 col-lg-6 mb-0">
                                        <div class="grid-inner bg-white row g-0 p-3 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                                            <div class="col-12 mb-md-0">
                                                <a href="{{ $program->program_details_page_url }}" class="entry-image">
                                                    <img src="{{ asset($program->program_thumb_image_url) }}" alt="{{ $program->program_name }}" class="rounded-2">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content justify-content-start align-items-start">
                                                            <div class="badge bg-light text-dark rounded-pill">{{ $program->event_program_title }} ({{ $program->event_program_mode }})</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-12 p-4 pt-0">


                                                <div class="entry-title nott">
                                                    <h3><a href="{{ $program->program_details_page_url }}">{{ $program->program_name }}</a></h3>
                                                </div>
                                                <div class="entry-content my-3">
                                                    <p class="mb-0">{{ $program->program_short_description }}</p>
                                                </div>

                                                <div class="entry-meta no-separator">
                                                    <ul>
                                                        <li><i class="fa-solid fa-calendar-days"></i> {{ $program->start_datetime }}</li>

                                                        <li><i class="uil uil-map-marker"></i>Venue : {{ $program->location_name }}</li>
                                                        <li><i class="fa-solid fa-tags"></i> Fee : <i class="fa-solid fa-inr"></i> {{ $program->fees }} + {{ $program->tax_rate }}% {{ $program->tax_name }}</li>
                                                        <li><i class="bi-mortarboard"></i> Certification: {{ $program->certificate_authority }}</li>
                                                        <li><i class="fa-regular fa-clock"></i> Duration: {{ $program->program_duration }} {{ $program->program_duration_time_unit }}</li>

                                                    </ul>
                                                </div>
                                                <div class="mb-4 mt-4 center">
                                                    @if( isset($program->show_short_description) && $program->show_short_description == 'Y' )
                                                    <a href="{{ url('/') }}/event/registration/{{ $program->seo_url }}"
                                                        class="button button-large py-lg-3"
                                                        style="padding-right: 30px !important; padding-left: 40px !important; background-color: blue;"
                                                        onmouseover="this.style.backgroundColor='black';"
                                                        onmouseout="this.style.backgroundColor='blue';">
                                                        <i class="fa-brands fa-readme"></i>Learn More
                                                    </a>
                                                    @endif
                                                    <a href="#registration-form" class="button button-large px-lg-5 py-lg-3 "><i class="fa-solid fa-right-to-bracket"></i>Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>


                                    @endif
                                    @endforeach



                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </section>


        @endif

        <!-- program tiles area end-->

        <!-- #workshop grid section end -->

        @include('frontend.help_text')




        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- <script src="{{ asset('assets/js/functions.bundle.js') }}"></script> -->

        {!! $data['form_setting']['end_body_script'] !!}



    </div><!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="uil uil-angle-up rounded-circle bg-color h-bg-dark"></div>

</body>

@endsection