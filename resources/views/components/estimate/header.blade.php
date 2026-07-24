<style>
    /* ===== Choices.js = Same as Input ===== */

    /* ===== Make Choices Same Height as Bootstrap Input ===== */
    .invoice-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Mobile */
    @media (max-width:576px) {
        .invoice-actions {
            gap: 0px;
        }
    }

    .action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: .25s ease;
    }

    .action-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, .18);
    }

    .action-btn i {
        font-size: 15px;
    }

    .action-btn:hover i,
    .action-btn:hover .text-default,
    .action-btn:hover .text-defaults {
        color: #fff !important;
    }


    .form-control,
    .form-select,
    .choices__inner {
        min-height: 48px;
    }

    .choices {
        margin-bottom: 0;
    }

    .choices__inner {
        min-height: 48px !important;
        height: 48px !important;
        padding: 0 14px !important;
        border: 1px solid #d7ddea !important;
        border-radius: 12px !important;
        background: #fff !important;

        display: flex;
        align-items: center;
    }

    .choices__list--single {
        padding: 0 !important;
        display: flex;
        align-items: center;
        height: 100%;
    }

    .choices__list--single .choices__item {
        line-height: 48px;
    }

    .choices[data-type*=select-one]::after {
        right: 16px;
        margin-top: -3px;
    }

    .choices.is-focused .choices__inner,
    .choices.is-open .choices__inner {
        border-color: #5b6cff !important;
        box-shadow: 0 0 0 .2rem rgba(91, 108, 255, .15) !important;
    }
</style>


<div class="row g-3 align-items-end invoice-top-section">

    <!-- Company Logo -->
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">

        <div class="invoice-top-card logo-card">

            <label class="invoice-label">
                <i class="bi bi-building"></i>
                Company
            </label>

            <div class="company-logo-wrapper">

                <img
                    src="{{ asset($data['setting']->logo_path) }}"
                    class="company-logo"
                    alt="Company Logo">

            </div>

        </div>

    </div>

    <!-- Invoice Number -->
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">

        <div class="invoice-top-card">

            <label class="invoice-label d-flex justify-content-between">

                <span>
                    <i class="bi bi-receipt"></i>
                    Estimate Number
                </span>
                @if(empty($data['estimate']->estimate_number))
                <div class="form-check form-switch m-0">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="invoiceModeSwitch"
                        onchange="toggleInvoiceMode(this)">

                    <label
                        class="form-check-label small"
                        for="invoiceModeSwitch">

                        Custom

                    </label>

                </div>
                @endif
            </label>

            <div class="">
                <input
                    type="text"
                    id="estimate_number"
                    name="estimate_number"
                    class="form-control"
                    placeholder="Auto Generated"
                    value="{{ old('estimate_number', $data['estimate']->estimate_number ?? '' ) }}"
                    >

            </div>

        </div>

    </div>

    <!-- Currency -->

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">

        <div class="invoice-top-card">

            <label class="invoice-label">


                <span>
                    <i class="bi bi-currency-dollar"></i>
                    Currency
                </span>


            </label>

            <div class="">

                <select
                    name="currency_code"
                    id="currency_code"
                    class="form-select">

                    <option value="">Select Currency</option>

                    @foreach($data['currencies'] as $currency)

                    <option
                        value="{{ $currency->currency_code }}"
                        {{ old('currency_code', $data['estimate']->currency_code ?? setting('default_currency') ) == $currency->currency_code ? 'selected' : '' }}>

                        {{ $currency->currency_name }}

                    </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>

    <!-- Template -->

    <div class="col-xl-4 col-lg-3 col-md-12">

        <div class="invoice-top-card">

            <label class="invoice-label">

                <i class="bi bi-layout-text-window"></i>

                Invoice Template

            </label>

            <div class="">


                <select
                    id="template_id"
                    name="template_id"
                    class="form-select">

                    <option value="">Select Template</option>

                    @foreach($data['templates'] as $template)

                    <option
                        value="{{ $template->template_id }}"
                        {{ old('template_id', $data['estimate']->template_id ?? setting('default_template_id') ) == $template->template_id ? 'selected':'' }}>

                        {{ $template->template_name }}

                    </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>

</div>