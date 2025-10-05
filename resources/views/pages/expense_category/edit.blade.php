<x-default-layout>

    <h2 class="py-3">Edit Expense Category </h2>

    <form action="{{ route('expense.category.update') }}" id="edit-expense-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-expenses-center">
            <div>
                <a href="{{ route('expense.category.list') }}" class="btn btn-outline-secondary btn-sm">
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
          
            <div class="col-md-12 mt-3">
                <label class="form-label">Name</label>
                <input type="text" name="expense_category_name" value="{{ old('expense_category_name', $data['expense_categories']->expense_category_name) }}" class="form-control" placeholder="expense Name">
            </div>

         

            <input type="hidden" name="expense_category_code" value="{{   $data['expense_categories']->expense_category_code }}">

        </div>
    </form>


    <script>
        const editors = {};
        document.addEventListener("DOMContentLoaded", function() {


            document.querySelector('.update-client').addEventListener('click', function(e) {
                e.preventDefault();



                const form = document.getElementById('edit-expense-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Updating...",
                    text: "Please wait while we update the expense category.",
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
                                title: "Expense Category Updated Successfully!",
                                text: response.message,
                                position: "center",
                                toast: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                window.location.href = "{{ route('expense.category.list') }}";
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