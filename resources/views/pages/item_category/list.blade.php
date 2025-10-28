<x-default-layout>

    <h2 class="py-3">Item Category</h2>


    <!-- Accordion Container -->


    @include('pages/item_category.filter')
    <div class="d-flex justify-content-between align-item_categories-center my-4 px-2">
        <a href="#" id="bulkDeleteBtn" title="Delete Invoice" data-bs-toggle="modal" data-bs-target="#deleteModal"
            class="btn btn-outline-danger btn-sm px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-item_categories-center gap-2">
            <i data-lucide="trash-2"></i> Delete
        </a>
        <!-- Add Button -->
         <a class="btn btn-outline-primary btn-sm px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center gap-2 new-item-category"
            id="add-action" href="#"> <i data-lucide="plus-circle"></i> Add New</a>

    </div>

    <!-- Lucide Init -->


    </div>

    <div class="listing-grid">

        <!-- Header -->
        <div class="listing-header">
            <div class="checkbox-col">
                <input class="form-check-input item_id checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                <span class="d-block d-md-none text-center fw-bold ms-1"> Select All </span>
            </div>

            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('item_category_name','Name') </div> 

            <div class="col "><i data-lucide="more-vertical"></i> <span>Action</span> <span></span></div>
        </div>

        <!-- Row -->

        @if ( $data['item_categories'] )
        @foreach ($data['item_categories'] as $index => $item_categories )


        <div class="listing-row">

            <div class="checkbox-col">
                <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $item_categories->item_category_code }}" id="flexCheckDefault">

            </div>




            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Name </span>

                <!-- Align status and due badge to the right -->
                <div class="d-flex flex-column align-item_categories-start text-start">
                    <span class="fw-bold">                    

                         <span class="item-category-name" item-category-code="{{  $item_categories->item_category_code }}"> <a href="#"> @if( $item_categories->user_id == '1' )<i title="System Category cannot be edit and delete" class=" text-primary fa-solid fa-desktop"></i>@endif {{ $item_categories->item_category_name  }}</a></span>

                    </span>
                


                </div>
            </div>        


            <div class="col"> <span class="d-block d-md-none text-center mt-2 fw-bold"> Action </span> <span>@include('pages/item_category/actions/edit_action') </span> </div>





        </div>
        @endforeach

        @endif

        <!-- You can duplicate the above .listing-row to add more rows -->

    </div>


    @if($data['show_pagination'])
    <!-- Pagination Links -->
    <div class="d-flex  align-item_categories-left mt-10">
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




    <!-- Bootstrap 5 Delete Confirm Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected item category(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>


        <!-- Add Category Model -->
    <div class="modal fade" id="itemCategory-modal" tabindex="-1" aria-labelledby="itemCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="itemCategoryModalLabel">Add Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="itemCategory-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    @include('pages/item_category/modal.edit_modal')

    <script>
        $(document).on('click', '.new-item-category', function(e) {
            e.preventDefault();
            $('.itemCategory-modal-body').empty();


            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('item.category.add') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                        $('.itemCategory-modal-body').html(response);
                        $('#itemCategory-modal').modal('show');


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
                const itemId = $(this).data('id');
                deleteIds = [itemId];
                $('#deleteConfirmModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('item.category.destroy') }}",
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
                            window.location.href = "{{ route('item.category.list') }}";
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