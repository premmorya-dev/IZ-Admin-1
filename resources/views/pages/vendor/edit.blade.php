<form action="{{ route('vendor.update') }}" id="edit-vendor-form" method="POST" enctype="multipart/form-data">
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-4">
            <div class="row g-4">

                {{-- Basic Info --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-user me-1"></i> Vendor Name</label>
                    <input type="text" name="vendor_name" id="id_vendor_name" class="form-control"
                        value="{{ old('vendor_name', optional($data['vendor'] ?? null)->vendor_name) }}"
                        placeholder="Enter vendor name">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-building me-1"></i> Company Name</label>
                    <input type="text" name="company_name" id="id_company_name" class="form-control"
                        value="{{ old('company_name', optional($data['vendor'] ?? null)->company_name) }}"
                        placeholder="Enter company name">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-envelope me-1"></i> Email</label>
                    <input type="email" name="email" id="id_email" class="form-control"
                        value="{{ old('email', optional($data['vendor'] ?? null)->email) }}"
                        placeholder="Enter email address">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i> Phone</label>
                    <input type="text" name="phone" id="id_phone" class="form-control"
                        value="{{ old('phone', optional($data['vendor'] ?? null)->phone) }}"
                        placeholder="Enter phone number">
                </div>

                {{-- Address --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-receipt me-1"></i> GST Number</label>
                    <input type="text" name="gst_number" id="id_gst_number" class="form-control"
                        value="{{ old('gst_number', optional($data['vendor'] ?? null)->gst_number) }}"
                        placeholder="Enter GST number">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="fas fa-city me-1"></i> City</label>
                    <input type="text" name="city" id="id_city" class="form-control"
                        value="{{ old('city', optional($data['vendor'] ?? null)->city) }}"
                        placeholder="Enter city">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Address 1</label>
                    <textarea name="address_1" id="id_address_1" class="form-control" rows="2" placeholder="Enter primary address">{{ old('address_1', optional($data['vendor'] ?? null)->address_1) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Address 2</label>
                    <textarea name="address_2" id="id_address_2" class="form-control" rows="2" placeholder="Enter secondary address">{{ old('address_2', optional($data['vendor'] ?? null)->address_2) }}</textarea>
                </div>

                {{-- Location --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Country</label>
                    <select name="country_id" id="id_country_id" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['countries'] as $country)
                        <option value="{{ $country->country_id }}" {{ optional($data['vendor'] ?? null)->country_id == $country->country_id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">State</label>
                    <select name="state_id" id="id_state_id" class="form-select">
                        <option value="">Please Select</option>

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Currency</label>
                    <select name="currency_code" id="id_currency_code" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['currencies'] as $currency)
                        <option value="{{ $currency->currency_code }}" {{ optional($data['vendor'] ?? null)->currency_code == $currency->currency_code ? 'selected' : '' }}>
                            {{ $currency->currency_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Notes & Terms --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" id="" class="form-control" rows="2" placeholder="Enter notes">{{ old('notes', optional($data['vendor'] ?? null)->notes) }}</textarea>
                </div>

              

                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="fas fa-mail-bulk me-1"></i> Zip Code</label>
                    <input type="text" name="zip" id="id_zip" class="form-control"
                        value="{{ old('zip', optional($data['vendor'] ?? null)->zip) }}"
                        placeholder="Enter zip code">
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" id="id_status" class="form-select">
                        <option value="active" {{ optional($data['vendor'] ?? null)->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="deactive" {{ optional($data['vendor'] ?? null)->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <input type="hidden" name="vendor_code" id="id_vendor_code" value="{{ optional($data['vendor'] ?? null)->vendor_code }}">
            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">
            <button type="submit" class="btn btn-success px-4 update-vendor w-100">
                <i class="fas fa-save me-1"></i> Update vendor
            </button>
        </div>
    </div>
</form>


<script>
    document.querySelector('.update-vendor').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('edit-vendor-form');
        const formData = new FormData(form);

      
       


        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your vendor.",
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
                        title: "Vendor Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#editvendor-modal').modal('hide');
                        location.reload();
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
        // Create Choices instance ONCE

        const stateChoices = new Choices('#id_state_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false
        });

        function refreshStates(selectedCountryId, selectedStateId = null) {
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    country_id: selectedCountryId
                },
                dataType: "json",
                success: function(response) {
                    console.log("States:", response.states);

                    // Clear old options, keep instance
                    stateChoices.clearChoices();
                    stateChoices.removeActiveItems();

                    // Add new options
                    const options = response.states.map(state => ({
                        value: String(state.state_id),
                        label: state.state_name,
                        selected: selectedStateId ? String(state.state_id) === String(selectedStateId) : false,
                    }));

                    stateChoices.setChoices(options, 'value', 'label', true);

                    // Explicitly select state if provided
                    if (selectedStateId) {
                        stateChoices.setChoiceByValue(String(selectedStateId));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }

        // When country changes
        $('#id_country_id').on('change', function() {
            let selectedCountryId = $(this).val();
            if (selectedCountryId) {
                refreshStates(selectedCountryId);
            } else {
                stateChoices.clearChoices();
                stateChoices.removeActiveItems();
            }
        });

        // On page load: preload country + states
        const initialCountryId = "{{ optional($data['vendor'] ?? null)->country_id ?? request('country_id') }}";
        const initialStateId = "{{ optional($data['vendor'] ?? null)->state_id ?? request('state_id') }}";

        if (initialCountryId) {
            refreshStates(initialCountryId, initialStateId);
        }
    });
</script>