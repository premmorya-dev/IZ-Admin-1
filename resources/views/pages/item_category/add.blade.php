


<form action="{{ route('item.category.store') }}" id="item-form" method="POST" enctype="multipart/form-data">
     @csrf
        @method('POST')
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-4">
            <div class="row g-4">

             <div class="col-md-12 mt-3">
                <label class="form-label">Name</label>
                <input type="text" name="item_category_name" id="id_item_category_name"  value="{{ old('item_category_name') }}" class="form-control" placeholder="Item Name">
            </div>       

           
            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">
            <button type="submit" class="btn btn-success px-4 w-100 add-item-category w-100">
                <i class="fas fa-save me-1"></i> Add Item Category
            </button>
        </div>
    </div>
</form>



<script>
    document.querySelector('.add-item-category').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('item-form');
        const formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we add your Item Category.",
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
                        let inputField = $('#id_' + field);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;

                            if (inputField.closest('.input-group').length) {
                                inputField.closest('.input-group').after(errorHtml);
                            } else if (inputField.hasClass('choices__input')) {
                                console.log(inputField)
                                inputField.parent().after(errorHtml);
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
                        title: "Item Category Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#editItem-modal').modal('hide');
                        location.reload();
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
</script>