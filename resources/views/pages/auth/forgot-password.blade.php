<x-auth-layout>
    <style>
        body {
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 50%, #f5f3ff 100%);
        }

        .forget-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 40px 0;
        }

        .forget-wrapper::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(37, 99, 235, .15);
            border-radius: 50%;
            top: -120px;
            left: -120px;
            filter: blur(80px);
        }

        .forget-wrapper::after {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(139, 92, 246, .15);
            border-radius: 50%;
            bottom: -120px;
            right: -120px;
            filter: blur(80px);
        }

        .forget-password {
            position: relative;
            z-index: 2;
            background: #fff;
            border-radius: 22px;
            padding: 45px;
            border: 1px solid #edf2f7;
            box-shadow: 0 20px 70px rgba(15, 23, 42, .08);
        }

        .logo-box {
            width: 85px;
            height: 85px;
            margin: auto;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            width: 55px;
        }

        .forget-password h2 {
            font-weight: 700;
            color: #111827;
        }

        .forget-password p {
            color: #6b7280;
            line-height: 28px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            height: 56px;
            border-radius: 14px;
            border: 1px solid #dbe4ef;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .15);
        }

        .btn-submit {
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            color: #fff;
            font-weight: 600;
            border: none;
        }

        .btn-submit:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .security-box {
            background: #f8fafc;
            border-radius: 15px;
            padding: 18px;
            border: 1px solid #e5e7eb;
        }

        .security-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .security-box li {
            margin-bottom: 8px;
            color: #475569;
        }

        .back-login {
            text-decoration: none;
            font-weight: 600;
        }
    </style>

    <div class="forget-wrapper">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-12 col-md-8">

                    <div class="forget-password">

                        <div class="text-center mb-5">

                            <div class="logo-box">

                                <img src="{{ asset('logo.png') }}" alt="Invoicezy">

                            </div>

                            <h2 class="mt-4">
                                Forgot Password?
                            </h2>

                            <p>
                                Enter your registered email address and we'll send a secure
                                One-Time Password (OTP) to verify your identity.
                            </p>

                        </div>

                        <form class="form w-100" id="kt_password_reset_form">

                            @csrf

                            <div class="mb-4">

                                <label class="form-label">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    autocomplete="off">

                            </div>

                            <div class="d-grid">

                                <button
                                    type="button"
                                    id="kt_password_reset_submit"
                                    class="btn btn-submit">

                                    @include('partials/general/_button-indicator',['label'=>'Send OTP'])

                                </button>

                            </div>

                            <div class="text-center mt-4">

                                <a href="{{ route('login') }}" class="back-login">

                                    ← Back to Login

                                </a>

                            </div>

                            <hr class="my-5">

                            <div class="security-box">

                                <h6 class="fw-bold mb-3">

                                    🔒 Your account is protected

                                </h6>

                                <ul>

                                    <li>OTP expires automatically in 10 minutes.</li>

                                    <li>Never share your OTP with anyone.</li>

                                    <li>Password reset is protected using secure encryption.</li>

                                </ul>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>




    <!--end::Form-->

    <style>
        .reset-modal .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(15, 23, 42, .15);
        }

        .reset-modal .modal-header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            padding: 30px;
            border: none;
            color: #fff;
        }

        .reset-modal .modal-title {
            font-weight: 700;
            font-size: 24px;
            color: #fff;
        }

        .reset-modal .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, .9);
            margin-top: 8px;
            font-size: 14px;
        }

        .reset-body {
            padding: 35px;
            background: #fff;
        }

        .otp-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 14px;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
        }

        .otp-box h6 {
            color: #2563eb;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .otp-box p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            height: 54px;
            border-radius: 12px;
            border: 1px solid #dbe4ef;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .15);
        }

        .btn-reset {
            height: 55px;
            border-radius: 14px;
            font-weight: 600;
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            border: none;
            color: #fff;
        }

        .btn-reset:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .password-hint {
            font-size: 13px;
            color: #6b7280;
            margin-top: 8px;
        }

        .text-danger {
            font-size: 13px;
            margin-top: 5px;
        }
    </style>

    <div class="modal fade reset-modal" id="forget-password-model" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <div>

                        <h4 class="modal-title">
                            Reset Password
                        </h4>

                        <div class="modal-subtitle">
                            Verify your OTP and create a new password.
                        </div>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="reset-body">

                    <div class="otp-box">

                        <h6>🔐 Secure Verification</h6>

                        <p>
                            Enter the OTP sent to your registered email.
                            OTP is valid for <strong>10 minutes</strong>.
                        </p>

                    </div>

                    <form>

                        <div class="mb-4">

                            <label class="form-label">
                                One-Time Password (OTP)
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="input_otp"
                                name="input_otp"
                                placeholder="Enter 6-digit OTP">

                            <div class="text-danger" id="error-input_otp"></div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="new_password"
                                name="new_password"
                                placeholder="Enter new password">

                            <div class="password-hint">

                                Minimum 8 characters with uppercase, lowercase and number.

                            </div>

                            <div class="text-danger" id="error-new_password"></div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="Confirm your password">

                            <div class="text-danger" id="error-confirm_password"></div>

                        </div>

                        <div class="d-grid">

                            <button
                                type="button"
                                id="password-reset"
                                class="btn btn-reset">

                                Reset Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>
        $('#kt_password_reset_submit').on('click', function(e) {

            e.preventDefault();
            try {
                $.ajax({
                    url: `{{ route('password.sendLink') }}`,
                    data: {
                        email: $('#email').val()
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response)

                        if (response.error == 0) {
                            $('#forget-password-model').modal('show')
                            toastr.success("OTP sent successfully to your email");



                        } else {
                            toastr.error("Oops Something went wrong.");

                        }

                        // location.reload();
                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }

        });

        $('#password-reset').on('click', function(e) {

            e.preventDefault();
            try {
                $.ajax({
                    url: `{{ route('password.reset') }}`,
                    data: {
                        email: $('#email').val(),
                        otp: $('#input_otp').val(),
                        new_password: $('#new_password').val(),
                        confirm_password: $('#confirm_password').val(),


                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {


                        if (response.error == 1) {
                            if (response.errors.otp) {
                                $('#error-input_otp').text(response.errors.otp[0])
                            } else {
                                $('#error-input_otp').text('')
                            }


                            if (response.errors.new_password) {
                                $('#error-new_password').text(response.errors.new_password[0])
                            } else {
                                $('#error-new_password').text('')
                            }


                            if (response.errors.confirm_password) {
                                $('#error-confirm_password').text(response.errors.confirm_password[0])

                            } else {
                                $('#error-confirm_password').text('')
                            }

                        } else {

                            $('#error-input_otp').text('')
                            $('#error-new_password').text('')
                            $('#error-confirm_password').text('')
                            $('#forget-password-model').modal('hide')
                            toastr.success("Password reset successfully");

                            setTimeout(function() {
                                window.location.href = "{{ route('login') }}";
                            }, 2000); 

                        }

                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>

</x-auth-layout>