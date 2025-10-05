<form id="update-registration" name="user_signup" method="post" class="mb-0" data-gtm-form-interact-id="0">

    <div class="row">

        <input type="hidden" value="{{ $data['registration_data']['registered_email'] }}" id="email" name="email">
        <input type="hidden" value="{{ $data['registration_data']['auto_login_string'] }}" name="uid">

        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="name">{{$data['form_setting']['lable_first_name_field']}}<span class="text-danger">*</span>:</label>
            @endif

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                    </span>
                </div>
                <input type="text" value="{{ $data['registration_data']['first_name'] }}" title="Name" placeholder="First Name" onKeyUp="return check_fist_name_error(this.value)" id="first_name" name="first_name" class="form-control">

                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" onclick="event.preventDefault();$('#help-first-name-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>
            </div>

            <span class="text-danger" id="error-msgname"></span>

        </div>

        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="last_name">{{$data['form_setting']['lable_last_name_field']}}:</label>
            @endif

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                    </span>
                </div>
                <input type="text" value="{{ $data['registration_data']['last_name'] }}" title="Last Name" onKeyUp="return check_last_name_error(this.value)" placeholder="Last Name" id="last_name" name="last_name" class="form-control">

                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" onclick="event.preventDefault();$('#help-last-name-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>
            </div>


            <span class="text-danger" id="error-msglname"></span>

        </div>




        @if( $data['form_setting']['after_registration_enable_gender_field'] == 'Y')
        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="age">{{$data['form_setting']['lable_age_field']}}*:</label>
            @endif
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                    </span>
                </div>

                <select name="age" id="age" onChange="return check_age_error(this.value)" class=" form-select">
                    <option value="0">[ {{$data['form_setting']['placeholder_text_age']}} ]</option>
                    @foreach( $data['allowed_age'] as $age)
                    <option value="{{ $age }}" {{  $data['registration_data']['age'] == $age  ? 'selected' : '' }}>{{ $age }}</option>
                    @endforeach
                </select>


                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" id="help-age-modal-btn" onclick="event.preventDefault();$('#help-age-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>

            </div>
            <span class="text-danger" id="error-msgAge"></span>

        </div>

        @endif


        @if( $data['form_setting']['after_registration_enable_gender_field'] == 'Y')
        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="gender">{{$data['form_setting']['label_gender_field']}}*:</label>
            @endif
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fa fa-user"></i> <!-- FontAwesome icon -->
                    </span>
                </div>


                <select name="gender" id="gender" onChange="return check_gender_error(this.value)" class=" form-select">
                    <option value="0">[ {{$data['form_setting']['placeholder_text_gender']}} ]</option>
                    <option value="Male" {{  $data['registration_data']['gender'] == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{  $data['registration_data']['gender'] == 'Female' ? 'selected' : '' }}>Female</option>

                </select>


                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" id="help-gender-modal-btn" onclick="event.preventDefault();$('#help-gender-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>

            </div>
            <span class="text-danger" id="error-msgGender"></span>

        </div>

        @endif






        <div class="col-md-12 form-group" style="margin-bottom:0px !important;">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="mobile">{{$data['form_setting']['lable_mobile_no_field']}}<span class="text-danger">*</span></label>

            @endif

        </div>


        <div class="col-md-4 form-group dselect-align" id="select-error-mobile_country_code_id">
            <select name="mobile_country_code_id" id="mobile_country_code_id" onChange="return check_mobile_country_code_id_error(this.value)" class=" form-select ">
                <option value="0">[Country Code]</option>
                @foreach( $data['mobile_country_list'] as $mobile_country_code)
                <option value="{{ $mobile_country_code->mobile_country_code_id }}" {{ old('mobile_country_code_id', $data['registration_data']['mobile_country_code_id']) == $mobile_country_code->mobile_country_code_id ? 'selected' : '' }}>{{ $mobile_country_code->country_name  }} ( +{{ $mobile_country_code->country_code }} )</option>
                @endforeach
            </select>
            <!--!select start! -->
            <span class="text-danger" id="error-msgmobile_country_code_id"></span>

        </div>

        <div class="col-md-8  form-group">
            <input type="text" maxlength="10" id="mobile" onKeyUp="return check_mobile_error(this.value)" name="mobile" title="Mobile No" placeholder="10 Digit Mobile Number" value="{{ $data['registration_data']['mobile_no'] }}" class="form-control">
            <span class="text-danger" id="error-msgmobile"></span>

        </div>









        @if( $data['form_setting']['after_registration_enable_college_insitute_field'] == 'Y')
        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="college_name">{{$data['form_setting']['lable_college_field']}}:</label>

            @endif

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fas fa-university"></i>
                    </span>
                </div>
                <input type="text" value="{{ $data['registration_data']['college'] }}" title="College/School" placeholder="Your College/School/Institute/University/Company etc" onKeyUp="return check_collage_name_error(this.value)" id="c_name" name="college" class="form-control">

                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" onclick="event.preventDefault();$('#help-college-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>
            </div>




            <span class="text-danger" id="error-msgcollege"></span>
        </div>
        @endif


        @if( $data['form_setting']['after_registration_enable_city_field'] == 'Y')
        <div class="col-md-12 form-group">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="city">{{$data['form_setting']['lable_city_field']}}<span class="text-danger">*</span>:</label>
            @endif


            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text me-1">
                        <i class="fa-solid fa-city"></i> <!-- FontAwesome icon -->
                    </span>
                </div>

                <input type="text" value="{{ $data['registration_data']['city'] }}" title="City" placeholder="City" onKeyUp="return check_city_name_error(this.value)" id="city" name="city" class="form-control">

                <div class="input-group-append">
                    <span class="input-group-text ms-2">
                        <a href="" onclick="event.preventDefault();$('#help-city-modal').modal('show');"><i class="fas fa-question-circle"></i> </a>
                    </span>
                </div>
            </div>


            <span class="text-danger" id="error-msgcity"></span>
        </div>
        @endif



        @if( $data['form_setting']['after_registration_enable_country_field'] == 'Y')

        <div class="col-md-12 form-group dselect-align" id="select-error-country_id">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="Select Country">Select Country<span class="text-danger">*</span>:</label>
            @endif
            <!--!select start! -->
            <select name="country_id" id="country_id" seo-url= {{ $data['form_setting']['seo_url'] }}  onChange="return check_country_id_error(this.value)" class=" form-select ">
                <option value="0">[Select Country Type]</option>
                @foreach( $data['country'] as $country)
                <option value="{{ $country->mobile_country_code_id }}" {{ old('country_id',$data['registration_data']['mobile_country_code_id']) == $country->mobile_country_code_id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                @endforeach
            </select>
            <!--!select start! -->

            <span class="text-danger" id="error-msgcountry_id"></span>

        </div>


        @endif




        @if( $data['form_setting']['after_registration_enable_state_field'] == 'Y')

        <div class="col-md-12 form-group load-state" id="select-error-state_id">
            @if( $data['form_setting']['registration_show_fields_name_lables'] == 'Y')
            <label for="Select State">Select State<span class="text-danger">*</span>:</label>
            @endif
            <!--!select start! -->
            <select name="state_id" id="state_id" onChange="return check_state_id_error(this.value)" class=" form-select ">
                <option value="0">[Select State Type]</option>
                @foreach( $data['country_to_state_code'] as $state)
                <option value="{{ $state->country_state_id }}" {{ old('country_state_id',$data['registration_data']['country_state_id']) == $state->country_state_id ? 'selected' : '' }}>{{ $state->state_name }}</option>
                @endforeach
            </select>
            <!--!select start! -->

            <span class="text-danger" id="error-msgstate_id"></span>

        </div>


        @endif














        <div class="col-md-12 form-group">
            <p id="edit-registration-message" class=""></p>
        </div>

    </div>
</form>

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