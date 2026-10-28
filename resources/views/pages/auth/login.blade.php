<x-auth-layout>
<style>
    .iz-auth{position:fixed;inset:0;z-index:1050;display:grid;grid-template-columns:1.05fr 1fr;background:#fff;overflow:auto;font-family:Inter,system-ui,sans-serif}

    /* LEFT brand panel */
    .iz-brand{position:relative;overflow:hidden;padding:56px;color:#fff;display:flex;flex-direction:column;justify-content:space-between;
        background:radial-gradient(1200px 600px at 0% 0%,#4f46e5 0%,transparent 60%),radial-gradient(900px 600px at 100% 100%,#7c3aed 0%,transparent 55%),#0f172a}
    .iz-brand::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:44px 44px;mask-image:radial-gradient(circle at 30% 30%,#000 0%,transparent 75%)}
    .iz-orb{position:absolute;border-radius:50%;filter:blur(70px);opacity:.5}
    .iz-orb.a{width:280px;height:280px;background:#6366f1;top:-60px;right:-60px}
    .iz-orb.b{width:240px;height:240px;background:#a855f7;bottom:-80px;left:-40px}
    .iz-brand > *{position:relative;z-index:1}
    .iz-wordmark{font-size:22px;font-weight:700;letter-spacing:-.02em;display:flex;align-items:center;gap:10px}
    .iz-wordmark i{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#818cf8,#c084fc);display:grid;place-items:center;font-style:normal;font-size:16px}
    .iz-brand h2{font-size:40px;line-height:1.15;font-weight:700;letter-spacing:-.03em;color:#fff;margin:0 0 14px}
    .iz-brand h2 span{background:linear-gradient(90deg,#a5b4fc,#e9d5ff);-webkit-background-clip:text;background-clip:text;color:transparent}
    .iz-brand p.lead{color:#c7d2fe;font-size:15px;max-width:440px;line-height:1.7;margin:0 0 28px}
    .iz-points{list-style:none;padding:0;margin:0;display:grid;gap:12px}
    .iz-points li{display:flex;align-items:center;gap:12px;font-size:14px;color:#e0e7ff}
    .iz-points li::before{content:"✓";width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,.14);display:grid;place-items:center;font-size:12px;flex:none}

    /* floating invoice card */
    .iz-invoice{position:absolute;right:40px;top:110px;width:250px;padding:18px;border-radius:18px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(14px);box-shadow:0 30px 60px -20px rgba(0,0,0,.5);animation:izfloat 6s ease-in-out infinite}
    .iz-invoice .row1{display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#c7d2fe}
    .iz-invoice .amt{font-size:26px;font-weight:700;margin:10px 0 2px;color:#fff}
    .iz-invoice .sub{font-size:12px;color:#c7d2fe}
    .iz-badge{padding:3px 10px;border-radius:99px;background:rgba(52,211,153,.2);color:#6ee7b7;font-size:11px;font-weight:600}
    .iz-bar{height:6px;border-radius:99px;background:rgba(255,255,255,.15);margin-top:14px;overflow:hidden}
    .iz-bar b{display:block;width:72%;height:100%;border-radius:99px;background:linear-gradient(90deg,#818cf8,#34d399)}
    @keyframes izfloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    .iz-foot{font-size:12px;color:#a5b4fc;display:flex;gap:18px;flex-wrap:wrap}

    /* RIGHT form panel */
    .iz-panel{display:flex;align-items:center;justify-content:center;padding:40px 24px;background:radial-gradient(600px 300px at 100% 0%,#eef2ff 0%,transparent 70%),#fff}
    .iz-form{width:100%;max-width:420px}
    .iz-form .iz-logo{height:46px;margin-bottom:28px}
    .iz-form h1{font-size:30px;font-weight:700;letter-spacing:-.02em;color:#0f172a;margin-bottom:6px}
    .iz-form .iz-sub{color:#64748b;font-size:14.5px;margin-bottom:30px}
    .iz-field{position:relative}
    .iz-field svg.ic{position:absolute;left:16px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#94a3b8;pointer-events:none}
    .iz-field .form-control{height:54px;padding-left:46px;border-radius:14px;background:#f8fafc!important;border:1.5px solid #e2e8f0;font-size:14.5px;color:#0f172a;transition:.2s}
    .iz-field .form-control:focus{background:#fff!important;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
   .iz-form .iz-field input.form-control{
    padding-left:48px !important;
    height:54px;
    border-radius:14px;
    background:#f8fafc !important;
    border:1.5px solid #e2e8f0;
    font-size:14.5px;
    color:#0f172a;
}
.iz-form .iz-field input.form-control#iz_password{padding-right:46px !important}
.iz-form .iz-field input.form-control:focus{
    background:#fff !important;
    border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,.14);
}
.iz-form .iz-field svg.ic{
    position:absolute;
    left:17px;
    top:50%;
    transform:translateY(-50%);
    width:18px !important;
    height:18px !important;
    color:#94a3b8;
    pointer-events:none;
    z-index:2;
}
.iz-form .iz-field:focus-within svg.ic{color:#4f46e5}
    .iz-eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:0;color:#94a3b8;padding:4px;cursor:pointer}
    .iz-eye:hover{color:#4f46e5}
    .iz-forgot{font-size:13.5px;font-weight:600;color:#4f46e5}
    .iz-forgot:hover{color:#3730a3}
    .iz-btn{height:54px;border:0;border-radius:14px;font-weight:600;font-size:15px;color:#fff;background:linear-gradient(135deg,#4f46e5,#7c3aed);box-shadow:0 12px 24px -10px rgba(79,70,229,.7);transition:.2s}
    .iz-btn:hover{transform:translateY(-2px);box-shadow:0 18px 30px -12px rgba(79,70,229,.8);color:#fff}
    .iz-btn:active{transform:translateY(0)}
    .iz-or{display:flex;align-items:center;gap:14px;color:#94a3b8;font-size:12px;text-transform:uppercase;letter-spacing:.12em;margin:26px 0}
    .iz-or::before,.iz-or::after{content:"";flex:1;height:1px;background:#e2e8f0}
    .iz-google{height:54px;border-radius:14px;border:1.5px solid #e2e8f0;background:#fff;font-weight:600;font-size:14.5px;color:#1e293b;display:flex;align-items:center;justify-content:center;gap:12px;width:100%;transition:.2s}
    .iz-google:hover{border-color:#c7d2fe;box-shadow:0 10px 24px -12px rgba(79,70,229,.35);transform:translateY(-2px)}
    .iz-google:disabled{opacity:.6;transform:none}
    .iz-secure{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:22px;color:#94a3b8;font-size:12.5px}
    .iz-signup{margin-top:26px;text-align:center;color:#64748b;font-size:14px}
    .iz-signup a{font-weight:600;color:#4f46e5}

    @media (max-width:991px){
        .iz-auth{grid-template-columns:1fr}
        .iz-brand{display:none}
    }
</style>

<div class="iz-auth">

    <!-- LEFT -->
    <aside class="iz-brand">
        <div class="iz-orb a"></div><div class="iz-orb b"></div>

        <div class="iz-wordmark"><i>₹</i> Invoicezy</div>

        <div class="iz-invoice">
            <div class="row1"><span>INV-2041</span><span class="iz-badge">Paid</span></div>
            <div class="amt">₹ 48,500</div>
            <div class="sub">GST 18% included</div>
            <div class="iz-bar"><b></b></div>
        </div>

        <div>
            <h2>Invoicing that looks<br><span>as sharp as your business.</span></h2>
            <p class="lead">GST-compliant invoices, client tracking and payment follow-ups, all in one clean workspace.</p>
            <ul class="iz-points">
                <li>GST-ready invoices in seconds</li>
                <li>Manage clients and payments in one place</li>
                <li>Secure by default, your data stays yours</li>
            </ul>
        </div>

        <div class="iz-foot">
            <span>© {{ date('Y') }} Invoicezy</span>
            <span>Built for Indian businesses</span>
        </div>
    </aside>

    <!-- RIGHT -->
    <main class="iz-panel">
        <form class="form iz-form" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
            @csrf

            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.png') }}" alt="Invoicezy Logo" class="iz-logo" />
            </a>

            <h1>Welcome back 👋</h1>
            <div class="iz-sub">Sign in to manage your invoices and clients.</div>

            <div class="fv-row mb-6">
                <div class="iz-field">
                    <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    <input type="text" placeholder="Email address" name="email" autocomplete="off" class="form-control" />
                </div>
            </div>

            <div class="fv-row mb-3">
                <div class="iz-field">
                    <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                    <input type="password" placeholder="Password" name="password" id="iz_password" autocomplete="off" class="form-control" />
                    <button type="button" class="iz-eye" id="iz_eye" aria-label="Show password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-8">
                <a href="{{ route('password.request') }}" class="iz-forgot">Forgot password?</a>
            </div>

            <div class="d-grid">
                <button type="submit" id="kt_sign_in_submit" class="btn iz-btn">
                    @include('partials/general/_button-indicator', ['label' => 'Sign In'])
                </button>
            </div>

            <div class="iz-or">or</div>

            <button type="button" id="google_login_btn" class="iz-google">
                <svg viewBox="0 0 48 48" width="20" height="20" aria-hidden="true">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                <span class="btn-label">Continue with Google</span>
                <span class="spinner-border spinner-border-sm d-none" id="google_login_spinner"></span>
            </button>

            <div class="iz-secure">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3z"/></svg>
                256-bit SSL encrypted
            </div>

            <div class="iz-signup">
                Not a member yet?
                <a href="https://invoicezy.com/register">Create free account</a>
            </div>
        </form>
    </main>
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
(function () {
    // Password show/hide
    const pw = document.getElementById('iz_password');
    document.getElementById('iz_eye').addEventListener('click', () => {
        pw.type = pw.type === 'password' ? 'text' : 'password';
    });

    // Google login
    const btn = document.getElementById('google_login_btn');
    const spinner = document.getElementById('google_login_spinner');
    const clientId = @json(config('services.google.client_id'));
    let tokenClient = null;

    const setLoading = (state) => {
        btn.disabled = state;
        spinner.classList.toggle('d-none', !state);
    };

    const showError = (msg) => {
        if (window.Swal) {
            Swal.fire({ text: msg, icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok',
                customClass: { confirmButton: 'btn btn-primary' } });
        } else {
            alert(msg);
        }
    };

    async function handleToken(accessToken) {
        try {
            const res = await fetch('/api/google-login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ access_token: accessToken }),
            });
            const data = await res.json();

            if (!data.status) {
                showError(data.message || 'Google sign-in failed. Please try again.');
                setLoading(false);
                return;
            }
            window.location.href = data.data.url;
        } catch (e) {
            console.error(e);
            showError('Something went wrong. Please try again.');
            setLoading(false);
        }
    }

    btn.addEventListener('click', function () {
        if (!window.google || !google.accounts) {
            showError('Google sign-in is still loading. Please try again in a moment.');
            return;
        }

        if (!tokenClient) {
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: clientId,
                scope: 'openid email profile',
                callback: (resp) => {
                    if (resp.error || !resp.access_token) {
                        setLoading(false);
                        return;
                    }
                    handleToken(resp.access_token);
                },
                error_callback: () => setLoading(false),
            });
        }

        setLoading(true);
        tokenClient.requestAccessToken();
    });
})();
</script>
</x-auth-layout>