<x-default-layout>
    <h2 class="py-3">Buisness Settings</h2>
    <style>
        .upload-area {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 300px;
            border: 2px dashed #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }

        .upload-area img {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>
            <button type="submit" class="btn btn-primary btn-sm "><i data-lucide="save"></i> Save Settings</button>
        </div>

        <fieldset class="border p-3 rounded mt-4">
            <legend class="w-auto mb-5">Contact Info</legend>
            <div class="row">
                <div class="col-md-6 mt-4">
                    <label for="mobile_country_code_id" class="form-label">Country Code</label>
                    <select name="mobile_country_code_id" id="mobile_country_code_id" class="form-select @error('mobile_country_code_id') is-invalid @enderror">
                        <option value="">-- Select Country Code --</option>
                        @foreach($data['mobile_country_list'] as $country)
                        <option
                            value="{{ $country->mobile_country_code_id }}"
                            data-code="{{ $country->country_code }}"
                            data-flag="{{ $country->flag_icon_class }}"
                            {{ old('mobile_country_code_id', Auth::user()->mobile_country_code_id ?? '') == $country->mobile_country_code_id ? 'selected' : '' }}>
                            {{ $country->country_name }} (+{{ $country->country_code }})
                        </option>
                        @endforeach
                    </select>
                    @error('mobile_country_code_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>



                <div class="col-md-6 mt-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" readonly class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data['setting']->email ?? '') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mt-4">
                    <label for="mobile_no" class="form-label">Mobile No</label>
                    <div class="input-group">
                        <span class="input-group-text" id="country_code_prefix">+--</span>
                        <input type="text" name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no',  Auth::user()->mobile_no ?? '') }}">
                        @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>


            </div>

        </fieldset>

        <fieldset class="border p-3 rounded mt-4">
            <legend class="w-auto mb-5">Company Info</legend>

            <div class="row">
                <div class="col-md-6 mt-4">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $data['setting']->company_name ?? '') }}">
                    @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mt-4">
                    <label for="is_company" class="form-label">Buisness Type</label>
                    <select name="is_company" id="is_company" class="form-select @error('is_company') is-invalid @enderror">
                        <option value="Y" {{ old('is_company', $data['setting']->is_company ?? '') == 'Y' ? 'selected' : '' }}>Organisation</option>
                        <option value="N" {{ old('is_company', $data['setting']->is_company ?? '') == 'N' ? 'selected' : '' }}>Individual</option>
                    </select>
                    @error('is_company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mt-4">
                    <label for="address_1" class="form-label">Address Line 1</label>
                    <input type="text" name="address_1" id="address_1" class="form-control" value="{{ old('address_1', $data['setting']->address_1 ?? '') }}">
                </div>

                <div class="col-md-6 mt-4">
                    <label for="address_2" class="form-label">Address Line 2</label>
                    <input type="text" name="address_2" id="address_2" class="form-control" value="{{ old('address_2', $data['setting']->address_2 ?? '') }}">
                </div>

                <div class="col-md-6 mt-4">
                    <label for="country_id" class="form-label">Country</label>
                    <select name="country_id" id="country_id" class="form-select @error('country_id') is-invalid @enderror">
                        <option value="">-- Select Country --</option>
                        @foreach($data['countries'] as $country)
                        <option value="{{ $country->country_id }}" {{ old('country_id', $data['setting']->country_id ?? '') == $country->country_id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mt-4">
                    <label for="state_id" class="form-label">State</label>
                    <select name="state_id" id="state_id" class="form-select @error('state_id') is-invalid @enderror">
                        <option value="">-- Select State --</option>
                        @foreach($data['states']->where('country_id', $data['setting']->country_id) as $state)
                        <option value="{{ $state->state_id }}" {{ old('state_id', $data['setting']->state_id ?? '') == $state->state_id ? 'selected' : '' }}>
                            {{ $state->state_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>


                <div class="col-md-6 mt-4">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" name="pincode" id="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $data['setting']->pincode ?? '') }}">
                    @error('pincode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>


            </div>

        </fieldset>

        <fieldset class="border p-3 rounded mt-4">
            <legend class="w-auto mb-5">Invoice Settings</legend>


            <div class="row">


                <div class="col-md-6 mt-3">
                    <label for="default_currency" class="form-label">Default Currency</label>
                    <select id="default_currency" name="default_currency" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['currencies'] as $currency )
                        <option value="{{ $currency->currency_code }}" {{ old('default_currency', $data['setting']->default_currency ?? '') == $currency->currency_code ? 'selected' : '' }}> {{ $currency->currency_name }} | {{ $currency->currency_symbol }}</option>
                        @endforeach

                    </select>
                </div>


                <div class="col-md-6 mt-3">
                    <label for="default_tax_id" class="form-label">Default Tax %</label>
                    <select id="default_tax_id" name="default_tax_id" class="form-select">
                        <option value="0">No Tax</option>
                        @foreach($data['taxes'] as $tax )
                        <option value="{{ $tax->tax_id }}" {{ old('default_tax_id', $data['setting']->default_tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="default_discount_id" class="form-label">Default Discount %</label>
                    <select id="default_discount_id" name="default_discount_id" class="form-select">
                        <option value="0">No Discount</option>
                        @foreach($data['discounts'] as $discount )
                        <option value="{{ $discount->discount_id }}" {{ old('default_discount_id', $data['setting']->default_discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="invoice_prefix" class="form-label">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" id="invoice_prefix" class="form-control" value="{{ old('invoice_prefix', $data['setting']->invoice_prefix ?? '') }}">
                </div>




                <div class="col-md-6 mt-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" id="id_notes" class="form-control">{{ old('notes', $data['setting']->notes) }}</textarea>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Terms And Conditions</label>
                    <textarea name="terms" id="id_terms" class="form-control">{{ old('terms', $data['setting']->terms) }}</textarea>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="pagination_limit" class="form-label">Pagination Limit</label>
                    <input type="number" name="pagination_limit" id="pagination_limit" class="form-control @error('pagination_limit') is-invalid @enderror" value="{{ old('pagination_limit', $data['setting']->pagination_limit ?? 10) }}">
                    @error('pagination_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="default_upi_id" class="form-label">Default Upi Id</label>
                    <select id="default_upi_id" name="default_upi_id" class="form-select">
                        <option value="0">Please Select</option>
                        @foreach($data['upi_payment_id'] as $upi_id )
                        <option value="{{ $upi_id->upi_log_id }}" {{ old('default_upi_id', $data['setting']->default_upi_id ?? '') == $upi_id->upi_log_id ? 'selected' : '' }}>{{ $upi_id->upi_name }}</option>
                        @endforeach
                    </select>
                    @error('pagination_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @php
                $selectedFormat = old('date_format', $data['setting']->date_format ?? 'MdY');

                $formats = [
                'Y M d' => date('Y M d'), // 2025 Jun 19
                'd M Y' => date('d M Y'), // 19 Jun 2025
                'M d Y' => date('M d Y'), // Jun 19 2025
                'Y-m-d' => date('Y-m-d'), // 2025-06-19
                'd-m-Y' => date('d-m-Y'), // 19-06-2025
                'm-d-Y' => date('m-d-Y'), // 06-19-2025
                'd.m.Y' => date('d.m.Y'), // 19.06.2025
                ];
                @endphp

                <div class="col-md-6 mt-3">
                    <label for="date_format" class="form-label">Default Date Format</label>
                    <select id="date_format" name="date_format" class="form-select">
                        @foreach($formats as $key => $sample)
                        <option value="{{ $key }}" {{ $selectedFormat == $key ? 'selected' : '' }}>
                            {{ $sample }}
                        </option>
                        @endforeach
                    </select>
                    @error('date_format')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <div class="row">

                    @php
                    $userId = Auth::id();
                    $storedSignature = $data['setting']->signature ? asset($data['setting']->signature) : '';
                    $showSignature = $storedSignature && !str_contains($storedSignature, 'no-image.png');

                    $storedLogo = $data['setting']->logo_path ? asset($data['setting']->logo_path) : '';
                    $showLogo = $storedLogo && !str_contains($storedLogo, 'no-image.png');
                    @endphp

                    <div class="col-md-6 mt-3">
                        <label for="logo_path" class="form-label mt-4">Company Logo</label> <br>
                        <label class="upload-area mt-3" id="upload-box-logo">
                            <input type="file" class="image-upload form-control" name="logo_path" accept="image/*"
                                data-preview="preview-logo_path" data-upload-box="upload-box-logo" data-clear-btn="clear-logo_path"
                                onchange="previewImage(event)">
                            <img id="preview-logo_path" src="{{ $showLogo ? $storedLogo : '' }}"
                                style="max-height: 150px; display: {{ $showLogo ? 'block' : 'none' }}" alt="Uploaded Logo">
                            <span style="display: none;">Click to upload<br>or drag & drop</span>

                            @error('logo_path')<div class="text-danger">{{ $message }}</div>@enderror
                        </label>

                        @if ($showLogo)
                        <button type="button" class="btn btn-lg mt-2" onclick="removeSavedImage('logo_path')">X</button>
                        <input type="hidden" name="remove_logo_path" id="remove_logo_path" value="0">
                        @endif


                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="signature" class="form-label mt-4">Digital Signature</label> <br>
                        <label class="upload-area mt-3" id="upload-box-signature">
                            <input type="file" class="image-upload form-control" name="signature" accept="image/*"
                                data-preview="preview-signature" data-upload-box="upload-box-signature" data-clear-btn="clear-signature"
                                onchange="previewImage(event)">
                            <img id="preview-signature" src="{{ $showSignature ? $storedSignature : '' }}"
                                style="max-height: 150px; display: {{ $showSignature ? 'block' : 'none' }};" alt="Uploaded Signature">
                            <span style="display: none;">Click to upload<br>or drag & drop</span>
                        </label>



                        @if ($showSignature)
                        <button type="button" class="btn btn-lg mt-2" onclick="removeSavedImage('signature')">X</button>
                        <input type="hidden" name="remove_signature" id="remove_signature" value="0">
                        @endif

                        @error('signature')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>




                </div>



            </div>

        </fieldset>


        <fieldset class="border p-3 rounded mt-4">
            <legend class="w-auto mb-5">Alerts</legend>

            <!-- Payment Reminder -->
            <div class="col-md-6 mt-3">
                <label for="invoice_payment_reminder_status" class="form-label">
                    Payment Reminder
                    <span data-bs-toggle="tooltip" title="Enable or disable payment reminders.">
                        <i class="bi bi-question-circle-fill text-primary ms-1"></i>
                    </span>
                </label>
                <select name="invoice_payment_reminder_status" id="invoice_payment_reminder_status" class="form-select">
                    <option value="N" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'N' ? 'selected' : '' }}>No</option>
                    <option value="Y" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'Y' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <!-- Before Due Days -->
            <div class="col-md-6 mt-3">
                <label for="reminder_before_due_days" class="form-label">
                    Before Due Days
                    <span data-bs-toggle="tooltip" title="Select how many days before due date the reminder should be sent.">
                        <i class="bi bi-question-circle-fill text-primary ms-1"></i>
                    </span>
                </label>
                <select name="reminder_before_due_days" id="reminder_before_due_days" class="form-select">
                    <option value="0">Disable</option>
                    @for ($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}" {{ old('reminder_before_due_days', $data['setting']->reminder_before_due_days ?? '') == $i ? 'selected' : '' }}>{{ $i }} day{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                </select>
            </div>


            <!-- After Due Days -->
            <div class="col-md-6 mt-3">
                <label for="enable_reminder" class="form-label">
                    Every Day Invoice Payment Reminder
                    <span
                        data-bs-toggle="tooltip"
                        title="If enabled, all invoices that are already past their due date will receive a reminder notification every day until they are paid.">
                        <i class="bi bi-question-circle-fill text-primary ms-1"></i>
                    </span>
                </label>


                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="everyday_reminder_after_due_day" name="everyday_reminder_after_due_day"
                        {{ !empty($data['setting']->everyday_reminder_after_due_day) && $data['setting']->everyday_reminder_after_due_day == 'Y'  ? 'checked' : '' }}>
                    <label class="form-check-label" for="everyday_reminder_after_due_day">Send reminder after due date</label>
                </div>
            </div>



        </fieldset>


    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#id_notes').summernote({
                placeholder: 'Enter notes...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('#id_terms').summernote({
                placeholder: 'Enter terms...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });


        })

        function previewImage(event) {
            const input = event.target;
            const previewId = input.dataset.preview;
            const uploadBoxId = input.dataset.uploadBox;
            const clearBtnId = input.dataset.clearBtn;

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    document.getElementById(clearBtnId).style.display = 'inline-block';
                    document.getElementById(uploadBoxId).classList.add('image-selected');
                };
                reader.readAsDataURL(file);
            }
        }

        function clearImage(button) {
            const inputName = button.dataset.input;
            const previewId = button.dataset.preview;
            const uploadBoxId = button.dataset.uploadBox;

            const input = document.querySelector(`input[name="${inputName}"]`);
            input.value = '';

            document.getElementById(previewId).src = '';
            document.getElementById(previewId).style.display = 'none';
            button.style.display = 'none';
            document.getElementById(uploadBoxId).classList.remove('image-selected');
        }

        function removeSavedImage(type) {
            const preview = document.getElementById('preview-' + type);
            if (preview) preview.style.display = 'none';

            const clearBtn = document.getElementById('clear-' + type);
            if (clearBtn) clearBtn.style.display = 'none';

            const removeInput = document.getElementById('remove_' + type);
            if (removeInput) removeInput.value = '1';
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#country_id').on('change', function() {
                var countryID = $(this).val();
                $('#state_id').html('<option value="">Loading...</option>');
                if (countryID) {
                    $.ajax({
                        url: "{{ route('get.states.by.country') }}",
                        type: "GET",
                        data: {
                            country_id: countryID
                        },
                        success: function(res) {
                            $('#state_id').empty().append('<option value="">-- Select State --</option>');
                            $.each(res.states, function(key, state) {
                                $('#state_id').append('<option value="' + state.state_id + '">' + state.state_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state_id').html('<option value="">-- Select State --</option>');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            function updatePrefix() {
                var selectedOption = $('#mobile_country_code_id').find('option:selected');
                var code = selectedOption.data('code') || '--';
                $('#country_code_prefix').text('+' + code);
            }

            $('#mobile_country_code_id').on('change', updatePrefix);

            // Trigger once on page load to set initial value
            updatePrefix();
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#mobile_country_code_id').select2({
                placeholder: "Choose Country Code",
                allowClear: true
            });

            $('#country_id').select2({
                placeholder: "Choose Country",
                allowClear: true
            });


            $('#state_id').select2({
                placeholder: "Choose State",
                allowClear: true
            });

            $('#default_currency').select2({
                placeholder: "Choose Default Currency",
                allowClear: true
            });

            $('#default_tax_id').select2({
                placeholder: "Choose Default Tax",
                allowClear: true
            });

            $('#default_discount_id').select2({
                placeholder: "Choose Default Discount",
                allowClear: true
            });
        });
    </script>

</x-default-layout>