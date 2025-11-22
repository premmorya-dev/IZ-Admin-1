<form action="{{ route('client.update') }}" id="edit-client-form" method="POST" enctype="multipart/form-data">
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-4">
            <div class="row g-4">

                {{-- Basic Info --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold  text-danger required"><i class="fas fa-user me-1"></i> Client Name</label>
                    <input type="text" name="client_name" id="id_client_name" class="form-control"
                        value="{{ old('client_name', optional($data['client'] ?? null)->client_name) }}"
                        placeholder="Enter client name">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-building me-1"></i> Company Name</label>
                    <input type="text" name="company_name" id="id_company_name" class="form-control"
                        value="{{ old('company_name', optional($data['client'] ?? null)->company_name) }}"
                        placeholder="Enter company name">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-envelope me-1"></i> Email</label>
                    <input type="email" name="email" id="id_email" class="form-control"
                        value="{{ old('email', optional($data['client'] ?? null)->email) }}"
                        placeholder="Enter email address">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i> Phone</label>
                    <input type="text" name="phone" id="id_phone" class="form-control"
                        value="{{ old('phone', optional($data['client'] ?? null)->phone) }}"
                        placeholder="Enter phone number">
                </div>

                {{-- Address --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-receipt me-1"></i> GST Number</label>
                    <input type="text" name="gst_number" id="id_gst_number" class="form-control"
                        value="{{ old('gst_number', optional($data['client'] ?? null)->gst_number) }}"
                        placeholder="Enter GST number">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-city me-1"></i> City</label>
                    <input type="text" name="city" id="id_city" class="form-control"
                        value="{{ old('city', optional($data['client'] ?? null)->city) }}"
                        placeholder="Enter city">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-danger required">Address 1</label>
                    <textarea name="address_1" id="id_address_1" class="form-control" rows="2" placeholder="Enter primary address">{{ old('address_1', optional($data['client'] ?? null)->address_1) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Address 2</label>
                    <textarea name="address_2" id="id_address_2" class="form-control" rows="2" placeholder="Enter secondary address">{{ old('address_2', optional($data['client'] ?? null)->address_2) }}</textarea>
                </div>

                {{-- Location --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-danger required">Country</label>
                    <select name="country_id" id="id_country_id" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['countries'] as $country)
                        <option value="{{ $country->country_id }}" {{ optional($data['client'] ?? null)->country_id == $country->country_id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-danger required">State</label>
                    <select name="state_id" id="id_state_id" class="form-select">
                        <option value="">Please Select</option>

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-danger required">Currency</label>
                    <select name="currency_code" id="id_currency_code" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['currencies'] as $currency)
                        <option value="{{ $currency->currency_code }}" {{ optional($data['client'] ?? null)->currency_code == $currency->currency_code ? 'selected' : '' }}>
                            {{ $currency->currency_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Notes & Terms --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" id="id_notes" class="form-control" rows="2" placeholder="Enter notes">{{ old('notes', optional($data['client'] ?? null)->notes) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Terms & Conditions</label>
                    <textarea name="terms" id="id_terms" class="form-control" rows="2" placeholder="Enter terms and conditions">{{ old('terms', optional($data['client'] ?? null)->terms) }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="fas fa-mail-bulk me-1"></i> Pincode</label>
                    <input type="text" name="zip" id="id_zip" class="form-control"
                        value="{{ old('zip', optional($data['client'] ?? null)->zip) }}"
                        placeholder="Enter pincode">
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" id="id_status" class="form-select">
                        <option value="active" {{ optional($data['client'] ?? null)->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="deactive" {{ optional($data['client'] ?? null)->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>


                <!-- Shipping Address Checkbox -->
                <div class="col-md-12 mt-3">
                    <div class="form-check form-switch d-flex align-items-center">
                        <input class="form-check-input me-2" name="edit_shipping_address" type="checkbox" id="toggleShippingAddress">
                        <label class="form-check-label fw-semibold mb-0" for="toggleShippingAddress">
                            Add Shipping Address
                        </label>
                        <i class="bi bi-question-circle ms-2 text-muted"
                            data-bs-toggle="tooltip"
                            title="Enable this if the shipping address is different from the client's address."></i>
                    </div>
                </div>
                <!-- Shipping Address Section -->
                <div id="shippingAddressSection" class="row g-4 mt-2 border rounded-3 p-3 bg-light" style="display:none;">

                    <h5 class="fw-semibold text-primary mb-3">
                        <i class="fas fa-shipping-fast me-1"></i> Shipping Address
                    </h5>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold  text-danger required"><i class="fas fa-user me-1"></i> Shipping Client Name</label>
                        <input type="text" name="shipping_client_name" id="id_shipping_client_name" class="form-control"
                            value="{{ old('shipping_client_name', optional($data['client'] ?? null)->shipping_client_name) }}"
                            placeholder="Enter shipping client name">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-city me-1"></i>Shipping City</label>
                        <input type="text" name="shipping_city" id="id_shipping_city" class="form-control"
                            value="{{ old('shipping_city', optional($data['client'] ?? null)->shipping_city) }}"
                            placeholder="Enter city">
                    </div>


                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i> Phone</label>
                        <input type="text" name="shipping_phone" id="id_shipping_phone" class="form-control"
                            value="{{ old('phone', optional($data['client'] ?? null)->shipping_phone) }}"
                            placeholder="Enter phone number">
                    </div>


                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-danger required">Shipping Address 1</label>
                        <textarea name="shipping_address_1" id="id_shipping_address_1" class="form-control" rows="2"
                            placeholder="Enter shipping address 1">{{ old('shipping_address_1', optional($data['client'] ?? null)->shipping_address_1) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Shipping Address 2</label>
                        <textarea name="shipping_address_2" id="id_shipping_address_2" class="form-control" rows="2"
                            placeholder="Enter shipping address 2">{{ old('shipping_address_2', optional($data['client'] ?? null)->shipping_address_2) }}</textarea>
                    </div>





                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-danger required">Shipping Country</label>

                        <select name="shipping_country_id" id="id_shipping_country_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['countries'] as $country)
                            <option value="{{ $country->country_id }}" {{ optional($data['client'] ?? null)->shipping_country_id == $country->country_id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-danger required">Shipping State</label>
                        <select name="shipping_state_id" id="id_shipping_state_id" class="form-select">
                            <option value="">Please Select</option>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-mail-bulk me-1"></i>Shipping PinCode</label>
                        <input type="number" name="shipping_zip" id="id_shipping_zip" class="form-control"
                            value="{{ old('shipping_zip', optional($data['client'] ?? null)->shipping_zip) }}"
                            placeholder="Enter shipping pincode">
                    </div>



                </div>


                <input type="hidden" name="client_code" id="id_client_code" value="{{ optional($data['client'] ?? null)->client_code }}">
            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">
            <button type="submit" class="btn btn-success px-4 update-client w-100">
                <i class="fas fa-save me-1"></i> Update Client
            </button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        // Toggle shipping address visibility
        $('#toggleShippingAddress').on('change', function() {
            if ($(this).is(':checked')) {
                $('#shippingAddressSection').slideDown(300);
            } else {
                $('#shippingAddressSection').slideUp(300);
            }
        });

        // If client already has shipping address data, show by default
        let show_shipping = "{{  $data['show_shipping'] }}";

        if (show_shipping == true) {
            $('#toggleShippingAddress').prop('checked', true);
            $('#shippingAddressSection').show();
        } else {
            $('#toggleShippingAddress').prop('checked', false);
            $('#shippingAddressSection').hide();
        }


    });
</script>


<script>
    document.querySelector('.update-client').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('edit-client-form');
        const formData = new FormData(form);

        formData.append('notes', $('#id_notes').summernote('code'));
        formData.append('terms', $('#id_terms').summernote('code'));


        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your client.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: form.action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('.error').remove();
                $('.is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#id_' + field);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;

                            if (inputField.closest('.input-group').length) {
                                inputField.closest('.input-group').after(errorHtml);
                            } else if (inputField.hasClass('choices__input')) {
                                console.log(inputField)
                                inputField.parent().after(errorHtml);
                            } else {
                                inputField.after(errorHtml);
                            }
                        }
                    });

                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please check the form carefully!",
                        position: "center",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Client Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#editClient-modal').modal('hide');
                        if (window.location.href.includes("/invoice/add") || window.location.href.includes("/invoice/edit") ||
                            window.location.href.includes("/estimate/add") || window.location.href.includes("/estimate/edit")

                        ) {

                            let addressHTML = '';

                            if ($('#id_company_name').val()) {
                                addressHTML += $('#id_company_name').val() + '<br>';
                            } else {
                                addressHTML += $('#id_client_name').val() + '<br>';
                            }
                            if ($('#id_address_1').val()) addressHTML += $('#id_address_1').val() + '<br>';
                            if ($('#id_address_2').val()) addressHTML += $('#id_address_2').val() + '<br>';
                            if ($('#id_state_id option:selected').text()) addressHTML += $('#id_state_id option:selected').text() + ' ';
                            if ($('#id_country_id option:selected').text()) addressHTML += $('#id_country_id option:selected').text() + ' ';
                            if ($('#id_zip').val()) addressHTML += $('#id_zip').val();

                            $('#client').val($('#id_client_name').val());
                            $('#client_id').val(response.client_id);
                            $('#clientList').hide();

                            let edit_client = `<button client-code="${response.client_code}"  class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center 
                   position-absolute shadow" style="width: 36px; height: 36px; bottom: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editClientAddressModal">
        <i class="bi bi-pencil-fill"></i>
    </button>`;

                            $('#clientAddress').html(addressHTML + edit_client).show();




                            $('#id_currency_code').val($('#client_id').val(response.client_id)).trigger('change');
                            if ($('#id_notes').val()) {
                                $('#id_invoice_terms').summernote('code', $('#id_notes').val());

                            }
                            if ($('#id_notes').val()) {
                                $('#id_invoice_notes').summernote('code', $('#id_notes').val());
                            }
                            $('#clientSearchBox').hide();
                            $('.change-client').show();
                            $('.new-client').hide();


                        } else {
                            location.reload();
                        }

                    });
                }
            },
            error: function(xhr) {
                Swal.close();

                if (xhr.status === 403 && xhr.responseJSON?.redirect) {
                    window.location.href = xhr.responseJSON.redirect;
                } else {
                    console.error("Error:", xhr.responseText);
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        // === Initialize Choices.js for both state selects ===
        const billingStateChoices = new Choices('#id_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        const shippingStateChoices = new Choices('#id_shipping_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        // === Function to load states dynamically ===
        function refreshStates(selectedCountryId, stateChoicesInstance, selectedStateId = null) {
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    country_id: selectedCountryId
                },
                dataType: "json",
                success: function(response) {
                    // Clear old options
                    stateChoicesInstance.clearChoices();
                    stateChoicesInstance.removeActiveItems();

                    // Map new state options
                    const options = response.states.map(state => ({
                        value: String(state.state_id),
                        label: state.state_name,
                        selected: selectedStateId ? String(state.state_id) === String(selectedStateId) : false,
                    }));

                    // Set new choices
                    stateChoicesInstance.setChoices(options, 'value', 'label', true);

                    // Select specific state if available
                    if (selectedStateId) {
                        stateChoicesInstance.setChoiceByValue(String(selectedStateId));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }

        // === Billing Country Change ===
        $('#id_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId, billingStateChoices);
            } else {
                billingStateChoices.clearChoices();
                billingStateChoices.removeActiveItems();
            }
        });

        // === Shipping Country Change ===
        $('#id_shipping_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId, shippingStateChoices);
            } else {
                shippingStateChoices.clearChoices();
                shippingStateChoices.removeActiveItems();
            }
        });

        // === On Page Load: preload both billing and shipping ===
        const initialBillingCountryId = "{{ optional($data['client'] ?? null)->country_id ?? request('country_id') }}";
        const initialBillingStateId = "{{ optional($data['client'] ?? null)->state_id ?? request('state_id') }}";

        const initialShippingCountryId = "{{ optional($data['client'] ?? null)->shipping_country_id ?? request('shipping_country_id') }}";
        const initialShippingStateId = "{{ optional($data['client'] ?? null)->shipping_state_id ?? request('shipping_state_id') }}";

        if (initialBillingCountryId) {
            refreshStates(initialBillingCountryId, billingStateChoices, initialBillingStateId);
        }

        if (initialShippingCountryId) {
            refreshStates(initialShippingCountryId, shippingStateChoices, initialShippingStateId);
        }
    });
</script>