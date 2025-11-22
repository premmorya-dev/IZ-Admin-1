<x-default-layout>

 @if( !empty($data['registration']) && $data['registration'] == 'success')
<script>
gtag('event', 'user_registered_create_invoice_page');
</script>

 @endif
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">


    <style>
        #invoice_number {
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

    <h2 class="py-3">Add Invoices</h2>


    <form action="#" id="invoice-generate" method="POST">
        @csrf


        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>

            @include('pages/invoice/actions.create_invoice_action')
        </div>


        <div class="row">

            <div class="col-md-3 mt-3 text-md-start text-center" id="company-logo-section">
                <img src="{{ asset($data['setting']->logo_path) }}" style="height: 80px;">
            </div>

            <!-- Invoice Number with Mode -->
            <div class="col-md-3 mt-3">
                <label for="invoice_number" class="form-label d-flex justify-content-between align-items-center text-danger">
                    <span>Invoice Number *</span>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="invoiceModeSwitch" onchange="toggleInvoiceMode(this)">
                        <label class="form-check-label small" for="invoiceModeSwitch">Custom</label>
                    </div>
                </label>
                <input type="text" class="form-control form-control-sm" id="invoice_number" name="invoice_number" placeholder="Auto-generated" readonly>
            </div>



            <!-- Currency -->
            <div class="col-md-3 mt-3">
                <label for="currency" class="form-label text-danger">Select Currency *</label>
                <select name="currency_code" id="currency_code" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['currencies'] as $currency)
                    <option value="{{ $currency->currency_code }}" {{ old('currency_code', setting('default_currency') ) == $currency->currency_code ? 'selected' : '' }}>
                        {{ $currency->currency_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Language -->
            <div class="col-md-3 mt-3" id="template-section">
                <label for="template" class="form-label text-danger">Template *</label>
                <select class="form-select" id="template_id" name="template_id">
                    <option value="">Please Select</option>
                    @foreach($data['templates'] as $template )
                    <option value="{{ $template->template_id }}" {{ old('template_id', setting('default_template_id') ) == $template->template_id ? 'selected' : '' }}>{{ $template->template_name }}</option>
                    @endforeach
                </select>
            </div>


            <!-- From Address Section -->
            <div class="mt-2 col-md-6">
                <div class="mt-8 ">
                    <div class="mb-1 mt-2 d-flex justify-content-between">
                        <h4 class="mb-1">From </h4>
                        <input type="hidden" name="user_state_id" id="user_state_id" value="{{ setting('state_id') }}">
                        <a href="{{ route('settings.edit') }}" target="__blank" style="text-decoration: none;"> ✏️ Edit Business Profile </a>
                    </div>

                    <div>
                        @if( !empty($data['setting']->company_name) )
                        {{ $data['setting']->company_name }} <br>
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
                        <h4 class="mb-1 text-danger">To *</h4>
                        <a href="{{ route('client.add') }}"  onclick="gtag('event', 'add_client');" target="__blank" class="clientActionBtn new-client" id="new-client-btn" style="text-decoration: none;display:none;">✏️ New Client</a>
                        <a href="#" onclick="event.preventDefault()" class="clientActionBtn change-client" style="text-decoration: none;">✏️ Change Client</a>

                    </div>

                    <div id="clientSearchBox">
                        <input type="text" class="form-control " id="client" name="client_name" placeholder="Type client name, email, contact number to search client" autocomplete="off">
                        <input type="hidden" name="client_id" id="client_id">
                        <input type="hidden" name="client_state_id" id="client_state_id">
                        <!-- Dropdown results -->
                        <div id="clientList" class="list-group w-100 z-3 shadow-sm" style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    </div>

                    <!-- Display client address here -->
                    <div id="clientAddress" class="mt-3 border p-3 rounded bg-light position-relative" style="display: none;"></div>
                </div>




            </div>


            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="display_shipping_status" name="display_shipping_status"
                                {{ old('display_shipping_status',setting('shipping_status')) == 'Y' ? 'checked' : '' }}>

                            <label class="form-check-label" for="display_shipping_status">Show Shipping</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <!-- Recurring switch -->
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring">
                                <label class="form-check-label" for="is_recurring">Enable Recurring Invoice</label>
                            </div>


                        </div>
                    </div>

                    <!-- Recurring options wrapper -->
                    <div id="recurringOptions" style="display: none;">
                        <!-- Frequency -->
                        <div class="mt-3">
                            <label for="frequency" class="form-label">Frequency</label>
                            <select name="frequency" id="frequency" class="form-select">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>

                        <!-- Monthly Day -->
                        <div class="mt-3" id="monthlyDay">
                            <label for="day_of_month" class="form-label">Day of Month (1–31)</label>
                            <select name="day_of_month" class="form-select">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>

                        <!-- Weekly Day -->
                        <div class="mt-3" id="weeklyDay" style="display: none;">
                            <label for="day_of_week" class="form-label">Day of Week</label>
                            <select name="day_of_week" class="form-select">

                                @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $day)
                                <option value="{{ $day }}">{{ ucfirst($day) }}</option>
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
                                    <option value="{{ $num }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Day -->
                            <div class="mt-3">
                                <label for="yearly_day_of_month" class="form-label">Day of Month</label>
                                <select name="yearly_day_of_month" class="form-select">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Time Picker -->
                        <div class="mt-3">
                            <label for="time_of_day" class="form-label">Time to Generate</label>
                            <input type="time" name="time_of_day" class="form-control" value="09:00">
                        </div>
                    </div>
                </div>



                <div class="mt-3">
                    <label for="invoice_date" class="form-label text-danger">Invoice Date *</label>

                    <div class="input-group">
                        <input type="text" id="invoice_date" class="form-control" name="invoice_date" placeholder="Select Invoice Issue Date">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="due_date" class="form-label text-danger">Invoice Due *</label>
                    <div class="input-group">
                        <input type="text" id="due_date" class="form-control" name="due_date" placeholder="Select Invoice Due Date">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>




                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="upi_id_payment_status" id="useUpiToggle">
                    <label class="form-check-label" for="useUpiToggle">Use UPI ID for Payment</label>
                </div>

                <!-- UPI Dropdown (Hidden by default) -->
                <div id="upiDropdownWrapper" class="mt-3" style="display: none;">
                    <label for="upi_id" class="form-label">Select UPI</label>
                    <select id="upi_id" name="upi_id" class="form-select">
                        <option value="">Please Select</option>
                        @foreach($data['upi_payment_id'] as $upi_payment)
                        <option value="{{ $upi_payment->upi_log_id }}" {{ old('upi_id', setting('default_upi_id') ) == $upi_payment->upi_log_id ? 'selected' : '' }}>
                            Name: {{ $upi_payment->upi_name }} | Id: {{ $upi_payment->upi_id }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>



            <!-- test -->
            <div class="container my-4">
                <h4 class="mb-3 text-danger">Invoice Item Entry *</h4>



                <div id="form-container"></div>

                <button type="button" id="add-item-btn" class="btn btn-outline btn-sm  btn-outline-primary w-100" onclick="addItemRow()"><i data-lucide="plus"></i> Add Item</button>

                <!-- Invoice Summary Section -->
                <div class="summary-box mt-5">
                    <h5>Invoice Summary</h5>
                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Subtotal:</div>
                        <div class="col-4 col-md-5 text-end" id="subtotal">−$0.00</div>
                    </div>

                    <div class="row">
                        <div class="col-8 col-md-7 col-label">Total Discount:</div>
                        <div class="col-4 col-md-5 text-end" id="total-discount">−$0.00</div>
                    </div>

                    <div class="row same-state-class">
                        <div class="col-8 col-md-7 col-label">Total CGST:</div>
                        <div class="col-4 col-md-5 text-end" id="total-cgst">$0.00</div>
                    </div>

                    <div class="row same-state-class">
                        <div class="col-8 col-md-7 col-label">Total SGST:</div>
                        <div class="col-4 col-md-5 text-end" id="total-sgst">$0.00</div>
                    </div>

                    <div class="row diffrent-state-class">
                        <div class="col-8 col-md-7 col-label">Total IGST:</div>
                        <div class="col-4 col-md-5 text-end" id="total-igst">$0.00</div>
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

                <input type="hidden" name="hidden_total_taxable" value="" id="hidden_total_taxable">
                <input type="hidden" name="hidden_total_cgst" value="" id="hidden_total_cgst">
                <input type="hidden" name="hidden_total_sgst" value="" id="hidden_total_sgst">
                <input type="hidden" name="hidden_total_igst" value="" id="hidden_total_igst">

                <input type="hidden" name="hidden_total_tax" value="" id="hidden_total_tax">
                <input type="hidden" name="hidden_grand_total" value="" id="hidden_grand_total">
                <input type="hidden" name="hidden_round_off" value="" id="hidden_round_off">
                <input type="hidden" name="hidden_total_due" value="" id="hidden_total_due">


            </div>
            <!-- test -->


            <div class="col-md-12 mt-3">
                <div class="col-12" id="terms-section">
                    <label for="terms" class="form-label fw-semibold">Terms and Conditions:</label>
                    <textarea name="terms" id="id_invoice_terms" class="form-control" placeholder="Enter Terms">{{ old('notes', setting('terms') ) }}</textarea>
                </div>

                <div class="col-12" id="notes-section">
                    <label for="notes" class="form-label fw-semibold">Notes:</label>
                    <textarea name="notes" id="id_invoice_notes" class="form-control " placeholder="Enter Notes">{{ old('notes', setting('notes') ) }}</textarea>
                </div>


            </div>





        </div>

        <!-- Submit Button -->

        <!-- Invoice Mode Modal -->
        <div class="modal fade" id="invoiceModeModal" tabindex="-1" aria-labelledby="invoiceModeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Invoice Mode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="invoice_mode" id="auto_mode" value="auto" checked>
                            <label class="form-check-label" for="auto_mode">Auto</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="invoice_mode" id="custom_mode" value="custom">
                            <label class="form-check-label" for="custom_mode">Custom</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>



    <!-- Add Client Model -->
    <div class="modal fade" id="client-modal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="clientModalLabel">Add Client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="client-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Model -->
    <div class="modal fade" id="editClient-modal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editClientModalLabel">Edit Client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editClient-modal-body py-3 px-3">

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



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

    <script>
        var onboarding_status = "{{ setting('invoice_onboarding') }}";
        document.addEventListener("DOMContentLoaded", function() {

            if (onboarding_status == 'N') {
                Swal.fire({
                    title: "Welcome to InvoiceZy!",
                    text: "We will guide you step-by-step to create your first invoice. This will take less than 20 seconds.",
                    icon: "info",
                    confirmButtonText: "Start Guide",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    startInvoiceOnboarding();
                });
            }




        });


        function startInvoiceOnboarding() {
            introJs().setOptions({
                steps: [{
                        element: '#company-logo-section',
                        intro: 'This is your company logo, which appears on all invoices. You can update it anytime from: Menu → Business Settings → Business Info → Company Logo.'
                    },
                    {
                        element: '#new-client-btn',
                        intro: 'Click here to add a new client. This helps you quickly create invoices for first-time customers.'
                    },
                    {
                        element: '#client',
                        intro: 'Start by selecting an existing client. Simply type the name, email, or mobile number to search.You can see all customer from: Menu → Client.'
                    },
                    {
                        element: '#add-item-btn',
                        intro: 'Add your first invoice item here — including product name, quantity, price, and taxes.'
                    },
                    {
                        element: '#invoice_date',
                        intro: 'Choose the invoice issue date. This is the date when the invoice becomes active.'
                    },
                    {
                        element: '#due_date',
                        intro: 'Select the payment due date. This helps your client know the last day to pay.'
                    },
                    {
                        element: '#invoiceModeSwitch',
                        intro: 'Switch to Custom Mode if you want to enter your own invoice number manually.'
                    },
                    {
                        element: '#template-section',
                        intro: 'Choose an invoice template. Pick the one that best matches your branding and business style.'
                    },
                    {
                        element: '#useUpiToggle',
                        intro: 'Enable this to show your UPI ID and QR Code on the invoice. Add or manage UPI IDs from the left menu’s UPI section.'
                    },
                    {
                        element: '#terms-section',
                        intro: 'Here you can review or update the Terms & Conditions for this invoice. When client-specific terms are not provided, Invoicezy automatically applies your default business Terms & Conditions.'
                    },
                    {
                        element: '#notes-section',
                        intro: 'Here you can review or update the Notes for this invoice. When client-specific notes are not provided, Invoicezy automatically applies your default business Notes.'
                    },
                    {
                        element: '#action-btn',
                        intro: 'Once everything is set, click here to save the invoice or send it directly to your client.'
                    }
                ],

                showProgress: true,
                exitOnOverlayClick: false,
                highlightClass: 'intro-highlight'
            }).oncomplete(function() {
                updateOnboardingStatus();
            }).start();
        }

        function updateOnboardingStatus() {
            $.ajax({
                url: "{{ route('settings.user.onboarding') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    onboarding_update: "invoice_onboarding"
                },
                success: function(response) {
                    console.log("Onboarding status updated in DB");
                }
            });
        }
    </script>


    <script>
        $(document).on('click', '.edit-client', function(e) {
            e.preventDefault();
            $('.client-modal-body').empty();
            $('.editClient-modal-body').empty();

            var client_code = $(this).attr('client-code');

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('client.edit') }}",
                    data: {
                        client_code: client_code
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                        $('.editClient-modal-body').html(response);
                        $('#editClient-modal').modal('show');

                        $('#editClient-modal').on('shown.bs.modal', function() {
                            // Initialize Choices.js (always safe to re-init)

                            ['#id_country_id', '#id_state_id', '#id_currency_code', '#id_shipping_state_id', '#id_shipping_country_id'].forEach(function(selector) {
                                const el = document.querySelector(selector);
                                if (!el) return; // skip if element not found

                                if (!el.choices) {
                                    // Only initialize if not already done
                                    el.choices = new Choices(el, {
                                        searchEnabled: true,
                                        itemSelectText: '',
                                        shouldSort: false
                                    });
                                }
                            });


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



                        });





                    }
                });

            } catch (error) {
                console.error('Error:', error);
            }


        });
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
            var client_id = 0;

            try {

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

                        $('.client-modal-body #id_notes').summernote({
                            placeholder: 'Enter notes...',
                            height: 120,
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['link']],
                                ['view', ['codeview']]
                            ]
                        });


                        $('.client-modal-body #id_terms').summernote({
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
        function toggleInvoiceMode(elem) {
            const input = document.getElementById('invoice_number');
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
        $(document).ready(function() {

            function generateInvoiceNumber() {
                let prefix = "{{ setting('invoice_prefix') }}";
                let now = new Date();
                let formattedDate = now.getFullYear().toString() +
                    (now.getMonth() + 1).toString().padStart(2, '0') +
                    now.getDate().toString().padStart(2, '0') +
                    now.getHours().toString().padStart(2, '0') +
                    now.getMinutes().toString().padStart(2, '0');

                let uniqueId = Math.floor(Math.random() * 9000 + 1000); // Random 4-digit
                return `${prefix}-${formattedDate}-${uniqueId}`;
            }

            function updateInvoiceField() {
                const isCustom = $("#invoiceModeSwitch").is(":checked");

                if (isCustom) {
                    let prefix = "{{ setting('invoice_prefix') }}";
                    $("#invoice_number")
                        .val(prefix)
                        .prop("readonly", false)
                        .removeClass("bg-light")
                        .attr("placeholder", "Enter manually");
                } else {
                    let autoValue = generateInvoiceNumber();
                    $("#invoice_number")
                        .val(autoValue)
                        .prop("readonly", true)
                        .addClass("bg-light")
                        .attr("placeholder", "Auto-generated");
                }

                $("#invoice_number").fadeOut(200).fadeIn(400);
            }

            // When the switch is toggled
            $("#invoiceModeSwitch").change(function() {
                updateInvoiceField();
            });

            // On page load
            updateInvoiceField();
        });
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('useUpiToggle');
            const dropdown = document.getElementById('upiDropdownWrapper');

            function updateDropdownVisibility() {
                if (toggle.checked) {
                    dropdown.style.display = 'block';
                    dropdown.classList.add('animate__animated', 'animate__fadeIn');
                } else {
                    dropdown.style.display = 'none';
                    dropdown.classList.remove('animate__animated', 'animate__fadeIn');
                }
            }

            setTimeout(() => {
                updateDropdownVisibility();
            }, 500); // Delay by 300ms
            // Run on DOM load


            // Run on toggle change
            toggle.addEventListener('change', updateDropdownVisibility);
        });
    </script>



    <script>
        $(document).ready(function() {
            var upi = "{{ setting('upi_id_status') == 'Y'  ? 1 : 0 }}";

            if (upi == '1') {
                $('#useUpiToggle').prop('checked', true);
            }
            $('#template_id, #upi_id, #currency_code').select2({
                placeholder: "Please select",
                allowClear: true
            });


        });
    </script>


    <script>
        // Keep CKEditor instances here
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {

            $('.change-client').hide();
            $('.new-client').show();

            $('#id_invoice_notes').summernote({
                placeholder: 'Enter notes...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('#id_invoice_terms').summernote({
                placeholder: 'Enter terms...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('.id_description').summernote({
                placeholder: 'Enter Description...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });


            $('.save-invoice').on('click', function(e) {
                e.preventDefault();

                $('#send_status').val($(this).attr('send-status'))

                let formData = new FormData(document.getElementById('invoice-generate'));

                formData.append('notes', $('#id_invoice_notes').summernote('code'));
                formData.append('terms', $('#id_invoice_terms').summernote('code'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your invoice.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('invoice.store') }}",
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
                                    text: "Please enter the invoice items details!",
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
                            $('#invoice-download').show();
                            $('#invoice-download').attr('href', response.download_url);

                            Swal.fire({
                                icon: "success",
                                title: "Invoice Generated Successfully. You Can Download!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('invoice.list') }}";
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
            $('#client').on('keyup', function() {
                let query = $(this).val();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("client.search") }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#clientList').html('');
                            if (data.length > 0) {
                                $('#clientList').show();
                                $('#clientList').append(`<div class="p-2 rounded shadow-sm border" style="max-height:400px; overflow-y:auto; background-color:#f8f9fa;">`);
                                data.forEach(function(client) {
                                    $('#clientList').append(`
                <a href="javascript:void(0);" class="list-group-item list-group-item-action mb-2 rounded shadow-sm p-3 select-client"
                   data-id="${client.client_id}"
                     data-client_code="${client.client_code}"
                   data-company_name="${client.company_name ?? ''}"
                   data-client_name="${client.client_name ?? ''}"
                   data-address_1="${client.address_1 ?? ''}"
                   data-address_2="${client.address_2 ?? ''}"
                   data-city="${client.city ?? ''}"
                   data-state_name="${client.state_name ?? ''}"
                    data-state_id="${client.state_id ?? ''}"
                   data-country_name="${client.country_name ?? ''}"
                   data-currency_code="${client.currency_code ?? ''}"
                   data-notes="${client.notes ?? ''}"
                   data-terms="${client.terms ?? ''}"
                   data-zip="${client.zip ?? ''}"
                   data-email="${client.email ?? ''}"
                   data-phone="${client.phone ?? ''}"
                   style="cursor:pointer; transition: all 0.2s ease-in-out;">
                   
                   <div class="d-flex justify-content-between align-items-center">
                       <div>
                           <h6 class="mb-1 fw-bold text-primary">
                               <i class="bi bi-building me-1"></i> ${client.client_name ?? ''}
                           </h6>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-geo-alt me-1"></i> ${client.address_1 ?? ''}, ${client.city ?? ''}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-envelope me-1"></i> ${client.email ?? 'N/A'}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-telephone me-1"></i> ${client.phone ?? 'N/A'}
                           </p>
                       </div>
                       <span class="badge bg-success rounded-pill align-self-start">${client.currency_code ?? ''}</span>
                   </div>
                </a>
            `);
                                });
                                $('#clientList').append(`</div>`);
                            } else {
                                $('#clientList').hide();
                            }
                        }

                    });
                } else {
                    $('#clientList').hide();
                }
            });

            // Select client
            $(document).on('click', '#clientList a', function(e) {
                e.preventDefault();

                let client = $(this).data();
                let addressHTML = '';

                if (client.company_name) {
                    addressHTML += client.company_name + '<br>';
                } else {
                    addressHTML += client.client_name + '<br>';
                }
                if (client.address_1) addressHTML += client.address_1 + '<br>';
                if (client.address_2) addressHTML += client.address_2 + '<br>';
                if (client.state_name) addressHTML += client.state_name + ' ';
                if (client.country_name) addressHTML += client.country_name + ' ';
                if (client.zip) addressHTML += client.zip;

                $('#client').val(client.client_name);
                $('#client_id').val(client.id);
                $('#client_state_id').val(client.state_id);
                $('#clientList').hide();

                let edit_client = `<button client-code="${client.client_code}"  class="edit-client btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center 
                   position-absolute shadow" style="width: 36px; height: 36px; bottom: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editClientAddressModal">
        <i class="bi bi-pencil-fill"></i>
    </button>`;

                $('#clientAddress').html(addressHTML + edit_client).show();



                $('#currency_code').val(client.currency_code).trigger('change');


                if (client.notes && client.notes.replace(/<[^>]*>/g, '').trim() !== '') {
                    $('#id_invoice_notes').summernote('code', client.notes);
                }

                if (client.terms && client.terms.replace(/<[^>]*>/g, '').trim() !== '') {
                    $('#id_invoice_terms').summernote('code', client.terms);
                }
                $('#clientSearchBox').hide();
                $('.change-client').show();
                $('.new-client').hide();

            });

            // Change / Edit client
            $('.change-client').on('click', function(e) {
                $('#client').val('');
                $('#client_id').val('');
                $('#clientAddress').hide().html('');
                $('#clientList').hide();
                $('#clientSearchBox').show();
                $('.change-client').hide();
                $('.new-client').show();


            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#client, #clientList').length) {
                    $('#clientList').hide();
                }
            });
        });
    </script>



    <script>
        flatpickr("#invoice_date", {
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
        return "<option value='" . $d->percent . "' discount-id='" . $d->discount_id . "'>" . e($d->name) . " (" . $d->percent . "%)</option>";
    })
    ->prepend("<option value='0'>No Discount</option>")   // first option at top
    ->push("<option value='new'>➕ Add New Discount</option>") // last option at bottom
    ->implode('') !!}`;
    </script>


    <script>
        const taxOptions = `{!! collect($data['taxes'])->map(function($t) {
        return "<option value='" . $t->percent . "' tax-id='" . $t->tax_id . "'>" . e($t->name) . " (" . $t->percent . "%)</option>";
    })
    ->prepend("<option value='0'>No Tax</option>")   // Top option
    ->push("<option value='new'>➕ Add New Tax</option>") // Bottom option
    ->implode('') !!}`;
    </script>

    <script>
        const currencies = @json($data['currencies']);
        const currencySymbols = Object.fromEntries(
            currencies.map(cur => [cur.currency_code, cur.currency_symbol])
        );


        var itemCount = 0;
        let currencySymbol = '$'; // Default currency

        $(document).ready(function() {
            $(document).on("change", '#currency_code', function(e) {
                let symbol = currencySymbols[this.value] || '$';
                currencySymbol = symbol;
                calculateInvoice();
            });

            let symbol = currencySymbols[$('#currency_code').val()] || '$';
            currencySymbol = symbol;
            calculateInvoice();
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
  <div class="d-flex align-items-center">
    <input type="text" 
           name="item[${itemCount}][name]" 
           class="form-control form-control-sm add-items" 
           id="item-${itemCount}" 
           item-id="${itemCount}"
           autocomplete="off"
           placeholder="Search product or type manually">
    
    <!-- Tooltip ? icon -->
    <span class="ms-2" 
          data-bs-toggle="tooltip" 
          data-bs-placement="top" 
          title="Select from inventory to auto-fill details (price, tax, discount etc.) or type manually." 
          style="cursor: pointer;"> <i class="fas fa-question-circle text-primary"></i></span>
  </div>
  
  <div id="item-list-${itemCount}" class="list-group" style="position: absolute; z-index: 1000;"></div>
</div>

         <div class="col-4 col-md-2">
          <input type="text" name="item[${itemCount}][hsn]" placeholder="HSN/SAC" oninput="calculateInvoice()" class="form-control form-control-sm hsn">
        </div>

        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][quantity]" placeholder="Quantity" oninput="calculateInvoice()" class="form-control form-control-sm quantity">
        </div>
        <div class="col-4 col-md-2">
          <input type="number" name="item[${itemCount}][rate]" placeholder="Rate" oninput="calculateInvoice()" class="form-control form-control-sm rate">
        </div>
                           

      </div>
      <div class="row w-100 g-2 mt-1 align-items-end">
          <div class="col-12 col-md-4">
        <div class="input-group input-group-sm w-100">
          <select name="item[${itemCount}][discount]" class="form-select discount-select flex-grow-1" onchange="calculateInvoice()">
            ${discountOptions}
          </select>
          <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
        </div>
      </div>
        <div class="col-12 col-md-4">
        
<div class="input-group input-group-sm w-100">
    <select name="item[${itemCount}][tax]" class="form-select tax-select flex-grow-1" onchange="calculateInvoice()">
        ${taxOptions}
    </select>
    <span class="input-group-text tax-amount">+${currencySymbol}0.00</span>
</div>

        </div>
        <div class="col-6 col-md-4">
          <input type="text" name="item[${itemCount}][amount]" placeholder="Amount" class="form-control form-control-sm amount" readonly>
        </div>

          <div class="w-100 mt-2">
                                <textarea
                                        class="id_description"
                                        name="item[${itemCount}][description]"
                                        class="form-control form-control-sm"
                                        placeholder="Item Description"
                                        rows="2"></textarea>
                            </div>


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


        function calculateInvoice() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalTax = 0;

            let total_cgstAmount = 0;
            let total_sgstAmount = 0;
            let total_igstAmount = 0;
            let total_taxable = 0;

            const items = document.querySelectorAll('[data-item-id]');
            items.forEach((item) => {
                const quantity = parseFloat(item.querySelector('.quantity').value || 0);
                const rate = parseFloat(item.querySelector('.rate').value || 0);
                const discountPercent = parseFloat(item.querySelector('.discount-select').value || 0);
                const taxPercent = parseFloat(item.querySelector('.tax-select').value || 0);

                const base = quantity * rate;
                const discount = (discountPercent / 100) * base;
                const taxable = base - discount;

                let isSameState = $('#user_state_id').val() == $('#client_state_id').val();

                let cgstPercent = 0;
                let sgstPercent = 0;
                let igstPercent = 0;

                if (isSameState) {
                    $('.same-state-class').removeClass('d-none');
                    $('.diffrent-state-class').addClass('d-none');
                    // CGST + SGST
                    cgstPercent = taxPercent / 2;
                    sgstPercent = taxPercent / 2;
                    igstPercent = 0;
                } else {
                    $('.same-state-class').addClass('d-none');
                    $('.diffrent-state-class').removeClass('d-none');
                    // IGST only
                    cgstPercent = 0;
                    sgstPercent = 0;
                    igstPercent = taxPercent;
                }

                // Calculate GST amount
                let cgstAmount = (taxable * cgstPercent) / 100;
                let sgstAmount = (taxable * sgstPercent) / 100;
                let igstAmount = (taxable * igstPercent) / 100;


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

                total_taxable += taxable;
                total_cgstAmount += cgstAmount;
                total_sgstAmount += sgstAmount;
                total_igstAmount += igstAmount;

            });

            // Update summary
            document.getElementById('subtotal').innerText = `${currencySymbol}${subtotal.toFixed(2)}`;
            document.getElementById('total-discount').innerText = `−${currencySymbol}${totalDiscount.toFixed(2)}`;

            document.getElementById('total-cgst').innerText = `${currencySymbol}${total_cgstAmount.toFixed(2)}`;
            document.getElementById('total-sgst').innerText = `${currencySymbol}${total_sgstAmount.toFixed(2)}`;
            document.getElementById('total-igst').innerText = `${currencySymbol}${total_igstAmount.toFixed(2)}`;


            document.getElementById('total-tax').innerText = `${currencySymbol}${totalTax.toFixed(2)}`;
            const grandTotal = subtotal - totalDiscount + totalTax;
            document.getElementById('grand-total').innerText = `${currencySymbol}${grandTotal.toFixed(2)}`;

            let roundedTotal = Math.round(grandTotal);
            let roundOff = (roundedTotal - grandTotal).toFixed(2);
            document.getElementById('round-off').innerText = `${currencySymbol}${roundOff}`;


            // Advance payment & balance
            const remainingBalance = roundedTotal;
            document.getElementById('remaining-balance').innerText = `${currencySymbol}${remainingBalance.toFixed(2)}`;


            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));

            $("#hidden_total_taxable").val(total_taxable.toFixed(2));
            $("#hidden_total_cgst").val(total_cgstAmount.toFixed(2));
            $("#hidden_total_sgst").val(total_sgstAmount.toFixed(2));
            $("#hidden_total_igst").val(total_igstAmount.toFixed(2));

            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));
            $("#hidden_total_due").val(remainingBalance.toFixed(2));
            $("#hidden_round_off").val(roundOff);


        }

        function removeRow(button) {
            const itemBlock = button.closest('[data-item-id]');
            if (itemBlock) itemBlock.remove();
            calculateInvoice();
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
                const description = $(this).data('description');

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

                // h) Recompute invoice totals:
                calculateInvoice();
            });


            $(document).click(function(e) {
                if (!$(e.target).closest('#item-list-' + row_id).length) {
                    $('#item-list-' + row_id).fadeOut();
                }
            });

        });
    </script>





</x-default-layout>