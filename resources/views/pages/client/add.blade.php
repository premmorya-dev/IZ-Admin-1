<form action="{{ route('client.store') }}" id="add-client-form" method="POST" enctype="multipart/form-data">
    <div class="card cef-card shadow-sm border-0 rounded-4">

        {{-- Header --}}
        <div class="cef-header d-flex align-items-center justify-content-between">
            <div>
                <h5><i class="fas fa-id-card me-2 text-primary"></i>New Client</h5>
                <p>Fill in the details for the new client</p>
            </div>
            <select name="status" id="id_status" class="form-select form-select-sm w-50 shadow-sm" style="border-radius:20px;">
                <option value="active" {{ optional($data['client'] ?? null)->status == 'active' ? 'selected' : '' }}>🟢 Active</option>
                <option value="deactive" {{ optional($data['client'] ?? null)->status == 'deactive' ? 'selected' : '' }}>⚪ Deactive</option>
            </select>
        </div>

        {{-- Tabs --}}
        <div class="cef-tabs">
            <button type="button" class="cef-tab-btn active" data-tab="basic">
                <span class="cef-ico"><i class="fas fa-user"></i></span> Basic Info
            </button>
            <button type="button" class="cef-tab-btn" data-tab="address">
                <span class="cef-ico"><i class="fas fa-map-marker-alt"></i></span> Address & Billing
            </button>
            <button type="button" class="cef-tab-btn" data-tab="shipping">
                <span class="cef-ico"><i class="fas fa-shipping-fast"></i></span> Shipping
                <span class="cef-tab-badge" id="shipBadge">Off</span>
            </button>
        </div>

        <div class="card-body p-0">

            {{-- ===================== TAB 1: BASIC INFO ===================== --}}
            <div class="cef-panel active" data-panel="basic">
                <div class="row g-4">
                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-user"></i></span> Client Name <span class="req-dot"></span></label>
                        <input type="text" name="client_name" id="id_client_name" class="form-control"
                            value="{{ old('client_name', optional($data['client'] ?? null)->client_name) }}"
                            placeholder="Enter client name">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-violet"><i class="fas fa-building"></i></span> Company Name</label>
                        <input type="text" name="company_name" id="id_company_name" class="form-control"
                            value="{{ old('company_name', optional($data['client'] ?? null)->company_name) }}"
                            placeholder="Enter company name">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-emerald"><i class="fas fa-envelope"></i></span> Email</label>
                        <input type="email" name="email" id="id_email" class="form-control"
                            value="{{ old('email', optional($data['client'] ?? null)->email) }}"
                            placeholder="Enter email address">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-amber"><i class="fas fa-phone"></i></span> Phone</label>
                        <input type="text" name="phone" id="id_phone" class="form-control"
                            value="{{ old('phone', optional($data['client'] ?? null)->phone) }}"
                            placeholder="Enter phone number">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-cyan"><i class="fas fa-receipt"></i></span> GST Number</label>
                        <input type="text" name="gst_number" id="id_gst_number" class="form-control"
                            value="{{ old('gst_number', optional($data['client'] ?? null)->gst_number) }}"
                            placeholder="Enter GST number">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-rose"><i class="fas fa-money-bill-wave"></i></span> Currency <span class="req-dot"></span></label>
                        <select name="currency_code" id="id_currency_code" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['currencies'] as $currency)
                            <option value="{{ $currency->currency_code }}" {{ optional($data['client'] ?? null)->currency_code == $currency->currency_code ? 'selected' : '' }}>
                                {{ $currency->currency_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    
                </div>

                <div class="text-end mt-4">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 cef-next" data-next="address">
                        Next: Address & Billing <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>

            {{-- ===================== TAB 2: ADDRESS & BILLING ===================== --}}
            <div class="cef-panel" data-panel="address">
                <div class="row g-4">
                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-violet"><i class="fas fa-map-marker-alt"></i></span> Address 1 <span class="req-dot"></span></label>
                        <textarea name="address_1" id="id_address_1" class="form-control" rows="2" placeholder="Enter primary address">{{ old('address_1', optional($data['client'] ?? null)->address_1) }}</textarea>
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-violet"><i class="fas fa-map-pin"></i></span> Address 2</label>
                        <textarea name="address_2" id="id_address_2" class="form-control" rows="2" placeholder="Enter secondary address">{{ old('address_2', optional($data['client'] ?? null)->address_2) }}</textarea>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-globe-asia"></i></span> Country <span class="req-dot"></span></label>
                        <select name="country_id" id="id_country_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['countries'] as $country)
                            <option value="{{ $country->country_id }}" {{ optional($data['client'] ?? null)->country_id == $country->country_id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-map"></i></span> State <span class="req-dot"></span></label>
                        <select name="state_id" id="id_state_id" class="form-select">
                            <option value="">Please Select</option>
                        </select>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-emerald"><i class="fas fa-city"></i></span> City</label>
                        <input type="text" name="city" id="id_city" class="form-control"
                            value="{{ old('city', optional($data['client'] ?? null)->city) }}"
                            placeholder="Enter city">
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-amber"><i class="fas fa-mail-bulk"></i></span> Pincode</label>
                        <input type="text" name="zip" id="id_zip" class="form-control"
                            value="{{ old('zip', optional($data['client'] ?? null)->zip) }}"
                            placeholder="Enter pincode">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 cef-prev" data-prev="basic">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </button>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 cef-next" data-next="shipping">
                        Next: Shipping <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>

            {{-- ===================== TAB 3: SHIPPING ===================== --}}
            <div class="cef-panel" data-panel="shipping">
                <div class="cef-ship-toggle">
                    <div>
                        <div class="fw-semibold"><i class="fas fa-shipping-fast me-1"></i> Different shipping address?</div>
                        <small>Turn this on if shipping address is not the same as the billing address.</small>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" name="edit_shipping_address" type="checkbox" id="toggleShippingAddress" style="width:2.6em;height:1.4em;">
                    </div>
                </div>

                <div id="shippingFields" class="row g-4">
                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-user"></i></span> Shipping Client Name <span class="req-dot"></span></label>
                        <input type="text" name="shipping_client_name" id="id_shipping_client_name" class="form-control"
                            value="{{ old('shipping_client_name', optional($data['client'] ?? null)->shipping_client_name) }}"
                            placeholder="Enter shipping client name">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-amber"><i class="fas fa-phone"></i></span> Phone</label>
                        <input type="text" name="shipping_phone" id="id_shipping_phone" class="form-control"
                            value="{{ old('shipping_phone', optional($data['client'] ?? null)->shipping_phone) }}"
                            placeholder="Enter phone number">
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-violet"><i class="fas fa-map-marker-alt"></i></span> Shipping Address 1 <span class="req-dot"></span></label>
                        <textarea name="shipping_address_1" id="id_shipping_address_1" class="form-control" rows="2"
                            placeholder="Enter shipping address 1">{{ old('shipping_address_1', optional($data['client'] ?? null)->shipping_address_1) }}</textarea>
                    </div>

                    <div class="col-md-6 cef-field">
                        <label><span class="cef-fico fico-violet"><i class="fas fa-map-pin"></i></span> Shipping Address 2</label>
                        <textarea name="shipping_address_2" id="id_shipping_address_2" class="form-control" rows="2"
                            placeholder="Enter shipping address 2">{{ old('shipping_address_2', optional($data['client'] ?? null)->shipping_address_2) }}</textarea>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-globe-asia"></i></span> Shipping Country <span class="req-dot"></span></label>
                        <select name="shipping_country_id" id="id_shipping_country_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['countries'] as $country)
                            <option value="{{ $country->country_id }}" {{ optional($data['client'] ?? null)->shipping_country_id == $country->country_id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-blue"><i class="fas fa-map"></i></span> Shipping State <span class="req-dot"></span></label>
                        <select name="shipping_state_id" id="id_shipping_state_id" class="form-select">
                            <option value="">Please Select</option>
                        </select>
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-emerald"><i class="fas fa-city"></i></span> Shipping City</label>
                        <input type="text" name="shipping_city" id="id_shipping_city" class="form-control"
                            value="{{ old('shipping_city', optional($data['client'] ?? null)->shipping_city) }}"
                            placeholder="Enter city">
                    </div>

                    <div class="col-md-4 cef-field">
                        <label><span class="cef-fico fico-amber"><i class="fas fa-mail-bulk"></i></span> Shipping Pincode</label>
                        <input type="number" name="shipping_zip" id="id_shipping_zip" class="form-control"
                            value="{{ old('shipping_zip', optional($data['client'] ?? null)->shipping_zip) }}"
                            placeholder="Enter shipping pincode">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 cef-prev" data-prev="address">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </button>
                </div>
            </div>

            <input type="hidden" name="client_code" id="id_client_code" value="{{ optional($data['client'] ?? null)->client_code }}">
        </div>

        
    </div>
    
        <x-invoice.sticky-actions
            submitText="Save Client"
            submitClass="save-client" />

</form>

<script>
    (function() {
        const form = document.getElementById('add-client-form');
        if (!form) return;

        const tabBtns = form.querySelectorAll('.cef-tab-btn');
        const panels = form.querySelectorAll('.cef-panel');
        const shipToggle = form.querySelector('#toggleShippingAddress');
        const shipFields = form.querySelector('#shippingFields');
        const shipBadge = form.querySelector('#shipBadge');

        function goToTab(name) {
            tabBtns.forEach(b => b.classList.toggle('active', b.dataset.tab === name));
            panels.forEach(p => p.classList.toggle('active', p.dataset.panel === name));
        }

        tabBtns.forEach(btn => btn.addEventListener('click', () => goToTab(btn.dataset.tab)));
        form.querySelectorAll('.cef-next').forEach(btn => btn.addEventListener('click', () => goToTab(btn.dataset.next)));
        form.querySelectorAll('.cef-prev').forEach(btn => btn.addEventListener('click', () => goToTab(btn.dataset.prev)));

        function syncShipping() {
            const on = shipToggle.checked;
            shipFields.classList.toggle('enabled', on);
            shipBadge.textContent = on ? 'On' : 'Off';
            shipBadge.classList.toggle('on', on);
        }

        if (shipToggle) {
            shipToggle.addEventListener('change', syncShipping);
            syncShipping(); // initial state on load (e.g. edit mode with existing shipping data)
        }

        // Bootstrap tooltips (kept from original markup)
        if (window.bootstrap) {
            form.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
        }
    })();
</script>
<script>
    document.querySelector('.save-client').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('add-client-form');
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
                        title: "Client Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#client-modal').modal('hide');

                        if ( window.location.href.includes("/invoice/add") || window.location.href.includes("/invoice/edit") ||
                        window.location.href.includes("/estimate/add") || window.location.href.includes("/estimate/edit")
                        
                        ) {

                            let addressHTML = '';

                            if ($('#id_company_name').val() ) {
                                addressHTML += $('#id_company_name').val()  + '<br>';
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

                            $('#clientAddress').html(addressHTML).show();

                            $('#id_currency_code').val( $('#client_id').val(response.client_id)).trigger('change');
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