<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    {!! $data['form_setting']['after_headscript'] !!}



    @if( isset( $data['registration_success_event_url_parameter']) && $data['registration_success_event_url_parameter'] == $data['form_setting']['registration_success_event_url_parameter_value'] && $data['form_setting']['registration_success_event_script_position'] == 'after_head_start' )
    {!! $data['form_setting']['registration_success_event_script'] !!}
    @endif


    <!-- Document Title
	============================================= -->
    <title>{{ $data['form_setting']['registration_meta_title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="technocon.org">
    <meta name="description" content="{{ $data['form_setting']['registration_page_seo_description'] }}">
    <meta property="fb:app_id" content="" />
    <meta property="og:type" content="event" />
    <meta property="og:title" content="{{ $data['form_setting']['registration_meta_title'] }}" />
    <meta property="og:url" content="{{ $data['og_url'] }}" />
    <meta property="og:image" content="{{ asset($data['form_setting']['registration_meta_og_image']) }}" />
    <meta property="og:image:width" content="{{ $data['form_setting']['registration_meta_og_image_width'] }}" />
    <meta property="og:image:height" content="{{ $data['form_setting']['registration_meta_og_image_height'] }}" />
    <meta property="og:description" content="{{ $data['form_setting']['registration_page_seo_description'] }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@" />
    <meta name="twitter:title" content="{{ $data['form_setting']['registration_meta_title'] }}" />
    <meta name="twitter:description" content="{{ $data['form_setting']['registration_page_seo_description'] }}">
    <meta name="twitter:image" content="{{ asset( $data['form_setting']['registration_meta_twitter_image']) }}" />
    <meta name="twitter:image:width" content="{{ $data['form_setting']['registration_meta_twitter_image_width'] }}" />
    <meta name="twitter:image:height" content="{{ $data['form_setting']['registration_meta_twitter_image_height'] }}" />

    <link rel="icon" href="{{ asset($data['form_setting']['registration_meta_icon']) }}">






    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&family=Cookie&display=swap" rel="stylesheet">

    <!-- Core Style -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} ">

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/registration/font-icons.css') }}">

    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/registration/swiper.css') }}">

    <!-- Saas Page Module Specific Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/saas-2.css') }}">
    <!-- select2 CSS -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">







    {!! $data['form_setting']['registration_event_schema'] !!}
    <!-- <script src="{{ asset('assets/js/dselect.js') }}"></script> -->



    <style>
        .loading-image {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 10;
        }

        .loader {
            display: none;
            width: 100px;
            position: fixed;
            text-align: center;
            z-index: 2;
            left: 45%;
            top: 40%;


        }



        .dselect-align button {
            text-align: left;
        }
    </style>

    <style>
        .clock-day::before {
            content: var(--timer-day);
        }

        .clock-hours::before {
            content: var(--timer-hours);
        }

        .clock-minutes::before {
            content: var(--timer-minutes);
        }

        .clock-seconds::before {
            content: var(--timer-seconds);
        }

        .clock-seconds::before {
            content: var(--timer-seconds);
        }

        .clock-col .clock-timer {
            margin-top: 10px;
            font-size: 30px;
        }



        body .clock-container {
            /* background: linear-gradient(45deg, #1870ed 0, #f18f88 100%); */
            font-family: 'Montserrat', 'sans-serif';

            display: flex;
            align-items: center;
            justify-content: center;
        }

        body .clock-container p {
            margin-bottom: 0px !important;
        }



        .clock-container {
            margin-top: 30px;
            margin-bottom: 0px;
            background-color: #00000029;
            border-radius: 5px;
            padding: 0px 0px 5px 0px;
            box-shadow: 1px 1px 5px rgba(255, 255, 255, .15), 0 15px 90px 30px rgba(0, 0, 0, 10%);
            display: flex;
            width: 260px;
        }

        .clock-col {
            text-align: center;

            min-width: 90px;
            position: relative;
        }

        .clock-col:not(:last-child)::before,
        .clock-col:not(:last-child)::after {
            content: "";
            background-color: black;
            height: 5px;
            width: 5px;
            border-radius: 50%;
            display: block;
            position: absolute;
            right: -5px;
        }

        .clock-col:not(:last-child)::before {
            top: 35%;
        }

        .clock-col:not(:last-child)::after {
            top: 50%;
        }

        .clock-timer::before {
            color: #fff;
            font-size: 4.2rem;
            text-transform: uppercase;
        }

        .clock-label {
            color: rgba(255, 255, 255, .35);
            text-transform: uppercase;
            font-size: .7rem;
            margin-top: 0px;
        }

        .gradient-text {
            font-size: 12px;
            font-weight: bold;
            background: black;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        @media (max-width: 825px) {
            .clock-container {
                margin: auto;
            }

        }
    </style>

    {!! $data['form_setting']['before_body_script'] !!}
    <script src="{{ asset('assets/js/jquery.js')  }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">



    @if( isset( $data['registration_success_event_url_parameter']) && $data['registration_success_event_url_parameter'] == $data['form_setting']['registration_success_event_url_parameter_value'] && $data['form_setting']['registration_success_event_script_position'] == 'before_head_close' )
    {!! $data['form_setting']['registration_success_event_script'] !!}
    @endif


</head>




@yield('content')

<script>
    const error = new Array();



    function check_mobile_country_code_id_error(mobile_country_code_id) {
        var error_msg = 'Please select country code';

        if ((mobile_country_code_id == "" || mobile_country_code_id == "0" || !mobile_country_code_id)) {
            $('#error-msgmobile_country_code_id').text(error_msg);
            $('#select-error-mobile_country_code_id .form-select ').addClass('is-invalid');
            $("#mobile_country_code_id").focus();
            $('#error-msgmobile_country_code_id').show();
            return false;
        } else {
            $('#error-msgmobile_country_code_id').text('');
            $('#select-error-mobile_country_code_id .form-select ').removeClass('is-invalid');
            $("#mobile_country_code_id").focus();
            $('#error-msgmobile_country_code_id').hide();
            return true;
        }
    }



    function check_agree_error() {
        var error_msg = 'Please select agree term and condition';
        var checkbox = document.querySelector('#agree');
        if ($('#agree').length) {
            if (checkbox.checked) {
                $('#error-msgagree').text('');
                $('#agree').removeClass('is-invalid');
                $("#agree").focus();
                $('#error-msgagree').hide();
                return true;
            } else {
                $('#error-msgagree').text(error_msg);
                $('#agree').addClass('is-invalid');
                $("#agree").focus();
                $('#error-msgagree').show();
                return false;
            }
        } else {
            return true;
        }

    }



    function check_state_id_error(state_id) {
        var error_msg = 'Please Select State..';
        if ($('#state_id').length) {
            if ((state_id == "" || state_id == "0" || !state_id)) {
                $('#error-msgstate_id').text(error_msg);
                $('#select-error-state_id .form-select ').addClass('is-invalid');
                $("#state_id").focus();
                $('#error-msgstate_id').show();
                return false;
            } else {
                $('#error-msgstate_id').text('');
                $('#select-error-state_id .form-select ').removeClass('is-invalid');
                $('#error-msgstate_id').hide();
                return true;
            }
        } else {
            return true;
        }

    }


    function check_shipping_state_id_error(state_id) {
        var error_msg = 'Please Select State..';
        if ($('#shipping_address_state_id').length) {
            if ((state_id == "" || state_id == "0" || !state_id)) {
                $('#error-shipping-msgstate_id').text(error_msg);
                $('#select-error-shipping-state_id .form-select ').addClass('is-invalid');
                $("#shipping_address_state_id").focus();
                $('#error-shipping-msgstate_id').show();
                return false;
            } else {
                $('#error-shipping-msgstate_id').text('');
                $('#select-error-shipping-state_id .form-select ').removeClass('is-invalid');
                $('#error-shipping-msgstate_id').hide();
                return true;
            }
        } else {
            return true;
        }

    }

    function check_country_id_error(country_id) {
        var error_msg = 'Please Select Country..';
        if ($('#country_id').length) {
            if ((country_id == "" || country_id == "0" || !country_id)) {
                $('#error-msgcountry_id').text(error_msg);
                $('#select-error-country_id .form-select ').addClass('is-invalid');
                $("#country_id").focus();
                $("#country_id").focus();
                $('#error-msgcountry_id').show();
                return false;
            } else {
                $('#error-msgcountry_id').text('');
                $('#select-error-country_id .form-select ').removeClass('is-invalid');
                $('#error-msgcountry_id').hide();
                return true;
            }
        } else {
            return true;
        }

    }

    function check_shipping_country_id_error(country_id) {

        var error_msg = 'Please Select Country..';
        if ($('#shipping_address_country_id').length) {
            if ((country_id == "" || country_id == "0" || !country_id)) {
                $('#error-shipping-msgcountry_id').text(error_msg);
                $('#select-error-shipping-country_id .form-select ').addClass('is-invalid');
                $("#shipping_address_country_id").focus();
                $("#shipping_address_country_id").focus();
                $('#error-shipping-msgcountry_id').show();
                return false;
            } else {
                $('#error-shipping-msgcountry_id').text('');
                $('#select-error-shipping-country_id .form-select').removeClass('is-invalid');
                $('#error-shipping-msgcountry_id').hide();
                return true;
            }
        } else {
            return true;
        }

    }



    function check_distt_error(distt) {
        if ((distt == "") || (distt.length <= 2)) {
            $("#distt").addClass('is-invalid');
            $("#distt").focus();
            return false;
        } else {

            $("#distt").removeClass('is-invalid');
            return true;
        }
    }


    function check_age_error(age) {
        var error_msg = 'Please Select Age..';
        if ($('#age').length) {
            if ((age == "" || age == "0" || !age)) {
                $('#error-msgAge').text(error_msg);
                $("#age").addClass('is-invalid');
                $("#age").focus();
                $('#error-msgAge').show();
                $('.errormsg').show();
                return false;
            } else {
                $('#error-msgAge').text('');
                $("#age").removeClass('is-invalid');
                $('#error-msgAge').hide();
                $('.errormsg').hide();
                return true;
            }
        } else {
            return true;
        }


    }


    function check_gender_error(gender) {
        var error_msg = 'Please Select Gender..';
        if ($('#gender').length) {
            if ((gender == "" || gender == "0" || !gender)) {
                $('#error-msgGender').text(error_msg);
                $("#gender").addClass('is-invalid');
                $("#gender").focus();
                $('#error-msgGender').show();
                $('.errormsg').show();
                return false;
            } else {
                $('#error-msgGender').text('');
                $("#gender").removeClass('is-invalid');
                $('#error-msgGender').hide();
                $('.errormsg').hide();
                return true;
            }
        } else {
            return true;
        }


    }

    function check_seats_error(seats) {
        var error_msg = 'Please Select Seats..';

        if ($('#seats').length) {
            if ((seats == "")) {
                $('#error-msgseat').text(error_msg);
                $("#seats").addClass('is-invalid');
                $("#seats").focus();
                $('#error-msgseat').show();
                $('.errormsg').show();
                return false;
            } else {
                $('#error-msgseat').text('');
                $("#seats").removeClass('is-invalid');
                $('#error-msgseat').hide();
                $('.errormsg').hide();
                return true;
            }
        } else {
            return true;
        }


    }


    function check_check_in_error(check_in) {
        if ((check_in == "")) {
            $("#check_in").addClass('is-invalid');
            $("#check_in").focus();
            return false;
        } else {

            $("#check_in").removeClass('is-invalid');
            return true;
        }
    }


    function check_check_out_error(check_out) {
        if ((check_out == "")) {
            $("#check_out").addClass('is-invalid');
            $("#check_out").focus();
            return false;
        } else {

            $("#check_out").removeClass('is-invalid');
            return true;
        }
    }


    function check_login_email_error(login_email) {

        var filter = /^([\w-\.]+)@((\[[0-9]{1,9}\.[0-9]{1,9}\.[0-9]{1,9}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,9})(\]?)$/;
        if (filter.test(login_email)) {
            $("#login_email").removeClass('is-invalid');
            return true;
        } else {
            $("#login_email").addClass('is-invalid');
            $("#login_email").focus();
            return false;
        }
    }


    function check_login_reg_error(login_reg) {
        if ((login_reg == "")) {
            $("#login_reg").addClass('is-invalid');
            $("#login_reg").focus();

            return false;
        } else {

            $("#login_reg").removeClass('is-invalid');
            return true;
        }
    }

    function check_collage_name_error(collage_name) {
        var error_msg = 'Please Enter Your College Name.';
        if ($('#c_name').length) {
            if (collage_name == "") {
                $('#error-msgcollege').text(error_msg);
                $("#c_name").addClass('is-invalid');
                $("#c_name").focus();
                $('#error-msgcollege').show();
                return false;
            } else {
                $('#error-msgcollege').text('');
                $("#c_name").removeClass('is-invalid');
                $('#error-msgcollege').hide();
                return true;
            }
        } else {
            return true;
        }

    }




    function check_city_name_error(city_name) {
        var error_msg = 'Please Enter Your City Name.';
        if ($('#city').length) {
            if (city_name == "" || !city_name) {
                $('#error-msgcity').text(error_msg);
                $("#city").addClass('is-invalid');
                $("#city").focus();
                $('#error-msgcity').show();
                return false;
            } else {
                $('#error-msgcity').text('');
                $("#city").removeClass('is-invalid');
                $('#error-msgcity').hide();
                return true;
            }
        } else {
            return true;
        }

    }


    function check_post_code_error(shipping_address_post_code) {
        var error_msg = 'Please Enter Post Code.';

        if (shipping_address_post_code == "" || !shipping_address_post_code) {
            $('#error-shipping-address-shipping_address_post_code').text(error_msg);
            $("#shipping_address_post_code").addClass('is-invalid');
            $("#shipping_address_post_code").focus();
            $('#error-shipping-address-shipping_address_post_code').show();
            return false;
        } else {
            $('#error-shipping-address-shipping_address_post_code').text('');
            $("#shipping_address_post_code").removeClass('is-invalid');
            $('#error-shipping-address-shipping_address_post_code').hide();
            return true;
        }


    }




    function check_shipping_address_line1_error(shipping_address_line1) {
        var error_msg = 'Please Enter Shipping Address Line 1.';

        if (shipping_address_line1 == "" || !shipping_address_line1) {
            $('#error-shipping_address_line_1').text(error_msg);
            $("#error-shipping_address_line_1").addClass('is-invalid');
            $("#error-shipping_address_line_1").focus();
            $('#error-shipping_address_line_1').show();
            $('.errormsg').show();
            return false;
        } else {
            $('#error-shipping_address_line_1').text('');
            $("#error-shipping_address_line_1").removeClass('is-invalid');
            $('#error-shipping_address_line_1').hide();
            $('.errormsg').hide();
            return true;
        }


    }

    function check_mobile_error(mob) {
        var numericString = mob;
        var firstDigit = parseInt(numericString.charAt(0), 10);
        var error_msg = '';
        if ((isNaN(mob)) || (mob == "") || (mob.length <= 9)) {
            error_msg = 'Please Enter Your Valid Mobile No.';
            $('#error-msgmobile').text(error_msg);
            $("#mobile").addClass(' is-invalid');
            $("#mobile").focus();
            $('#error-msgmobile').show();
            $('.errormsg').show();
            return false;
        } else if (firstDigit == 0) {
            error_msg = 'First Digit should not be 0';
            $('#error-msgmobile').text(error_msg);
            $('#error-msgmobile').show();
            $('.errormsg').show();
        } else {
            $('#error-msgmobile').text('');
            $("#mobile").removeClass('is-invalid');
            $('#error-msgmobile').hide();
            $('#error-msgmobile').hide();
            $('.errormsg').hide();
            return true;
        }
    }


    function check_mail1_error(email) {
        var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var error_msg = 'Please Enter Valid Email ID .';
        if (filter.test(email)) {
            $('#error-msgemail').text('');
            $("#email_id").removeClass('is-invalid');
            $('#error-msgemail').hide();
            $('.errormsg').hide();
            return true;
        } else {
            $('#error-msgemail').text(error_msg);
            $("#email_id").addClass('is-invalid');
            $("#email_id").focus();
            $('#error-msgemail').show();
            $('.errormsg').show();
            return false;
        }
    }

    function check_last_name_error(last_name) {
        var pattern = /[^a-z|^A-Z|^\s]/;
        var last_name = $("#last_name").val();
        var error_msg = 'Please Enter Valid Last Name..';

        if ($('#last_name').length) {
            if (document.getElementById("last_name").value.match(pattern)) {
                $('#error-msglname').text(error_msg);
                $("#last_name").addClass('is-invalid');
                $('#error-msglname').show();
                $('.errormsg').show();
                return false;
            } else if ((last_name == "")) {
                $('#error-msglname').text(error_msg);
                $("#last_name").addClass(' is-invalid');
                $('#error-msglname').show();
                $('.errormsg').show();
                return false;
            } else {
                $('#error-msglname').text('');
                $("#last_name").removeClass(' is-invalid');
                $('#error-msglname').hide();
                $('.errormsg').hide();
                return true;
            }
        } else {
            return true;
        }



    }



    function check_fist_name_error(first_name) {
        var pattern = /[^a-z|^A-Z|^\s]/;
        var first_name = $("#first_name").val();
        var name = isNaN(first_name);
        var error_msg = 'Please Enter Valid First Name..';
        if (document.getElementById("first_name").value.match(pattern)) {
            $('#error-msgname').text(error_msg);
            $("#first_name").addClass('is-invalid');
            $('#error-msgname').show();
            $('.errormsg').hide();
            return true;
        } else if ((first_name == "")) {
            $('#error-msgname').text(error_msg);
            $("#first_name").addClass('is-invalid');
            $("#first_name").focus();
            $('#error-msgname').show();
            $('.errormsg').show();
            return false;
        } else {
            $('#error-msgname').text('');
            $("#first_name").removeClass('is-invalid');
            $('#error-msgname').hide();
            $('.errormsg').hide();
            return true;
        }

    }

    function updateRegistration() {
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var mobile = $("#mobile").val();
        var collage_name = $("#c_name").val();
        var city = $("#city").val();

        var mobile_country_code_id = $("#mobile_country_code_id").val();
        var country_id = $("#country_id").val();
        var state_id = $("#state_id").val();


        var error = 0;


        if (check_fist_name_error(fname) === false) {
            error = 1;
        }
        // if (check_last_name_error(lname) === false) {
        //     error = 1;
        // }

        if (check_mobile_error(mobile) === false) {
            error = 1;
        }
        if (check_collage_name_error(collage_name) === false) {
            error = 1;
        }
        if (check_city_name_error(city) === false) {
            error = 1;
        }


        if (check_mobile_country_code_id_error(mobile_country_code_id) === false) {
            error = 1;
        }

        if (check_country_id_error(country_id) === false) {
            error = 1;
        }
        if (check_state_id_error(state_id) === false) {
            error = 1;
        }

        if (error) {
            return false;
        }





        $.ajax({
            url: '/ajax/update-registration',
            data: new FormData(document.querySelector('#update-registration')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token()  }}'
            },
            beforeSend: function() {
                $('.loader').show()
            },
            complete: function() {
                $('.loader').hide()
            },
            success: function(result) {
                if (result.error == 0) {
                    console.log(result);
                    window.location.reload();
                }

            },
            error: function(data) {
                console.log(data)
                $('#edit-registration-message').text('Something went wrong. please try again later');
                $('#edit-registration-message').addClass('alert alert-danger');
                return false;
            }
        });


    }

    function updateShippingAddress() {
        var fname = $("#first_name").val();
        var shipping_address_line_1 = $("#shipping_address_line_1").val();
        var mobile = $("#mobile").val();
        var city = $("#city").val();
        var shipping_address_post_code = $("#shipping_address_post_code").val();
        var mobile_country_code_id = $("#shipping_address_mobile_country_code_id").val();
        var country_id = $("#shipping_address_country_id").val();
        var state_id = $("#shipping_address_state_id").val();


        var error = 0;


        if (check_fist_name_error(fname) === false) {
            error = 1;
        }

        if (check_mobile_error(mobile) === false) {
            error = 1;
        }

        if (check_city_name_error(city) === false) {
            error = 1;
        }

        if (check_shipping_address_line1_error(shipping_address_line_1) === false) {
            error = 1;
        }

        if (check_mobile_country_code_id_error(mobile_country_code_id) === false) {
            error = 1;
        }

        if (check_shipping_country_id_error(country_id) === false) {
            error = 1;
        }
        if (check_shipping_state_id_error(state_id) === false) {
            error = 1;
        }

        if (error) {
            return false;
        }



        $.ajax({
            url: '/ajax/update-shipping-address',
            data: new FormData(document.querySelector('#form-update-address')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token()  }}'
            },
            beforeSend: function() {
                $('.loader').show()
            },
            complete: function() {
                $('.loader').hide()
            },
            success: function(result) {
                if (result.error == 0) {
                    window.location.reload();
                }


            },
            error: function(data) {
                console.log(data)
                $('#edit-shipping-address-message').text('Something went wrong. please try again later');
                $('#edit-shipping-address-message').addClass('alert alert-danger');
                return false;
            }
        });
    }


    function register_workshop() {


        $('#register-btn').attr('disabled', 'disabled')
        $('.loader').hide()
        var program = $("#program").val();
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var email = $("#email_id").val();
        var mobile = $("#mobile").val();
        var collage_name = $("#c_name").val();
        var city = $("#city").val();
        var seats = $("#seats").val();

        var mobile_country_code_id = $("#mobile_country_code_id").val();
        var country_id = $("#country_id").val();
        var state_id = $("#state_id").val();
        var age = $("#age").val();
        var gender = $("#gender").val();


        var error = 0;

        var reff = $('#rff').val();
        $('#error-user_exist').text('')

        if (check_fist_name_error(fname) === false) {
            error = 1;
        }
        // if (check_last_name_error(lname) === false) {
        //     error = 1;
        // }
        if (check_mail1_error(email) === false) {
            error = 1;
        }
        if (check_mobile_error(mobile) === false) {
            error = 1;
        }
        if (check_collage_name_error(collage_name) === false) {
            error = 1;
        }
        if (check_city_name_error(city) === false) {
            error = 1;
        }
        if (check_program_error(program) === false) {
            error = 1;
        }
        if (check_seats_error(seats) === false) {
            error = 1;
        }

        if (check_mobile_country_code_id_error(mobile_country_code_id) === false) {
            error = 1;
        }
        if (check_agree_error() === false) {
            error = 1;
        }
        if (check_country_id_error(country_id) === false) {
            error = 1;
        }
        if (check_state_id_error(state_id) === false) {
            error = 1;
        }
        if (check_age_error(age) === false) {
            error = 1;
        }
        if (check_gender_error(gender) === false) {
            error = 1;
        }

        if (error) {
            return false;
        }



        $.ajax({
            url: '/ajax/add-student-registration',
            data: new FormData(document.querySelector('#user_signup')),
            processData: false,
            contentType: false,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token()  }}'
            },
            beforeSend: function() {
                $('.loader').show()
                $('#register-btn').attr('disabled', 'disabled')
                $('#register-btn').hide()
            },
            complete: function() {
                $('.loader').hide()
                $('#register-btn').show()
                // $('#register-btn').prop('disabled', false);
            },
            success: function(result) {


                if (typeof result.errors !== 'undefined' &&
                    Array.isArray(result.errors.email_id) &&
                    result.errors.email_id.length > 0) {
                    $('#error-user_exist').html(result.html_errors.email_id);
                }
                if (result.error == 0) {
                    window.top.location.href = result.redirect;

                }

            },
            error: function(data) {
                $('#register-btn').prop('disabled', false);
               
            }
        });



    }
</script>



<script>
    function check_program_error(program) {

        var program = $("#program").val();
        var error_msg = 'Please Select WorkShop Type.';
        $.ajax({
            url: '/ajax/get-seat',
            data: {
                program_id: $('#program').val()
            },
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                $('#seats').html(result['html']);


                if (result['count'] > 1) {
                    $('#seat-container').show();
                } else {
                    $('#seat-container').hide();

                }
            }
        });


        if ((program == 0)) {
            $("#error-msgworktype").text(error_msg);
            $("#program").addClass('is-invalid');
            $('#select-error-program .form-select ').addClass('is-invalid');

            $('#error-msgworktype').show();
            return false;
        } else {
            $("#error-msgworktype").text('');
            $('#select-error-program .form-select ').removeClass('is-invalid');
            $('#error-msgworktype').hide();
            return true;
        }
    }

    function vpb_refresh_aptcha() {

        return $("#vpb_captcha_code").val('').focus(), document.images['captchaimg'].src = document.images['captchaimg'].src.substring(0, document.images['captchaimg'].src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
    }






    function login_workshop() {

        var login_email = $("#login_email").val();
        var login_reg = $("#login_reg").val();
        if ((check_login_email_error(login_email) != 1) || (check_login_reg_error(login_reg) != 1)) {
            $("#show_login_form_workshop").css('border-color', 'red');
            $("#error_msg_login").show();
            return false;

        }



        var email = $('#login_email').val();
        var reg = $('#login_reg').val();
        $.ajax({
            url: 'tryst_login.php',
            data: {
                'Email': email,
                'RegId': reg
            },
            type: 'POST',
            success: function(result) {
                if (result == 0) {
                    $('#error-msg1login').show();
                    $('#error-msg2login').show();
                    $('#show_login_form_workshop').css('border-color', 'red');

                    return false;
                } else {

                    window.location.href = "../wep.php?r=" + result;
                    $("#landing_busy_login").hide();
                }
            },
            error: function(data) {
                alert('Error in Data Processing. Please try Again.');
                $("#landing_busy_login").hide();
                return false;
            }
        });

    }
</script>
<script>
    $('document').ready(function() {
        $('.accordions').trigger('click');


        $('#country_id').on('change', function() {
            $.ajax({
                url: "{{ route('load_state') }}",              
                data: {
                    'country_id': this.value,
                    'seo_url': $(this).attr('seo-url'),
                },               
                type: 'GET',
                beforeSend: function(result) {
                      $('.load-state').html('')
                },
                success: function(result) {
                      $('.load-state').html(result.html)
                },
                error: function(data) {
                    alert('Error in Data Processing. Please try Again.');
                    return false;
                }
            });
        });




    });
</script>

@if( isset($data['dselect_library_status']) && $data['dselect_library_status'] )
<script>
    // dselect(document.querySelector('#mobile_country_code_id'), {   search: true   });
    // dselect(document.querySelector('#country_id'), {   search: true   });
    // dselect(document.querySelector('#state_id'), {   search: true   });
    // dselect(document.querySelector('#program'), {   search: true   });
</script>

@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ asset('assets/js/functions.bundle.js') }}"></script>

<script src="{{ asset('assets/js/plugins.min.js') }}"></script>

<script src="{{ asset('assets/js/select2.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#mobile_country_code_id').select2();
        $('#country_id').select2();
        $('#state_id').select2();
    });
</script>

<!-- Toastr Initialization Script -->
<script>
    $(document).ready(function() {
        @if(session('success'))
        toastr.success('{{ session('
            success ') }}');
        @endif
        @if(session('error'))
        toastr.error('{{ session('
            error ') }}');
        @endif
        @if(session('info'))
        toastr.info('{{ session('
            info ') }}');
        @endif
        @if(session('warning'))
        toastr.warning('{{ session('
            warning ') }}');
        @endif
    });
</script>