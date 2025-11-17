<x-default-layout>
    <h2 class="py-3">Report</h2>
    <form action="{{ route('report.get') }}" id="generate-report-form" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>
            <button id="generate-report" class="btn btn-primary btn-sm "><i data-lucide="settings"></i> Generate Report</button>

        </div>

        <fieldset class="border p-3 rounded mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <legend class="w-auto m-0">Report</legend>
                <!-- Trigger Button -->
                <a href="#" class="btn btn-sm btn-outline-secondary"
                    style="border: 1px solid #6c757d !important;"
                    data-bs-toggle="modal" data-bs-target="#gstr1Modal">
                    GSTR-1 (Sales)
                </a>

            </div>


            <div class="row">

                <div class="col-md-4 mt-4">
                    <label for="report_type" class="form-label">Report Type</label>
                    <select name="report_type" id="report_type" class="form-select">
                        <option value="invoice">Invoice</option>
                        <option value="bill">Bill</option>
                        <option value="itc">Input Tax Credit</option>
                    </select>

                </div>

                <div class="col-md-4 mt-4">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status[]" class="form-select" multiple multiselect-max-items="2" multiselect-search="true">
                        <option value="pending" {{ in_array('pending', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ in_array('sent', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ in_array('paid', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ in_array('overdue', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ in_array('cancelled', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                  <div class="col-md-4 mt-4">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency[]" class="form-select" multiple multiselect-max-items="2" multiselect-search="true">
                        @foreach($data['currencies'] as $currency )
                        <option value="{{ $currency->currency_code }}" {{ old('currency', $data['setting']->currency ?? '') == $currency->currency_code ? 'selected' : '' }}> {{ $currency->currency_name }} | {{ $currency->currency_symbol }}</option>
                        @endforeach

                    </select>

                </div>


                <div class="col-md-3 mt-4">
                    <label for="period" class="form-label">Period</label>
                    <select name="period" id="period" class="form-select">
                        <option value="all_time">All Time</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="3_month">Last 3 Months</option>
                        <option value="custom">Custom</option>
                    </select>

                </div>


                <div class="col-md-3 mt-4" id="custom-date-wrapper" style="display: none;">
                    <label class="form-label">Custom Date</label>
                    <div class="input-group">
                        <input type="text" name="date" id="date" value="{{ request('date') }}" class="form-control date-range" placeholder="Pick Custom Date Range">
                        <span class="input-group-text date-range"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>



              


                <div class="col-md-3 mt-4">
                    <label for="client" class="form-label fw-semibold">Select Client Type</label>
                    <select name="client" id="client" class="form-select">
                        <option value="all_client" selected>All Clients</option>
                        <option value="single_client">Single Client</option>
                    </select>
                </div>

                <div class="col-md-3 mt-4" id="client_search_wrapper" style="display: none; position: relative;">
                    <label for="client_name" class="form-label fw-semibold">Search Client</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ request('client_name') }}" placeholder="Type to search client..." autocomplete="off">
                    <input type="hidden" name="client_id" id="client_id">
                    <div id="clientList" class="list-group shadow" style="position: absolute; top: 100%; width: 100%; z-index: 1050;"></div>
                </div>


                <!-- Purchase Vendor Section -->
                <div class="col-md-3 mt-4" id="vendor_type_wrapper" style="display:none;">
                    <label for="vendor" class="form-label fw-semibold">Select Vendor Type</label>
                    <select name="vendor" id="vendor" class="form-select">
                        <option value="all_vendor" selected>All Vendors</option>
                        <option value="single_vendor">Single Vendor</option>
                    </select>
                </div>

                <div class="col-md-3 mt-4" id="vendor_search_wrapper" style="display:none; position:relative;">
                    <label for="vendor_name" class="form-label fw-semibold">Search Vendor</label>
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name"
                        placeholder="Type to search vendor..." autocomplete="off">
                    <input type="hidden" name="vendor_id" id="vendor_id">
                    <div id="vendorList" class="list-group shadow"
                        style="position:absolute; top:100%; width:100%; z-index:1050;"></div>
                </div>



            </div>

        </fieldset>

        <div id="report-result" class="mt-4"></div>



    </form>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <!-- GSTR-1 Modal -->
    <div class="modal fade" id="gstr1Modal" tabindex="-1" aria-labelledby="gstr1ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title" id="gstr1ModalLabel">Download GSTR-1 (Sales)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <p class="mb-4 text-muted">
                        Export your GSTR-1 (Sales) data for the selected period in JSON format for GST filing.
                    </p>

                    <!-- Month and Year Selection -->
                    <form id="gstr1-form">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="monthYearPicker" class="form-label">Select Month & Year</label>
                                <input type="text" id="monthYearPicker" name="period" class="form-control" placeholder="Select month and year" readonly>
                            </div>

                        </div>
                    </form>


                    <!-- Action Buttons -->
                    <div class="d-flex gap-3">
                        <a id="downloadGSTR1" href="#" class="btn btn-outline-success w-100">
                            <i class="fas fa-download me-2"></i> Download JSON
                        </a>
                        <!-- <a id="viewJsonBtn" href="#" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-eye me-2"></i> View JSON
                        </a> -->
                    </div>
                </div>

                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

    <script>
        $(document).ready(function() {

            function toggleReportType() {
                let type = $('#report_type').val();

                if (type === 'invoice') {
                    $('#client').closest('.col-md-3').show();
                    $('#client_search_wrapper').hide();
                    $('#vendor_type_wrapper').hide();
                    $('#vendor_search_wrapper').hide();
                    $('#vendor_name, #vendor_id').val('');
                } else {
                    $('#vendor_type_wrapper').show();
                    $('#client').closest('.col-md-3').hide();
                    $('#client_search_wrapper').hide();
                    $('#client_name, #client_id').val('');
                }
            }

            // On load + on change
            toggleReportType();
            $('#report_type').on('change', toggleReportType);
        });


        $(document).ready(function() {

            // When user selects vendor type
            $('#vendor').on('change', function() {
                if ($(this).val() === 'single_vendor') {
                    $('#vendor_search_wrapper').slideDown();
                } else {
                    $('#vendor_search_wrapper').slideUp();
                    $('#vendor_name, #vendor_id').val('');
                    $('#vendorList').fadeOut();
                }
            });

            // Vendor autocomplete search
            $('#vendor_name').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('vendor.search2') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#vendorList').fadeIn().html(data);
                        }
                    });
                } else {
                    $('#vendorList').fadeOut();
                }
            });

            // Select vendor from list
            $(document).on('click', '.vendor-item', function() {
                $('#vendor_name').val($(this).data('name'));
                $('#vendor_id').val($(this).data('id'));
                $('#vendorList').fadeOut();
            });

        });
    </script>

    <script>
        $('#downloadGSTR1').on('click', function(e) {
            e.preventDefault();

            let period = $('#monthYearPicker').val(); // Ensure this input exists

            if (!period) {
                Swal.fire('Please select a period!');
                return;
            }

            Swal.fire({
                title: "Generating File...",
                text: "Please wait while we prepare your GSTR-1 JSON file.",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const downloadUrl = "{{ route('gst.gstr1') }}?period=" + period;

            // Trigger file download
            window.location.href = downloadUrl;

            Swal.close();
        });
    </script>
    <script>
        flatpickr("#monthYearPicker", {
            plugins: [
                new monthSelectPlugin({
                    shorthand: true, // Display Jan, Feb, etc.
                    dateFormat: "mY", // Output: 072025
                    altFormat: "F Y" // UI display: July 2025
                })
            ]
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateGSTRLinks() {
                const month = document.getElementById("gstrMonth").value;
                const year = document.getElementById("gstrYear").value;
                const fp = month + year;

                const monthText = document.getElementById("gstrMonth").selectedOptions[0].text;
                document.getElementById("selectedPeriod").textContent = `${monthText} ${year}`;

                // You can fetch GT & Cur_GT by AJAX here if needed

                // Update View & Download links
                document.getElementById("downloadJsonBtn").href = `/gstr1/download?period=${fp}`;
                document.getElementById("viewJsonBtn").href = `/gstr1/view?period=${fp}`;
            }

            document.getElementById("gstrMonth").addEventListener("change", updateGSTRLinks);
            document.getElementById("gstrYear").addEventListener("change", updateGSTRLinks);
            updateGSTRLinks(); // Initial set
        });
    </script>

    <script>
        $(document).ready(function() {
            function toggleCustomDate() {
                if ($('#period').val() === 'custom') {
                    $('#custom-date-wrapper').slideDown();
                } else {
                    $('#custom-date-wrapper').slideUp();
                }
            }

            // Initial check on page load
            toggleCustomDate();

            // Event listener
            $('#period').on('change', toggleCustomDate);
        });
    </script>



    <script>
        $("#date").daterangepicker({

            autoUpdateInput: false, // Keep input field empty initially
            locale: {
                format: "YYYY-M-DD"
            }
        }, function(start, end) {
            // When a user selects a date range, update the input field
            $('#date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

            // Calculate total days selected
            var daysSelected = end.diff(start, 'days');
            $("#total_days").text("Total Days Selected: " + daysSelected);
        });

        // Optional: Clear input field when clicking "Cancel" in the date picker
        $('#date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });



        $('#generate-report').on('click', function(e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById('generate-report-form'));
            Swal.fire({
                title: "Processing...",
                text: "Please wait while we preparing your report.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('report.get') }}",
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
                        $('#report-result').html(response.html);

                        Swal.fire({
                            icon: "success",
                            title: "Report Generated Successfully!",
                            text: response.message,
                            toast: false,
                            position: "center",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            lucide.createIcons(); // re-render icons
                            // Redirect after the alert closes
                            //window.location.href = "{{ route('invoice.list') }}";
                        });



                    }
                },
                complete: function() {
                    lucide.createIcons(); // re-render icons
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Show/hide client search field based on selection
            $('#client').on('change', function() {
                if ($(this).val() === 'single_client') {
                    $('#client_search_wrapper').slideDown();
                } else {
                    $('#client_search_wrapper').slideUp();
                    $('#client_name').val('');
                    $('#client_id').val('');
                    $('#clientList').fadeOut();
                }
            });

            // Autocomplete client search
            $('#client_name').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('client.search2') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#clientList').fadeIn().html(data);
                        }
                    });
                } else {
                    $('#clientList').fadeOut();
                }
            });

            // Select client from suggestion list
            $(document).on('click', '.client-item', function(e) {
                e.preventDefault();
                const clientName = $(this).data('name');
                const clientId = $(this).data('id');

                $('#client_name').val(clientName);
                $('input[name="client_id"]').val(clientId);
                $('#clientList').fadeOut();
            });

            // Hide suggestion list when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#client_name, #clientList').length) {
                    $('#clientList').fadeOut();
                }
            });

            // Pre-select if form reloads with single client
            @if(request('client') === 'single_client')
            $('#client').val('single_client').trigger('change');
            @endif
        });
    </script>

</x-default-layout>