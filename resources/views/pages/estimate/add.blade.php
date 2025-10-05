<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #estimate_number {
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

    <h2 class="py-3">Add Estimate</h2>


    <form action="#" id="invoice-generate" method="POST">
        @csrf


        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>

            @include('pages/invoice/actions.create_invoice_action')
        </div>


        <div class="row">

            <div class="col-md-3 mt-3 text-md-start text-center">
                <img src="{{ asset($data['setting']->logo_path) }}" style="height: 80px;">
            </div>

            <!-- Invoice Number with Mode -->
            <div class="col-md-3 mt-3">
                <label for="estimate_number" class="form-label d-flex justify-content-between align-items-center">
                    <span>Estimate Number</span>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="estimateModeSwitch" onchange="toggleEstimateMode(this)">
                        <label class="form-check-label small" for="estimateModeSwitch">Custom</label>
                    </div>
                </label>
                <input type="text" class="form-control form-control-sm" id="estimate_number" name="estimate_number" placeholder="Auto-generated" readonly>
            </div>



            <!-- Currency -->
            <div class="col-md-3 mt-3">
                <label for="currency" class="form-label">Select Currency</label>
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
            <div class="col-md-3 mt-3">
                <label for="template" class="form-label">Template</label>
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
                        <h4 class="mb-1">To</h4>
                        <a href="{{ route('client.add') }}" target="__blank" class="clientActionBtn new-client" style="text-decoration: none;display:none;">✏️ New Client</a>
                        <a href="#" onclick="event.preventDefault()" class="clientActionBtn change-client" style="text-decoration: none;">✏️ Change Client</a>
                    </div>

                    <div id="clientSearchBox">
                        <input type="text" class="form-control " id="client" name="client_name" placeholder="Type client name, email, contact number to search client" autocomplete="off">
                        <input type="hidden" name="client_id" id="client_id">
                        <!-- Dropdown results -->
                        <div id="clientList" class="list-group w-100 z-3 shadow-sm" style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    </div>

                    <!-- Display client address here -->
                    <div id="clientAddress" class="mt-3 border p-2 rounded bg-light" style="display: none;"></div>
                </div>




            </div>


            <div class="col-md-6">

                <div class="mt-3">
                    <label for="issue_date" class="form-label">Estimate Date</label>

                    <div class="input-group">
                        <input type="text" id="issue_date" class="form-control" name="issue_date" placeholder="Select Estimate Issue Date">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="expiry_date" class="form-label">Expiry Date</label>
                    <div class="input-group">
                        <input type="text" id="expiry_date" class="form-control" name="expiry_date" placeholder="Select Invoice Due Date">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>



            </div>



            <!-- test -->
            <div class="container my-4">
                <h4 class="mb-3">Estimate Item Entry</h4>



                <div id="form-container"></div>

                <button type="button" class="btn btn-outline btn-sm  btn-outline-primary w-100" onclick="addItemRow()"><i data-lucide="plus"></i> Add Item</button>

                <!-- Invoice Summary Section -->
                <div class="summary-box mt-5">
                    <h5>Estimate Summary</h5>
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



            </div>
            <!-- test -->


            <div class="col-md-12 mt-3">
                <div class="col-12">
                    <label for="terms" class="form-label fw-semibold">Terms and Conditions:</label>
                    <textarea id="id_estimate_terms" name="terms" class="form-control" placeholder="Enter Terms">{{ old('notes', setting('terms') ) }}</textarea>
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label fw-semibold">Notes:</label>
                    <textarea id="id_estimate_notes" name="notes" class="form-control ck-editor" placeholder="Enter Notes">{{ old('notes', setting('notes') ) }}</textarea>
                </div>


            </div>





        </div>

        <!-- Submit Button -->


    </form>

    <!-- Invoice Mode Modal -->
    <div class="modal fade" id="estimateModeModal" tabindex="-1" aria-labelledby="estimateModeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Estimate Mode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estimate_mode" id="auto_mode" value="auto" checked>
                        <label class="form-check-label" for="auto_mode">Auto</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estimate_mode" id="custom_mode" value="custom">
                        <label class="form-check-label" for="custom_mode">Custom</label>
                    </div>
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
        function toggleEstimateMode(elem) {
            const input = document.getElementById('estimate_number');
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
                const isCustom = $("#estimateModeSwitch").is(":checked");

                if (isCustom) {
                    $("#estimate_number")
                        .val("")
                        .prop("readonly", false)
                        .removeClass("bg-light")
                        .attr("placeholder", "Enter manually");
                } else {
                    let autoValue = generateInvoiceNumber();
                    $("#estimate_number")
                        .val(autoValue)
                        .prop("readonly", true)
                        .addClass("bg-light")
                        .attr("placeholder", "Auto-generated");
                }

                $("#estimate_number").fadeOut(200).fadeIn(400);
            }

            // When the switch is toggled
            $("#estimateModeSwitch").change(function() {
                updateInvoiceField();
            });

            // On page load
            updateInvoiceField();
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
            $('#id_estimate_notes').summernote({
                placeholder: 'Enter notes...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('#id_estimate_terms').summernote({
                placeholder: 'Enter terms...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('.save-invoice').on('click', function(e) {
                e.preventDefault();

                $('#send_status').val($(this).attr('send-status'))


                // 🛠️ Update textarea values before creating FormData
                Object.keys(editors).forEach(id => {
                    const data = editors[id].getData();
                    document.getElementById(id).value = data;
                });

                let formData = new FormData(document.getElementById('invoice-generate'));

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we prepare your estimate.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('estimate.store') }}",
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
                            $('#estimate-download').show();
                            $('#estimate-download').attr('href', response.download_url);

                            Swal.fire({
                                icon: "success",
                                title: "Estimate Generated Successfully. You Can Download!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('estimate.list') }}";
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
                   data-company_name="${client.company_name ?? ''}"
                   data-client_name="${client.client_name ?? ''}"
                   data-address_1="${client.address_1 ?? ''}"
                   data-address_2="${client.address_2 ?? ''}"
                   data-city="${client.city ?? ''}"
                   data-state_name="${client.state_name ?? ''}"
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
                               <i class="bi bi-envelope me-1"></i> ${client.email ?? ''}
                           </p>
                           <p class="mb-0 text-muted small">
                               <i class="bi bi-telephone me-1"></i> ${client.phone ?? ''}
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
                }else{
                     addressHTML += client.client_name + '<br>';
                }
                if (client.address_1) addressHTML += client.address_1 + '<br>';
                if (client.address_2) addressHTML += client.address_2 + '<br>';
                if (client.state_name) addressHTML += client.state_name + ' ';
                if (client.country_name) addressHTML += client.country_name + ' ';
                if (client.zip) addressHTML += client.zip;

                $('#client').val(client.client_name);
                $('#client_id').val(client.id);
                $('#clientList').hide();

                $('#clientAddress').html(addressHTML).show();

                $('#currency_code').val(client.currency_code).trigger('change');
                if (client.notes) {
                    $('#id_invoice_terms').summernote('code', client.notes);

                }
                if (client.terms) {
                    $('#id_invoice_notes').summernote('code', client.terms);
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
        flatpickr("#issue_date", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format: 2025-04-17 14:00
            time_24hr: true
        });

        flatpickr("#expiry_date", {
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

        let currencySymbols = {};
        currencies.forEach(cur => {
            currencySymbols[cur.code] = cur.symbol;
        });

        let itemCount = 0;
        let currencySymbol = '$'; // Default currency

        function changeCurrency(currency) {
            let symbol = currencySymbols[currency] || '$';
            currencySymbol = symbol;
            calculateInvoice(); // Refresh all amounts with new symbol
        }

        function addItemRow() {
            itemCount++;
            const formContainer = document.getElementById('form-container');

            const itemRow = document.createElement('div');
            itemRow.classList.add('row', 'g-3', 'p-3', 'border', 'rounded', 'shadow-sm', 'bg-light', 'align-items-start', 'mb-3', 'mt-3', 'position-relative');
            itemRow.setAttribute('data-item-id', itemCount);

            itemRow.innerHTML = `
      <div class="row w-100 g-2">
        
      
       <div class="col-12 col-md-6">
          <input type="text" name="item[${itemCount}][name]" placeholder="Item Name & Description" class="form-control form-control-sm add-items" id="item-${itemCount}" item-id="${itemCount}"  >
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
      </div>
      <div class="col-12">
        <button type="button" class="btn btn-outline btn-sm btn-outline-danger w-100" onclick="removeRow(this)"><i data-lucide="minus"></i> Remove</button>
      </div>
    `;

            formContainer.appendChild(itemRow);
            lucide.createIcons();
        }


        function calculateInvoice() {
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



            $("#hidden_sub_total").val(subtotal.toFixed(2));
            $("#hidden_total_discount").val(totalDiscount.toFixed(2));
            $("#hidden_total_tax").val(totalTax.toFixed(2));
            $("#hidden_grand_total").val(grandTotal.toFixed(2));



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