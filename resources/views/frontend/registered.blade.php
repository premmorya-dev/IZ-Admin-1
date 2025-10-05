@extends('frontend.master')
@section('content')
<style>
    .notes-text {
        font-size: 10px;
    }
</style>


<body style="overflow-x:hidden;">
    @if($data['form_setting']['start_body_script'])
    {!! $data['form_setting']['start_body_script'] !!}
    @endif

    @if( isset( $data['registration_success_event_url_parameter']) && $data['registration_success_event_url_parameter'] == $data['form_setting']['registration_success_event_url_parameter_value'] && $data['form_setting']['registration_success_event_script_position'] == 'after_body_start' )
    {!! $data['form_setting']['registration_success_event_script'] !!}
    @endif


    <div id="wrapper">
        <section id="registration-form-view">
            <div class="content-wrap content-wrap-workshop-registration">
                <div class="container">
                    <div class="mx-auto mb-0" id="tab-login-register" >
                        <div class="card mb-0s">
                            <div class="card-body" style="padding: 10px;">
                                <div class="row " style="border-bottom:var(--cnvs-themecolor) solid 5px;">
                                    <div>
                                        <img src="{{ asset($data['form_setting']['page_header_banner_image_url']) }}" alt="{{ asset($data['form_setting']['page_header_banner_image_alt']) }}">
                                    </div>
                                </div>
                                @if( isset($data['registration_data']['after_registration_show_support_contacts']) && $data['registration_data']['after_registration_show_support_contacts'] == 'Y' )
                                <div class="row">

                                    @if( isset($data['registration_data']['support_contacts_json']) && $data['registration_data']['support_contacts_json'])

                                    @foreach($data['registration_data']['support_contacts_json'] as $position => $number)
                                    <div class="col-md-6">
                                        <span>{{ $position }} : <a href="tel:{{$number}}">{{$number}}</a></span>
                                    </div>

                                    @endforeach

                                    @endif
                                </div>

                                @endif


                                @if( isset($data['registration_data']['after_registration_show_support_email']) && $data['registration_data']['after_registration_show_support_email'] == 'Y' )
                                <div class="row">

                                    @if( isset($data['registration_data']['support_email_json']) && $data['registration_data']['support_email_json'])

                                    @foreach($data['registration_data']['support_email_json'] as $position => $number)
                                    <div class="col-md-12 text-center">
                                        <span>{{ $position }} : <a href="mailto:{{$number}}">{{$number}}</a></span>
                                    </div>

                                    @endforeach

                                    @endif
                                </div>

                                @endif





                                <div class="promo promo-light mt-2">
                                    <h4 class="mt-3 center">{{ $data['form_setting']['registration_page_form_heading'] ?? '' }}</h4>
                                </div>
                                <div class="row">




                                    <div class="col-md-5">
                                        <label for="Name">Name:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Name">
                                            {{ $data['registration_data']['first_name'] ?? '' }} {{ $data['registration_data']['last_name'] ?? '' }} </label>
                                    </div>

                                    @if(!empty($data['form_setting']['after_registration_enable_age_field']) && $data['form_setting']['after_registration_enable_age_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="age Name">{{ $data['form_setting']['lable_age_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="age Name Value">
                                            {{ $data['registration_data']['age'] ?? ''}} </label>
                                    </div>

                                    @endif

                                    @if(!empty($data['form_setting']['after_registration_enable_gender_field']) && $data['form_setting']['after_registration_enable_gender_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="gender Name">{{ $data['form_setting']['label_gender_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="gender Name Value">
                                            {{ $data['registration_data']['gender'] ?? ''}} </label>
                                    </div>

                                    @endif








                                    <div class="col-md-5">
                                        <label for="Email">{{ $data['form_setting']['lable_email_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Email Value">
                                            {{ $data['registration_data']['registered_email'] ?? '' }} </label>
                                    </div>


                                    <div class="col-md-5">
                                        <label for="Mobile No">{{ $data['registration_data']['lable_mobile_no_field'] ??  '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Mobile No Value">
                                            +{{ $data['registration_data']['country_code'] ?? '' }}-{{ $data['registration_data']['mobile_no'] ?? '' }} </label>
                                    </div>

                                    @if(!empty($data['form_setting']['after_registration_enable_college_insitute_field']) && $data['form_setting']['after_registration_enable_college_insitute_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="College Name">{{ $data['form_setting']['lable_college_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="College Name Value">
                                            {{ $data['registration_data']['college'] ?? ''}} </label>
                                    </div>

                                    @endif



                                    @if(!empty($data['form_setting']['after_registration_enable_city_field']) && $data['form_setting']['after_registration_enable_city_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="City">{{ $data['form_setting']['lable_city_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="City Value">
                                            {{ $data['registration_data']['city'] ?? ''}} </label>
                                    </div>
                                    @endif




                                    @if(!empty($data['form_setting']['after_registration_enable_country_field']) && $data['form_setting']['after_registration_enable_country_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="City">Country:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Country">
                                            {{ $data['registration_data']['country_name'] ?? '' }} </label>
                                    </div>
                                    @endif



                                    @if(!empty($data['form_setting']['after_registration_enable_state_field']) && $data['form_setting']['after_registration_enable_state_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="City">State:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="State">
                                            {{ $data['registration_data']['state_name'] ?? ''}} </label>
                                    </div>

                                    @endif



                                    <div class="col-md-5">
                                        <label for="Program Name">Program Name:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Name Value">
                                            <span> {{ $data['registration_data']['program_name'] ?? '' }}</span>

                                            <a href="{{ $data['registration_data']['program_details_page_url'] ?? '' }}" class="badge bg-info text-dark"> View More Details <i class="fa-solid fa-arrow-up-right-from-square"></i></a>


                                        </label>
                                    </div>

                                    @if(!empty($data['form_setting']['after_registration_enable_program_level_field']) && $data['form_setting']['after_registration_enable_program_level_field'] == 'Y' )

                                    <div class="col-md-5">
                                        <label for="program-level Name">{{ $data['form_setting']['lable_program_type_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="program-level Name Value">
                                            {{ $data['registration_data']['event_program_level'] ?? ''}} </label>
                                    </div>

                                    @endif



                                    <div class="col-md-5">
                                        <label for="Program Mode">{{ $data['form_setting']['lable_program_mode'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Mode Value">
                                            {{ $data['registration_data']['event_program_title'] ?? '' }} <span class="badge text-bg-info ">{{ $data['registration_data']['event_program_mode'] ?? '' }} </span>
                                        </label>

                                    </div>


                                    <div class="col-md-5">
                                        <label for="Program Mode">{{ $data['form_setting']['lable_program_duration_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Mode Value">
                                            {{ $data['registration_data']['program_duration'] ?? '' }} {{ $data['registration_data']['program_duration_time_unit'] ?? '' }}
                                        </label>

                                    </div>


                                    @if( isset($data['registration_data']['after_registration_show_sample_certificate']) && $data['registration_data']['after_registration_show_sample_certificate'] == 'Y')
                                    <div class="col-md-5">
                                        <label for="Program Name">Sample Certificate:</label>
                                    </div>
                                    <div class="col-md-7">


                                        <a href="#" id="view-certificate-modal-btn"> <img src="{{ asset($data['registration_data']['sample_certificate_url']) ?? '' }}" width="400px;" alt="sample certificate"></a>
                                    </div>

                                    @endif


                                    <div class="col-md-5">
                                        <label for="Program Date">Schedule Date Time:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Date Value">
                                            {{ $data['registration_data']['schedule_date_time'] ?? '' }}</label>
                                    </div>


                                    @if( isset($data['registration_data']['after_registration_enable_location_field'] ) && $data['registration_data']['after_registration_enable_location_field'] == 'Y' )


                                    <div class="col-md-5">
                                        <label for="Program Date">Program Location :</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Date Value">
                                            @if(!empty($data['registration_data']['location_name']))
                                            {{ $data['registration_data']['location_name'] }} <br>
                                            @endif

                                            @if(!empty($data['registration_data']['location_sub_location_name']))
                                            {{ $data['registration_data']['location_sub_location_name'] }},
                                            @endif


                                            @if(!empty($data['registration_data']['location_address_line1']))
                                            {{ $data['registration_data']['location_address_line1'] }},
                                            @endif

                                            @if(!empty($data['registration_data']['location_address_city']))
                                            {{ $data['registration_data']['location_address_city'] }},
                                            @endif

                                            @if(!empty($data['registration_data']['location_state']))
                                            {{ $data['registration_data']['location_state'] }},
                                            @endif

                                            @if(!empty($data['registration_data']['location_country']))
                                            {{ $data['registration_data']['location_country'] }}
                                            @endif
                                        </label>
                                    </div>

                                    @if((!empty($data['registration_data']['enable_gate_pass']) && $data['registration_data']['student_selection_status_id'] == $data['registration_data']['enable_gate_pass_on_selection_status_id']) && !empty( $data['registration_data']['gatepass_template_id']) && isset($data['registration_data']['classroom_venue_id']) && !empty($data['registration_data']['classroom_venue_id']) )
                                    <div class="col-md-5">
                                        <label for="Program Date">Venue Location :</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Program Date Value">
                                            {{ $data['registration_data']['venue_name'] ?? '' }} </label>
                                    </div>
                                    @endif


                                    @endif



                                    <div class="col-md-5">
                                        <label for="Registration Number">Registration Number :</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Registration Number Value" class="border border-1 border-success  bg-success bg-opacity-10 p-1 ">
                                            {{ $data['registration_data']['registration_number'] ?? '' }}
                                        </label>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="Date of Registration">Date of Registration :</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Date of Registration Value">
                                            {{ $data['registration_data']['registration_time'] ?? '' }} ({{ $data['registration_data']['registration_time_lable'] ?? '' }})
                                        </label>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="Date of Registration">{{ $data['registration_data']['lable_profile_link_field'] ?? '' }}:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Date of Registration Value">
                                            <a href="https://{{ setting('app_short_domain') }}/{{ $data['registration_data']['short_login_code'] }}" style="color:black !important;" class="border border-1 border-info  bg-info bg-opacity-10 p-1 ">https://{{ setting('app_short_domain') }}/{{ $data['registration_data']['short_login_code'] }} </a>
                                        </label>
                                    </div>




                                    <div class="col-md-5">
                                        <label for="Seats">Seats:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Seats Value">
                                            {{ $data['registration_data']['seats'] ?? '' }} Seat(s)
                                        </label>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="Total Amount">Total Amount :</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Total Amount Value">

                                            @if( !empty( $data['paid_amount_show']) )
                                            {{ $data['registration_data']['symbol_left'] ?? '' }}
                                            {{ $data['paid_amount_show'] ?? '' }}
                                            {{ $data['registration_data']['symbol_right'] ?? '' }}
                                            (Inclusive {{ $data['registration_data']['tax_rate'] ?? '' }}% GST)


                                            @else

                                            @if( isset($data['registration_data']['discounted_total_fee_all_inclusive'])
                                            && isset($data['registration_data']['total_fee_all_inclusive'])
                                            && $data['registration_data']['enable_discounted_fee'] == 'Y'
                                            && $data['registration_data']['discounted_total_fee_all_inclusive'] < $data['registration_data']['total_fee_all_inclusive']
                                                )
                                                <span class="text-decoration-line-through">{{ $data['registration_data']['symbol_left'] ?? '' }} {{ $data['registration_data']['total_fee_all_inclusive'] ?? '' }} (All Inclusive)</span> <br>
                                                {{ $data['registration_data']['symbol_left'] ?? '' }}
                                                {{ $data['registration_data']['discounted_amount'] ?? '' }}
                                                {{ $data['registration_data']['symbol_right'] ?? '' }} +
                                                {{ $data['registration_data']['discounted_tax_amount'] ?? '' }} GST({{ $data['registration_data']['tax_rate'] ?? '' }}%)<br>
                                                <span style="font-weight: 700;font-size: larger;"> {{ $data['registration_data']['symbol_left'] ?? '' }} {{ $data['registration_data']['discounted_total_fee_all_inclusive'] ?? '' }} (All Inclusive) </span>


                                                <div class="clock-container" id="clock-container">

                                                    <div class="clock-col">
                                                        <p class="clock-hours clock-timer text-black" id="clock-hours" data-value="--"></p>
                                                        <p class="clock-label text-black">Hours</p>
                                                    </div>
                                                    <div class="clock-col">
                                                        <p class="clock-minutes clock-timer text-black" id="clock-minutes" data-value="--"></p>
                                                        <p class="clock-label text-black">Minutes</p>
                                                    </div>
                                                    <div class="clock-col">
                                                        <p class="clock-seconds clock-timer text-black" id="clock-seconds" data-value="--"></p>
                                                        <p class="clock-label text-black">Seconds</p>
                                                    </div>
                                                </div>
                                                <span class="gradient-text">{{ $data['registration_data']['discounted_fee_note'] ?? '' }}</span>


                                                @else

                                                {{ $data['registration_data']['symbol_left'] ?? '' }}
                                                {{ $data['registration_data']['amount'] ?? '' }}
                                                {{ $data['registration_data']['symbol_right'] ?? '' }} +
                                                {{ $data['registration_data']['tax_amount'] ?? '' }} GST({{ $data['registration_data']['tax_rate'] ?? '' }}%)<br>
                                                {{ $data['registration_data']['symbol_left'] ?? '' }} {{ $data['registration_data']['total_fee_all_inclusive'] ?? '' }} (All Inclusive)

                                                @endif



                                                @endif





                                        </label>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="Selection Status">Selection Status:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Selection Status Value">
                                            <a href="#" id="view-selection-status-modal-btn" class="{{ $data['registration_data']['selection_bootstrap_class'] ?? '' }}">
                                                {{ $data['registration_data']['selection_status'] ?? '' }}
                                                <i class="fa fa-info-circle" title="{{ $data['registration_data']['selection_status_description'] ?? '' }}" aria-hidden="true"></i>
                                            </a>
                                        </label>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="Payment Status">Payment Status:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Payment Status Value">
                                            <a href="#" id="view-payment-status-modal-btn" class="{{ $data['registration_data']['payment_bootstrap_class'] ?? '' }}">
                                                {{ $data['registration_data']['payment_status'] ?? '' }}
                                                <i class="fa fa-info-circle" title="{{ $data['registration_data']['payment_status_description'] ?? '' }}" aria-hidden="true"></i>
                                            </a>
                                        </label>
                                    </div>

                                    @if( isset($data['registration_data']['payment_status_id']) && $data['registration_data']['payment_status_id'] != isset($data['registration_data']['payment_status_after_payment']) && $data['registration_data']['payment_status_after_payment']
                                    && $data['show_payment_last_date_according_current_time'] == 'show'

                                    )
                                    <div class="col-md-5">
                                        <label for="Payment Last Date">Payment Last Date:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Payment Last Date Value">
                                            {{ $data['registration_data']['payment_last_datetime'] }} </label>
                                    </div>
                                    @endif


                                    @if( ( !empty($data['registration_data']['enable_gate_pass']) && $data['registration_data']['enable_gate_pass'] == 'Y' && $data['registration_data']['student_selection_status_id'] == $data['registration_data']['enable_gate_pass_on_selection_status_id']) && (!empty( $data['registration_data']['gatepass_template_id']) && isset($data['registration_data']['classroom_venue_id'])) && !empty($data['registration_data']['classroom_venue_id']) )

                                    <div class="col-md-5">
                                        <label for="Download Gatepass">Download Gatepass:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Download Gatepass Value">
                                            <a href="{{ route('gatepass.view',['registration_number'=>$data['registration_data']['registration_number']]) }}" class="btn btn-primary">View Gatepass <i class="fa fa-eye" title="Click to view the gatepass" aria-hidden="true"></i></a>

                                            <a href="{{ route('gatepass.download',['registration_number'=>$data['registration_data']['registration_number']]) }}" class="btn btn-primary mt-2">Download Gatepass <i class="fa-solid fa-file-arrow-down" title="Click to download the gatepass" aria-hidden="true"></i></a>

                                        </label>
                                    </div>


                                    @endif




                                    @if(!empty($data['registration_data']['enable_digital_certificate']) && $data['registration_data']['enable_digital_certificate'] == 'Y' && $data['registration_data']['student_selection_status_id'] == $data['registration_data']['enable_digital_certificate_on_selection_status_id'] )

                                    <div class="col-md-5">
                                        <label for="City">Download Certificate:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="Certificate">

                                            <a href="{{ route('certificate.download-certificate',['certificate_code'=>$data['registration_data']['certificate_code']]) }}" id="download-certificate" class="{{ $data['registration_data']['payment_bootstrap_class'] }}">Download Certificate <i class="fa fa-info-circle" title="Download Your Certificate" aria-hidden="true"></i></a>


                                        </label>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="City">Certificate Code:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="Certificate" class="border border-1 border-info  bg-info bg-opacity-10 p-1 ">
                                            {{ $data['registration_data']['certificate_code'] }}
                                        </label> <a href="{{ route('certificate.display',['certificate_code' => $data['registration_data']['certificate_code'] ]) }}"> verified <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>

                                    </div>



                                    @endif

                                    @if(
                                    !empty($data['registration_data']['enable_online_mode_link_on_selection_status_id']) &&
                                    !empty($data['registration_data']['online_mode_link_url']) &&
                                    $data['registration_data']['enable_online_mode_link_on_selection_status_id'] == $data['registration_data']['student_selection_status_id'] &&
                                    $data['registration_data']['enable_online_mode_link'] == 'Y'

                                    )
                                    <div class="col-md-5">
                                        <label for="zoom">{{ $data['registration_data']['lable_online_mode'] }}:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <a href="{{$data['registration_data']['online_mode_link_url']}}" target="__blank">
                                            <label for="zoom">
                                                {{ $data['registration_data']['online_mode_link_url'] ?? '' }}
                                            </label> <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>

                                    </div>
                                    @endif


                                    @if(!empty($data['registration_data']['payment_status_id']))
                                    <div class="col-md-5">
                                        <label for="Payment Last Date">Payment Id:</label>
                                    </div>
                                    <div class="col-md-7" style="font-family:Courier New,Courier,monospace">
                                        <label for="Payment Last Date Value">
                                            {{ $data['registration_data']['payment_id'] }} </label>
                                    </div>
                                    @endif




                                    @if(!empty($data['registration_data']['enable_address_field']) &&
                                    $data['registration_data']['enable_address_field'] == 'Y' &&
                                    !empty($data['registration_data']['enable_address_field_on_selection_status_id']) &&
                                    !empty($data['registration_data']['student_selection_status_id']) &&
                                    $data['registration_data']['student_selection_status_id'] == $data['registration_data']['enable_address_field_on_selection_status_id'] )
                                    <div class="col-md-5">
                                        <label for="City">Shipping Address:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="Shipping">
                                            @if( !empty($data['registration_data']['shipping_address_firstname']) )
                                            <span>{{ ucfirst($data['registration_data']['shipping_address_firstname']) }}
                                            </span>
                                            @endif

                                            @if( !empty($data['registration_data']['shipping_address_lastname']) )
                                            <span>{{ ucfirst($data['registration_data']['shipping_address_lastname']) }}
                                            </span>
                                            @endif

                                            @if( !empty($data['registration_data']['shipping_address_firstname']) )
                                            <br>
                                            @endif

                                            @if( !empty($data['registration_data']['shipping_address_line_1']) )
                                            <span>{{ ucfirst($data['registration_data']['shipping_address_line_1']) }} </span> <br>
                                            @endif
                                            @if( !empty($data['registration_data']['shipping_address_line_2']) )
                                            <span>{{ ucfirst($data['registration_data']['shipping_address_line_2']) }} </span> <br>
                                            @endif
                                            <span>
                                                @if( !empty($data['registration_data']['shipping_address_city']) )
                                                {{ ucfirst($data['registration_data']['shipping_address_city']) }},
                                                @endif
                                                @if( !empty($data['registration_data']['shipping_address_state_id']) )
                                                {{ ucfirst($data['registration_data']['shipping_address_state']) }},
                                                @endif
                                                @if( !empty($data['registration_data']['shipping_address_country_id']) )
                                                {{ ucfirst($data['registration_data']['shipping_address_country']) }}
                                                @endif
                                                @if( !empty($data['registration_data']['shipping_address_country_id']) )
                                                <br>
                                                Postcode #:{{ ucfirst($data['registration_data']['shipping_address_post_code']) }},
                                                @endif

                                            </span>
                                            @if( !empty($data['registration_data']['shipping_address_mobile']) )
                                            <br>
                                            <span>Mobile #: +{{ ucfirst($data['registration_data']['shipping_address_mobile_country_code_id']) }}-{{ ucfirst($data['registration_data']['shipping_address_mobile']) }}</span> <br>
                                            @endif








                                            <button type="button" title="Update Address" name="shipping_address" id="shipping_address" class="btn btn-primary btn-sm mt-2"><i class="fa fa-edit"></i> Update Address </button>


                                        </label>
                                    </div>

                                    @endif


                                    @if( isset($data['registration_data']['after_registration_note']) && !empty($data['registration_data']['after_registration_note']) && $data['registration_data']['show_after_registration_note'] == 'Y' && $data['registration_data']['after_registration_note_on_selection_status_id'] == $data['registration_data']['student_selection_status_id'])
                                    <div class="container mb-3">
                                        <div class="card alert alert-secondary">

                                            <h5 class="card-title center">Important Notes</h5>
                                            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                                            <p class="card-text notes-text center">{!! $data['registration_data']['after_registration_note'] ?? '' !!}</p>


                                        </div>
                                    </div>
                                    @endif


                                    @if( isset($data['registration_data']['after_payment_note']) && !empty($data['registration_data']['after_payment_note']) && $data['registration_data']['show_after_payment_note'] == 'Y' && $data['registration_data']['after_payment_note_on_selection_status_id'] == $data['registration_data']['student_selection_status_id'])
                                    <div class="container mb-3">
                                        <div class="card alert alert-success">
                                            <h5 class="card-title center">Important Notes</h5>
                                            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                                            <p class="card-text notes-text center">{!! $data['registration_data']['after_payment_note'] ?? '' !!}</p>

                                        </div>
                                    </div>
                                    @endif


                                </div>

                            </div>

                        </div>


                        <div class="col-md-12" style="text-align:center; margin-top: 20px; ">


                            <form action="{{ route('payment.store') }}" method="POST" style="margin-bottom:0px !important;">
                                @csrf
                                @if( isset($data['registration_data']['payment_status_id']) && $data['registration_data']['payment_status_id'] != isset($data['registration_data']['payment_status_after_payment']) && $data['registration_data']['payment_status_after_payment'] && $data['registration_data']['enable_payment_on_selection_status_id'] == $data['registration_data']['student_selection_status_id'] )
                                <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="rzp_live_D2lzE1os3o5bdY" data-amount="{{ $data['payment_total'] * 100 }}" data-order_id="{{ $data['razorpay_order_id'] }}" data-buttontext="Pay Now" data-name="Technocon" data-description="{{ $data['form_setting']['registration_page_form_heading'] }} | registration number: {{ $data['registration_data']['registration_number'] }}" data-image="{{ asset($data['form_setting']['registration_meta_icon']) }}" data-notes.registration_number="{{ $data['registration_data']['registration_number'] }}" data-prefill.name="{{ $data['registration_data']['first_name']  }}" data-prefill.email="" data-prefill.contact="{{ $data['registration_data']['country_code'] }}{{ $data['registration_data']['mobile_no'] }}" data-theme.color="">
                                </script>
                                <input type="hidden" name="program_id" value="{{ $data['registration_data']['program_id'] }}">
                                <input type="hidden" name="registration_number" value="{{ $data['registration_data']['registration_number'] }}">
                                <script>
                                    var payNow = "{{ $data['registration_data']['enable_payment_link'] }}";
                                    if (payNow == 'N') {
                                        $('.razorpay-payment-button').addClass("disabled");
                                    }
                                    $('.razorpay-payment-button').addClass('btn btn-success btn-sm')
                                </script>
                                @if(isset($data['registration_data']['show_pay_later_button']) && $data['registration_data']['show_pay_later_button'] == 'Y' )
                                <button type="button" onclick="document.location.href='{{ $data['registration_data']['program_details_page_url'] }}'" class="btn btn-warning btn-sm" style="margin:10px;"><i class="fa-regular fa-clock"></i> Pay Later</button>

                                @endif


                                @endif

                                @if(isset($data['registration_data']['enable_payment_on_selection_status_id']) && ( $data['registration_data']['enable_payment_on_selection_status_id'] == '6' || $data['registration_data']['enable_payment_on_selection_status_id'] == '7' )   )
                                <button type="button" class="btn btn-info btn-sm" id="updateRegistrationBtn"><i class="fa-regular fa-edit"></i> Edit Details</button>
                                @endif


                                <div class="alert alert-primary mt-3 px-3">
                                    {!! $data['registration_data']['selection_status_message_html'] !!}
                                </div>


                            </form>






                        </div>
                        @if( $data['registration_data']['enable_payment_link'] == 'N' )

                        <div class="alert alert-danger mt-3 px-3">
                            {!! $data['registration_data']['disable_payment_link_reason_html'] !!}
                        </div>
                        @endif

                    </div>


                    <!-- #Shipping Address section  -->



                    <div class="modal fade modal-xl" style="min-height:500px;" id="shipping-address-modal" tabindex="-1" aria-labelledby="shipping-address-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">


                            <div class="loader">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="shipping-address-modalLabel">Certificate Shipping Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body  shpping-address-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateShippingAddress()" id="btn-update-address">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- #Shipping Address section end -->


                    <!-- #Edit Registration section  -->



                    <div class="modal fade modal-xl" style="min-height:500px;" id="update-registration-modal" tabindex="-1" aria-labelledby="update-registration-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="loader">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>


                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="update-registration-modalLabel">Update Registration</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body  edit-registration-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateRegistration()" id="btn-update-address">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- #Edit Registration section end -->





                </div>
            </div>

        </section><!-- #registration section end -->






        <!-- #Selection status section  -->



        <div class="modal fade modal-xl" style="min-height:500px;" id="view-selection-status-modal" tabindex="-1" aria-labelledby="view-selection-status-modalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-selection-status-modalLabel">Selection Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $data['registration_data']['selection_status_description'] ?? '' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- # Selection status section end -->

        <!-- #Payment status section  -->



        <div class="modal fade modal-xl" style="min-height:500px;" id="view-payment-status-modal" tabindex="-1" aria-labelledby="view-payment-status-modalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-payment-status-modalLabel">Payment Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $data['registration_data']['payment_status description'] ?? '' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- # Payment status section end -->


        <!-- #Certification section  -->



        <div class="modal fade modal-xl" style="min-height:500px;" id="view-certificate-modal" tabindex="-1" aria-labelledby="view-certificate-modalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-certificate-modalLabel">Certificate Sample</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset($data['registration_data']['sample_certificate_url'] ?? '' ) }}" alt="sample certificate">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- # Certification section end -->




    </div>


    <!-- program tiles area -->

    @if( isset($data['program_tiles']) && $data['program_tiles'] && isset($data['registration_data']['after_registration_show_program_tiles_registration_page']) && $data['registration_data']['after_registration_show_program_tiles_registration_page'] =='Y' )

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

                                @if( isset($program->status) && $program->status == '1')
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

                                                
                                                @if( isset($program->rstatus) && $program->rstatus == '1' )
                                                <a href="{{ url('/') }}/event/registration/{{ $program->seo_url }}" class="button button-large px-lg-5 py-lg-3"><i class="fa-solid fa-right-to-bracket"></i>Register</a>
                                                @else


                                                <a href="#" class="btn btn-secondary"><i class="fa-solid fa-lock"></i> Registration Closed</a>

                                                @if( $program->enable_payment_link == 'Y')
                                                <span class="badge bg-success"> Old Registration can Still Pay</span>
                                                @else
                                                <span class="badge bg-secondary"> Old Registration Payment Link Disabled</span>
                                                @endif
                                                @endif



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

    <div class="span12" style="margin-left: 0px;">
        <div style="margin-bottom: 5px;margin-left: 5px; padding:30px;">
            <p style="text-align:center; text-decoration:underline;"><b>Status Code and their Meanings:</b></p>
            @if ($data['students_selection_status'])
            @foreach ($data['students_selection_status'] as $key => $status)
            <p><b>
                    {{ $status->selection_status ?? '' }} </b> : <i>
                    {{ $status->selection_status_description ?? '' }} </i></p>
            @endforeach
            @endif

        </div>
    </div>


    @if( isset( $data['registration_success_event_url_parameter']) && $data['registration_success_event_url_parameter'] == isset($data['form_setting']['registration_success_event_url_parameter_value']) && $data['form_setting']['registration_success_event_url_parameter_value'] && isset($data['form_setting']['registration_success_event_script_position']) && $data['form_setting']['registration_success_event_script_position'] == 'before_body_close' )
    {!! isset($data['form_setting']['registration_success_event_script']) ? $data['form_setting']['registration_success_event_script'] : '' !!}
    @endif

    @include('frontend.help_text')
</body>



<script>
    // Get today's date in the format YYYY-MM-DD
    var today = new Date();
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2); // Add leading zero
    var day = ('0' + today.getDate()).slice(-2); // Add leading zero

    // Get the day name
    var dayName = today.toLocaleDateString('en-US', {
        weekday: 'long'
    });
    console.log("Today is: " + dayName); // Example: "Today is: Monday"

    // Construct start and end datetime strings
    var startDateTime = new Date(`${year}-${month}-${day}T00:00:00`).getTime(); // Today at 12:00 AM
    var endDateTime = new Date(`${year}-${month}-${day}T23:59:00`).getTime(); // Today at 11:59 PM

    // Update the countdown every 1 second
    var countdownFunction = setInterval(function() {

        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the difference between the end date and now
        var timeRemaining = endDateTime - now;

        // Calculate days, hours, minutes, and seconds
        var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        // Format the time to always show double digits
        hours = ('0' + hours).slice(-2);
        minutes = ('0' + minutes).slice(-2);
        seconds = ('0' + seconds).slice(-2);

        // Display the result in the corresponding elements
        // document.getElementById("clock-day").innerHTML = dayName; // Display the day name
        var timerElement = document.getElementById("clock-container");
        if (timerElement) {
            document.getElementById("clock-hours").innerHTML = hours;
            document.getElementById("clock-minutes").innerHTML = minutes;
            document.getElementById("clock-seconds").innerHTML = seconds;

            console.log("Seconds: " + seconds);

            // If the countdown is finished, display a message
            if (timeRemaining < 0) {
                clearInterval(countdownFunction);
                document.getElementById("timer").innerHTML = "OFFER ENDED";
            }
        }

    }, 1000);
</script>




<script>
    $(document).ready(function() {

        $('#updateRegistrationBtn').on('click', function(e) {
            e.preventDefault();
            const registration_id = "{{ $data['registration_data']['registration_id'] ?? '' }}";
            try {
                $.ajax({
                    url: `/event/edit-registration`,
                    data: {
                        registration_id: registration_id,
                        seo_handle: "{{ $data['form_setting']['seo_url'] ?? '' }}"
                    },
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        $('.edit-registration-body').html(response);
                        $('#update-registration-modal').modal('show');


                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });


        $('#shipping_address').on('click', function(e) {
            e.preventDefault();
            const registration_id = "{{ $data['registration_data']['registration_id'] ?? '' }}";
            try {
                $.ajax({
                    url: `/event/shipping-address-view`,
                    data: {
                        registration_id: registration_id
                    },
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.shpping-address-body').html(response);
                        $('#shipping-address-modal').modal('show');

                        $('#mobile_country_code_id').select2();
                        $('#country_id').select2();
                        $('#state_id').select2();

                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });







    });

    $('#view-certificate-modal-btn').on('click', function(e) {
        e.preventDefault();
        $('#view-certificate-modal').modal('show');

    });

    $('#view-selection-status-modal-btn').on('click', function(e) {
        e.preventDefault();
        $('#view-selection-status-modal').modal('show');

    });

    $('#view-payment-status-modal-btn').on('click', function(e) {
        e.preventDefault();
        $('#view-payment-status-modal').modal('show');

    });
</script>


@endsection