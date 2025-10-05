<x-default-layout>


    <h2 class="py-3">Expenses</h2>

    <!-- Accordion Container -->



    @include('pages/expense.filter')
    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center my-4 px-2 gap-2">
        <!-- Bulk Action Section -->
        <div id="bulk-action-section" class="d-none d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
            <a href="#" id="bulk-delete" title="Delete expense" data-bs-toggle="modal" data-bs-target="#deleteModal"
                class="btn btn-outline-danger btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="trash-2"></i> Delete
            </a>

            <!-- <a href="#" id="bulk-expense-download" title="Download expense"
                class="btn btn-outline-primary btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="download"></i> Download
            </a> -->

            <form id="download-form" method="POST" action="{{ route('expense.bulk_download') }}">
                @csrf
            </form>


        </div>

        <!-- Spacer for pushing Add button to right -->
        <div class="d-none d-md-block flex-grow-1"></div>

        <!-- Add Button -->
        <a class="btn btn-outline-primary btn-sm w-100 w-md-auto px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2"
            id="add-action" href="{{ route('expense.add') }}">
            <i data-lucide="plus-circle"></i> Add New
        </a>
    </div>





    <div class="listing-grid">

        <!-- Header -->
        <div class="listing-header">
            <div class="checkbox-col">
                <input class="form-check-input expense_code checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                <span class="d-block d-md-none text-center fw-bold ms-1"> Select All </span>
            </div>

            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('expense_number','expense #') </div>
            <div class="col sortable"><i data-lucide="dollar-sign"></i> @sortablelink('total','Total') </div>


            <div class="col sortable"><i data-lucide="calendar"></i> @sortablelink('expense_date','Expense Date') </div>
            <div class="col sortable"><i data-lucide="dollar-sign"></i> @sortablelink('is_paid','Status') </div>


            <div class="col "><i data-lucide="more-vertical"></i> <span>Action</span> <span></span></div>
        </div>

        <!-- Row -->

        @if ( $data['expense'] )
        @foreach ($data['expense'] as $index => $expense )


        <div class="listing-row">

            <div class="checkbox-col">
                <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $expense->expense_code }}" id="flexCheckDefault">
            </div>





            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Expense Id </span>

                <!-- Align status and due badge to the right -->
                <div class="d-flex flex-column align-items-start text-start">
                    <span class="fw-bold">
                        <a href="{{ route('expense.edit',['expense_code' => $expense->expense_code ]) }}">{{ $expense->expense_number }}</a>
                      
                    </span>
                    <span></span>


                </div>
            </div>






            <div class="col mt-3 text-end text-md-start">
                <span class="d-block d-md-none text-center mt-2 fw-bold">Amount</span>

                <div class="d-flex flex-column align-items-end align-items-md-start">
                    {{ $expense->symbol }} {{ number_format($expense->amount, 2) }}

                </div>
            </div>



            <div class="col mt-3">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Expense Date </span>
                <span> {{ $expense->expense_date }}</span>

            </div>


            @php
            $badgeClasses = [
            'Y' => 'badge text-bg-success text-white',
            'N' => 'badge text-bg-warning text-white',

            ];
            @endphp


            <div class="col mt-3">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Status </span>

                <span class="{{ $badgeClasses[$expense->is_paid] ?? 'badge text-bg-warning text-white' }}">
                   {{ $expense->is_paid == 'Y' ? 'Paid' : 'Un-Paid' }}
                </span>
            </div>


            <div class="col mt-3"> <span class="d-block d-md-none text-center mt-2 fw-bold"> Action </span> <span>@include('pages/expense/actions/edit_action') </span> </div>





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
                <div class="modal-header">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="singleDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the expenses?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" expense-code="" class="btn btn-danger" id="confirmed-single-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi Delete Confirmation Modal -->
    <div class="modal fade" id="multiDeleteModal" tabindex="-1" aria-labelledby="multiDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multiDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the all selected expenses?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" expense-code="" class="btn btn-danger" id="confirmed-multi-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Email Confirmation Modal -->
    <div class="modal fade" id="emailConfirmModal" tabindex="-1" aria-labelledby="emailConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send expense Emails</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to send selected expenses to clients via email?
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
                <div class="modal-header bg-primary text-white rounded-top-4">
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
                <div class="modal-header bg-primary text-white rounded-top-4 mb-3">
                    <h5 class="modal-title" id="viewModalLabel">
                        View expense
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="view-record-form-body">

                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {

            $('.copyButton').on('click', function(e) {
                e.preventDefault();
                copyToClipboard($(this).attr('link'));
            });

            $(document).on('change', '.selected, .expense_code', function() {
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


            var expense_code = [];
            $('#bulk-delete').on('click', function(e) {
                expense_code = [];
                e.preventDefault();
                $('.selected:checked').each(function() {
                    expense_code.push(this.value);
                });
                $('#multiDeleteModal').modal('show');

            });

            $('#confirmed-multi-delete').on('click', function(e) {
                $('#multiDeleteModal').modal('hide');
                try {
                    $.ajax({
                        url: "{{ route('expense.bulk_delete') }}",
                        data: {
                            expense_code: expense_code
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




            $(document).on('click', '.expense-view-model', function(e) {
                e.preventDefault();
                $('#viewModal').modal('show');
                var expense_code = $(this).attr('expense-code')

                try {

                    $.ajax({
                        url: "{{ route('expense.view.model') }}",
                        data: {
                            expense_code: expense_code
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

            $('#bulk-expense-download').on('click', function(e) {
                e.preventDefault();
                let selectedexpenses = $(".selected:checked");
                let form = $('#download-form');

                form.find('input[name="expenses_code[]"]').remove(); // clear old values

                if (selectedexpenses.length === 0) {
                    alert("Please select at least one expense.");
                    return;
                }

                selectedexpenses.each(function() {
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'expenses_code[]')
                        .val($(this).val())
                        .appendTo(form);
                });

                form.submit(); // Normal form POST → Laravel returns ZIP → Browser prompts download
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
                alert("Please select at least one expense.");
                return;
            }

            $.ajax({
                url: "{{ route('expense.bulk_delete') }}",
                method: 'POST',
                data: {
                    expense_codes: selected,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete expenses.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting expenses.");
                }
            });
        });

        $('#confirmed-single-delete').on('click', function(e) {
            e.preventDefault();
            var expense_code = $(this).attr('expense-code');
            $.ajax({
                url: "{{ route('expense.destroy') }}",
                method: 'POST',
                data: {
                    expense_code: expense_code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.error === 0) {
                        location.reload();
                    } else {
                        alert("Failed to delete expenses.");
                    }
                },
                error: function() {
                    alert("An error occurred while deleting expenses.");
                }
            });
        });
    </script>



</x-default-layout>