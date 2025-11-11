<x-default-layout>

    <h2 class="py-3">Client</h2>



    <!-- Accordion Container -->


    @include('pages/client.filter')
    <div class="d-flex justify-content-between align-items-center my-4 px-2">
        <a href="#" id="bulkDeleteBtn" title="Delete Invoice" data-bs-toggle="modal" data-bs-target="#deleteModal"
            class="btn btn-outline-danger btn-sm px-4 py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center gap-2">
            <i data-lucide="trash-2"></i> Delete
        </a>
        <!-- Add Button -->
        <a class="btn btn-outline-primary btn-sm px-4 new-client py-2 shadow-sm fw-semibold text-uppercase d-flex align-items-center gap-2"
            id="add-action" href="{{ route('client.add') }}"> <i data-lucide="plus-circle"></i> Add New</a>

    </div>

    <!-- Lucide Init -->


    </div>

    <div class="listing-grid">

        <!-- Header -->
        <div class="listing-header">
            <div class="checkbox-col">
                <input class="form-check-input client_id checkbox-border-color" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault">
                <span class="d-block d-md-none text-center fw-bold ms-1"> Select All </span>
            </div>

            <div class="col sortable"><i data-lucide="file-text"></i> @sortablelink('client_name','Name') </div>
            <div class="col sortable"><i data-lucide="letter-text"></i> @sortablelink('company_name','Company') </div>
            <div class="col sortable"><i data-lucide="shield-check"></i> @sortablelink('status','Status') </div>
            <div class="col sortable"><i data-lucide="letter-text"></i> @sortablelink('email','Email') </div>
            <div class="col sortable"><i data-lucide="file-digit"></i> @sortablelink('phone','Phone') </div>
            <div class="col sortable"><i data-lucide="calendar"></i> @sortablelink('created_at','Created At') </div>



            <div class="col "><i data-lucide="more-vertical"></i> <span>Action</span> <span></span></div>
        </div>

        <!-- Row -->

        @if ( $data['clients'] )
        @foreach ($data['clients'] as $index => $client )


        <div class="listing-row">

            <div class="checkbox-col">
                <input class="form-check-input selected checkbox-border-color" name="selected[]" type="checkbox" value="{{ $client->client_code }}" id="flexCheckDefault">

            </div>


            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold" > Name </span>
                <span>
                    <a href="#" client-code="{{ $client->client_code }}" class="edit-client" title="Client Detail"> {{ $client->client_name }} </a>
                </span>


            </div>


            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold">Company </span>
                <span> {{ $client->company_name ?? 'N/A' }} </span>

            </div>

            @php
            $badgeClasses = [
            'active' => 'badge text-bg-success text-white',
            'deactive' => 'badge text-bg-danger text-white',

            ];
            @endphp

            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Status </span>
                <span class="{{ $badgeClasses[$client->status] ?? 'badge text-bg-dark' }}"> {{ ucfirst($client->status) }}</span>

            </div>

            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Email </span>
                <span>{{ $client->email ?? 'N/A' }}</span>

            </div>
            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Phone </span>
                <span> {{ $client->phone  ?? 'N/A' }}</span>

            </div>


            <div class="col">
                <span class="d-block d-md-none text-center mt-2 fw-bold"> Create At </span>
                <span> {{ $client->created_at }}</span>

            </div>
            <div class="col"> <span></span> <span>@include('pages/client/actions/edit_action') </span> </div>





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




    <!-- Bootstrap 5 Delete Confirm Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white rounded-top-3">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected client(s)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Model -->
    <div class="modal fade" id="Client-modal" tabindex="-1" aria-labelledby="ClientModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title " id="ClientModalLabel">New Client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="Client-modal-body py-3 px-3">

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
            $('.editClient-modal-body').empty();
            $('.Client-modal-body').empty();
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
                        // Destroy any existing CKEditor instances before loading new HTML
                        for (let id in editors) {
                            if (editors[id]) {
                                editors[id].destroy().catch(() => {});
                                editors[id] = null;
                            }
                        }
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
        $(document).on('click', '.new-client', function(e) {
            e.preventDefault();
            $('.editClient-modal-body').empty();
            $('.Client-modal-body').empty();
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

                        $('.Client-modal-body').html(response);
                        $('#Client-modal').modal('show');

                        $('#Client-modal').on('shown.bs.modal', function() {
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

            $(document).on('change', '.selected, .client_id', function() {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    document.getElementById('bulk-action-section').style.visibility = 'visible';


                } else {

                    console.log("Checkbox unchecked: ");
                    var q_id = [];
                    $(".selected:checked").each(function() {
                        q_id.push($(this).val());
                    });
                    if (q_id === undefined || q_id === null || q_id === '' || q_id.length == 0) {
                        document.getElementById('bulk-action-section').style.visibility = 'hidden';
                    }
                }
            });



            $(document).on('click', '#bulk-action-update', function(e) {
                e.preventDefault();
                try {

                    $.ajax({
                        url: "",
                        data: new FormData(document.querySelector('#bulk-notification-action')),
                        processData: false,
                        contentType: false,
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
                        success: function(result) {
                            if (result.error == 0) {
                                window.location.reload();
                            }

                            if (result.error == 1) {
                                $('#errors').show();
                                $('#errors').text(result.message);
                            }

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

                form.find('input[name="client_ids[]"]').remove(); // clear old values

                if (selectedInvoices.length === 0) {
                    alert("Please select at least one invoice.");
                    return;
                }

                selectedInvoices.each(function() {
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'client_ids[]')
                        .val($(this).val())
                        .appendTo(form);
                });

                form.submit(); // Normal form POST → Laravel returns ZIP → Browser prompts download
            });

            $('#bulk-invoice-downloadsss').on('click', function(e) {

            })




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
                        client_ids: selected
                    },
                    success: function(response) {
                        $('#emailConfirmModal').modal('hide');
                        alert("Emails queued successfully!");
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
                const clientId = $(this).data('id');
                deleteIds = [clientId];
                $('#deleteConfirmModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('client.destroy') }}",
                    method: "POST",
                    data: {
                        ids: deleteIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteConfirmModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2500,
                            showConfirmButton: false
                        }).then(() => {
                            toggleBulkButton();
                            location.reload();
                        });
                        // Disable bulk delete button again

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