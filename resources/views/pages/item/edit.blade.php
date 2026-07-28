<div class="item-form-wrap">
    <form action="{{ route('item.update') }}" id="edit-item-form" method="POST" enctype="multipart/form-data">

        <div class="iz-edit-layout">

            <!-- ============ LEFT: main, frequently-edited fields ============ -->
            <div class="iz-card">

                <!-- Basic Info -->
                <div class="iz-section">
                    <div class="iz-section-title">
                        <div class="iz-icon-chip iz-chip-indigo"><i class="fas fa-info-circle text-white"></i></div>
                        <div>
                            <h6>Basic Information</h6>
                            <span class="iz-sub">Name, description &amp; category</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-tag iz-label-icon"></i>Name<span class="req">*</span>
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="This name will appear on the invoice and item list shown to customers.">?</button>
                            </label>
                            <input type="text" name="item_name" id="id_item_name" value="{{ old('item_name', $data['item']->item_name ?? '' ) }}" class="form-control" placeholder="e.g. Premium Website Design">
                        </div>

                        <div class="col-md-6">
                            <label for="item_category_id" class="form-label">
                                <i class="fas fa-layer-group iz-label-icon"></i>Category
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Group similar items together for easier organization.">?</button>
                            </label>
                            <select id="item_category_id" name="item_category_id" class="form-select">
                                <option value="0">-- Select --</option>
                                @foreach($data['item_categories'] as $item_categories )
                                <option value="{{ $item_categories->item_category_id }}" {{ old('item_category_id', $data['item']->item_category_id ?? '') == $item_categories->item_category_id ? 'selected' : '' }}>{{ $item_categories->item_category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-barcode iz-label-icon"></i>SKU
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Your own internal stock or tracking code. Optional.">?</button>
                            </label>
                            <input type="text" name="sku" id="id_sku" value="{{ old('sku', $data['item']->sku ?? '' ) }}" class="form-control" placeholder="e.g. SKU-00123">
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-align-left iz-label-icon"></i>Description
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Optional. A short detail about the item, may also appear on the invoice PDF.">?</button>
                            </label>
                            <textarea name="description" id="id_description" class="form-control" placeholder="Brief description of the item" rows="3">{{ old('description', $data['item']->description ?? '' ) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="iz-section">
                    <div class="iz-section-title">
                        <div class="iz-icon-chip iz-chip-emerald"><i class="fas fa-tags text-white"></i></div>
                        <div>
                            <h6>Pricing &amp; Stock</h6>
                            <span class="iz-sub">Tax code, price &amp; inventory</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-hashtag iz-label-icon"></i>HSN/SAC<span class="req">*</span>
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Required for GST invoices. Use HSN code for products, SAC code for services.">?</button>
                            </label>
                            <input type="number" name="hsn_sac" id="id_hsn_sac" value="{{ old('hsn_sac', $data['item']->hsn_sac ?? '' ) }}" class="form-control" placeholder="HSN/SAC code">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-boxes-stacked iz-label-icon"></i>Stock<span class="req">*</span>
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Current available quantity. Updates automatically as sales happen.">?</button>
                            </label>
                            <input type="number" name="stock" id="id_stock" value="{{ old('stock', $data['item']->stock ?? '' ) }}" class="form-control" placeholder="Available quantity">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-indian-rupee-sign iz-label-icon"></i>Unit Price<span class="req">*</span>
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="The default rate used when this item is added to an invoice.">?</button>
                            </label>
                            <div class="iz-input-prefix">
                                <input type="number" name="unit_price" id="id_unit_price" value="{{ old('unit_price', $data['item']->unit_price ?? '' ) }}" class="form-control" placeholder="₹0.00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-cart-shopping iz-label-icon"></i>Purchase Price
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="What this item costs you. Used to calculate your profit margin.">?</button>
                            </label>
                            <div class="iz-input-prefix">
                                <input type="number" name="cost_price" id="id_cost_price" value="{{ old('cost_price', $data['item']->cost_price ?? '' ) }}" class="form-control" placeholder="₹0.00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-money-bill-trend-up iz-label-icon"></i>Selling Price
                                <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Use this if you want a selling price different from the unit price.">?</button>
                            </label>
                            <div class="iz-input-prefix">
                                <input type="number" name="selling_price" id="id_selling_price" value="{{ old('selling_price', $data['item']->selling_price ?? '' ) }}" class="form-control" placeholder="₹0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ RIGHT: sticky sidebar, secondary settings ============ -->
            <div class="iz-edit-sidebar">

                <div class="iz-card">
                    <div class="iz-card-header">
                        <h5><i class="fas fa-sliders-h"></i> Type &amp; Status</h5>
                        <p>Item type &amp; visibility</p>
                    </div>
                    <div class="iz-section">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-cube iz-label-icon"></i>Type
                                    <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose Service to hide or ignore stock tracking for this item.">?</button>
                                </label>
                                <select name="item_type" id="id_item_type" class="form-select">
                                    <option value="product" {{ old('item_type', $data['item']->item_type ?? ''  ) == 'product' ? 'selected' : '' }}>Product</option>
                                    <option value="service" {{ old('item_type', $data['item']->item_type  ?? '' ) == 'service' ? 'selected' : '' }}>Service</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on iz-label-icon"></i>Status
                                    <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivated items will not appear in the invoice creation list.">?</button>
                                </label>
                                <select name="status" id="id_status" class="form-select">
                                    <option value="Y" {{ old('status', $data['item']->status ?? ''  ) == 'Y' ? 'selected' : '' }}>Active</option>
                                    <option value="N" {{ old('status', $data['item']->status ?? '' ) == 'N' ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="iz-card">
                    <div class="iz-card-header">
                        <h5><i class="fas fa-percentage"></i> Tax &amp; Discount</h5>
                        <p>Applicable tax slab and discount</p>
                    </div>
                    <div class="iz-section">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tax_id" class="form-label">
                                    <i class="fas fa-receipt iz-label-icon"></i>Tax
                                    <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="This tax rate will be auto-applied to this item on invoices.">?</button>
                                </label>
                                <select id="id_tax_id" name="tax_id" class="form-select">
                                    <option value="0">No Tax</option>
                                    @foreach($data['taxes'] as $tax )
                                    <option value="{{ $tax->tax_id }}" {{ old('tax_id', $data['item']->tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="discount_id" class="form-label">
                                    <i class="fas fa-ticket iz-label-icon"></i>Discount
                                    <button type="button" class="iz-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Optional. A pre-defined discount that will auto-apply to this item.">?</button>
                                </label>
                                <select id="id_discount_id" name="discount_id" class="form-select">
                                    <option value="0">No Discount</option>
                                    @foreach($data['discounts'] as $discount )
                                    <option value="{{ $discount->discount_id }}" {{ old('discount_id', $data['item']->discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="item_code" value="{{ $data['item']->item_code }}">

        <!-- Sticky save bar — hamesha visible, end tak scroll karne ki zaroorat nahi -->
       
        <x-invoice.sticky-actions
            submitText="Update Item"
            submitClass="update-item" />


    </form>
</div>
<script>
// Initialize Bootstrap 5 tooltips scoped to this form only
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = document.querySelectorAll('.item-form-wrap [data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});
</script>


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