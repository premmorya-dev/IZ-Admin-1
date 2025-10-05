<style>
        /* Custom CSS to left-align dselect options */
        .dselect ul {
            text-align: left; /* Ensure text alignment is left */
        }
    </style>
      <form id="form-update-address">

                            <div class="container">
                                <div class="card-body" style="padding: 10px;">
                                    <div class="row" style="">
                                        <div class="promo promo-light mb-3">
                                            <h4 class="mt-3 mb-3 center">Update Shipping Address For Delivery For Your
                                                Hardcopy Certificate</h4>
                                        </div>

                                     


                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                        <label for="Shipping-First-Name">First Name:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                        <input type="text" name="shipping_address_firstname"  onKeyUp="return check_fist_name_error(this.value)" id="first_name"
                                                        value="{{ $data['shipping_data']['shipping_address_firstname'] }}"  id="first_name" class="form-control" />

                                                        <span class="text-danger"  id="error-msgname"></span>
                                        </div>




                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-Line-1">Last Name:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                        <input type="text" name="shipping_address_lastname" value="{{ $data['shipping_data']['shipping_address_lastname'] ?? '' }}"    id="last_name"
                                                        class="form-control" />
                                                        <span class="text-danger"  id="error-msglname"></span>
                                        </div>





                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-Line-1">Address Line 1:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                            <input type="text" id="shipping_address_line_1" onkeyup="return check_shipping_address_line1_error(this.value)"  name="shipping_address_line_1"  value="{{ $data['shipping_data']['shipping_address_line_1'] ?? '' }}"
                                                class="form-control" />
                                            <span id="error-shipping_address_line_1"     class="text-danger"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-Line-2">Address Line 2:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                            <input type="text" name="shipping_address_line_2" value="{{ $data['shipping_data']['shipping_address_line_2'] ?? '' }}"
                                                class="form-control" />
                                            <span id="error-shipping-address-shipping_address_line_2"
                                                class="text-danger"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-City">City:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;"> 
                                            <input type="text" name="shipping_address_city" onKeyUp="return check_city_name_error(this.value)" id="city" value="{{ $data['shipping_data']['shipping_address_city'] ?? '' }}"
                                                class="form-control" />

                                                <span class="text-danger"  id="error-msgcity"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-City">Postcode:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                            <input type="number" name="shipping_address_post_code"  id= "shipping_address_post_code" onKeyUp="return check_post_code_error(this.value)" value="{{ $data['shipping_data']['shipping_address_post_code'] ?? '' }}"
                                                class="form-control" />

                                            <span id="error-shipping-address-shipping_address_post_code"
                                                class="text-danger"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Country">Country:</label>
                                        </div>
                                        <div class="col-md-7 mt-3 select-error-shipping-country_id dselect-align" style="font-family: Courier New, Courier, monospace;">

                                            <select name="shipping_address_country_id"  id="shipping_address_country_id" onChange="return check_shipping_country_id_error(this.value)" 
                                                class=" form-select ">
                                                <option value="0">[Select Country Type]</option>
                                                @foreach ($data['country'] as $country)
                                                    <option value="{{ $country->mobile_country_code_id }}"
                                                        {{ old('country_id',$data['shipping_data']['registration_default_country_field']) == $country->mobile_country_code_id ? 'selected' : '' }}>
                                                        {{ $country->country_name }}</option>
                                                @endforeach
                                            </select>                                   


                                            <span class="text-danger"  id="error-shipping-msgcountry_id"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Address-State">State:</label>
                                        </div>
                                        <div class="col-md-7 mt-3 select-error-shipping-state_id dselect-align" style="font-family: Courier New, Courier, monospace;">


                                            <select name="shipping_address_state_id" id="shipping_address_state_id" onChange="return check_shipping_state_id_error(this.value)" 
                                                class=" form-select ">
                                                <option value="0">[Select State Type]</option>
                                                @foreach ($data['country_to_state_code'] as $state)
                                                    <option value="{{ $state->country_state_id }}"
                                                        {{ old('country_state_id',$data['shipping_data']['shipping_address_state_id']) == $state->country_state_id ? 'selected' : '' }}>
                                                        {{ $state->state_name }}</option>
                                                @endforeach
                                            </select>


                                            <span class="text-danger"  id="error-shipping-msgstate_id"></span>
                                        </div>

                                        <div class="col-md-5 mt-3" style="font-size: 19px;">
                                            <label for="Mobile-No">Mobile No.:</label>
                                        </div>
                                        <div class="col-md-7 mt-3" style="font-family: Courier New, Courier, monospace;">
                                            <div class="row">
                                                <div class="col-md-6 dselect-align">


                                                    <select name="shipping_address_mobile_country_code_id"
                                                    id="shipping_address_mobile_country_code_id" onChange="return check_mobile_country_code_id_error(this.value)" 
                                                        class=" form-select ">
                                                        <option value="0">[Country Code]</option>
                                                        @foreach ($data['mobile_country_list'] as $mobile_country_code)
                                                            <option
                                                                value="{{ $mobile_country_code->mobile_country_code_id }}"
                                                                {{ old('shipping_address_mobile_country_code_id',$data['shipping_data']['registration_default_mobile_country']) == $mobile_country_code->mobile_country_code_id ? 'selected' : '' }}>
                                                                {{ $mobile_country_code->country_name }} (
                                                                +{{ $mobile_country_code->country_code }} )</option>
                                                        @endforeach
                                                    </select>

                                                    <span class="text-danger"  id="error-msgmobile_country_code_id"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="shipping_address_mobile" id="mobile" onKeyUp="return check_mobile_error(this.value)"  value="{{ $data['shipping_data']['shipping_address_mobile'] ?? '' }}"
                                                        class="form-control" />
                                                        <span class="text-danger"  id="error-msgmobile"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-3">
                                            <div class="alert alert-success alert-dismissible mt-3 fade show"
                                                id="message" role="alert" style="display: none;">
                                                <strong>Success!</strong> Your address has been updated successfully.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-group">
                                                      <p id="edit-shipping-address-message" class=""></p>
                                                                    </div>



                                        <input type="hidden" name="type" value="updateAddress"
                                            class="form-control" />
                                        <input type="hidden" name="uid" value="{{ $data['shipping_data']['auto_login_string'] ?? '' }}"
                                            class="form-control" />

                                    </div>
                                </div>
                            </div>
                        </form>
 