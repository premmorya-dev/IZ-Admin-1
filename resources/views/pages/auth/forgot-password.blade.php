<x-auth-layout>
<style>
    /* ---------- Layout (same system as login page) ---------- */
    .iz-auth{position:fixed;inset:0;z-index:1000;display:grid;grid-template-columns:1.05fr 1fr;background:#fff;overflow:auto;font-family:Inter,system-ui,sans-serif}

    .iz-brand{position:relative;overflow:hidden;padding:56px;color:#fff;display:flex;flex-direction:column;justify-content:space-between;
        background:radial-gradient(1200px 600px at 0% 0%,#4f46e5 0%,transparent 60%),radial-gradient(900px 600px at 100% 100%,#7c3aed 0%,transparent 55%),#0f172a}
    .iz-brand::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:44px 44px;mask-image:radial-gradient(circle at 30% 30%,#000 0%,transparent 75%);-webkit-mask-image:radial-gradient(circle at 30% 30%,#000 0%,transparent 75%)}
    .iz-orb{position:absolute;border-radius:50%;filter:blur(70px);opacity:.5}
    .iz-orb.a{width:280px;height:280px;background:#6366f1;top:-60px;right:-60px}
    .iz-orb.b{width:240px;height:240px;background:#a855f7;bottom:-80px;left:-40px}
    .iz-brand > *{position:relative;z-index:1}
    .iz-wordmark{font-size:22px;font-weight:700;letter-spacing:-.02em;display:flex;align-items:center;gap:10px;color:#fff}
    .iz-wordmark i{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#818cf8,#c084fc);display:grid;place-items:center;font-style:normal;font-size:16px}
    .iz-brand h2{font-size:38px;line-height:1.15;font-weight:700;letter-spacing:-.03em;color:#fff;margin:0 0 14px}
    .iz-brand h2 span{background:linear-gradient(90deg,#a5b4fc,#e9d5ff);-webkit-background-clip:text;background-clip:text;color:transparent}
    .iz-brand p.lead{color:#c7d2fe;font-size:15px;max-width:440px;line-height:1.7;margin:0 0 30px}

    /* steps */
    .iz-steps{list-style:none;margin:0;padding:0;display:grid;gap:0}
    .iz-steps li{position:relative;display:flex;gap:16px;padding-bottom:22px}
    .iz-steps li:last-child{padding-bottom:0}
    .iz-steps li:not(:last-child)::after{content:"";position:absolute;left:17px;top:38px;bottom:2px;width:2px;background:linear-gradient(rgba(255,255,255,.35),rgba(255,255,255,.08))}
    .iz-steps .n{flex:none;width:36px;height:36px;border-radius:12px;display:grid;place-items:center;font-weight:700;font-size:14px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(8px)}
    .iz-steps li:first-child .n{background:linear-gradient(135deg,#818cf8,#c084fc);border-color:transparent}
    .iz-steps b{display:block;font-size:15px;color:#fff;margin-bottom:2px}
    .iz-steps small{color:#c7d2fe;font-size:13px;line-height:1.5}
    .iz-foot{font-size:12px;color:#a5b4fc;display:flex;gap:18px;flex-wrap:wrap}

    /* right panel */
    .iz-panel{display:flex;flex-direction:column;background:radial-gradient(600px 300px at 100% 0%,#eef2ff 0%,transparent 70%),#fff}
    .iz-mtop{display:none}
    .iz-center{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px}
    .iz-form{width:100%;max-width:420px}

    .iz-logo-card{display:inline-flex;align-items:center;justify-content:center;padding:12px 18px;margin-bottom:26px;border-radius:20px;background:#fff;border:1px solid #e0e7ff;
        box-shadow:0 0 0 6px rgba(99,102,241,.07),0 14px 30px -14px rgba(79,70,229,.35)}
    .iz-logo-card img{height:44px;width:auto;max-width:180px;object-fit:contain;display:block}

    .iz-form h1{font-size:30px;font-weight:700;letter-spacing:-.02em;color:#0f172a;margin:0 0 8px}
    .iz-sub{color:#64748b;font-size:14.5px;line-height:1.7;margin-bottom:28px}

    .iz-label{display:block;font-size:13.5px;font-weight:600;color:#334155;margin-bottom:8px}
    .iz-field{position:relative}
    .iz-field svg.ic{position:absolute;left:17px;top:50%;transform:translateY(-50%);width:18px!important;height:18px!important;color:#94a3b8;pointer-events:none;z-index:2;transition:.2s}
    .iz-field:focus-within svg.ic{color:#4f46e5}
    .iz-field input.form-control{height:54px;padding-left:48px!important;border-radius:14px;background:#f8fafc!important;border:1.5px solid #e2e8f0;font-size:14.5px;color:#0f172a;transition:.2s}
    .iz-field input.form-control.has-eye{padding-right:48px!important}
    .iz-field input.form-control:focus{background:#fff!important;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .iz-eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:0;color:#94a3b8;padding:4px;cursor:pointer;z-index:2}
    .iz-eye:hover{color:#4f46e5}

    .iz-btn{height:54px;border:0;border-radius:14px;font-weight:600;font-size:15px;color:#fff;background:linear-gradient(135deg,#4f46e5,#7c3aed);box-shadow:0 12px 24px -10px rgba(79,70,229,.7);transition:.2s}
    .iz-btn:hover{transform:translateY(-2px);box-shadow:0 18px 30px -12px rgba(79,70,229,.8);color:#fff}
    .iz-btn:active{transform:translateY(0)}

    .iz-back{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:22px;font-weight:600;font-size:14px;color:#4f46e5}
    .iz-back:hover{color:#3730a3}

    .iz-secure{margin-top:28px;padding:16px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .iz-secure h6{display:flex;align-items:center;gap:8px;margin:0 0 10px;font-size:13.5px;font-weight:700;color:#3730a3}
    .iz-secure ul{margin:0;padding:0;list-style:none;display:grid;gap:7px}
    .iz-secure li{display:flex;gap:9px;font-size:13px;line-height:1.5;color:#475569}
    .iz-secure li::before{content:"✓";color:#4f46e5;font-weight:700}

    /* ---------- Modal (scoped) ---------- */
    .iz-modal .modal-content{border:0;border-radius:24px;overflow:hidden;box-shadow:0 30px 80px -20px rgba(15,23,42,.35)}
    .iz-modal .modal-header{position:relative;overflow:hidden;border:0;padding:28px 28px 26px;color:#fff;align-items:flex-start;
        background:radial-gradient(500px 200px at 0% 0%,#6366f1 0%,transparent 70%),linear-gradient(135deg,#4f46e5,#7c3aed)}
    .iz-modal .modal-title{font-size:22px;font-weight:700;color:#fff;letter-spacing:-.01em}
    .iz-modal .modal-subtitle{margin-top:6px;font-size:13.5px;color:rgba(255,255,255,.85)}
    .iz-modal .btn-close{filter:brightness(0) invert(1);opacity:.9;margin:0}
    .iz-modal .reset-body{padding:28px;background:#fff}
    .iz-otp-box{display:flex;gap:12px;align-items:flex-start;padding:14px 16px;border-radius:14px;background:#eef2ff;border:1px solid #e0e7ff;margin-bottom:24px}
    .iz-otp-box .ico{flex:none;width:34px;height:34px;border-radius:10px;background:#fff;display:grid;place-items:center;color:#4f46e5;box-shadow:0 4px 10px -4px rgba(79,70,229,.4)}
    .iz-otp-box h6{margin:0 0 2px;font-size:14px;font-weight:700;color:#3730a3}
    .iz-otp-box p{margin:0;font-size:12.5px;line-height:1.55;color:#64748b}
    .iz-modal .iz-field input.form-control{height:52px}
    #input_otp{letter-spacing:.35em;font-weight:700;font-size:17px}
    #input_otp::placeholder{letter-spacing:normal;font-weight:400;font-size:14.5px}
    .iz-hint{font-size:12.5px;color:#94a3b8;margin-top:7px}
    .iz-modal .text-danger{font-size:12.5px;margin-top:6px;font-weight:500}

    /* ---------- Responsive ---------- */
    @media (max-width:991px){
        .iz-auth{grid-template-columns:1fr}
        .iz-brand{display:none}
        .iz-mtop{display:flex;align-items:center;gap:10px;padding:18px 24px;color:#fff;font-weight:700;font-size:18px;
            background:radial-gradient(500px 200px at 0% 0%,#6366f1 0%,transparent 70%),linear-gradient(135deg,#4f46e5,#7c3aed)}
        .iz-mtop i{width:30px;height:30px;border-radius:9px;background:rgba(255,255,255,.2);display:grid;place-items:center;font-style:normal;font-size:14px}
        .iz-center{align-items:flex-start;padding:28px 20px 40px}
    }
    @media (max-width:480px){
        .iz-form h1{font-size:25px}
        .iz-modal .modal-header{padding:22px 20px}
        .iz-modal .reset-body{padding:20px}
        .iz-modal .modal-title{font-size:19px}
    }
</style>

<div class="iz-auth">

    <!-- LEFT -->
    <aside class="iz-brand">
        <div class="iz-orb a"></div><div class="iz-orb b"></div>

        <div class="iz-wordmark"><i>₹</i> Invoicezy</div>

        <div>
            <h2>Locked out? <br><span>Back in under a minute.</span></h2>
            <p class="lead">Recover your account securely with a one-time password sent to your registered email.</p>

            <ul class="iz-steps">
                <li><span class="n">1</span><div><b>Enter your email</b><small>Use the address you registered with.</small></div></li>
                <li><span class="n">2</span><div><b>Verify the OTP</b><small>A 6-digit code is valid for 10 minutes.</small></div></li>
                <li><span class="n">3</span><div><b>Set a new password</b><small>Choose something strong and unique.</small></div></li>
            </ul>
        </div>

        <div class="iz-foot">
            <span>© {{ date('Y') }} Invoicezy</span>
            <span>Built for Indian businesses</span>
        </div>
    </aside>

    <!-- RIGHT -->
    <main class="iz-panel">
        <div class="iz-mtop"><i>₹</i> Invoicezy</div>

        <div class="iz-center">
            <form class="form iz-form" id="kt_password_reset_form" onsubmit="return false;">
                @csrf

                <a href="{{ route('login') }}" class="iz-logo-card">
                    <img src="{{ asset('logo.png') }}" alt="Invoicezy">
                </a>

                <h1>Forgot password?</h1>
                <p class="iz-sub">Enter your registered email address and we'll send a secure One-Time Password (OTP) to verify your identity.</p>

                <div class="mb-6">
                    <label class="iz-label" for="email">Email address</label>
                    <div class="iz-field">
                        <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" autocomplete="off">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="button" id="kt_password_reset_submit" class="btn iz-btn">
                        @include('partials/general/_button-indicator',['label'=>'Send OTP'])
                    </button>
                </div>

                <a href="{{ route('login') }}" class="iz-back">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to login
                </a>

                <div class="iz-secure">
                    <h6>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3z"/></svg>
                        Your account is protected
                    </h6>
                    <ul>
                        <li>OTP expires automatically in 10 minutes.</li>
                        <li>Never share your OTP with anyone.</li>
                        <li>Password reset is protected with secure encryption.</li>
                    </ul>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- RESET MODAL (outside .iz-auth so backdrop stacks correctly) -->
<div class="modal fade iz-modal" id="forget-password-model" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h4 class="modal-title">Reset password</h4>
                    <div class="modal-subtitle">Verify your OTP and create a new password.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="reset-body">

                <div class="iz-otp-box">
                    <span class="ico">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                    </span>
                    <div>
                        <h6>Secure verification</h6>
                        <p>Enter the OTP sent to your registered email. It is valid for <strong>10 minutes</strong>.</p>
                    </div>
                </div>

                <form onsubmit="return false;">

                    <div class="mb-5">
                        <label class="iz-label" for="input_otp">One-Time Password (OTP)</label>
                        <div class="iz-field">
                            <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3z"/><path d="m9 12 2 2 4-4"/></svg>
                            <input type="text" inputmode="numeric" maxlength="6" class="form-control" id="input_otp" name="input_otp" placeholder="Enter 6-digit OTP" autocomplete="one-time-code">
                        </div>
                        <div class="text-danger" id="error-input_otp"></div>
                    </div>

                    <div class="mb-5">
                        <label class="iz-label" for="new_password">New password</label>
                        <div class="iz-field">
                            <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                            <input type="password" class="form-control has-eye" id="new_password" name="new_password" placeholder="Enter new password" autocomplete="new-password">
                            <button type="button" class="iz-eye" aria-label="Show password"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="iz-hint">Minimum 8 characters with uppercase, lowercase and number.</div>
                        <div class="text-danger" id="error-new_password"></div>
                    </div>

                    <div class="mb-6">
                        <label class="iz-label" for="confirm_password">Confirm password</label>
                        <div class="iz-field">
                            <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                            <input type="password" class="form-control has-eye" id="confirm_password" name="confirm_password" placeholder="Confirm your password" autocomplete="new-password">
                            <button type="button" class="iz-eye" aria-label="Show password"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="text-danger" id="error-confirm_password"></div>
                    </div>

                    <div class="d-grid">
                        <button type="button" id="password-reset" class="btn iz-btn">Reset password</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // show / hide password
    $(document).on('click', '.iz-eye', function () {
        const input = $(this).siblings('input');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    // OTP: sirf digits
    $('#input_otp').on('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });

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