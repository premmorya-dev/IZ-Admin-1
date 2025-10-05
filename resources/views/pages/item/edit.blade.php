<form action="{{ route('item.update') }}" id="edit-item-form" method="POST" enctype="multipart/form-data">
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-4">
            <div class="row g-4">

                <div class="col-md-12 mt-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="item_name" id="id_item_name" value="{{ old('item_name', $data['item']->item_name) }}" class="form-control" placeholder="Item Name">
                </div>

                <div class="col-md-12 mt-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="id_description" class="form-control" placeholder="Item Description" rows="5">{{ old('description', $data['item']->description) }}</textarea>

                </div>


                <div class="col-md-12 mt-3">
                    <label for="item_category_id" class="form-label">Category</label>
                    <select id="item_category_id" name="item_category_id" id="id_item_category_id" class="form-select">
                        <option value="0"><-- Select --></option>
                        @foreach($data['item_categories'] as $item_categories )
                        <option value="{{ $item_categories->item_category_id }}" {{ old('item_category_id', $data['item']->item_category_id ?? '') == $item_categories->item_category_id ? 'selected' : '' }}>{{ $item_categories->item_category_name }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-6 mt-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" id="id_sku" value="{{ old('sku', $data['item']->sku) }}" class="form-control" placeholder="SKU">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Hsn/Sac</label>
                    <input type="number" name="hsn_sac" id="id_hsn_sac" value="{{ old('hsn_sac', $data['item']->hsn_sac) }}" class="form-control" placeholder="HSN/SAC">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Unit Price</label>
                    <input type="number" name="unit_price" id="id_unit_price" value="{{ old('unit_price', $data['item']->unit_price) }}" class="form-control" placeholder="unit_price">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" id="id_stock" value="{{ old('stock', $data['item']->stock) }}" class="form-control" placeholder="Stock">
                </div>


                <div class="col-md-6 mt-3">
                    <label class="form-label">Purchase Price</label>
                    <input type="number" name="cost_price" id="id_cost_price" value="{{ old('cost_price', $data['item']->cost_price) }}" class="form-control" placeholder="Purchase Price">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Selling Price</label>
                    <input type="number" name="selling_price" id="id_selling_price" value="{{ old('selling_price', $data['item']->selling_price) }}" class="form-control" placeholder="Selling Price">
                </div>


                <div class="col-md-6 mt-3">
                    <label class="form-label">Type</label>
                    <select name="item_type" id="id_item_type" class="form-select">
                        <option value="product" {{ old('item_type', $data['item']->item_type )   == 'product' ? 'selected' : '' }}>Product</option>
                        <option value="service" {{ old('item_type', $data['item']->item_type )  == 'service' ? 'selected' : '' }}>Service</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="id_status" class="form-select">
                        <option value="Y" {{ old('status', $data['item']->status )   == 'Y' ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ old('status', $data['item']->status )  == 'N' ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="tax_id" class="form-label">Tax</label>
                    <select id="id_status" name="tax_id" class="form-select">
                        <option value="0">No Tax</option>
                        @foreach($data['taxes'] as $tax )
                        <option value="{{ $tax->tax_id }}" {{ old('tax_id', $data['item']->tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="discount_id" class="form-label">Discount</label>
                    <select id="id_discount_id" name="discount_id" class="form-select">
                        <option value="0">No Discount</option>
                        @foreach($data['discounts'] as $discount )
                        <option value="{{ $discount->discount_id }}" {{ old('discount_id', $data['item']->discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="item_code" value="{{   $data['item']->item_code }}">
            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">
            <button type="submit" class="btn btn-success px-4 w-100 update-item">
                <i class="fas fa-save me-1"></i> Update Item
            </button>
        </div>
    </div>
</form>


<script>
    document.querySelector('.update-item').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('edit-item-form');
        const formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we update your Item.",
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
                        title: "Item Updated Successfully!",
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