<x-default-layout>

    <h2 class="py-3">Edit Client</h2>

    <form action="{{ route('client.update') }}" id="edit-client-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('client.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-lucide="arrow-left"></i> Back
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm update-client">
                    <i data-lucide="save"></i> Update
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Client Form Fields -->
            <div class="col-md-3 mt-3">
                <label class="form-label">Client Name</label>
                <input type="text" name="client_name" value="{{ old('client_name', $data['client']->client_name) }}" class="form-control" placeholder="Client Name">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name', $data['client']->company_name) }}" class="form-control" placeholder="Company Name">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $data['client']->email) }}" class="form-control" placeholder="Email">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $data['client']->phone) }}" class="form-control" placeholder="Phone">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">GST Number</label>
                <input type="text" name="gst_number" value="{{ old('gst_number', $data['client']->gst_number) }}" class="form-control" placeholder="GST Number">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Address 1</label>
                <textarea name="address_1" class="form-control" placeholder="Address 1">{{ old('address_1', $data['client']->address_1) }}</textarea>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Address 2</label>
                <textarea name="address_2" class="form-control" placeholder="Address 2">{{ old('address_2', $data['client']->address_2) }}</textarea>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">City</label>
                <input type="text" name="city" value="{{ old('city', $data['client']->city) }}" class="form-control" placeholder="City">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Country</label>
                <select name="country_id" id="country_id" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['countries'] as $country)
                    <option value="{{ $country->country_id }}" {{ $data['client']->country_id == $country->country_id ? 'selected' : '' }}>
                        {{ $country->country_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">State</label>
                <select name="state_id" id="state_id" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['states'] as $state)
                    <option value="{{ $state->state_id }}" {{ $data['client']->state_id == $state->state_id ? 'selected' : '' }}>
                        {{ $state->state_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Currency</label>
                <select name="currency_code" id="currency_code" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['currencies'] as $currency)
                    <option value="{{ $currency->currency_code }}" {{ $data['client']->currency_code == $currency->currency_code ? 'selected' : '' }}>
                        {{ $currency->currency_name }}
                    </option>
                    @endforeach
                </select>
            </div>



            <div class="col-md-6 mt-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control">{{ old('notes', $data['client']->notes) }}</textarea>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label">Terms And Conditions</label>
                <textarea name="terms" id="terms" class="form-control">{{ old('terms', $data['client']->terms) }}</textarea>
            </div>
            <div class="col-md-3 mt-3">
                <label class="form-label">Zip Code</label>
                <input type="text" name="zip" value="{{ old('zip', $data['client']->zip) }}" class="form-control" placeholder="Zip Code">
            </div>
            <div class="col-md-3 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $data['client']->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ $data['client']->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <input type="hidden" name="client_code" value="{{   $data['client']->client_code }}">

        </div>
    </form>


    <script>
        const editors = {};
        document.addEventListener("DOMContentLoaded", function() {
            const ids = ['notes', 'terms'];
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

            document.querySelector('.update-client').addEventListener('click', function(e) {
                e.preventDefault();

                for (const id in editors) {
                    if (editors.hasOwnProperty(id)) {
                        document.getElementById(id).value = editors[id].getData();
                    }
                }

                const form = document.getElementById('edit-client-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Updating...",
                    text: "Please wait while we update the client.",
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
                                text: "Please fix the errors.",
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
                                toast: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
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

            $('#country_id').on('change', function() {
                var selectedCountry = $(this).val();
                refreshStates(selectedCountry);
            });

            function refreshStates(country_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get.states.by.country') }}",
                    data: {
                        country_id: country_id
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#state_id').empty();
                        $.each(response.states, function(key, state) {
                            $('#state_id').append(`<option value="${state.state_id}">${state.state_name}</option>`);
                        });
                        $('#state_id').val('{{ $data["client"]->state_id }}').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching states:', xhr);
                    }
                });
            }
        });
    </script>

</x-default-layout>