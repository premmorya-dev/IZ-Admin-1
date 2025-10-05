<form action="{{ route('invoice.record_payment') }}" id="payment-form" method="POST">
    @csrf

    <div class="modal-body row g-3">

        <!-- ===== Invoice Number and Client Name ===== -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Invoice Number</label>
            <input type="text" class="form-control-plaintext" value=" {{ $data->invoice_number }}" readonly>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Client Name</label>
            <input type="text" class="form-control-plaintext" value=" {{ $data->company_name ?? 'N/A' }}" readonly>
        </div>

        <!-- ===== Payment Input Fields ===== -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Amount</label>
            <input type="number" name="amount" value="{{ $data->total_due }}" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Payment Date</label>
            <input type="date" name="payment_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Payment Method</label>
            <select name="payment_method" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
                <option value="card">Card</option>
                <option value="upi">UPI</option>
                <option value="paypal">PayPal</option>
                <option value="stripe">Stripe</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Transaction Reference</label>
            <input type="text" name="transaction_reference" class="form-control">
        </div>

        <div class="col-12">
            <label class="form-label fw-semibold">Notes</label>
            <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>

    </div>

    <input type="hidden" name="invoice_id" value="{{ $data->invoice_id }}">

    <div class="modal-footer">
        <button id="save-payment" class="btn btn-success px-4 rounded-pill">
            <i class="fa-solid fa-check"></i> Submit Payment
        </button>
    </div>

</form>



<script>

$('#save-payment').on('click', function(e) {
                e.preventDefault(); 
                let formData = new FormData(document.getElementById('payment-form'));
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we processing your payment.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('invoice.record_payment') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('.error').remove();
                        $('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.error == 1) {
                            $.each(response.errors, function(field, messages) {
                                let inputField = $('[name="' + field + '"]');
                                if (inputField.length > 0) {
                                    inputField.addClass("is-invalid");

                                    if (inputField.closest('.input-group').length > 0) {
                                        inputField.closest('.input-group').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else if (inputField.hasClass('select2-hidden-accessible')) {
                                        inputField.next('.select2-container').after('<div class="text-danger error">' + messages[0] + '</div>');
                                    } else {
                                        inputField.after('<div class="text-danger error">' + messages[0] + '</div>');
                                    }
                                }
                            });

                            Swal.fire({
                                icon: "warning",
                                title: "Warning!",
                                text: "Please check the form carefully!",
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                timer: 3000
                            });





                        } else if (response.error == 0) {
                           
                            Swal.fire({
                                icon: "success",
                                title: "Payment recorded successfully!",
                                text: response.message,
                                toast: false,
                                position: "center",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Redirect after the alert closes
                                window.location.href = "{{ route('invoice.list') }}";
                            });



                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            });


</script>
