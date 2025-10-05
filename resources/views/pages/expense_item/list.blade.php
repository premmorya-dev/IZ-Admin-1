<x-default-layout>

    <h2 class="py-3">Expense Items</h2>


    <!-- Accordion Container -->


    @include('pages/expense_item.filter')
    <div class="d-flex justify-content-between align-expense_items-center my-4 px-2">
        <a href="#" id="bulkDeleteBtn" title="Delete Invoice" data-bs-toggle="modal" data-bs-target="#deleteModal"
            class="btn btn-outline-danger btn-sm px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-expense_items-center gap-2">
            <i data-lucide="trash-2"></i> Delete
        </a>
        <!-- Add Button -->
        <a class="btn btn-outline-primary btn-sm px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-expense_items-center gap-2"
            id="add-action" href="{{ route('expense.item.add') }}"> <i data-lucide="plus-circle"></i> Add New</a>

    </div>

    <!-- Lucide Init -->


    </div>

    <div class="listing-grid">

        <!-- Header -->
        <div class="listing-header">
            <div class="checkbox-col">
                <input class="form-check-input expense_item_id checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                <span class="d-block d-md-none text-center fw-bold ms-1"> Select All </span>
            </div>

            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('expense_item_name','Name') </div>
            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('expense_item_type','Type') </div>
            <div class="col sortable"><i data-lucide="shield-check"></i> @sortablelink('status','Status') </div>
      



            <div class="col "><i data-lucide="more-vertical"></i> <span>Action</span> <span></span></div>
        </div>

        <!-- Row -->

        @if ( $data['expense_items'] )
        @foreach ($data['expense_items'] as $index => $expense_item )


        <div class="listing-row">

            <div class="checkbox-col">
                <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $expense_item->expense_item_code }}" id="flexCheckDefault">

            </div>




            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Name </span>

                <!-- Align status and due badge to the right -->
                <div class="d-flex flex-column align-expense_items-start text-start">
                    <span class="fw-bold">
                        <a href="{{ route('expense.item.edit',['expense_item_code' => $expense_item->expense_item_code ]) }}">{{ $expense_item->expense_item_name }}</a>
                    </span>
                    <span></span>
                    <div class="d-flex align-expense_items-center flex-wrap gap-1">
                        <i class="fas fa-folder"></i>
                        @if( !empty( $expense_item->expense_item_category_code ) )
                        <a href="{{ route('expense.item.category.edit',['expense_item_category_code' => $expense_item->expense_item_category_code ]) }}" target="__blank">{{ $expense_item->expense_item_category_name ?? 'N/A' }}</a>
                        @else
                        N/A
                        @endif


                    </div>


                </div>
            </div>


            @php
            $badgeClasses = [
            'Y' => 'badge text-bg-success text-white',
            'N' => 'badge text-bg-danger text-white',

            ];
            @endphp


            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Type </span>
                <span>{{ ucfirst($expense_item->expense_item_type) }}</span>

            </div>


            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Status </span>
                <span class="{{ $badgeClasses[$expense_item->status] ?? 'badge text-bg-dark' }}"> {{ $expense_item->status == 'Y' ? 'Active' : 'De-Active'   }}</span>

            </div>
        


            <div class="col"> <span class="d-block d-md-none text-center mt-2 fw-bold"> Action </span> <span>@include('pages/expense_item/actions/edit_action') </span> </div>





        </div>
        @endforeach

        @endif

        <!-- You can duplicate the above .listing-row to add more rows -->

    </div>


    @if($data['show_pagination'])
    <!-- Pagination Links -->
    <div class="d-flex  align-expense_items-left mt-10">
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
                <li class="page-expense_item">
                    <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}1" aria-label="First">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>
                <li class="page-expense_item">
                    <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['page'] - 1 }}" aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
                @else
                <li class="page-expense_item disabled">
                    <span class="page-link"><i class="bi bi-chevron-double-left"></i></span>
                </li>
                <li class="page-expense_item disabled">
                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                </li>
                @endif

                {{-- Show "..." before middle pages if needed --}}
                @if ($data['page'] > 3)
                <li class="page-expense_item disabled"><span class="page-link">...</span></li>
                @endif

                {{-- Page Number Links (Only 5 around the current page) --}}
                @for ($i = max(1, $data['page'] - 2); $i <= min($data['totalPages'], $data['page'] + 2); $i++)
                    <li class="page-expense_item {{ $i == $data['page'] ? 'active' : '' }}">
                    <a href="{{ $data['pagination_url']}}{{ $i }}" class="page-link">{{ $i }}</a>
                    </li>
                    @endfor

                    {{-- Show "..." after middle pages if needed --}}
                    @if ($data['page'] < $data['totalPages'] - 2)
                        <li class="page-expense_item disabled"><span class="page-link">...</span></li>
                        @endif

                        {{-- Next & Last Buttons --}}
                        @if ($data['page'] < $data['totalPages'])
                            <li class="page-expense_item">
                            <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['page'] + 1 }}" aria-label="Next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            </li>
                            <li class="page-expense_item">
                                <a class="page-link text-primary fw-bold" href="{{ $data['pagination_url']}}{{ $data['totalPages'] }}" aria-label="Last">
                                    <i class="bi bi-chevron-double-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="page-expense_item disabled">
                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                            </li>
                            <li class="page-expense_item disabled">
                                <span class="page-link"><i class="bi bi-chevron-double-right"></i></span>
                            </li>
                            @endif
            </ul>
        </nav>
    </div>
    @endif




    <!-- Bootstrap 5 Delete Confirm Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected expense_item(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
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


        });
    </script>



    <script>
        $(document).ready(function() {
            let deleteIds = [];

            // Enable or disable bulk delete button
            function toggleBulkButton() {
                let selected = $('.form-check-input.selected:checked').length;
                $('#bulkDeleteBtn').prop('disabled', selected === 0);
            }

            // Select checkboxes
            $('.form-check-input.selected').on('change', function() {
                toggleBulkButton();
            });

            // Bulk Delete button click
            $('#bulkDeleteBtn').on('click', function() {
                deleteIds = $('.form-check-input.selected:checked').map(function() {
                    return $(this).val();
                }).get();

                if (deleteIds.length > 0) {
                    $('#deleteConfirmModal').modal('show');
                }
            });

            // Single Delete from dropdown
            $('.dropdown-menu a.deleteSingleBtn').on('click', function(e) {
                e.preventDefault();
                const expense_itemId = $(this).data('id');
                deleteIds = [expense_itemId];
                $('#deleteConfirmModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('expense.item.destroy') }}",
                    method: "POST",
                    data: {
                        ids: deleteIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteConfirmModal').modal('hide');


                        // Disable bulk delete button again
                        toggleBulkButton();

                        Swal.fire({
                            icon: "success",
                            title: 'Deleted!',
                            text: response.message,
                            position: "center",
                            toast: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('expense.item.list') }}";
                        });



                    },
                    error: function(xhr) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: xhr.responseJSON.message ?? 'Something went wrong!',
                        });
                    }
                });
            });

        });
    </script>



</x-default-layout>