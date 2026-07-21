

<div class="invoice-summary bg-blue">

    <!-- Header -->
   <div class="summary-header mt-3">

    <div class="summary-header-left">

        <div class="summary-icon">
            <i data-lucide="receipt-text"></i>
        </div>

        <div>

            <h6>Invoice Summary</h6>

            <span>Auto updated</span>

        </div>

    </div>

    <div class="summary-live">

        <span class="live-dot"></span>

        Live

    </div>

</div>


    <!-- Grand Total -->

    <div class="summary-total-card">

        <div class="summary-total-label">

            Grand Total

        </div>

        <div
            class="summary-total-value"
            id="grand-total">

            $0.00

        </div>

    </div>



    <!-- Summary Card -->

    <div class="summary-card">



        <!-- Balance -->

        <div class="summary-balance">

            <div>

                <span>

                    Balance Due

                </span>

                <small>

                    Amount remaining

                </small>

            </div>

            <strong id="remaining-balance">

                $0.00

            </strong>

        </div>



        <!-- Divider -->

        <div class="summary-divider"></div>



        <!-- Subtotal -->

        <div class="summary-row">

            <span>

                Subtotal

            </span>

            <strong id="subtotal">

                $0.00

            </strong>

        </div>



        <!-- Discount -->

        <div class="summary-row">

            <span>

                Discount

            </span>

            <strong
                class="text-danger"
                id="total-discount">

                -$0.00

            </strong>

        </div>



        <!-- Tax -->

        <div class="summary-row">

            <span>

                Tax

            </span>

            <strong id="total-tax">

                $0.00

            </strong>

        </div>



        <!-- Tax Button -->

        <button
            type="button"
            class="tax-btn"
            id="toggleTax">

            <span>

                Tax Breakdown

            </span>

            <i
                data-lucide="chevron-down"
                class="tax-arrow">

            </i>

        </button>



        <!-- Tax Details -->

        <div
            id="taxBreakdown"
            style="display:none;">



            <div class="summary-divider mt-3 mb-2"></div>



            <div class="summary-row same-state-class">

                <span>

                    CGST

                </span>

                <strong id="total-cgst">

                    $0.00

                </strong>

            </div>



            <div class="summary-row same-state-class">

                <span>

                    SGST

                </span>

                <strong id="total-sgst">

                    $0.00

                </strong>

            </div>



            <div class="summary-row diffrent-state-class">

                <span>

                    IGST

                </span>

                <strong id="total-igst">

                    $0.00

                </strong>

            </div>



            <div class="summary-row">

                <span>

                    Round Off

                </span>

                <strong id="round-off">

                    $0.00

                </strong>

            </div>

        </div>

    </div>

</div>

