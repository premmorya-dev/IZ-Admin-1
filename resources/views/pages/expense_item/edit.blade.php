<x-default-layout>

    <h2 class="py-3">Edit expense_item</h2>

    <form action="{{ route('expense.item.update') }}" id="edit-expense_item-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="page-header-fixed mb-3 d-flex justify-content-between align-expense_items-center">
            <div>
                <a href="{{ route('expense.item.list') }}" class="btn btn-outline-secondary btn-sm">
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
                <label class="form-label">Name</label>
                <input type="text" name="expense_item_name" value="{{ old('expense_item_name', $data['expense_item']->expense_item_name) }}" class="form-control" placeholder="expense_item Name">
            </div>

          

            <div class="col-md-3 mt-3">
                <label class="form-label">Hsn/Sac</label>
                <input type="number" name="hsn_sac" value="{{ old('hsn_sac', $data['expense_item']->hsn_sac) }}" class="form-control" placeholder="hsn_sac">
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Unit Price</label>
                <input type="number" name="unit_price" value="{{ old('unit_price', $data['expense_item']->unit_price) }}" class="form-control" placeholder="unit_price">
            </div>

        

            <div class="col-md-3 mt-3">
                <label class="form-label">Type</label>
                <select name="expense_item_type" class="form-select">
                    <option value="product" {{ old('expense_item_type', $data['expense_item']->expense_item_type )   == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="service" {{ old('expense_item_type', $data['expense_item']->expense_item_type )  == 'service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Y" {{ old('status', $data['expense_item']->status )   == 'Y' ? 'selected' : '' }}>Active</option>
                    <option value="N" {{ old('status', $data['expense_item']->status )  == 'N' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="tax_id" class="form-label">Tax</label>
                <select id="tax_id" name="tax_id" class="form-select">
                    <option value="0">No Tax</option>
                    @foreach($data['taxes'] as $tax )
                    <option value="{{ $tax->tax_id }}" {{ old('tax_id', $data['expense_item']->tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mt-3">
                <label for="discount_id" class="form-label">Discount</label>
                <select id="discount_id" name="discount_id" class="form-select">
                    <option value="0">No Discount</option>
                    @foreach($data['discounts'] as $discount )
                    <option value="{{ $discount->discount_id }}" {{ old('discount_id', $data['expense_item']->discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="expense_item_code" value="{{   $data['expense_item']->expense_item_code }}">

        </div>
    </form>


    <script>
        const editors = {};
        document.addEventListener("DOMContentLoaded", function() {


            document.querySelector('.update-client').addEventListener('click', function(e) {
                e.preventDefault();



                const form = document.getElementById('edit-expense_item-form');
                const formData = new FormData(form);

                Swal.fire({
                    title: "Updating...",
                    text: "Please wait while we update the expense item.",
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
                                title: "Expense Item Updated Successfully!",
                                text: response.message,
                                position: "center",
                                toast: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
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