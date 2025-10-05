<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <h2 class="py-3">Add Client</h2>

    <form action="{{ route('client.store') }}" id="add-client-form" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-lucide="arrow-left"></i> Back
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm save-client">
                    <i data-lucide="save"></i> Add
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mt-3">
                <label for="client_name" class="form-label">Client Name</label>
                <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}" class="form-control" placeholder="Client Name">
            </div>

            <div class="col-md-3 mt-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" class="form-control" placeholder="Company Name">
            </div>

            <div class="col-md-3 mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
            </div>

            <div class="col-md-3 mt-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Mobile Number">
            </div>

            <div class="col-md-3 mt-3">
                <label for="gst_number" class="form-label">Gst Number</label>
                <input type="text" id="gst_number" name="gst_number" value="{{ old('gst_number') }}" class="form-control" placeholder="Gst Number">
            </div>

            <div class="col-md-3 mt-3">
                <label for="address_1" class="form-label">Address 1</label>
                <textarea name="address_1" id="address_1" class="form-control" placeholder="Address 1">{{ old('address_1') }}</textarea>
            </div>

            <div class="col-md-3 mt-3">
                <label for="address_2" class="form-label">Address 2</label>
                <textarea name="address_2" id="address_2" class="form-control" placeholder="Address 2">{{ old('address_2') }}</textarea>
            </div>

            <div class="col-md-3 mt-3">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control" placeholder="City">
            </div>

            <div class="col-md-3 mt-3">
                <label for="country_id" class="form-label">Country</label>
                <select id="country_id" name="country_id" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['countries'] as $country)
                    <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="state_id" class="form-label">State</label>
                <select id="state_id" name="state_id" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['states'] as $state)
                    <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="currency" class="form-label">Select Currency</label>
                <select name="currency_code" id="currency_code" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['currencies'] as $currency)
                        <option value="{{ $currency->currency_code }}" {{ old('currency_code') == $currency->currency_code ? 'selected' : '' }}>
                            {{ $currency->currency_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="zip" class="form-label">Zip Code</label>
                <input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="form-control" placeholder="Zip Code">
            </div>

            <div class="col-md-6 mt-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
            </div>

            <div class="col-md-6 mt-3">
                <label for="terms" class="form-label">Terms And Conditions</label>
                <textarea name="terms" id="terms" class="form-control">{{ old('terms') }}</textarea>
            </div>

            <div class="col-md-3 mt-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="deactive">Deactive</option>
                </select>
            </div>
        </div>
    </form>

    <script>
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {
            const ids = ['id_notes', 'id_terms'];

            ids.forEach(function(id) {
                const element = document.getElementById(id);
                if (element) {
                    ClassicEditor
                        .create(element)
                        .then(editor => {
                            editors[id] = editor;
                        })
                        .catch(error => {
                            console.error(`CKEditor init failed for ${id}`, error);
                        });
                }
            });

            document.querySelector('.save-client').addEventListener('click', function(e) {
                e.preventDefault();

                // Sync CKEditor data
                for (const id in editors) {
                    if (editors.hasOwnProperty(id)) {
                        document.getElementById(id).value = editors[id].getData();
                    }
                }

                const form = document.getElementById('add-client-form');
                const formData = new FormData(form);

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
                                let inputField = $('[name="' + field + '"]');
                                if (inputField.length) {
                                    inputField.addClass('is-invalid');
                                    const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;

                                    if (inputField.closest('.input-group').length) {
                                        inputField.closest('.input-group').after(errorHtml);
                                    } else if (inputField.hasClass('select2-hidden-accessible')) {
                                        inputField.next('.select2-container').after(errorHtml);
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
                                // Redirect after the alert closes
                                window.location.href = "{{ route('client.list') }}";
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
        });
    </script>




    <script>
        $(document).ready(function() {


            $('#country_id, #state_id, #currency_code').select2({
                placeholder: "Please select",
                allowClear: true
            });


        });
    </script>

    <script>
        function refreshStates(selectedCountries) {
            // AJAX Call to fetch states
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    country_id: selectedCountries
                },
                dataType: "json",
                success: function(response) {

                    console.log(response.states)
                    // Clear previous states
                    $('#state_id').html('');

                    // Append new state options
                    $.each(response.states, function(key, state) {
                        $('#state_id').append(`<option value="${state.state_id}">${state.state_name}</option>`);
                    });

                    // Refresh the multiselect dropdown
                    document.getElementById('state_id').loadOptions();

                    let selectedState = "{{ request('state_id') }}".split(',').map(String);
                    $('#state_id').val(selectedState).trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }
        $(document).ready(function() {

            $('#country_id').on('change', function() {
                var selectedCountries = $(this).val(); // Get selected country IDs (array)
                refreshStates(selectedCountries);
            });

            let country_id = "{{ request('country_id') }}";
            if (country_id) {

                let country = country_id.split(',').map(Number);
                $('#country_id').val(country).trigger('change'); // Preselect
                refreshProgramsBySeoUrls(country); // Load programs
            }


        });
    </script>





   





</x-default-layout>