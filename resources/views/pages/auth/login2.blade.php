<x-auth-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
      

        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .login-container {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
        }

        .login-container h2 {
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            text-shadow: 0 0 5px #00ffdd;
        }

        .form-control {
            background-color: rgba(0, 0, 0, 0.2);
            border: none;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 255, 221, 0.4);
        }

        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.4);
            border-color: #00ffdd;
            box-shadow: 0 0 10px #00ffdd;
        }

        .btn-login {
            background-color: #00ffdd;
            color: #000;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 0 15px #00ffdd;
        }

        .btn-login:hover {
            background-color: #00b3a3;
            box-shadow: 0 0 20px #00ffdd;
        }

        .tech-glow {
            text-shadow: 0 0 10px #00ffdd, 0 0 20px #00ffdd, 0 0 30px #00ffdd;
        }

        .focus-glow {
            box-shadow: 0 0 10px #00ffdd, 0 0 20px #00ffdd;
            transition: box-shadow 0.3s ease-in-out;
        }
    </style>
    <!--begin::Form-->
    <div class="overlay"></div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h2 class="tech-glow fs-1">Login</h2>
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
                        <!--begin::Input group--->
                        @csrf

                        <div class="fv-row mt-3">
                            <label for="email" class="form-label text-white">Email Address</label>
                            <input type="text" class="form-control text-white" name="email" id="email" autocomplete="off" placeholder="Enter your email">

                        </div>


                        <!--end::Input group--->
                        <div class="fv-row mt-5">
                            <!--begin::Password-->
                            <label for="password" class="form-label text-white">Password</label>
                            <input type="password" class="form-control text-white" name="password" id="password" placeholder="Enter your password">
                            <!--end::Password-->
                        </div>
                        <!--end::Input group--->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mt-3">
                            <div></div>

                            <!--begin::Link-->
                            <a href="{{ route('password.request') }}" class="link-primary">
                                Forgot Password ?
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Submit button-->
                        <div class="d-grid mt-6">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-login">
                                @include('partials/general/_button-indicator', ['label' => 'Sign In'])
                            </button>
                        </div>
                        <!--end::Submit button-->

                        <!--begin::Sign up-->
                        <!-- <div class="text-gray-500 text-center fw-semibold fs-6 mt-3">
                            Not a Member yet?

                            <a href="{{ route('register') }}" class="link-primary">
                                Sign up
                            </a>
                        </div>
 -->


                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--end::Sign up-->

    <!--end::Form-->

</x-auth-layout>