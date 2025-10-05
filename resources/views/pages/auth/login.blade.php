<x-auth-layout>
    <!--begin::Logo-->

    <!--end::Logo-->

    <!--begin::Form-->
    <form class="form w-sm-100 w-md-50 w-lg-40 mx-auto" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf
        <div class="d-flex justify-content-center align-items-center ">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.png') }}" alt="Invoicezy Logo" class="h-60px" />
            </a>
        </div>
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <h1 class="text-gray-900 fw-bold mb-2 fs-2">
                Welcome Back to <span class="text-primary">Invoicezy</span>
            </h1>
            <div class="text-muted fw-semibold fs-6">
                Sign in to manage your invoices and clients
            </div>
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
        </div>
        <!--end::Input group-->

        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <a href="#" class="link-primary">Forgot Password?</a>
        </div>

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => 'Sign In'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Not a member yet?
            <a href="https://invoicezy.com/register" class="link-primary">Sign up</a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-auth-layout>