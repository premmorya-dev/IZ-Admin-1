<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

    </style>

    <h2 class="py-3">Add New Upi Id</h2>


    <form action="{{ route('upi_id.store') }}" id="add-upi-id-form" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('upi_id.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-lucide="arrow-left"></i> Back
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm save-upi-id">
                    <i data-lucide="save"></i> Add
                </button>
            </div>
        </div>
        <div class="row">
            <!-- Client Form Fields -->
            <div class="col-md-3 mt-3">
                <label class="form-label">Upi Name</label>
                <input type="text" name="upi_name" value="{{ old('upi_name') }}" class="form-control" placeholder="Upi Name">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Upi Id</label>
                <input type="text" name="upi_id" value="{{ old('upi_id') }}" class="form-control" placeholder="Upi Id">
            </div>




            <div class="col-md-3 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Y" {{ old('status' )   == 'Y' ? 'selected' : '' }}>Active</option>
                    <option value="N" {{ old('status' )  == 'N' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

         

        </div>
    </form>

    <script>
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {

            document.querySelector('.save-upi-id').addEventListener('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('add-upi-id-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we save your client.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.action,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('.error').remove();
                        $('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.error === 1) {
                            $.each(response.errors, function(field, messages) {
                                let inputField = $('[name="' + field + '"]');
                                if (inputField.length) {
                                    inputField.addClass('is-invalid');
                                    const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;

                                    if (inputField.closest('.input-group').length) {
                                        inputField.closest('.input-group').after(errorHtml);
                                    } else if (inputField.hasClass('select2-hidden-accessible')) {
                                        inputField.next('.select2-container').after(errorHtml);
                                    } else {
                                        inputField.after(errorHtml);
                                    }
                                }
                            });

                            Swal.fire({
                                icon: "warning",
                                title: "Warning!",
                                text: "Please check the form carefully!",
                                position: "center",
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Upi Added Successfully!",
                                text: response.message,
                                position: "center",
                                toast: false, // make it popup centered, not small toast
                                showConfirmButton: false,
                                timer: 2000 // show for 2 seconds
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('upi_id.list') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        console.error("Error:", xhr.responseText);
                    }
                });
            });
        });
    </script>













</x-default-layout>