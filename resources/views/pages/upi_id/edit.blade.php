<x-default-layout>

   <h2 class="py-3" >Edit Upi Ids</h2>

    <form action="{{ route('upi_id.update') }}" id="edit-upi-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('upi_id.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-lucide="arrow-left"></i> Back
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm update-client">
                    <i data-lucide="save"></i> Update
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Client Form Fields -->
            <div class="col-md-3 mt-3">
                <label class="form-label">Upi Name</label>
                <input type="text" name="upi_name" value="{{ old('upi_name', $data['upi_id']->upi_name) }}" class="form-control" placeholder="Upi Name">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Upi Id</label>
                <input type="text" name="upi_id" value="{{ old('upi_id', $data['upi_id']->upi_id) }}" class="form-control" placeholder="Upi Id">
            </div>       
        


          
            <div class="col-md-3 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Y" {{ old('status', $data['upi_id']->status )   == 'Y' ? 'selected' : '' }}>Active</option>
                    <option value="N" {{ old('status', $data['upi_id']->status )  == 'N' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <input type="hidden" name="upi_log_id" value="{{   $data['upi_id']->upi_log_id }}" >

        </div>
    </form>

    
    <script>
        const editors = {};
        document.addEventListener("DOMContentLoaded", function() {
          

            document.querySelector('.update-client').addEventListener('click', function(e) {
                e.preventDefault();

               

                const form = document.getElementById('edit-upi-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Updating...",
                    text: "Please wait while we update the client.",
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
                                text: "Please fix the errors.",
                                position: "center",
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Upi Id Updated Successfully!",
                                text: response.message,
                                position: "center",
                                toast: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
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
