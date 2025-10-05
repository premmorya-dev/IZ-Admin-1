<x-default-layout>
    <link href="{{ asset('assets/css/is.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

    </style>

    <h2 class="py-3">Add New Expense Item</h2>


    <form action="{{ route('expense.item.store') }}" id="add-expense_item-form" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-expense_items-center">
            <div>
                <a href="{{ route('expense.item.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-lucide="arrow-left"></i> Back
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm save-expense_item">
                    <i data-lucide="save"></i> Add
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Client Form Fields -->

          


            <div class="col-md-3 mt-3">
                <label class="form-label">Name</label>
                <input type="text" name="expense_item_name" value="{{ old('expense_item_name') }}" class="form-control" placeholder="expense_item Name">
            </div>

         
            <div class="col-md-3 mt-3">
                <label class="form-label">Hsn/Sac</label>
                <input type="number" name="hsn_sac" value="{{ old('hsn_sac') }}" class="form-control" placeholder="HSN/SAC">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Unit Price</label>
                <input type="number" name="unit_price" value="{{ old('unit_price') }}" class="form-control" placeholder="Unit Price">
            </div>

           

            <div class="col-md-3 mt-3">
                <label class="form-label">Type</label>
                <select name="expense_item_type" class="form-select">
                    <option value="product" {{ old('expense_item_type' )   == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="service" {{ old('expense_item_type' )  == 'service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Y" {{ old('status' )   == 'Y' ? 'selected' : '' }}>Active</option>
                    <option value="N" {{ old('status' )  == 'N' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="tax_id" class="form-label">Tax</label>
                <select id="tax_id" name="tax_id" class="form-select">
                    <option value="0">No Tax</option>
                    @foreach($data['taxes'] as $tax )
                    <option value="{{ $tax->tax_id }}" {{ old('tax_id') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="discount_id" class="form-label">Discount</label>
                <select id="discount_id" name="discount_id" class="form-select">
                    <option value="0">No Discount</option>
                    @foreach($data['discounts'] as $discount )
                    <option value="{{ $discount->discount_id }}" {{ old('discount_id') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                    @endforeach
                </select>
            </div>



        </div>
    </form>

    <script>
        const editors = {};

        document.addEventListener("DOMContentLoaded", function() {

            document.querySelector('.save-expense_item').addEventListener('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('add-expense_item-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we save your expense item.",
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
                                title: "Expense Item Added Successfully!",
                                text: response.message,
                                position: "center",
                                toast: false, // make it popup centered, not small toast
                                showConfirmButton: false,
                                timer: 2000 // show for 2 seconds
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('expense.item.list') }}";
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