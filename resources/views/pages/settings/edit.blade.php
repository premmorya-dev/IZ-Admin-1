<x-default-layout>



    <div class="settings-shell">

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf

            <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
                <div><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a> </div>
                <button type="submit" class="btn btn-primary btn-sm "><i data-lucide="save"></i> Save Settings</button>
            </div>
            <div class="settings-topbar">
                <div>
                    <h4>Business Settings</h4>
                    <p>Manage your company profile, invoicing rules, branding and alerts.</p>
                </div>

            </div>

            <div class="row g-4">

                {{-- ===================== TAB NAV ===================== --}}
                <div class="col-lg-3">
                    <div class="nav flex-lg-column settings-tabs" id="settingsTab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active tab-color-1" id="tab-general-btn" data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab">
                            <span class="tab-icon-wrap"><i class="bi bi-person-lines-fill"></i></span>
                            <span>
                                <span class="tab-label">Contact &amp; Company</span>
                                <small>Profile, address, GST</small>
                            </span>
                        </button>
                        <button class="nav-link tab-color-2" id="tab-invoicing-btn" data-bs-toggle="pill" data-bs-target="#tab-invoicing" type="button" role="tab">
                            <span class="tab-icon-wrap"><i class="bi bi-receipt"></i></span>
                            <span>
                                <span class="tab-label">Invoicing</span>
                                <small>Numbering, tax, defaults</small>
                            </span>
                        </button>

                        <button class="nav-link tab-color-2" id="tab-sequence-btn" data-bs-toggle="pill" data-bs-target="#tab-sequence" type="button" role="tab">
                            <span class="tab-icon-wrap"><i class="bi bi-123"></i></span>
                            <span>
                                <span class="tab-label">Automatic Numbering</span>
                                <small>Manage document number sequences</small>
                            </span>
                        </button>

                        <button class="nav-link tab-color-3" id="tab-branding-btn" data-bs-toggle="pill" data-bs-target="#tab-branding" type="button" role="tab">
                            <span class="tab-icon-wrap"><i class="bi bi-image"></i></span>
                            <span>
                                <span class="tab-label">Branding</span>
                                <small>Logo &amp; signature</small>
                            </span>
                        </button>
                        <button class="nav-link tab-color-4" id="tab-alerts-btn" data-bs-toggle="pill" data-bs-target="#tab-alerts" type="button" role="tab">
                            <span class="tab-icon-wrap"><i class="bi bi-bell"></i></span>
                            <span>
                                <span class="tab-label">Alerts</span>
                                <small>Payment reminders</small>
                            </span>
                        </button>
                    </div>
                </div>
                {{-- ===================== TAB CONTENT ===================== --}}
                <div class="col-lg-9">
                    <div class="tab-content" id="settingsTabContent">

                        {{-- ===================== CONTACT + COMPANY ===================== --}}
                        <div class="tab-pane fade show active" id="tab-general" role="tabpanel">

                            <div class="set-card">
                                <h6 class="set-card-title">Contact Info</h6>
                                <p class="set-card-desc">How customers and the system reach your business.</p>

                                <div class="row g-3">
                                    <div class="col-md-4 set-field">
                                        <label for="mobile_country_code_id" class="form-label">
                                            Country Code
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select your country code for mobile number."></i>
                                        </label>
                                        <select name="mobile_country_code_id" id="mobile_country_code_id" class="form-select @error('mobile_country_code_id') is-invalid @enderror">
                                            <option value="">-- Select Country Code --</option>
                                            @foreach($data['mobile_country_list'] as $country)
                                            <option
                                                value="{{ $country->mobile_country_code_id }}"
                                                data-code="{{ $country->country_code }}"
                                                data-flag="{{ $country->flag_icon_class }}"
                                                {{ old('mobile_country_code_id', Auth::user()->mobile_country_code_id ?? '') == $country->mobile_country_code_id ? 'selected' : '' }}>
                                                {{ $country->country_name }} (+{{ $country->country_code }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('mobile_country_code_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="email" class="form-label">
                                            Email
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Your registered business email address. Cannot be changed."></i>
                                        </label>
                                        <input type="email" name="email" id="email" readonly class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data['setting']->email ?? '') }}">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="mobile_no" class="form-label">
                                            Mobile No
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter your valid business mobile number."></i>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="country_code_prefix">+--</span>
                                            <input type="text" name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no', Auth::user()->mobile_no ?? '') }}">
                                            @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="set-card">
                                <h6 class="set-card-title">Company Info</h6>
                                <p class="set-card-desc">Legal details shown on invoices and estimates.</p>

                                <div class="row g-3">
                                    <div class="col-md-5 set-field">
                                        <label for="company_name" class="form-label">
                                            Company Name
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter your registered business or company name."></i>
                                        </label>
                                        <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $data['setting']->company_name ?? '') }}">
                                        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="is_company" class="form-label">
                                            Business Type
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select whether you are an organisation or an individual."></i>
                                        </label>
                                        <select name="is_company" id="is_company" class="form-select @error('is_company') is-invalid @enderror">
                                            <option value="Y" {{ old('is_company', $data['setting']->is_company ?? '') == 'Y' ? 'selected' : '' }}>Organisation</option>
                                            <option value="N" {{ old('is_company', $data['setting']->is_company ?? '') == 'N' ? 'selected' : '' }}>Individual</option>
                                        </select>
                                        @error('is_company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="user_gst_number" class="form-label">
                                            Business GST Number
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter your business GSTIN and select whether to display it on invoices and estimates."></i>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="user_gst_number" id="user_gst_number" class="form-control @error('user_gst_number') is-invalid @enderror" placeholder="Enter your GSTIN" value="{{ old('user_gst_number', $data['setting']->user_gst_number ?? '') }}">
                                            <select name="display_gst_number" id="display_gst_number" class="form-select @error('display_gst_number') is-invalid @enderror" style="max-width: 100px;" data-bs-toggle="tooltip" title="Choose whether to display the GST number on invoices and estimates.">
                                                <option value="Y" {{ old('display_gst_number', $data['setting']->display_gst_number ?? '') == 'Y' ? 'selected' : '' }}>Show</option>
                                                <option value="N" {{ old('display_gst_number', $data['setting']->display_gst_number ?? '') == 'N' ? 'selected' : '' }}>Hide</option>
                                            </select>
                                        </div>
                                        @error('user_gst_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        @error('display_gst_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 set-field">
                                        <label for="address_1" class="form-label">
                                            Address Line 1
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter the first line of your business address."></i>
                                        </label>
                                        <input type="text" name="address_1" id="address_1" class="form-control" value="{{ old('address_1', $data['setting']->address_1 ?? '') }}">
                                    </div>

                                    <div class="col-md-6 set-field">
                                        <label for="address_2" class="form-label">
                                            Address Line 2
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter additional address details, if any."></i>
                                        </label>
                                        <input type="text" name="address_2" id="address_2" class="form-control" value="{{ old('address_2', $data['setting']->address_2 ?? '') }}">
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="country_id" class="form-label">
                                            Country
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select your business country."></i>
                                        </label>
                                        <select name="country_id" id="country_id" class="form-select @error('country_id') is-invalid @enderror">
                                            <option value="">-- Select Country --</option>
                                            @foreach($data['countries'] as $country)
                                            <option value="{{ $country->country_id }}" {{ old('country_id', $data['setting']->country_id ?? '') == $country->country_id ? 'selected' : '' }}>
                                                {{ $country->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="state_id" class="form-label">
                                            State
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select your business state or region."></i>
                                        </label>
                                        <select name="state_id" id="state_id" class="form-select @error('state_id') is-invalid @enderror">
                                            <option value="">-- Select State --</option>
                                            @foreach($data['states']->where('country_id', $data['setting']->country_id) as $state)
                                            <option value="{{ $state->state_id }}" {{ old('state_id', $data['setting']->state_id ?? '') == $state->state_id ? 'selected' : '' }}>
                                                {{ $state->state_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="pincode" class="form-label">
                                            Pincode
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enter the postal or ZIP code for your business address."></i>
                                        </label>
                                        <input type="text" name="pincode" id="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $data['setting']->pincode ?? '') }}">
                                        @error('pincode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== INVOICING ===================== --}}
                        <div class="tab-pane fade" id="tab-sequence" role="tabpanel">

                            <x-settings.document-sequence
                                title="Invoice Numbering"
                                description="Configure how invoice numbers are automatically generated."
                                label="Invoice"
                                name="invoice_sequence"
                                placeholder="INV-"
                                :sequence="$invoiceSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Estimate Numbering"
                                description="Configure how estimate numbers are automatically generated."
                                label="Estimate"
                                name="estimate_sequence"
                                placeholder="EST-"
                                :sequence="$estimateSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Bill Numbering"
                                description="Configure how bill numbers are automatically generated."
                                label="Bill"
                                name="bill_sequence"
                                placeholder="BILL-"
                                :sequence="$billSequence" />

                            <x-settings.document-sequence
                                class="mt-5"
                                title="Expense Numbering"
                                description="Configure how expense numbers are automatically generated."
                                label="Expense"
                                name="expense_sequence"
                                placeholder="EXP-"
                                :sequence="$expenseSequence" />



                        </div>

                        {{-- ===================== INVOICING ===================== --}}
                        <div class="tab-pane fade" id="tab-invoicing" role="tabpanel">


                            <div class="set-card">
                                <h6 class="set-card-title">Prefixes &amp; Defaults</h6>
                                <p class="set-card-desc">Default prefixes, currency, tax, discount and UPI applied to new documents.</p>

                                <div class="row g-3">
                                    

                                    <div class="col-md-3 set-field">
                                        <label for="default_currency" class="form-label">
                                            Default Currency
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select the currency that will be used by default for all invoices and estimates."></i>
                                        </label>
                                        <select id="default_currency" name="default_currency" class="form-select">
                                            <option value="">Please Select</option>
                                            @foreach($data['currencies'] as $currency )
                                            <option value="{{ $currency->currency_code }}" {{ old('default_currency', $data['setting']->default_currency ?? '') == $currency->currency_code ? 'selected' : '' }}> {{ $currency->currency_name }} | {{ $currency->currency_symbol }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="default_tax_id" class="form-label">
                                            Default Tax %
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Choose a default tax percentage that will automatically apply to all new invoices."></i>
                                        </label>
                                        <select id="default_tax_id" name="default_tax_id" class="form-select">
                                            <option value="0">No Tax</option>
                                            @foreach($data['taxes'] as $tax )
                                            <option value="{{ $tax->tax_id }}" {{ old('default_tax_id', $data['setting']->default_tax_id ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="default_discount_id" class="form-label">
                                            Default Discount %
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select a default discount percentage to apply automatically to new invoices."></i>
                                        </label>
                                        <select id="default_discount_id" name="default_discount_id" class="form-select">
                                            <option value="0">No Discount</option>
                                            @foreach($data['discounts'] as $discount )
                                            <option value="{{ $discount->discount_id }}" {{ old('default_discount_id', $data['setting']->default_discount_id ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="default_upi_id" class="form-label">
                                            Default UPI ID
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select your default UPI account that the UPI QR code will be shown on invoices for payment."></i>
                                        </label>
                                        <select id="default_upi_id" name="default_upi_id" class="form-select">
                                            <option value="0">Please Select</option>
                                            @foreach($data['upi_payment_id'] as $upi_id )
                                            <option value="{{ $upi_id->upi_log_id }}" {{ old('default_upi_id', $data['setting']->default_upi_id ?? '') == $upi_id->upi_log_id ? 'selected' : '' }}>{{ $upi_id->upi_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="pagination_limit" class="form-label">
                                            Pagination Limit
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Set how many records you want to display per page in list views."></i>
                                        </label>
                                        <input type="number" name="pagination_limit" id="pagination_limit" class="form-control @error('pagination_limit') is-invalid @enderror" value="{{ old('pagination_limit', $data['setting']->pagination_limit ?? 10) }}">
                                        @error('pagination_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    @php
                                    $selectedFormat = old('date_format', $data['setting']->date_format ?? 'MdY');
                                    $formats = [
                                    'Y M d' => date('Y M d'),
                                    'd M Y' => date('d M Y'),
                                    'M d Y' => date('M d Y'),
                                    'Y-m-d' => date('Y-m-d'),
                                    'd-m-Y' => date('d-m-Y'),
                                    'm-d-Y' => date('m-d-Y'),
                                    'd.m.Y' => date('d.m.Y'),
                                    ];
                                    @endphp

                                    <div class="col-md-3 set-field">
                                        <label for="date_format" class="form-label">
                                            Default Date Format
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select the date format that will appear on your invoices, estimate and reports."></i>
                                        </label>
                                        <select id="date_format" name="date_format" class="form-select">
                                            @foreach($formats as $key => $sample)
                                            <option value="{{ $key }}" {{ $selectedFormat == $key ? 'selected' : '' }}>{{ $sample }}</option>
                                            @endforeach
                                        </select>
                                        @error('date_format')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-3 set-field">
                                        <label for="shipping_status" class="form-label">
                                            Display Shipping Address
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enable this option to display the shipping address on invoices and estimates."></i>
                                        </label>
                                        <select name="shipping_status" id="shipping_status" class="form-select @error('shipping_status') is-invalid @enderror">
                                            <option value="N" {{ old('shipping_status', $data['setting']->shipping_status ?? '') == 'N' ? 'selected' : '' }}>Hide</option>
                                            <option value="Y" {{ old('shipping_status', $data['setting']->shipping_status ?? '') == 'Y' ? 'selected' : '' }}>Show</option>
                                        </select>
                                        @error('shipping_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="set-card">
                                <h6 class="set-card-title">Notes &amp; Terms</h6>
                                <p class="set-card-desc">Shown at the bottom of every invoice and estimate.</p>

                                <div class="row g-3">
                                    <div class="col-md-6 set-field">
                                        <label class="form-label">Notes</label>
                                        <textarea name="notes" id="id_notes" class="form-control">{{ old('notes', $data['setting']->notes) }}</textarea>
                                    </div>

                                    <div class="col-md-6 set-field">
                                        <label class="form-label">Terms And Conditions</label>
                                        <textarea name="terms" id="id_terms" class="form-control">{{ old('terms', $data['setting']->terms) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== BRANDING ===================== --}}
                        <div class="tab-pane fade" id="tab-branding" role="tabpanel">

                            @php
                            $storedSignature = $data['setting']->signature ? asset($data['setting']->signature) : '';
                            $showSignature = $storedSignature && !str_contains($storedSignature, 'no-image.png');

                            $storedLogo = $data['setting']->logo_path ? asset($data['setting']->logo_path) : '';
                            $showLogo = $storedLogo && !str_contains($storedLogo, 'no-image.png');
                            @endphp

                            <div class="set-card">
                                <h6 class="set-card-title">Branding</h6>
                                <p class="set-card-desc">Your logo and signature appear on invoices and estimates.</p>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="logo_path" class="form-label">
                                            Company Logo
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Upload your business logo to appear on invoices and estimates. Recommended size: 200x200px."></i>
                                        </label>

                                        <label class="upload-area" id="upload-box-logo">
                                            <input type="file" class="image-upload d-none" name="logo_path" accept="image/*"
                                                data-preview="preview-logo_path" data-upload-box="upload-box-logo" data-clear-btn="clear-logo_path"
                                                onchange="previewImage(event)">
                                            <img id="preview-logo_path" src="{{ $showLogo ? $storedLogo : '' }}" style="display: {{ $showLogo ? 'block' : 'none' }}" alt="Uploaded Logo">
                                            <span class="upload-placeholder" style="display: {{ $showLogo ? 'none' : 'block' }};">
                                                <i class="bi bi-cloud-arrow-up fs-4 d-block mb-1"></i>
                                                Click to upload or drag &amp; drop
                                            </span>
                                        </label>
                                        @error('logo_path')<div class="text-danger set-hint mt-1">{{ $message }}</div>@enderror

                                        @if ($showLogo)
                                        <button type="button" class="btn btn-outline-danger upload-remove-btn mt-2" onclick="removeSavedImage('logo_path')">Remove logo</button>
                                        <input type="hidden" name="remove_logo_path" id="remove_logo_path" value="0">
                                        @endif

                                        <div class="mt-2 p-2 rounded bg-light border-start border-4 border-primary">
                                            <small class="set-hint">
                                                <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                                                Use a high-quality logo up to <strong>600×400 px</strong> and keep the file size below <strong>100 KB</strong>.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="signature" class="form-label">
                                            Digital Signature
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Upload your authorized signature to be printed on invoices automatically. Recommended size: 200x100px."></i>
                                        </label>

                                        <label class="upload-area" id="upload-box-signature">
                                            <input type="file" class="image-upload d-none" name="signature" accept="image/*"
                                                data-preview="preview-signature" data-upload-box="upload-box-signature" data-clear-btn="clear-signature"
                                                onchange="previewImage(event)">
                                            <img id="preview-signature" src="{{ $showSignature ? $storedSignature : '' }}" style="display: {{ $showSignature ? 'block' : 'none' }};" alt="Uploaded Signature">
                                            <span class="upload-placeholder" style="display: {{ $showSignature ? 'none' : 'block' }};">
                                                <i class="bi bi-cloud-arrow-up fs-4 d-block mb-1"></i>
                                                Click to upload or drag &amp; drop
                                            </span>
                                        </label>
                                        @error('signature')<div class="text-danger set-hint mt-1">{{ $message }}</div>@enderror

                                        @if ($showSignature)
                                        <button type="button" class="btn btn-outline-danger upload-remove-btn mt-2" onclick="removeSavedImage('signature')">Remove signature</button>
                                        <input type="hidden" name="remove_signature" id="remove_signature" value="0">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== ALERTS ===================== --}}
                        <div class="tab-pane fade" id="tab-alerts" role="tabpanel">

                            <div class="set-card">
                                <h6 class="set-card-title">Payment Reminders</h6>
                                <p class="set-card-desc">Automatically notify customers about upcoming or overdue invoices.</p>

                                <div class="row g-3">
                                    <div class="col-md-4 set-field">
                                        <label for="invoice_payment_reminder_status" class="form-label">
                                            Payment Reminder
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Enable or disable payment reminders."></i>
                                        </label>
                                        <select name="invoice_payment_reminder_status" id="invoice_payment_reminder_status" class="form-select">
                                            <option value="N" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'N' ? 'selected' : '' }}>No</option>
                                            <option value="Y" {{ old('invoice_payment_reminder_status', $data['setting']->invoice_payment_reminder_status ?? '') == 'Y' ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="reminder_before_due_days" class="form-label">
                                            Before Due Days
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="Select how many days before due date the reminder should be sent."></i>
                                        </label>
                                        <select name="reminder_before_due_days" id="reminder_before_due_days" class="form-select">
                                            <option value="0">Disable</option>
                                            @for ($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}" {{ old('reminder_before_due_days', $data['setting']->reminder_before_due_days ?? '') == $i ? 'selected' : '' }}>{{ $i }} day{{ $i > 1 ? 's' : '' }}</option>
                                                @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-4 set-field">
                                        <label for="everyday_reminder_after_due_day" class="form-label d-block">
                                            Every Day Reminder After Due Date
                                            <i class="bi bi-question-circle-fill set-help" data-bs-toggle="tooltip" title="If enabled, all invoices that are already past their due date will receive a reminder notification every day until they are paid."></i>
                                        </label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="everyday_reminder_after_due_day" name="everyday_reminder_after_due_day"
                                                {{ !empty($data['setting']->everyday_reminder_after_due_day) && $data['setting']->everyday_reminder_after_due_day == 'Y' ? 'checked' : '' }}>
                                            <label class="form-check-label set-hint" for="everyday_reminder_after_due_day">Send reminder after due date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#id_notes').summernote({
                placeholder: 'Enter notes...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            $('#id_terms').summernote({
                placeholder: 'Enter terms...',
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            // Initialise Bootstrap tooltips
            var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(function(el) {
                if (window.bootstrap) new bootstrap.Tooltip(el);
            });

            // Re-render lucide icons if the layout uses lucide
            if (window.lucide) lucide.createIcons();
        });

        function previewImage(event) {
            const input = event.target;
            const previewId = input.dataset.preview;
            const uploadBoxId = input.dataset.uploadBox;
            const clearBtnId = input.dataset.clearBtn;

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    const placeholder = document.querySelector('#' + uploadBoxId + ' .upload-placeholder');
                    if (placeholder) placeholder.style.display = 'none';

                    const clearBtn = document.getElementById(clearBtnId);
                    if (clearBtn) clearBtn.style.display = 'inline-block';

                    document.getElementById(uploadBoxId).classList.add('image-selected');
                };
                reader.readAsDataURL(file);
            }
        }

        function clearImage(button) {
            const inputName = button.dataset.input;
            const previewId = button.dataset.preview;
            const uploadBoxId = button.dataset.uploadBox;

            const input = document.querySelector(`input[name="${inputName}"]`);
            input.value = '';

            document.getElementById(previewId).src = '';
            document.getElementById(previewId).style.display = 'none';

            const placeholder = document.querySelector('#' + uploadBoxId + ' .upload-placeholder');
            if (placeholder) placeholder.style.display = 'block';

            button.style.display = 'none';
            document.getElementById(uploadBoxId).classList.remove('image-selected');
        }

        function removeSavedImage(type) {
            const preview = document.getElementById('preview-' + type);
            if (preview) preview.style.display = 'none';

            const uploadBoxId = 'upload-box-' + (type === 'logo_path' ? 'logo' : 'signature');
            const placeholder = document.querySelector('#' + uploadBoxId + ' .upload-placeholder');
            if (placeholder) placeholder.style.display = 'block';

            const clearBtn = document.getElementById('clear-' + type);
            if (clearBtn) clearBtn.style.display = 'none';

            const removeInput = document.getElementById('remove_' + type);
            if (removeInput) removeInput.value = '1';

            event.target.style.display = 'none';
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#country_id').on('change', function() {
                var countryID = $(this).val();
                $('#state_id').html('<option value="">Loading...</option>');
                if (countryID) {
                    $.ajax({
                        url: "{{ route('get.states.by.country') }}",
                        type: "GET",
                        data: {
                            country_id: countryID
                        },
                        success: function(res) {
                            $('#state_id').empty().append('<option value="">-- Select State --</option>');
                            $.each(res.states, function(key, state) {
                                $('#state_id').append('<option value="' + state.state_id + '">' + state.state_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state_id').html('<option value="">-- Select State --</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function updatePrefix() {
                var selectedOption = $('#mobile_country_code_id').find('option:selected');
                var code = selectedOption.data('code') || '--';
                $('#country_code_prefix').text('+' + code);
            }

            $('#mobile_country_code_id').on('change', updatePrefix);
            updatePrefix();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#mobile_country_code_id').select2({
                placeholder: "Choose Country Code",
                allowClear: true
            });

            $('#country_id').select2({
                placeholder: "Choose Country",
                allowClear: true
            });

            $('#state_id').select2({
                placeholder: "Choose State",
                allowClear: true
            });

            $('#default_currency').select2({
                placeholder: "Choose Default Currency",
                allowClear: true
            });

            $('#default_tax_id').select2({
                placeholder: "Choose Default Tax",
                allowClear: true
            });

            $('#default_discount_id').select2({
                placeholder: "Choose Default Discount",
                allowClear: true
            });

            $('#default_upi_id').select2({
                placeholder: "Choose UPI ID",
                allowClear: true
            });
        });
    </script>

</x-default-layout>