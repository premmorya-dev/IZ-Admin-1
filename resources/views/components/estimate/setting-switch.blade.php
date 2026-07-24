<div class="invoice-options">

    <!-- UPI -->
    <div class="invoice-option">

        <div class="option-left">

            <div class="option-icon">
                <i class="bi bi-qr-code"></i>
            </div>

            <div>
                <h6>UPI Payment</h6>
                <p>Accept payments using UPI.</p>
            </div>

        </div>

        <div class="form-check form-switch">
            <input class="form-check-input"
                type="checkbox"
                id="useUpiToggle"
                name="upi_id_payment_status">
        </div>

    </div>

   
    <!-- Shipping -->
    <div class="invoice-option">

        <div class="option-left">

            <div class="option-icon">
                <i class="bi bi-truck"></i>
            </div>

            <div>
                <h6>Shipping</h6>
                <p>Show shipping section.</p>
            </div>

        </div>

        <div class="form-check form-switch">
            <input class="form-check-input"
                type="checkbox"
                id="display_shipping_status"
                name="display_shipping_status"
                {{ old('display_shipping_status', !empty($data['estimate']->display_shipping_status) && $data['estimate']->display_shipping_status == 'Y' ? 'checked' : '') }}>
        </div>

    </div>

</div>