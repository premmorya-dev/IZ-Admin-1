<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">


    <style>
        #bill_number {
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

        #bill-generate .bill-view-model:hover {
            color: white !important;

        }
    </style>
    <h2 class="py-3">Add Bill</h2>


    <form action="#" id="bill-generate" method="POST">
        @csrf


        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('bill.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>
            @include('pages/bill/actions.create_bill_action')
        </div>


        <div class="row">

            <div class="col-md-3 mt-3 text-md-start text-center">
                <img src="{{ asset($data['setting']->logo_path) }}" style="height: 80px;">
            </div>       

              <!-- Invoice Number with Mode -->
            <div class="col-md-3 mt-3">
                <label for="bill_number" class="form-label d-flex justify-content-between align-items-center text-danger">
                    <span>Bill Number *</span>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="billModeSwitch" onchange="toggleBillMode(this)">
                        <label class="form-check-label small" for="billModeSwitch">Custom</label>
                    </div>
                </label>
                <input type="text" class="form-control form-control-sm" id="bill_number" name="bill_number" placeholder="Auto-generated" readonly>
            </div>




            <!-- Currency -->
            <div class="col-md-3 mt-3">
                <label for="currency" class="form-label text-danger">Select Currency *</label>
                <select name="currency_code" id="currency_code" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['currencies'] as $currency)
                    <option value="{{ $currency->currency_code }}" {{ old('currency_code', setting('default_currency')) == $currency->currency_code ? 'selected' : '' }}>
                        {{ $currency->currency_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Language -->
            <div class="col-md-3 mt-3">
                <label for="template" class="form-label text-danger">Template *</label>
                <select class="form-select" id="template_id" name="template_id">
                    <option value="">Please Select</option>
                    @foreach($data['templates'] as $template )
                    <option value="{{ $template->template_id }}" {{ old('template_id', setting('default_template_id')) == $template->template_id ? 'selected' : '' }}>{{ $template->template_name }}</option>
                    @endforeach
                </select>
            </div>


            <!-- From Address Section -->
            <div class="mt-2 col-md-6">
                <div class="mt-8 ">
                    <div class="mb-1 mt-2 d-flex justify-content-between">
                        <h4 class="mb-1">To </h4>
                        <a href="{{ route('settings.edit') }}" target="__blank" style="text-decoration: none;"> ✏️ Edit Business Profile </a>
                    </div>

                    <div>
                        @if( !empty($data['setting']->company_name) )
                        {{ $data['setting']->company_name }} <br>
                        @else
                        {{ $data['setting']->vendor_name }} <br>
                        @endif

                        @if( !empty($data['setting']->address_1) )
                        {{ $data['setting']->address_1 }} <br>
                        @endif

                        @if( !empty($data['setting']->address_2) )
                        {{ $data['setting']->address_2 }} <br>
                        @endif

                        @if( !empty($data['setting']->state->state_name ) )
                        {{ $data['setting']->state->state_name }}
                        @endif


                        @if( !empty($data['setting']->country->country_name ) )
                        {{ $data['setting']->country->country_name }}
                        @endif

                        @if( !empty($data['setting']->pincode) )
                        {{ $data['setting']->pincode }}
                        @endif
                    </div>
                </div>

                <!-- To Address Section -->
                <div>
                    <div class="mb-1 mt-4 d-flex justify-content-between align-items-center">
                        <h4 class="mb-1 text-danger">From *</h4>
                        <a href="{{ route('vendor.add') }}" target="__blank" class="vendorActionBtn new-vendor" style="text-decoration: none;display:none;">✏️ New vendor</a>
                        <a href="#" onclick="event.preventDefault()" class="vendorActionBtn change-vendor" style="text-decoration: none;">✏️ Change Vendor</a>

                    </div>

                    <div id="vendorSearchBox">
                        <input type="text" class="form-control " id="vendor" name="vendor_name" placeholder="Type vendor name, email, contact number to search vendor" autocomplete="off">
                        <input type="hidden" name="vendor_id" id="vendor_id">
                        <!-- Dropdown results -->
                        <div id="vendorList" class="list-group w-100 z-3 shadow-sm" style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    </div>

                    <!-- Display vendor address here -->
                    <div id="vendorAddress" class="mt-3 border p-2 rounded bg-light" style="display: none;"></div>
                </div>




            </div>


            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-6">
                        <div class="mt-3">
                            <!-- Recurring switch -->
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring"
                                    {{ old('is_recurring') == 'Y'  ? 'checked' : '' }}>

                                <label class="form-check-label" for="is_recurring">Enable Recurring Bill</label>
                            </div>


                        </div>
                    </div>

                    <!-- Recurring options wrapper -->
                    <div id="recurringOptions" style="display: none;">
                        <!-- Frequency -->
                        <div class="mt-3">
                            <label for="frequency" class="form-label">Frequency</label>
                            <select name="frequency" id="frequency" class="form-select">
                                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>

                        </div>

                        <!-- Monthly Day -->
                        <div class="mt-3" id="monthlyDay">
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
                        <div class="mt-3" id="weeklyDay" style="display: none;">
                            <label for="day_of_week" class="form-label">Day of Week</label>
                            <select name="day_of_week" class="form-select">
                                @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $day)
                                <option value="{{ $day }}"
                                    {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                    {{ ucfirst($day) }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Yearly Month + Day -->
                        <div id="yearlySection" style="display: none;">
                            <!-- Month -->
                            <div class="mt-3">
                                <label for="month_of_year" class="form-label">Month of Year</label>
                                <select name="month_of_year" class="form-select">
                                    @foreach([
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                    ] as $num => $month)
                                    <option value="{{ $num }}"
                                        {{ old('month_of_year') == $num ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <!-- Day -->
                            <div class="mt-3">
                                <label for="yearly_day_of_month" class="form-label">Day of Month</label>
                                <select name="yearly_day_of_month" class="form-select">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}"
                                        {{ old('yearly_day_of_month') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                        </option>
                                        @endfor
                                </select>

                            </div>
                        </div>

                        <!-- Time Picker -->
                        <div class="mt-3">
                            <label for="time_of_day" class="form-label">Time to Generate</label>
                            @php
                            $time = '09:00';
                            @endphp
                            <input type="time" name="time_of_day" class="form-control" value="{{ $time }}">

                        </div>
                    </div>
                </div>



                <div class="row mt-5">
                    <div class="col-md-6 mt-3">
                        <label for="bill_date" class="form-label text-danger">Bill Date *</label>

                        <div class="input-group">
                            <input type="text" id="bill_date" class="form-control" name="bill_date" value="{{ old('bill_date')  }}" placeholder="Select bill Issue Date">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="due_date" class="form-label text-danger">Bill Due *</label>
                        <div class="input-group">
                            <input type="text" id="due_date" class="form-control" name="due_date" value="{{ old('due_date')  }}" placeholder="Select bill Due Date">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>



                    <div class="col-md-6 mt-3">
                        <label for="supply_source_state_id" class="form-label text-danger">Source of Supply *</label>
                        <select name="supply_source_state_id" id="supply_source_state_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['states'] as $state)
                            <option value="{{ $state->state_id }}" {{ old('supply_source_state_id') == $state->state_id ? 'selected' : '' }}>
                                {{ $state->state_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="destination_source_state_id" class="form-label text-danger">Source of Destination *</label>
                        <select name="destination_source_state_id" id="destination_source_state_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($data['states'] as $state)
                            <option value="{{ $state->state_id }}" {{ old('destination_source_state_id') == $state->state_id ? 'selected' : '' }}>
                                {{ $state->state_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>




                </div>


            </div>






            <!-- test -->
            <div class="container my-4">
                <h4 class="mb-3 text-danger">Bill Item Entry *</h4>



                <div id="form-container">
                    @php $itemCount = 0; @endphp
                    @if(!empty($data['items']))
                    @foreach($data['items'] as $itemCount => $item)
                    @php $itemCount++; @endphp
                    <div class="row g-3 p-3 border rounded shadow-sm bg-light align-items-start mb-3 mt-3 position-relative" data-item-id="{{ $itemCount }}">
                        <div class="row w-100 g-2">

                            <!-- Item Name -->
                            <div class="col-12 col-md-6 position-relative">
                                <div id="item-list-{{ $itemCount }}" class="list-group" style="position: absolute; z-index: 1000;margin-top:35px;"></div>
                                <div class="d-flex align-items-center">
                                    <input type="text"
                                        name="item[{{ $itemCount }}][name]"
                                        value="{{ $item['name'] ?? '' }}"
                                        placeholder="Search product or type manually"
                                        class="form-control form-control-sm add-items"
                                        autocomplete="off"
                                        id="item-{{ $itemCount }}"
                                        item-id="{{ $itemCount }}">
                                    <span class="ms-2" title="Select from inventory or type manually." style="cursor: pointer;">
                                        <i class="fas fa-question-circle text-primary"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- HSN -->
                            <div class="col-4 col-md-2">
                                <input type="text"
                                    name="item[{{ $itemCount }}][hsn]"
                                    value="{{ $item['hsn'] ?? '' }}"
                                    placeholder="HSN/SAC"
                                    class="form-control form-control-sm hsn"
                                    oninput="calculatebill()">
                            </div>

                            <!-- Quantity -->
                            <div class="col-4 col-md-2">
                                <input type="number"
                                    name="item[{{ $itemCount }}][quantity]"
                                    value="{{ $item['quantity'] ?? '' }}"
                                    placeholder="Quantity"
                                    class="form-control form-control-sm quantity"
                                    oninput="calculatebill()">
                            </div>

                            <!-- Rate -->
                            <div class="col-4 col-md-2">
                                <input type="number"
                                    name="item[{{ $itemCount }}][rate]"
                                    value="{{ $item['rate'] ?? '' }}"
                                    placeholder="Rate"
                                    class="form-control form-control-sm rate"
                                    oninput="calculatebill()">
                            </div>


                        </div>



                        <div class="row w-100 g-2 mt-1 align-items-end">
                            <!-- Discount -->
                            <div class="col-12 col-md-4">
                                <div class="input-group input-group-sm w-100">
                                    <select name="item[{{ $itemCount }}][discount]" class="form-select discount-select flex-grow-1">
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

                            <!-- Tax -->
                            <div class="col-12 col-md-4">
                                <div class="input-group input-group-sm w-100">
                                    <select name="item[{{ $itemCount }}][tax]" class="form-select tax-select flex-grow-1">
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

                            <!-- Amount -->
                            <div class="col-6 col-md-4">
                                <input type="text" name="item[{{ $itemCount }}][amount]" value="{{ $item['amount'] }}" class="form-control form-control-sm amount" readonly>
                            </div>

                            <!-- Description (New Field) -->
                            <div class="w-100 mt-2">
                                <textarea
                                    class="id_description"
                                    name="item[{{ $itemCount }}][description]"
                                    class="form-control form-control-sm"
                                    placeholder="Item Description"
                                    rows="2">{{ $item['description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Remove Button -->
                        <div class="col-12 mt-2">
                            <button type="button" class="btn btn-outline btn-sm btn-outline-danger w-100" onclick="removeRow(this)">
                                <i data-lucide="minus"></i> Remove
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>



                <button type="button" class="btn btn-outline btn-sm  btn-outline-primary w-100" onclick="addItemRow()"><i data-lucide="plus"></i> Add Item</button>

                <!-- bill Summary Section -->
                <div class="summary-box mt-5">
                    <h5>Bill Summary</h5>
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

                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Round Off:</div>
                        <div class="col-4 col-md-5 text-end" id="round-off">$0.00</div>
                    </div>



                    <!-- Remaining Balance -->
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Remaining Balance:</div>
                        <div class="col-4 col-md-5 text-end" id="remaining-balance">$0.00</div>
                    </div>
                </div>




                <input type="hidden" name="hidden_sub_total" value="" id="hidden_sub_total">
                <input type="hidden" name="hidden_total_discount" value="" id="hidden_total_discount">
                <input type="hidden" name="hidden_total_tax" value="" id="hidden_total_tax">
                <input type="hidden" name="hidden_grand_total" value="" id="hidden_grand_total">
                <input type="hidden" name="hidden_advance_payment" value="" id="hidden_advance_payment">
                <input type="hidden" name="hidden_round_off" value="" id="hidden_round_off">
                <input type="hidden" name="hidden_total_due" value="" id="hidden_total_due">

          


            </div>
            <!-- test -->


            <div class="col-md-12 mt-5">


                <div class="col-12">
                    <label for="notes" class="form-label fw-semibold">Notes:</label>
                    <textarea id="id_bill_notes" name="notes" class="form-control" placeholder="Enter Notes">{{ old('notes' ) }}</textarea>
                </div>


            </div>





        </div>

        <!-- Submit Button -->




    </form>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-4 mb-3">
                    <h5 class="modal-title" id="viewModalLabel">
                        View Bill
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body">

                </div>
            </div>
        </div>
    </div>


    <!-- Add vendor Model -->
    <div class="modal fade" id="vendor-modal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vendorModalLabel">Edit Vendor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="vendor-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


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
    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title" id="paymentModalLabel">
                        Record Payment
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="payment-record-form-body">

                </div>
            </div>
        </div>
    </div>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        <script>
        $(document).ready(function() {

            function generateBillNumber() {
                let prefix = "{{ setting('bill_prefix') }}";
                let now = new Date();
                let formattedDate = now.getFullYear().toString() +
                    (now.getMonth() + 1).toString().padStart(2, '0') +
                    now.getDate().toString().padStart(2, '0') +
                    now.getHours().toString().padStart(2, '0') +
                    now.getMinutes().toString().padStart(2, '0');

                let uniqueId = Math.floor(Math.random() * 9000 + 1000); // Random 4-digit
                return `${prefix}-${formattedDate}-${uniqueId}`;
            }

            function updateBillField() {
                const isCustom = $("#billModeSwitch").is(":checked");

                if (isCustom) {
                    let prefix = "{{ setting('bill_prefix') }}";
                    $("#bill_number")
                        .val(prefix)
                        .prop("readonly", false)
                        .removeClass("bg-light")
                        .attr("placeholder", "Enter manually");
                } else {
                    let autoValue = generateBillNumber();
                    $("#bill_number")
                        .val(autoValue)
                        .prop("readonly", true)
                        .addClass("bg-light")
                        .attr("placeholder", "Auto-generated");
                }

                $("#bill_number").fadeOut(200).fadeIn(400);
            }

            // When the switch is toggled
            $("#billModeSwitch").change(function() {
                updateBillField();
            });

            // On page load
            updateBillField();
        });
    </script>


    <script>
        function toggleBillMode(elem) {
            const input = document.getElementById('bill_number');
            if (elem.checked) {
                input.removeAttribute('readonly');
                input.placeholder = "Enter manually";
                input.focus();
            } else {
                input.setAttribute('readonly', true);
                input.value = '';
                input.placeholder = "Auto-generated";
            }
        }
    </script>

    <script>
        $(document).on('click', '.record-payment-form', function(e) {
            e.preventDefault();
            $('#paymentModal').modal('show');
            var bill_code = $(this).attr('bill-code')

            try {

                $.ajax({
                    url: "{{ route('bill.get_payment_form') }}",
                    data: {
                        bill_code: bill_code
                    },
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
                    success: function(response) {
                        $('#payment-record-form-body').html(response);
                        $('#paymentModal').modal('show');
                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });



        $(document).on('click', '.bill-view-model', function(e) {
            e.preventDefault();
            $('#viewModal').modal('show');
            var bill_code = $(this).attr('bill-code')

            try {

                $.ajax({
                    url: "{{ route('bill.view.model') }}",
                    data: {
                        bill_code: bill_code
                    },
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
                    success: function(response) {
                        $('#view-record-form-body').html(response.html);
                        $('#viewModal').modal('show');
                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }
        });


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
                calculatebill();
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
                calculatebill();
            }
        });

        $(document).on('click', '.new-vendor', function(e) {
            e.preventDefault();


            // $('#view-modal').modal('show');

            var vendor_id = 0;

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('vendor.add') }}",
                    data: {
                        vendor_id: vendor_id
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

                        $('.vendor-modal-body').html(response);
                        $('#vendor-modal').modal('show');

                        $('#vendor-modal').on('shown.bs.modal', function() {
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

            $('#template_id, #upi_id, #currency_code,#supply_source_state_id,#destination_source_state_id').select2({
                placeholder: "Please select",
                allowClear: true
            });


        });
    </script>


    <script>
        // Keep CKEditor instances here
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {
          
            $('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });


            $('.save-bill').on('click', function(e) {
                e.preventDefault();           

                let formData = new FormData(document.getElementById('bill-generate'));          

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your bill.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('bill.store') }}",
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

                            if (response.errors.item[0]) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Please enter the bill items details!",
                                    toast: true,
                                    position: "center",
                                    confirmButtonText: "OK"

                                });
                            } else {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Warning!",
                                    text: "Please check the form carefully!",
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }









                        } else if (response.error == 0) {
                            $('#bill-download').show();
                            $('#bill-download').attr('href', response.download_url);

                            Swal.fire({
                                icon: "success",
                                title: "Bill Updated Successfully. You Can Download!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('bill.list') }}";
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

           

            $('#vendor').on('keyup', function() {
                let query = $(this).val();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("vendor.search") }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#vendorList').html('');
                            if (data.length > 0) {
                                $('#vendorList').show();
                                $('#vendorList').append(`<div class="p-2 rounded shadow-sm border" style="max-height:400px; overflow-y:auto; background-color:#f8f9fa;">`);
                                data.forEach(function(vendor) {
                                    $('#vendorList').append(`
                <a href="javascript:void(0);" class="list-group-item list-group-item-action mb-2 rounded shadow-sm p-3 select-vendor"
                   data-id="${vendor.vendor_id}"
                   data-company_name="${vendor.company_name ?? ''}"
                   data-vendor_name="${vendor.vendor_name ?? ''}"
                   data-address_1="${vendor.address_1 ?? ''}"
                   data-address_2="${vendor.address_2 ?? ''}"
                   data-city="${vendor.city ?? ''}"
                   data-state_name="${vendor.state_name ?? ''}"
                   data-country_name="${vendor.country_name ?? ''}"
                   data-currency_code="${vendor.currency_code ?? ''}"
                   data-notes="${vendor.notes ?? ''}"
                   data-terms="${vendor.terms ?? ''}"
                   data-zip="${vendor.zip ?? ''}"
                   data-email="${vendor.email ?? ''}"
                   data-phone="${vendor.phone ?? ''}"
                   style="cursor:pointer; transition: all 0.2s ease-in-out;">
                   
                   <div class="d-flex justify-content-between align-items-center">
                       <div>
                           <h6 class="mb-1 fw-bold text-primary">
                               <i class="bi bi-building me-1"></i> ${vendor.vendor_name ?? ''}
                           </h6>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-geo-alt me-1"></i> ${vendor.address_1 ?? ''}, ${vendor.city ?? ''}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-envelope me-1"></i> ${vendor.email ?? 'N/A'}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-telephone me-1"></i> ${vendor.phone ?? 'N/A'}
                           </p>
                       </div>
                       <span class="badge bg-success rounded-pill align-self-start">${vendor.currency_code ?? ''}</span>
                   </div>
                </a>
            `);
                                });
                                $('#vendorList').append(`</div>`);
                            } else {
                                $('#vendorList').hide();
                            }
                        }

                    });
                } else {
                    $('#vendorList').hide();
                }
            });

            // Select vendor
            $(document).on('click', '#vendorList a', function(e) {
                e.preventDefault();

                let vendor = $(this).data();
                let addressHTML = '';

                if (vendor.company_name) {
                    addressHTML += vendor.company_name + '<br>';
                } else {
                    addressHTML += vendor.vendor_name + '<br>';
                }
                if (vendor.address_1) addressHTML += vendor.address_1 + '<br>';
                if (vendor.address_2) addressHTML += vendor.address_2 + '<br>';
                if (vendor.state_name) addressHTML += vendor.state_name + ' ';
                if (vendor.country_name) addressHTML += vendor.country_name + ' ';
                if (vendor.zip) addressHTML += vendor.zip;

                $('#vendor').val(vendor.vendor_name);
                $('#vendor_id').val(vendor.id);
                $('#vendorList').hide();

                $('#vendorAddress').html(addressHTML).show();

                $('#currency_code').val(vendor.currency_code).trigger('change');
                if (vendor.notes) {
                    $('#id_bill_terms').summernote('code', vendor.notes);

                }
                if (vendor.terms) {
                    $('#id_bill_notes').summernote('code', vendor.terms);
                }
                $('#vendorSearchBox').hide();
                $('.change-vendor').show();
                $('.new-vendor').hide();

            });

            // Change / Edit vendor
            $('.change-vendor').on('click', function(e) {
                $('#vendor').val('');
                $('#vendor_id').val('');
                $('#vendorAddress').hide().html('');
                $('#vendorList').hide();
                $('#vendorSearchBox').show();
                $('.change-vendor').hide();
                $('.new-vendor').show();


            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#vendor, #vendorList').length) {
                    $('#vendorList').hide();
                }
            });
        });
    </script>

    <script>
        flatpickr("#bill_date", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format: 2025-04-17 14:00
            time_24hr: true
        });

        flatpickr("#due_date", {
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
                calculatebill();
            });

            let symbol = currencySymbols[$('#currency_code').val()] || '$';
            currencySymbol = symbol;
            calculatebill();
        });


        function addItemRow() {
            itemCount++;
            const formContainer = document.getElementById('form-container');

            const itemRow = document.createElement('div');
            itemRow.classList.add('row', 'g-3', 'p-3', 'border', 'rounded', 'shadow-sm', 'bg-light', 'align-items-start', 'mb-3', 'mt-3', 'position-relative');
            itemRow.setAttribute('data-item-id', itemCount);

            itemRow.innerHTML = `
      <div class="row w-100 g-2">
       
      
      
   <div class="col-12 col-md-6 position-relative">
     <div id="item-list-${itemCount}" class="list-group" style="position: absolute; z-index: 1000;margin-top:35px;"></div>
  <div class="d-flex align-items-center">
    <input type="text" 
           name="item[${itemCount}][name]" 
           class="form-control form-control-sm add-items" 
            autocomplete="off"
           id="item-${itemCount}" 
           item-id="${itemCount}"
           placeholder="Search product or type manually">
    
    <!-- Tooltip ? icon -->
    <span class="ms-2" 
          data-bs-toggle="tooltip" 
          data-bs-placement="top" 
          title="Select from inventory to auto-fill details (price, tax, discount etc. ) or type manually." 
          style="cursor: pointer;"> <i class="fas fa-question-circle text-primary"></i></span>
  </div>
  

</div>


         <div class="col-4 col-md-2">
          <input type="text" name="item[${itemCount}][hsn]" placeholder="HSN/SAC" oninput="calculatebill()" class="form-control form-control-sm hsn">
        </div>

        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][quantity]" placeholder="Quantity" oninput="calculatebill()" class="form-control form-control-sm quantity">
        </div>
        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][rate]" placeholder="Rate" oninput="calculatebill()" class="form-control form-control-sm rate">
        </div>
     

      </div>
      <div class="row w-100 g-2 mt-1 align-items-end">
          <div class="col-12 col-md-4">
        <div class="input-group input-group-sm w-100">
          <select name="item[${itemCount}][discount]" class="form-select discount-select flex-grow-1" onchange="calculatebill()">
            ${discountOptions}
             <option value="new">➕ Add New Discount</option>
          </select>
          <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
        </div>
      </div>
        <div class="col-12 col-md-4">
        
<div class="input-group input-group-sm w-100">
    <select name="item[${itemCount}][tax]" class="form-select tax-select flex-grow-1" onchange="calculatebill()">
        ${taxOptions}
         <option value="new">➕ Add New Tax</option>
    </select>
    <span class="input-group-text tax-amount">+${currencySymbol}0.00</span>
</div>
        </div>
        <div class="col-6 col-md-4">
          <input type="text" name="item[${itemCount}][amount]" placeholder="Amount" class="form-control form-control-sm amount" readonly>
        </div>
      </div>

         <div class="w-100 mt-2">
                                <textarea
                                        class="id_description"
                                        name="item[${itemCount}][description]"
                                        class="form-control form-control-sm"
                                        placeholder="Item Description"
                                        rows="2"></textarea>
                            </div>

      <div class="col-12">
        <button type="button" class="btn btn-outline btn-sm btn-outline-danger w-100" onclick="removeRow(this)"><i data-lucide="minus"></i> Remove</button>
      </div>
    `;

            formContainer.appendChild(itemRow);
            lucide.createIcons();
            $('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });
        }

        function calculatebill() {
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

            // Round to nearest rupee
            let roundedTotal = Math.round(grandTotal);



            // Calculate round-off difference
            let roundOff = (roundedTotal - grandTotal).toFixed(2);

            document.getElementById('round-off').innerText = `${currencySymbol}${roundOff}`;

            // Advance payment & balance
            const remainingBalance = roundedTotal;
            document.getElementById('remaining-balance').innerText = `${currencySymbol}${remainingBalance.toFixed(2)}`;


            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));
            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));
            $("#hidden_total_due").val(remainingBalance.toFixed(2));
            $("#hidden_round_off").val(roundOff);


        }

        function removeRow(button) {
            const itemBlock = button.closest('[data-item-id]');
            if (itemBlock) itemBlock.remove();
            calculatebill();
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
                const description = $(this).data('description'); // item name text
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
                $row.find('.id_description').summernote('code', description);
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

                // h) Recompute bill totals:
                calculatebill();
            });


            $(document).click(function(e) {
                if (!$(e.target).closest('#item-list-' + row_id).length) {
                    $('#item-list-' + row_id).fadeOut();
                }
            });

        });
    </script>






</x-default-layout>