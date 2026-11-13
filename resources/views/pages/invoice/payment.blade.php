<style>
    .rp-form {
        --rp-primary: #2563EB;
        --rp-success: #16A34A;
        --rp-danger: #DC2626;
        --rp-border: #E5E7EB;
        --rp-text: #0F172A;
        --rp-muted: #64748B;
        --rp-bg: #F8FAFC;
        --rp-ease: .18s ease;
        font-family: 'Inter', sans-serif;
        color: var(--rp-text);
    }

    .rp-form .rp-body { padding: 24px; }

    /* ---------- Summary ---------- */
    .rp-form .rp-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        padding: 18px 20px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        box-shadow: 0 10px 24px -10px rgba(79, 70, 229, .55);
    }
    .rp-form .rp-summary__client { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .rp-form .rp-summary__name {
        margin: 0; font-weight: 600; font-size: 15px; color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px;
    }
    .rp-form .rp-summary__stats { display: flex; gap: 12px; }

    .rp-form .rp-avatar {
        width: 42px; height: 42px; flex-shrink: 0;
        display: grid; place-items: center;
        border-radius: 12px;
        font-weight: 700; font-size: 16px;
        background: rgba(255, 255, 255, .18);
        border: 1px solid rgba(255, 255, 255, .28);
    }

    .rp-form .rp-eyebrow {
        display: block;
        font-size: 11px; font-weight: 500;
        letter-spacing: .04em; text-transform: uppercase;
        opacity: .75; margin-bottom: 2px;
    }

    .rp-form .rp-stat {
        padding: 8px 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .12);
    }
    .rp-form .rp-stat__value { font-size: 15px; font-weight: 600; }
    .rp-form .rp-stat--due { background: rgba(255, 255, 255, .95); color: var(--rp-text); }
    .rp-form .rp-stat--due .rp-eyebrow { color: var(--rp-muted); opacity: 1; }
    .rp-form .rp-stat--due .rp-stat__value { color: var(--rp-success); font-size: 17px; }

    /* ---------- Labels ---------- */
    .rp-form .rp-label {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px; font-weight: 600; color: var(--rp-text);
    }
    .rp-form .rp-optional {
        font-size: 11px; font-weight: 500; color: var(--rp-muted);
        padding: 2px 8px; border-radius: 999px; background: #F1F5F9;
    }

    /* ---------- Inputs ---------- */
    .rp-form .rp-input {
        border-radius: 12px;
        transition: box-shadow var(--rp-ease);
    }
    .rp-form .rp-input .input-group-text {
        background: var(--rp-bg);
        border: 1px solid var(--rp-border);
        border-right: 0;
        border-radius: 12px 0 0 12px;
        color: var(--rp-muted);
        padding: 0 14px;
        transition: color var(--rp-ease), border-color var(--rp-ease);
    }
    .rp-form .rp-input .form-control,
    .rp-form .rp-input .form-select {
        height: 46px;
        border: 1px solid var(--rp-border);
        border-left: 0;
        border-radius: 0 12px 12px 0;
        font-size: 14px;
        box-shadow: none;
        transition: border-color var(--rp-ease);
    }
    .rp-form .rp-input .form-control::placeholder { color: #94A3B8; }

    .rp-form .rp-input:focus-within { box-shadow: 0 0 0 4px rgba(37, 99, 235, .12); }
    .rp-form .rp-input:focus-within .input-group-text { color: var(--rp-primary); border-color: var(--rp-primary); }
    .rp-form .rp-input:focus-within .form-control,
    .rp-form .rp-input:focus-within .form-select { border-color: var(--rp-primary); }

    .rp-form .rp-input--lg .input-group-text { padding: 0 16px; font-size: 18px; color: var(--rp-success); }
    .rp-form .rp-input--lg .form-control { height: 56px; font-size: 22px; font-weight: 700; letter-spacing: -.01em; }

    /* validation */
    .rp-form .rp-input:has(.is-invalid) .input-group-text,
    .rp-form .rp-input:has(.is-invalid) .form-control,
    .rp-form .rp-input:has(.is-invalid) .form-select { border-color: var(--rp-danger); }
    .rp-form .rp-input:has(.is-invalid) .input-group-text { color: var(--rp-danger); }
    .rp-form .rp-input:has(.is-invalid):focus-within { box-shadow: 0 0 0 4px rgba(220, 38, 38, .12); }

    .rp-form .form-control.is-invalid,
    .rp-form .form-select.is-invalid { background-image: none; }

    .rp-form .rp-textarea {
        border: 1px solid var(--rp-border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        resize: none;
        box-shadow: none;
        transition: border-color var(--rp-ease), box-shadow var(--rp-ease);
    }
    .rp-form .rp-textarea:focus { border-color: var(--rp-primary); box-shadow: 0 0 0 4px rgba(37, 99, 235, .12); }
    .rp-form .rp-textarea.is-invalid { border-color: var(--rp-danger); }

    /* error text injected by ajax handler */
    .rp-form .error {
        margin-top: 6px;
        font-size: 12px; font-weight: 500;
        color: var(--rp-danger) !important;
    }

    /* ---------- Footer ---------- */
    .rp-form .rp-footer {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px;
        padding: 16px 24px;
        background: var(--rp-bg);
        border-top: 1px solid var(--rp-border);
        border-radius: 0 0 18px 18px;
    }
    .rp-form .rp-footer__hint { align-items: center; gap: 6px; font-size: 12px; color: var(--rp-muted); }
    .rp-form .rp-footer__hint i { color: var(--rp-success); font-size: 14px; }
    .rp-form .rp-footer__actions { display: flex; gap: 10px; margin-left: auto; }

    .rp-form .rp-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 44px; padding: 0 20px;
        border-radius: 12px;
        font-size: 14px; font-weight: 600;
        transition: transform var(--rp-ease), box-shadow var(--rp-ease), background var(--rp-ease);
    }
    .rp-form .rp-btn--ghost { background: #fff; color: var(--rp-text); border: 1px solid var(--rp-border); }
    .rp-form .rp-btn--ghost:hover { background: #F1F5F9; }
    .rp-form .rp-btn--success {
        color: #fff; border: 0;
        background: linear-gradient(135deg, #22C55E, var(--rp-success));
        box-shadow: 0 6px 14px -6px rgba(22, 163, 74, .7);
    }
    .rp-form .rp-btn--success:hover {
        color: #fff; transform: translateY(-1px);
        box-shadow: 0 10px 20px -8px rgba(22, 163, 74, .8);
    }
    .rp-form .rp-btn--success:active { transform: translateY(0); }

    /* ---------- Responsive ---------- */
    @media (max-width: 767.98px) {
        .rp-form .rp-body { padding: 18px; }
        .rp-form .rp-summary { padding: 16px; }
        .rp-form .rp-summary__stats { width: 100%; }
        .rp-form .rp-summary__stats .rp-stat { flex: 1; }
        .rp-form .rp-footer { padding: 14px 18px; }
        .rp-form .rp-footer__actions { width: 100%; }
        .rp-form .rp-footer__actions .rp-btn { flex: 1; }
    }
</style>

<form action="{{ route('invoice.record_payment') }}" id="payment-form" method="POST" class="rp-form">
    @csrf

    <div class="modal-body rp-body">

        {{-- ===== Summary ===== --}}
        <div class="rp-summary">
            <div class="rp-summary__client">
                <span class="rp-avatar">{{ strtoupper(mb_substr($data->company_name ?? 'N', 0, 1)) }}</span>
                <div class="rp-summary__text">
                    <span class="rp-eyebrow">Client</span>
                    <h6 class="rp-summary__name">{{ $data->company_name ?? 'N/A' }}</h6>
                </div>
            </div>

            <div class="rp-summary__stats">
                <div class="rp-stat">
                    <span class="rp-eyebrow">Invoice</span>
                    <strong class="rp-stat__value">#{{ $data->invoice_number }}</strong>
                </div>
                <div class="rp-stat rp-stat--due">
                    <span class="rp-eyebrow">Amount due</span>
                    <strong class="rp-stat__value">{{ number_format((float) $data->total_due, 2) }}</strong>
                </div>
            </div>
        </div>

        {{-- ===== Payment details ===== --}}
        <div class="row g-3">

            <div class="col-12">
                <label class="rp-label" for="rp-amount">Amount received</label>
                <div class="input-group rp-input rp-input--lg">
                    <span class="input-group-text"><i class="bi bi-wallet2"></i></span>
                    <input type="number" id="rp-amount" name="amount" value="{{ $data->total_due }}"
                           class="form-control" step="any" placeholder="0.00" required>
                </div>
            </div>

            <div class="col-md-6">
                <label class="rp-label" for="rp-date">Payment date</label>
                <div class="input-group rp-input">
                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                    <input type="date" id="rp-date" name="payment_date" class="form-control"
                           value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <label class="rp-label" for="rp-method">Payment method</label>
                <div class="input-group rp-input">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                    <select id="rp-method" name="payment_method" class="form-select" required>
                        <option value="cash">Cash</option>
                        <option value="bank">Bank</option>
                        <option value="card">Card</option>
                        <option value="upi">UPI</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <label class="rp-label" for="rp-ref">
                    Transaction reference <span class="rp-optional">Optional</span>
                </label>
                <div class="input-group rp-input">
                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                    <input type="text" id="rp-ref" name="transaction_reference" class="form-control"
                           placeholder="e.g. UTR / Txn ID / Cheque no.">
                </div>
            </div>

            <div class="col-12">
                <label class="rp-label" for="rp-notes">
                    Notes <span class="rp-optional">Optional</span>
                </label>
                <textarea id="rp-notes" name="notes" class="form-control rp-textarea" rows="3"
                          placeholder="Add an internal note about this payment..."></textarea>
            </div>

        </div>
    </div>

    <input type="hidden" name="invoice_id" value="{{ $data->invoice_id }}">

    <div class="modal-footer rp-footer">
        <span class="rp-footer__hint d-none d-md-inline-flex">
            <i class="bi bi-shield-check"></i> Recorded securely against this invoice
        </span>
        <div class="rp-footer__actions">
            <button type="button" class="btn rp-btn rp-btn--ghost" data-bs-dismiss="modal">Cancel</button>
            <button id="save-payment" class="btn rp-btn rp-btn--success">
                <i class="bi bi-check2-circle"></i> Record payment
            </button>
        </div>
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