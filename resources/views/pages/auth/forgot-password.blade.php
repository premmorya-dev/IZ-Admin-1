<x-auth-layout>
    <style>
        .forget-password {
            border: 1px solid #a1a2ac;
            padding: 40px;
            border-radius: 5px;
        }
    </style>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="forget-password">
                    <h2 class="tech-glow fs-1 d-flex justify-content-center">Forgot Password ?</h2>
                    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" action="">
                        <!--begin::Input group--->
                        @csrf

                        <div class="fv-row mt-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="Enter your email">

                        </div>

                        <!--begin::Actions-->
                        <div class="d-flex flex-wrap justify-content-center pb-lg-0 mt-6">
                            <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                @include('partials/general/_button-indicator', ['label' => 'Submit'])
                            </button>

                            <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>





    <!--end::Form-->

    <div class="modal fade" id="forget-password-model" tabindex="-1" aria-labelledby="forgetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="forgetPasswordLabel">Forget Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="view-modal-body py-5 px-5">
                    <form>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="input_otp" class="form-label">OTP</label>
                                <input type="number" name="input_otp" id="input_otp" class="form-control">
                                <div class="text-danger" id="error-input_otp"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="text" name="new_password" id="new_password" class="form-control">
                                <div class="text-danger" id="error-new_password"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="text" name="confirm_password" id="confirm_password" class="form-control">
                                <div class="text-danger" id="error-confirm_password"></div>
                            </div>

                            <div class="col-md-12 mt-3 ">
                                <button class="btn btn-sm btn-primary w-100 " id="password-reset">Reset</button>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">

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

                        }

                    }

                });
            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>

</x-auth-layout>