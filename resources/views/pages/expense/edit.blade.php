<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #expense_number {
            transition: all 0.4s ease;
            font-weight: 500;
        }

        /* CSS */
        .custom-dropdown {
            min-width: 220px;
            width: 80vw;
            /* Responsive width: 80% of viewport on mobile */
            max-width: 300px;
            /* Limit maximum width on larger screens */
        }

        /* Optional: fine-tune for very small screens */
        @media (max-width: 400px) {
            .custom-dropdown {
                width: 90vw;
            }
        }
    </style>

    <style>
        .upload-area {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 350px;
            border: 2px dashed #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }

        .upload-area img {
            max-width: 100%;
            max-height: 300px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>

    <h2 class="py-3">Edit Expenses</h2>


    <form action="#" id="expense-generate" method="POST">
        @csrf


        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('expense.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>

            <a href="#" id="update-expense" class="btn btn-primary btn-sm"> <i data-lucide="save" class="text-white"></i> Update Expense </a>

        </div>


        <div class="row">

            <div class="col-md-5">
                <div class="col-md-12 text-center">
                    @php
                    $storedLogo = $data['expense']->expense_image ? asset($data['expense']->expense_image) : '';
                    $showLogo = $storedLogo && !str_contains($storedLogo, 'no-image.png');
                    @endphp


                    <label for="upload" class="form-label ">Upload</label> <br>
                    <label class="upload-area " id="upload-box-logo">
                        <input type="file" class="image-upload form-control" name="upload" accept="image/*"
                            data-preview="preview-upload" data-upload-box="upload-box-logo" data-clear-btn="clear-upload"
                            onchange="previewImage(event)">
                        <img id="preview-upload" src="{{ $showLogo ? $storedLogo : '' }}"
                            style="max-height: 150px; display: {{ $showLogo ? 'block' : 'none' }}" alt="Uploaded Logo">
                        <span style="display: none;">Click to upload<br>or drag & drop</span>
                    </label>

                    @if ($showLogo)
                    <button type="button" class="btn btn-lg mt-2" onclick="removeSavedImage('upload')">X</button>
                    <input type="hidden" name="remove_upload" id="remove_upload" value="0">
                    @endif

                    @error('upload')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <!-- expense Number with Mode -->
                    <div class="col-md-4 mt-3">
                        <label for="expense_number" class="form-label d-flex justify-content-between align-items-center">
                            <span>Expense Number</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" id="expense_number" value="{{ old('expense_number', $data['expense']->expense_number ) }}" name="expense_number" placeholder="Auto-generated" readonly>
                    </div>



                    <!-- Currency -->
                    <div class="col-md-4 mt-3">
                        <label for="currency" class="form-label">Select Currency</label>
                        <select name="currency_code" id="currency_code" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['currencies'] as $currency)
                            <option value="{{ $currency->currency_code }}" {{ old('currency_code',$data['expense']->currency_code) == $currency->currency_code ? 'selected' : '' }}>
                                {{ $currency->currency_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @php
                    $paymentModes = [
                    'cash',
                    'upi',
                    'card',
                    'net-banking',
                    'bank-transfer',
                    'cheque'
                    ];
                    @endphp

                    <div class="col-md-4 mt-3">
                        <label for="currency" class="form-label">Payment Mode</label>
                        <select name="payment_mode" id="payment_mode" class="form-select">
                            @foreach ($paymentModes as $value)
                            <option value="{{ $value }}"
                                {{ old('payment_mode', $data['expense']->payment_mode) == $value ? 'selected' : '' }}>
                                {{ ucwords(str_replace('-', ' ', $value)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>




                    <!-- Language -->
                    <div class="col-md-6 mt-3">
                        <label for="template" class="form-label">Template</label>
                        <select class="form-select" id="template_id" name="template_id">
                            <option value="">Please Select</option>
                            @foreach($data['templates'] as $template )
                            <option value="{{ $template->template_id }}" {{ old('template_id',$data['expense']->template_id) == $template->template_id ? 'selected' : '' }}>{{ $template->template_name }}</option>
                            @endforeach
                        </select>
                    </div>








                    <!-- Recurring switch -->


                    <div class="col-md-6 mt-3">
                        <label for="expense_date" class="form-label">Expense Date</label>

                        <div class="input-group">
                            <input type="text" id="expense_date" class="form-control" name="expense_date" value="{{ old('expense_date', $data['expense']->expense_date )  }}" placeholder="Select expense Issue Date">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>





                    <div class="col-md-6 mt-3">
                        <!-- Recurring switch -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring"
                                {{ old('is_recurring', !empty($data['recurring']) ? 'checked' : '') }}>

                            <label class="form-check-label" for="is_recurring">Enable Recurring Invoice</label>
                        </div>


                    </div>


                    <div class="col-md-4 mt-3">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_paid"
                                name="is_paid"
                                value="1"
                                {{ old('is_paid', $data['expense']->is_paid) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_paid">
                                Paid
                            </label>
                        </div>
                    </div>


                    <!-- Recurring options wrapper -->
                    <div class="row" id="recurringOptions" style="display: none;">
                        <!-- Frequency -->
                        <div class="col-md-4 mt-3">
                            <label for="frequency" class="form-label">Frequency</label>
                            <select name="frequency" id="frequency" class="form-select">
                                <option value="monthly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="weekly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="yearly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>

                        </div>

                        <!-- Monthly Day -->
                        <div class="col-md-4 mt-3" id="monthlyDay">
                            <label for="day_of_month" class="form-label">Day of Month (1–31)</label>
                            <select name="day_of_month" class="form-select">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}"
                                    {{ old('day_of_month', $data['recurring']->day_of_month ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>

                        </div>

                        <!-- Weekly Day -->
                        <div class="col-md-4 mt-3" id="weeklyDay" style="display: none;">
                            <label for="day_of_week" class="form-label">Day of Week</label>
                            <select name="day_of_week" class="form-select">
                                @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $day)
                                <option value="{{ $day }}"
                                    {{ old('day_of_week', $data['recurring']->day_of_week ?? '') == $day ? 'selected' : '' }}>
                                    {{ ucfirst($day) }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Yearly Month + Day -->
                        <div id="yearlySection" style="display: none;">
                            <!-- Month -->
                            <div class="col-md-4 mt-3">
                                <label for="month_of_year" class="form-label">Month of Year</label>
                                <select name="month_of_year" class="form-select">
                                    @foreach([
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                    ] as $num => $month)
                                    <option value="{{ $num }}"
                                        {{ old('month_of_year', $data['recurring']->month_of_year ?? '') == $num ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <!-- Day -->
                            <div class="col-md-4 mt-3">
                                <label for="yearly_day_of_month" class="form-label">Day of Month</label>
                                <select name="yearly_day_of_month" class="form-select">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}"
                                        {{ old('yearly_day_of_month', $data['recurring']->day_of_month ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                        </option>
                                        @endfor
                                </select>

                            </div>
                        </div>

                        <!-- Time Picker -->
                        <div class="col-md-4 mt-3">
                            <label for="time_of_day" class="form-label">Time to Generate</label>
                            @php
                            $time = old('time_of_day', isset($data['recurring']->time_of_day)
                            ? \Carbon\Carbon::parse($data['recurring']->time_of_day)->setTimezone('Asia/Kolkata')->format('H:i')
                            : '09:00');
                            @endphp
                            <input type="time" name="time_of_day" class="form-control" value="{{ $time }}">

                        </div>
                    </div>


                </div>

            </div>






            <!-- test -->
            <div class="container my-4">
                <h4 class="mb-3">Expense Item Entry</h4>



                <div id="form-container">
                    @php $itemCount = 0; @endphp
                    @foreach($data['items'] as $itemCount => $item)
                    @php $itemCount++; @endphp
                    <div class="row g-3 p-3 border rounded shadow-sm bg-light align-items-start mb-3 mt-3 position-relative" data-item-id="{{ $itemCount }}">
                        <div class="row w-100 g-2">
                            <div class="col-12 col-md-6">
                                <input type="text" name="item[{{ $itemCount }}][name]" value="{{ $item['name'] ?? '' }}" class="form-control form-control-sm  add-items" id="item-{{ $itemCount }}" item-id="{{ $itemCount }}" placeholder="Item Name & Description">
                                <div id="item-list-{{ $itemCount }}" class="list-group" style="position: absolute; z-index: 1000;"></div>
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="text" name="item[{{ $itemCount }}][hsn]" value="{{ $item['hsn'] ?? ''  }}" placeholder="HSN/SAC" class="form-control form-control-sm hsn" oninput="calculateexpense()">
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="number" name="item[{{ $itemCount }}][quantity]" value="{{ $item['quantity'] ?? '' }}" placeholder="Quantity" class="form-control form-control-sm quantity" oninput="calculateexpense()">
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="number" name="item[{{ $itemCount }}][rate]" value="{{ $item['rate'] ?? '' }}" placeholder="Rate" class="form-control form-control-sm rate" oninput="calculateexpense()">
                            </div>
                        </div>
                        <div class="row w-100 g-2 mt-1 align-items-end">
                            <div class="col-12 col-md-4">
                                <div class="input-group input-group-sm w-100">
                                    <select name="item[{{ $itemCount }}][discount]" class="form-select discount-select flex-grow-1" onchange="calculateexpense()">
                                        <option value="0" {{ (isset($item['discount']) && $item['discount'] == 0) ? 'selected' : '' }}>No Discount</option>
                                        @foreach($data['discounts'] as $discount)
                                        <option value="{{ $discount->percent }}" discount-id="{{ $discount->discount_id }}" {{ (isset($item['discount']) && $item['discount'] == $discount->percent) ? 'selected' : '' }}>
                                            {{ $discount->name }} ({{ $discount->percent }}%)
                                        </option>
                                        @endforeach
                                        <option value="new">➕ Add New Discount</option>
                                    </select>
                                    <span class="input-group-text discount-amount">−$0.00</span>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group input-group-sm w-100">
                                    <select name="item[{{ $itemCount }}][tax]" class="form-select tax-select flex-grow-1" onchange="calculateexpense()">
                                        <option value="0" {{ (isset($item['tax']) && $item['tax'] == 0) ? 'selected' : '' }}>No Tax</option>
                                        @foreach($data['taxes'] as $tax)
                                        <option value="{{ $tax->percent }}" tax-id="{{ $tax->tax_id }}" {{ (isset($item['tax']) && $item['tax'] == $tax->percent) ? 'selected' : '' }}>
                                            {{ $tax->name }} ({{ $tax->percent }}%)
                                        </option>
                                        @endforeach
                                        <option value="new">➕ Add New Tax</option>
                                    </select>
                                    <span class="input-group-text tax-amount">+$0.00</span>
                                </div>

                            </div>
                            <div class="col-6 col-md-4">
                                <input type="text" name="item[{{ $itemCount }}][amount]" value="{{ $item['amount'] }}" class="form-control form-control-sm amount" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline btn-sm btn-outline-danger w-100" onclick="removeRow(this)"><i data-lucide="minus"></i> Remove</button>
                        </div>
                    </div>
                    @endforeach
                </div>


                <button type="button" class="btn btn-outline btn-sm  btn-outline-primary w-100" onclick="addItemRow()"><i data-lucide="plus"></i> Add Item</button>

                <!-- expense Summary Section -->
                <div class="summary-box mt-5">
                    <h5>Expense Summary</h5>
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Subtotal:</div>
                        <div class="col-4 col-md-5 text-end" id="subtotal">−$0.00</div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Total Discount:</div>
                        <div class="col-4 col-md-5 text-end" id="total-discount">−$0.00</div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Total Tax:</div>
                        <div class="col-4 col-md-5 text-end" id="total-tax">$0.00</div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Grand Total:</div>
                        <div class="col-4 col-md-5 text-end" id="grand-total">$0.00</div>
                    </div>


                </div>




                <input type="hidden" name="hidden_sub_total" value="" id="hidden_sub_total">
                <input type="hidden" name="hidden_total_discount" value="" id="hidden_total_discount">
                <input type="hidden" name="hidden_total_tax" value="" id="hidden_total_tax">
                <input type="hidden" name="hidden_grand_total" value="" id="hidden_grand_total">
                <input type="hidden" name="hidden_advance_payment" value="" id="hidden_advance_payment">
                <input type="hidden" name="hidden_total_due" value="" id="hidden_total_due">

                <input type="hidden" name="expense_code" value="{{ $data['expense']->expense_code }}" id="expense_code">


            </div>
            <!-- test -->


            <div class="col-md-12 mt-3">
                <label for="notes" class="form-label fw-semibold">Notes:</label>
                <textarea id="notes" name="notes" class="form-control ck-editor" placeholder="Enter Notes">{{ old('notes', $data['expense']->notes ) }}</textarea>

            </div>





        </div>

        <!-- Submit Button -->



        <!-- Modal to add new tax -->
        <div class="modal fade" id="newTaxModal" tabindex="-1" aria-labelledby="newTaxModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Tax</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="newTaxName" placeholder="Tax Name" class="form-control mb-2">
                        <input type="number" id="newTaxRate" placeholder="Tax Rate (%)" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveNewTax()">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    
    <!-- Add Tax Model -->
    <div class="modal fade" id="tax-modal" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="taxModalLabel">Add Tax</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="tax-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



    <!-- Add Dicount Model -->
    <div class="modal fade" id="discount-modal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="discountModalLabel">Add Discount</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="discount-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <script>
        $(document).ready(function() {
            $('#is_recurring').on('change', function() {
                if (this.checked) {
                    $('#recurringOptions').slideDown();
                } else {
                    $('#recurringOptions').slideUp();
                }
            });

            $('#frequency').on('change', function() {
                const value = $(this).val();

                $('#monthlyDay').hide();
                $('#weeklyDay').hide();
                $('#yearlySection').hide();

                if (value === 'monthly') {
                    $('#monthlyDay').fadeIn();
                } else if (value === 'weekly') {
                    $('#weeklyDay').fadeIn();
                } else if (value === 'yearly') {
                    $('#yearlySection').fadeIn();
                }
            });

            // Load initial state (edit mode)
            if ($('#is_recurring').is(':checked')) {
                $('#recurringOptions').show();
                $('#frequency').trigger('change');
            }
        });
    </script>

   



    <script>
        $(document).ready(function() {

            $('#template_id, #currency_code').select2({
                placeholder: "Please select",
                allowClear: true
            });


        });
    </script>


    <script>
        // Keep CKEditor instances here
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {
            const ids = ['notes'];

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

            $('#update-expense').on('click', function(e) {
                e.preventDefault();
                // 🛠️ Update textarea values before creating FormData
                Object.keys(editors).forEach(id => {
                    const data = editors[id].getData();
                    document.getElementById(id).value = data;
                });

                let formData = new FormData(document.getElementById('expense-generate'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your expense.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('expense.update') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('.error').remove();
                        $('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.error == 1) {
                            $.each(response.errors, function(field, messages) {
                                let inputField = $('[name="' + field + '"]');
                                if (inputField.length > 0) {
                                    inputField.addClass("is-invalid");

                                    if (inputField.closest('.input-group').length > 0) {
                                        inputField.closest('.input-group').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else if (inputField.hasClass('select2-hidden-accessible')) {
                                        inputField.next('.select2-container').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else {
                                        inputField.after('<div class="text-danger error">' + messages[0] + '</div>');
                                    }
                                }
                            });

                            Swal.fire({
                                icon: "warning",
                                title: "Warning!",
                                text: "Please check the form carefully!",
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                timer: 3000
                            });





                        } else if (response.error == 0) {
                            $('#expense-download').show();
                            $('#expense-download').attr('href', response.download_url);

                            Swal.fire({
                                icon: "success",
                                title: "Expense Updated Successfully. You Can Download!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('expense.list') }}";
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
        flatpickr("#expense_date", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format: 2025-04-17 14:00
            time_24hr: true
        });
    </script>




    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const discountOptions = `{!! collect($data['discounts'])->map(function($d) {
        return "<option value='" . $d->percent . "' discount-id='" . $d->discount_id . "'  >" . e($d->name) . " (" . $d->percent . "%)</option>";
    })->prepend("<option value='0'>No Discount</option>")->implode('') !!}`;
    </script>

    <script>
        const taxOptions = `{!! collect($data['taxes'])->map(function($t) {
        return "<option value='" . $t->percent . "' tax-id='" . $t->tax_id . "' >" . e($t->name) . " (" . $t->percent . "%)</option>";
    })->prepend("<option value='0'>No Tax</option>")->implode('') !!}`;
    </script>


    <script>
        const currencies = @json($data['currencies']);
        const currencySymbols = Object.fromEntries(
            currencies.map(cur => [cur.currency_code, cur.currency_symbol])
        );


        var itemCount = "{{ $itemCount }}";
        let currencySymbol = '$'; // Default currency

        $(document).ready(function() {
            $(document).on("change", '#currency_code', function(e) {
                let symbol = currencySymbols[this.value] || '$';
                currencySymbol = symbol;
                calculateexpense();
            });
            let symbol = currencySymbols[$('#currency_code').val()] || '$';
            currencySymbol = symbol;
            calculateexpense();


        });



        function addItemRow() {
            itemCount++;
            const formContainer = document.getElementById('form-container');

            const itemRow = document.createElement('div');
            itemRow.classList.add('row', 'g-3', 'p-3', 'border', 'rounded', 'shadow-sm', 'bg-light', 'align-items-start', 'mb-3', 'mt-3', 'position-relative');
            itemRow.setAttribute('data-item-id', itemCount);

            itemRow.innerHTML = `
      <div class="row w-100 g-2">
       
      
      
       <div class="col-12 col-md-6">
          <input type="text" name="item[${itemCount}][name]" placeholder="Item Name & Description" class="form-control form-control-sm add-items" id="item-${itemCount}" item-id="${itemCount}" >
            <div id="item-list-${itemCount}" class="list-group" style="position: absolute; z-index: 1000;"></div>
        </div>

         <div class="col-4 col-md-2">
          <input type="text" name="item[${itemCount}][hsn]" placeholder="HSN/SAC" oninput="calculateexpense()" class="form-control form-control-sm hsn">
        </div>

        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][quantity]" placeholder="Quantity" oninput="calculateexpense()" class="form-control form-control-sm quantity">
        </div>
        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][rate]" placeholder="Rate" oninput="calculateexpense()" class="form-control form-control-sm rate">
        </div>


      </div>
      <div class="row w-100 g-2 mt-1 align-items-end">
          <div class="col-12 col-md-4">
        <div class="input-group input-group-sm w-100">
          <select name="item[${itemCount}][discount]" class="form-select discount-select flex-grow-1" onchange="calculateexpense()">
            ${discountOptions}
          </select>
          <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
        </div>
      </div>
        <div class="col-12 col-md-4">
        
<div class="input-group input-group-sm w-100">
    <select name="item[${itemCount}][tax]" class="form-select tax-select flex-grow-1" onchange="calculateexpense()">
        ${taxOptions}
    </select>
    <span class="input-group-text tax-amount">+${currencySymbol}0.00</span>
</div>
        </div>
        <div class="col-6 col-md-4">
          <input type="text" name="item[${itemCount}][amount]" placeholder="Amount" class="form-control form-control-sm amount" readonly>
        </div>
      </div>
      <div class="col-12">
        <button type="button" class="btn btn-outline btn-sm btn-outline-danger w-100" onclick="removeRow(this)"><i data-lucide="minus"></i> Remove</button>
      </div>
    `;

            formContainer.appendChild(itemRow);
            lucide.createIcons();
        }

        function calculateexpense() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalTax = 0;

            const items = document.querySelectorAll('[data-item-id]');
            items.forEach((item) => {
                const quantity = parseFloat(item.querySelector('.quantity').value || 0);
                const rate = parseFloat(item.querySelector('.rate').value || 0);
                const discountPercent = parseFloat(item.querySelector('.discount-select').value || 0);
                const taxPercent = parseFloat(item.querySelector('.tax-select').value || 0);

                const base = quantity * rate;
                const discount = (discountPercent / 100) * base;
                const tax = (taxPercent / 100) * (base - discount);
                const amount = base - discount + tax;

                // Update discount and tax amount spans
                const discountSpan = item.querySelector('.discount-amount');
                const taxSpan = item.querySelector('.tax-amount');
                if (discountSpan) discountSpan.innerText = `−${currencySymbol}${discount.toFixed(2)}`;
                if (taxSpan) taxSpan.innerText = `${currencySymbol}${tax.toFixed(2)}`;

                // Update each item's amount
                item.querySelector('.amount').value = `${currencySymbol}${amount.toFixed(2)}`;

                // Add to totals
                subtotal += base;
                totalDiscount += discount;
                totalTax += tax;
            });

            // Update summary
            document.getElementById('subtotal').innerText = `${currencySymbol}${subtotal.toFixed(2)}`;
            document.getElementById('total-discount').innerText = `−${currencySymbol}${totalDiscount.toFixed(2)}`;
            document.getElementById('total-tax').innerText = `${currencySymbol}${totalTax.toFixed(2)}`;
            const grandTotal = subtotal - totalDiscount + totalTax;
            document.getElementById('grand-total').innerText = `${currencySymbol}${grandTotal.toFixed(2)}`;

            // Advance payment & balance

            const remainingBalance = grandTotal;



            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));
            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));

            $("#hidden_total_due").val(remainingBalance.toFixed(2));


        }

        function removeRow(button) {
            const itemBlock = button.closest('[data-item-id]');
            if (itemBlock) itemBlock.remove();
            calculateexpense();
        }
    </script>


    <script>
        function validateInputNumber(input) {
            if (input.value < 0) {
                input.value = 0;
            }
        }
    </script>





    <script>
        $(document).on('keyup', '.add-items', function() {


            let query = $(this).val();
            const row_id = $(this).attr('item-id');


            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('item.search') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        // $('#item-list-' + row_id).fadeIn();
                        $('#item-list-' + row_id).fadeIn().html(data);
                    }
                });
            } else {
                $('#item-list-' + row_id).fadeOut();
            }


            // Delegate click to any .select-item, but compute row_id inside the handler:
            $(document).on('click', '.select-item', function(e) {
                e.preventDefault();

                // a) Find the parent .list-group to figure out which row to update:
                const $listDiv = $(this).closest('.list-group');
                const listDivId = $listDiv.attr('id'); // e.g. "item-list-3"
                const rowIdx = listDivId.replace('item-list-', ''); // "3"

                // b) Grab all data attributes from the clicked <a>:
                const dbItemId = $(this).data('item_id'); // actual DB ID
                const itemName = $(this).data('item_name'); // item name text
                const hsnVal = $(this).data('hsn_sac'); // HSN/SAC
                const rateVal = $(this).data('unit_price'); // unit price
                const taxIdVal = $(this).data('tax_id'); // tax ID
                const discountIdVal = $(this).data('discount_id');

                console.log(taxIdVal)

                // c) Set the input value (the <input id="item-3">) to the product name:
                $(`#item-${rowIdx}`).val(itemName);

                // d) Hide & clear that dropdown:
                $listDiv.fadeOut().empty();

                // e) Find the entire row container (<div data-item-id="3">) so we can fill HSN, rate, tax:
                const $row = $(`#item-${rowIdx}`).closest('[data-item-id]');

                // f) Auto-fill HSN, Rate, and set the correct tax-select
                $row.find('.hsn').val(hsnVal);
                $row.find('.quantity').val(1);
                $row.find('.rate').val(rateVal).trigger('input');

                $row.find('.tax-select option[tax-id="' + taxIdVal + '"]').prop('selected', true);
                $row.find('.tax-select').trigger('change');

                $row.find('.discount-select option[discount-id="' + discountIdVal + '"]').prop('selected', true);
                $row.find('.discount-select').trigger('change');



                // g) (Optional) If you need to submit the actual DB item_id to the server,
                //    either create a hidden <input> or reuse an existing one:
                if ($(`#hidden-item-id-${rowIdx}`).length === 0) {
                    // Insert a hidden field if it doesn’t exist yet:
                    $(`<input type="hidden"
                  name="item[${rowIdx}][item_id]"
                  id="hidden-item-id-${rowIdx}"
                  value="${dbItemId}">`)
                        .appendTo($row);
                } else {
                    $(`#hidden-item-id-${rowIdx}`).val(dbItemId);
                }

                // h) Recompute expense totals:
                calculateexpense();
            });


            $(document).click(function(e) {
                if (!$(e.target).closest('#item-list-' + row_id).length) {
                    $('#item-list-' + row_id).fadeOut();
                }
            });

        });
    </script>



    <script>
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
        $(document).on("change", ".discount-select", function() {
            let selectedVal = $(this).val();

            if (selectedVal === "new") {
                // Reset back to default (No Discount)
                $(this).val("0");
                // Open your modal
                $('.editDiscount-modal-body').empty();
                try {
                    $.ajax({
                        url: "{{ route('discount.add') }}",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $('.discount-modal-body').html(response);
                            $('#discount-modal').modal('show');

                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                }


            } else {
                // Call your calculation if needed
                calculateInvoice();
            }
        });


        $(document).on("change", ".tax-select", function() {
            let selectedVal = $(this).val();

            if (selectedVal === "new") {
                // Reset back to default (No Discount)
                $(this).val("0");
                // Open your modal
                $('.edittax-modal-body').empty();
                try {
                    $.ajax({
                        url: "{{ route('tax.add') }}",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $('.tax-modal-body').html(response);
                            $('#tax-modal').modal('show');

                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                }


            } else {
                // Call your calculation if needed
                calculateInvoice();
            }
        });

        $(document).on('click', '.new-client', function(e) {
            e.preventDefault();


            // $('#view-modal').modal('show');

            var client_id = 0;

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('client.add') }}",
                    data: {
                        client_id: client_id
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Destroy any existing CKEditor instances before loading new HTML
                        for (let id in editors) {
                            if (editors[id]) {
                                editors[id].destroy().catch(() => {});
                                editors[id] = null;
                            }
                        }
                    },
                    success: function(response) {

                        $('.client-modal-body').html(response);
                        $('#client-modal').modal('show');

                        $('#client-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)
                            ['#id_country_id', '#id_state_id', '#id_currency_code'].forEach(function(selector) {
                                new Choices(selector, {
                                    searchEnabled: true,
                                    itemSelectText: '',
                                });
                            });
                        });


                        // Initialize CKEditor (destroy old if exists)

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


                    }
                });

            } catch (error) {
                console.error('Error:', error);
            }


        });
    </script>
    
</x-default-layout>