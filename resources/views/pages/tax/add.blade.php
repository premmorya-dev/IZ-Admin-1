<form action="{{ route('tax.store') }}" id="add-tax-form" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-4">
            <div class="row g-4">

                {{-- Tax Name --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-percent me-1"></i> Tax Name</label>
                    <input type="text" name="name" id="id_name" class="form-control"
                        value="{{ old('name', optional($data['tax'] ?? null)->name) }}"
                        placeholder="Enter tax name">
                </div>

                {{-- Percent --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-calculator me-1"></i> Percent (%)</label>
                    <input type="number" step="0.01" name="percent" id="id_percent" class="form-control"
                        value="{{ old('percent', optional($data['tax'] ?? null)->percent) }}"
                        placeholder="Enter percent">
                </div>

                {{-- Status --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold"><i class="fas fa-toggle-on me-1"></i> Status</label>
                    <select name="status" id="id_status" class="form-select">
                        <option value="Y" {{ optional($data['tax'] ?? null)->status == 'Y' ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ optional($data['tax'] ?? null)->status == 'N' ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>


            </div>
        </div>

        <div class="card-footer bg-light text-end rounded-bottom-4">

            <button type="submit" class="btn btn-success px-4 save-tax w-100">
                <i class="fas fa-save me-1"></i> Save Tax
            </button>
        </div>
    </div>
</form>


<script>
    document.querySelector('.save-tax').addEventListener('click', function(e) {
        e.preventDefault();


        const form = document.getElementById('add-tax-form');
        const formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your tax.",
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
                        title: "Tax Added Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#tax-modal').modal('hide');

                        // Append new tax into the dropdown

                        if (
                            window.location.href.includes("/invoice/add") || window.location.href.includes("/invoice/edit") ||
                            window.location.href.includes("/estimate/add") || window.location.href.includes("/estimate/edit") ||
                            window.location.href.includes("/expense/add") || window.location.href.includes("/expense/edit")
                        ) {
                            let newTax = response.data; // make sure backend returns {id, name, percent}
                            let optionText = `${newTax.name} (${newTax.percent}%)`;
                            // find your select (adjust selector if multiple exist)
                            let $select = $(".tax-select");
                            // add new option before "Add New"
                            let newOption = $(`<option>`)
                                .val(newTax.percent)
                                .attr("tax-id", newTax.tax_id)
                                .text(optionText);

                            // Insert before "Add New Discount"
                            $select.find("option[value='new']").before(newOption);

                            // Select the new option
                            $select.val(newTax.percent);

                            // Trigger change if needed
                            $select.trigger("change");
                            calculateInvoice();
                        } else {
                            location.reload();
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