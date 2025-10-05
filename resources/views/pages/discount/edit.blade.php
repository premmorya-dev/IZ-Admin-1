<form action="{{ route('discount.update') }}" id="edit-discount-form" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- Discount Name --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i> Discount Name</label>
                    <input type="text" name="name" id="id_name" class="form-control"
                        value="{{ old('name', optional($data['discount'] ?? null)->name) }}"
                        placeholder="Enter discount name">
                </div>

                {{-- Percent --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-calculator me-1"></i> Percent (%)</label>
                    <input type="number" step="0.01" name="percent" id="id_percent" class="form-control"
                        value="{{ old('percent', optional($data['discount'] ?? null)->percent) }}"
                        placeholder="Enter percent">
                </div>

                {{-- Status --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-toggle-on me-1"></i> Status</label>
                    <select name="status" id="id_status" class="form-select">
                        <option value="Y" {{ optional($data['discount'] ?? null)->status == 'Y' ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ optional($data['discount'] ?? null)->status == 'N' ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <input type="hidden" name="discount_id" id="id_discount_id" value="{{ optional($data['discount'] ?? null)->discount_id }}">
            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">
        
            <button type="submit" class="btn btn-success px-4 update-discount w-100">
                <i class="fas fa-save me-1"></i> Update
            </button>
        </div>
    </div>
</form>

<script>
    document.querySelector('.update-discount').addEventListener('click', function(e) {
        e.preventDefault();

        const form = document.getElementById('edit-discount-form');
        const formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your discount.",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
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
                        title: "Discount Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        // If used inside a modal, close it and reload; otherwise go back to list
                        if ($('#editDiscount-modal').length) {
                            $('#editDiscount-modal').modal('hide');
                            location.reload();
                        } else {
                            window.location.href = "{{ route('discount.list') }}";
                        }
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