<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <h2 class="py-3">Edit Invoices</h2>


    <form action="#" id="invoice-generate" method="POST">
        @csrf


        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>
            <div class="invoice-actions">
                <a href="#"
                    invoice-code="{{ $data['invoice']->invoice_code }}"
                    class="invoice-view-model action-btn"
                    title="Preview">
                    <i class="fa-regular fa-eye"></i>
                </a>

                <a href="{{ route('invoice.download',['invoice_code'=>$data['invoice']->invoice_code]) }}?preview=true"
                    target="_blank"
                    class="action-btn"
                    title="Print">
                    <i class="fa-solid fa-print"></i>
                </a>

                <a href="{{ route('invoice.download',['invoice_code'=>$data['invoice']->invoice_code]) }}"
                    class="action-btn"
                    title="Download">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>

            @include('pages/invoice/actions.update_invoice_action')
        </div>


        <div class="row">

            <x-invoice.header :data="$data" />

            <!-- From Address Section -->
            <x-invoice.address-section :setting="$data['setting']" />

            <div class="row g-4">

                <div class="col-lg-6 col-md-6">
                    <x-date
                        id="invoice_date"
                        name="invoice_date"
                        label="Invoice Date"
                        icon="calendar-event"
                        placeholder="Select invoice issue date"
                        value="{{ old('invoice_date', $data['invoice']->invoice_date) }}"
                        required />
                </div>

                <div class="col-lg-6 col-md-6">
                    <x-date
                        id="due_date"
                        name="due_date"
                        label="Due Date"
                        icon="calendar-check"
                        placeholder="Select invoice due date"
                        value="{{ old('due_date', $data['invoice']->due_date) }}"
                        required />
                </div>

            </div>

            <x-invoice.setting-switch :data="$data" />
            <x-invoice.recurring-invoice :data="$data" />

            <!-- UPI Dropdown (Hidden by default) -->
            <div id="upiDropdownWrapper" class="mt-3" style="display: none;">
                <label for="upi_id" class="form-label">Select UPI</label>
                <select id="upi_id" name="upi_id" class="form-select">
                    <option value="">Please Select</option>
                    @foreach($data['upi_payment_id'] as $upi_payment)
                    <option value="{{ $upi_payment->upi_id }}" {{ old('upi_id',$data['invoice']->upi_id) == $upi_payment->upi_id ? 'selected' : '' }}>
                        Name: {{ $upi_payment->upi_name }} | Id: {{ $upi_payment->upi_id }}
                    </option>
                    @endforeach
                </select>
            </div>


            <!-- test -->
            <div class="container my-4">
                <h4 class="mb-3 text-danger">Invoice Item Entry *</h4>



                <div id="form-container">
                    @php $itemCount = 0; @endphp
                    @if(!empty($data['items']))
                    @foreach($data['items'] as $itemCount => $item)
                    @php $itemCount++; @endphp
                    <div class="row bg-blue g-3 p-3 border rounded shadow-sm bg-light align-items-start mb-3 mt-3 position-relative" data-item-id="{{ $itemCount }}">
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
                                    oninput="calculateInvoice()">
                            </div>

                            <!-- Quantity -->
                            <div class="col-4 col-md-2">
                                <input type="number"
                                    name="item[{{ $itemCount }}][quantity]"
                                    value="{{ $item['quantity'] ?? '' }}"
                                    placeholder="Quantity"
                                    class="form-control form-control-sm quantity"
                                    oninput="calculateInvoice()">
                            </div>

                            <!-- Rate -->
                            <div class="col-4 col-md-2">
                                <input type="number"
                                    name="item[{{ $itemCount }}][rate]"
                                    value="{{ $item['rate'] ?? '' }}"
                                    placeholder="Rate"
                                    class="form-control form-control-sm rate"
                                    oninput="calculateInvoice()">
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
                        <div class="col-12">
                            <button
                                type="button"
                                class="remove-item-btn"
                                onclick="removeRow(this)"
                                title="Remove Item">

                                <i data-lucide="x"></i>

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>



                <x-invoice.add-item-button
                    id="add-item-btn"
                    text="Add Item"
                    onclick="addItemRow()" />

                <!-- Invoice Summary Section -->
                <x-invoice.summary />

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
                <input type="hidden" name="invoice_code" value="{{ $data['invoice']->invoice_code }}" id="invoice_code">


            </div>
            <!-- test -->

            <div class="row mt-3 gx-4">
                <div class="col-md-6 bg-blue" id="terms-section">
                    <label for="terms" class="form-label fw-semibold">Terms and Conditions:</label>
                    <textarea id="id_invoice_terms" name="terms" class="form-control" placeholder="Enter Terms">{{ old('terms', $data['invoice']->terms ) }}</textarea>
                </div>

                <div class="col-md-6 bg-blue" id="notes-section">
                    <label for="notes" class="form-label fw-semibold">Notes:</label>
                    <textarea id="id_invoice_notes" name="notes" class="form-control" placeholder="Enter Notes">{{ old('notes', $data['invoice']->notes ) }}</textarea>
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
                        View Invoice
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body" class="mb-5">

                </div>
            </div>
        </div>
    </div>


    <!-- Add Client Model -->
    <div class="modal fade" id="client-modal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="clientModalLabel">Edit Client</h4>
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
        $(document).on('click', '.record-payment-form', function(e) {
            e.preventDefault();
            $('#paymentModal').modal('show');
            var invoice_code = $(this).attr('invoice-code')

            try {

                $.ajax({
                    url: "{{ route('invoice.get_payment_form') }}",
                    data: {
                        invoice_code: invoice_code
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



        $(document).on('click', '.invoice-view-model', function(e) {
            e.preventDefault();
            $('#viewModal').modal('show');
            var invoice_code = $(this).attr('invoice-code')

            try {

                $.ajax({
                    url: "{{ route('invoice.view.model') }}",
                    data: {
                        invoice_code: invoice_code
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
        document.addEventListener('DOMContentLoaded', function() {
            var upi = "{{ empty($data['invoice']->upi_id) ? 0 : 1 }}";

            const upiDropdown = document.getElementById('upiDropdownWrapper');
            const upiToggle = document.getElementById('useUpiToggle');

            if (upi == '1') {
                $('#useUpiToggle').prop('checked', true); //
                upiDropdown.style.display = 'block';
            }

            upiToggle.addEventListener('change', function() {
                if (this.checked) {
                    upiDropdown.style.display = 'block';
                    upiDropdown.classList.add('animate__animated', 'animate__fadeIn');
                } else {
                    upiDropdown.style.display = 'none';
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {

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


            $('.update-invoice').on('click', function(e) {
                e.preventDefault();

                $('#send_status').val($(this).attr('send-status'))




                // 🛠️ Update textarea values before creating FormData
                Object.keys(editors).forEach(id => {
                    const data = editors[id].getData();
                    document.getElementById(id).value = data;
                });

                let formData = new FormData(document.getElementById('invoice-generate'));

                formData.append('notes', $('#id_invoice_notes').summernote('code'));
                formData.append('terms', $('#id_invoice_terms').summernote('code'));
                formData.append('paid_status', $(this).attr('paid-status'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your invoice.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('invoice.update') }}",
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

                            if (response.errors && response.errors.item && response.errors.item[0]) {
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
                                title: "Invoice Updated Successfully. You Can Download!",
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

            var address = `{!! $data['client_details_html'] !!}`;
            var client_id = `{{ $data['invoice']->client_id }}`;
            var client_state_id = `{{ $data['invoice']->state_id }}`;

            if (address) {
                $('#clientAddress').html(address).show();
                $('#clientSearchBox').hide();
                $('#clientActionBtn').attr('status', 'false')
                $('#clientActionBtn').text('✏️ Change Client').show();

                $('#client_id').val(client_id);
                $('#client_state_id').val(client_state_id);
            }


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
            itemRow.classList.add('row', 'bg-blue', 'g-3', 'p-3', 'border', 'rounded', 'shadow-sm', 'bg-light', 'align-items-start', 'mb-3', 'mt-3', 'position-relative');
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
             <option value="new">➕ Add New Discount</option>
          </select>
          <span class="input-group-text discount-amount">−${currencySymbol}0.00</span>
        </div>
      </div>
        <div class="col-12 col-md-4">
        
<div class="input-group input-group-sm w-100">
    <select name="item[${itemCount}][tax]" class="form-select tax-select flex-grow-1" onchange="calculateInvoice()">
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
        <button
    type="button"
    class="remove-item-btn"
    onclick="removeRow(this)"
    title="Remove Item">

    <i data-lucide="x"></i>
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