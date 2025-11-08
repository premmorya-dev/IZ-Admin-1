<x-default-layout>


    <h2 class="py-3">Invoices</h2>

    <!-- Accordion Container -->



    @include('pages/invoice.filter')
    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center my-4 px-2 gap-2">
        <!-- Bulk Action Section -->
        <div id="bulk-action-section" class="d-none d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
            <a href="#" id="bulk-delete" title="Delete Invoice" data-bs-toggle="modal" data-bs-target="#deleteModal"
                class="btn btn-outline-danger btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="trash-2"></i> Delete
            </a>

            <a href="#" id="bulk-invoice-download" title="Download Invoice"
                class="btn btn-outline-primary btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="download"></i> Download
            </a>

            <form id="download-form" method="POST" action="{{ route('invoice.bulk_download') }}">
                @csrf
            </form>

            <a href="#" title="Send Email To Client" data-bs-toggle="modal" data-bs-target="#emailConfirmModal"
                class="btn btn-outline-primary btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="mail"></i> Email
            </a>
        </div>

        <!-- Spacer for pushing Add button to right -->
        <div class="d-none d-md-block flex-grow-1"></div>

        <!-- Add Button -->
        <a class="btn btn-outline-primary btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2"
            id="add-action" href="{{ route('invoice.add') }}">
            <i data-lucide="plus-circle"></i> Add New
        </a>
    </div>





    <div class="listing-grid">

        <!-- Header -->
        <div class="listing-header">
            <div class="checkbox-col">
                <input class="form-check-input invoice_code checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                <span class="d-block d-md-none text-center fw-bold ms-1"> Select All </span>
            </div>

            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('invoice_number','Invoice #') </div>
            <div class="col sortable"><i data-lucide="check-circle"></i> @sortablelink('status','Status') </div>
            <div class="col sortable"><i data-lucide="dollar-sign"></i> @sortablelink('total','Total') </div>


            <div class="col sortable"><i data-lucide="calendar"></i> @sortablelink('due_date','Due Date') </div>


            <div class="col "><i data-lucide="more-vertical"></i> <span>Action</span> <span></span></div>
        </div>

        <!-- Row -->

        @if ( $data['invoice'] )
        @foreach ($data['invoice'] as $index => $invoice )


        <div class="listing-row">

            <div class="checkbox-col">
                <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $invoice->invoice_code }}" id="flexCheckDefault">
            </div>





            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Invoice Id </span>

                <!-- Align status and due badge to the right -->
                <div class="d-flex flex-column align-items-start text-start">
                    <span class="fw-bold">
                        <a href="{{ route('invoice.edit',['invoice_code' => $invoice->invoice_code ]) }}">{{ $invoice->invoice_number }}</a>
                        <a href="#" invoice-code="{{ $invoice->invoice_code }}" class="invoice-view-model" title="View Invoice"><i class="fa-regular fa-eye text-default"></i> </a>
                        <a href="{{ route('invoice.download',['invoice_code' => $invoice->invoice_code ]) }}?preview=true" target="__blank" title="Print Invoice"><i class="fa-solid fa-print text-defaults"></i> </a>
                        <a href="{{ route('invoice.download',['invoice_code' => $invoice->invoice_code ]) }}" title="Download Invoice"><i class="fa-solid fa-download text-defaults"></i> </a>
                    </span>
                    <span></span>
                    <div class="d-flex align-items-center flex-wrap gap-1">
                        To:  <a href="#" client-code="{{ $invoice->client_code }}" class="edit-client" title="Client Detail"> {{ $invoice->company_name ??  $invoice->client_name }} </a>


                        @php
                        $badgeClasses = [
                        'pending' => 'text-warning',
                        'submitted' => 'text-info',
                        'sent' => 'text-success',
                        ];
                        @endphp

                        @php
                        $sentStatus = [
                        'pending' => 'Invoice email not sent to customer',
                        'submitted' => 'invoice email notification in queue or in processing',
                        'sent' => 'Invoice email sent to customer',
                        ];
                        @endphp

                        <i class="fa-solid fa-envelope {{ $badgeClasses[$invoice->is_sent] ?? 'text-dark' }} cursor-pointer" title="{{ $sentStatus[$invoice->is_sent] }}"></i>


                    </div>


                </div>
            </div>



            @php
            $badgeClasses = [
            'pending' => 'badge text-bg-warning text-white',
            'sent' => 'badge text-bg-primary text-white',
            'paid' => 'badge text-bg-success text-white',
            'cancelled' => 'badge text-bg-dark',
            'overdue' => 'badge text-bg-danger text-white',
            ];
            @endphp

            <div class="col mt-3">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Status </span>

                <!-- Align status and due badge to the right -->
                <div class="d-flex flex-column align-items-end text-end">
                    <span class="{{ $badgeClasses[$invoice->status] ?? 'badge text-bg-dark' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                    <span></span>
                    @if (!empty($invoice->due_status_text) && $invoice->status != 'paid')
                    @php
                    $dueBadgeClass = match ($invoice->due_type) {
                    'overdue' => 'badge bg-danger mt-1',
                    'upcoming' => 'badge bg-warning mt-1',
                    'today' => 'badge bg-primary mt-1',
                    default => 'badge bg-secondary mt-1',
                    };
                    @endphp
                    <span class="{{ $dueBadgeClass }} text-white">{{ $invoice->due_status_text }}</span>
                    @endif
                </div>
            </div>




            <div class="col mt-3 text-end text-md-start">
                <span class="d-block d-md-none text-center mt-2 fw-bold">Total</span>

                <div class="d-flex flex-column align-items-end align-items-md-start">
                    <span class="badge bg-success mb-1 text-white">
                        {{ $invoice->symbol }} {{ number_format($invoice->grand_total, 2) }} Total
                    </span>
                    @if( $invoice->total_due > 0 )
                    <span class="badge bg-danger text-white">
                        {{ $invoice->symbol }} {{ number_format($invoice->total_due, 2) }} Due
                    </span>
                    @endif

                </div>
            </div>



            <div class="col mt-3">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Due Date </span>
                <span> {{ $invoice->due_date }}</span>

            </div>

            <div class="col mt-3"> <span class="d-block d-md-none text-center mt-2 fw-bold"> Action </span> <span>@include('pages/invoice/actions/edit_action') </span> </div>





        </div>
        @endforeach

        @endif

        <!-- You can duplicate the above .listing-row to add more rows -->

    </div>


    @if($data['show_pagination'])
    <!-- Pagination Links -->
    <div class="d-flex  align-items-left mt-10">
        {{-- Showing results text --}}
        <div class="mb-2 mb-md-0">
            <p class="fw-semibold text-muted">
                Showing {{ ($data['page'] - 1) * $data['perPage'] + 1 }}
                to {{ min($data['page'] * $data['perPage'], $data['totalRecords']) }}
                of {{ number_format($data['totalRecords']) }} results
            </p>
        </div>

        {{-- Pagination UI --}}
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0">
                {{-- First & Previous Buttons --}}
                @if ($data['page'] > 1)
                <li class="page-item">
                    <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}1" aria-label="First">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['page'] - 1 }}" aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="bi bi-chevron-double-left"></i></span>
                </li>
                <li class="page-item disabled">
                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                </li>
                @endif

                {{-- Show "..." before middle pages if needed --}}
                @if ($data['page'] > 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                {{-- Page Number Links (Only 5 around the current page) --}}
                @for ($i = max(1, $data['page'] - 2); $i <= min($data['totalPages'], $data['page'] + 2); $i++)
                    <li class="page-item {{ $i == $data['page'] ? 'active' : '' }}">
                    <a href="{{ $data['pagination_url']}}{{ $i }}" class="page-link">{{ $i }}</a>
                    </li>
                    @endfor

                    {{-- Show "..." after middle pages if needed --}}
                    @if ($data['page'] < $data['totalPages'] - 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        {{-- Next & Last Buttons --}}
                        @if ($data['page'] < $data['totalPages'])
                            <li class="page-item">
                            <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['page'] + 1 }}" aria-label="Next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['totalPages'] }}" aria-label="Last">
                                    <i class="bi bi-chevron-double-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                            </li>
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-double-right"></i></span>
                            </li>
                            @endif
            </ul>
        </nav>
    </div>
    @endif


    <!-- Bulk Modal -->
    <div class="modal fade" id="bulk-modal" tabindex="-1" aria-labelledby="bulkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="bulkModalLabel">Bulk Action</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="spinner-border text-primary spinner-format" id="bulk-loader" style="display:none;" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <div class="bulk-modal-body py-5 px-5">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Single Delete Confirmation Modal -->
    <div class="modal fade" id="singleDeleteModal" tabindex="-1" aria-labelledby="singleDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="singleDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the invoices?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" invoice-code="" class="btn btn-danger" id="confirmed-single-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi Delete Confirmation Modal -->
    <div class="modal fade" id="multiDeleteModal" tabindex="-1" aria-labelledby="multiDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="multiDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the all selected invoices?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" invoice-code="" class="btn btn-danger" id="confirmed-multi-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Email Confirmation Modal -->
    <div class="modal fade" id="emailConfirmModal" tabindex="-1" aria-labelledby="emailConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h5 class="modal-title">Send Invoice Emails</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to send selected invoices to clients via email?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-email">
                        <i class="fa-solid fa-paper-plane text-white"></i> Send
                    </button>
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

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top-3 mb-3">
                    <h5 class="modal-title" id="viewModalLabel">
                        View Invoice
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body">

                </div>
            </div>
        </div>
    </div>

    <!-- Add Client Model -->
    <div class="modal fade" id="client-modal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
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

                            ['#id_country_id', '#id_state_id', '#id_currency_code' ,'#id_shipping_state_id', '#id_shipping_country_id'].forEach(function(selector) {
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
        $(document).ready(function() {

            $('.copyButton').on('click', function(e) {
                e.preventDefault();
                copyToClipboard($(this).attr('link'));
            });

            $(document).on('change', '.selected, .invoice_code', function() {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    document.getElementById('bulk-action-section')?.classList.remove('d-none');


                } else {

                    console.log("Checkbox unchecked: ");
                    var q_id = [];
                    $(".selected:checked").each(function() {
                        q_id.push($(this).val());
                    });
                    if (q_id === undefined || q_id === null || q_id === '' || q_id.length == 0) {
                        document.getElementById('bulk-action-section')?.classList.add('d-none');
                    }
                }
            });


            var invoices_code = [];
            $('#bulk-delete').on('click', function(e) {
                invoices_code = [];
                e.preventDefault();
                $('.selected:checked').each(function() {
                    invoices_code.push(this.value);
                });
                $('#multiDeleteModal').modal('show');

            });

            $('#confirmed-multi-delete').on('click', function(e) {
                $('#multiDeleteModal').modal('hide');
                try {
                    $.ajax({
                        url: "{{ route('invoice.bulk_delete') }}",
                        data: {
                            invoices_code: invoices_code
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
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


            $('#bulk-modal').on('shown.bs.modal', function() {
                flatpickr("#scheduled_datetime", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:s",
                    time_24hr: true,
                    minuteIncrement: 1,
                    defaultHour: 12,
                    defaultMinute: 0
                });
            });

            $('#bulk-invoice-download').on('click', function(e) {
                e.preventDefault();
                let selectedInvoices = $(".selected:checked");
                let form = $('#download-form');

                form.find('input[name="invoices_code[]"]').remove(); // clear old values

                if (selectedInvoices.length === 0) {
                    alert("Please select at least one invoice.");
                    return;
                }

                selectedInvoices.each(function() {
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'invoices_code[]')
                        .val($(this).val())
                        .appendTo(form);
                });

                form.submit(); // Normal form POST → Laravel returns ZIP → Browser prompts download
            });


            $('#confirm-send-email').click(function() {
                let selected = [];
                $('input[name="selected[]"]:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    alert("Please select at least one invoice.");
                    return;
                }

                $.ajax({
                    url: "{{ route('invoice.send_bulk_email') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        invoices_code: selected
                    },
                    success: function(response) {
                        $('#emailConfirmModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });



            /*    bulk action end  */


        });
    </script>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $('#confirmed-delete').on('click', function() {
            let selected = $('.form-check-input.selected:checked').map(function() {
                return this.value;
            }).get();

            if (selected.length === 0) {
                alert("Please select at least one invoice.");
                return;
            }

            $.ajax({
                url: "{{ route('invoice.bulk_delete') }}",
                method: 'POST',
                data: {
                    invoice_codes: selected,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete invoices.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting invoices.");
                }
            });
        });

        $('#confirmed-single-delete').on('click', function(e) {
            e.preventDefault();
            var invoice_code = $(this).attr('invoice-code');
            $.ajax({
                url: "{{ route('invoice.destroy') }}",
                method: 'POST',
                data: {
                    invoice_code: invoice_code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete invoices.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting invoices.");
                }
            });
        });
    </script>



</x-default-layout>