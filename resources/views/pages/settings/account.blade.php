<x-default-layout>
    <style>
        .iz-acc {
            --iz-1: #4f46e5;
            --iz-2: #7c3aed;
            --iz-border: #e8ebf3;
            --iz-muted: #64748b;
            --iz-ink: #0f172a
        }

        .iz-acc .iz-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px
        }

        .iz-acc .iz-top h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -.02em;
            color: var(--iz-ink)
        }

        .iz-acc .iz-top p {
            margin: 2px 0 0;
            color: var(--iz-muted);
            font-size: 14px
        }

        .iz-acc .iz-actions {
            display: flex;
            gap: 10px
        }

        .iz-acc .iz-btn {
            height: 44px;
            padding: 0 20px;
            border: 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--iz-1), var(--iz-2));
            box-shadow: 0 10px 22px -10px rgba(79, 70, 229, .7);
            transition: .2s
        }

        .iz-acc .iz-btn:hover {
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 16px 28px -12px rgba(79, 70, 229, .8)
        }

        .iz-acc .iz-btn-ghost {
            height: 44px;
            padding: 0 18px;
            border-radius: 12px;
            border: 1.5px solid var(--iz-border);
            background: #fff;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s
        }

        .iz-acc .iz-btn-ghost:hover {
            border-color: #c7d2fe;
            color: var(--iz-1);
            background: #f8f9ff
        }

        .iz-acc svg.lucide {
            width: 17px;
            height: 17px
        }

        /* cards */
        .iz-acc .iz-card {
            background: #fff;
            border: 1px solid var(--iz-border);
            border-radius: 20px;
            box-shadow: 0 10px 30px -18px rgba(15, 23, 42, .18);
            margin-bottom: 24px;
            overflow: hidden
        }

        .iz-acc .iz-card-h {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px 26px;
            border-bottom: 1px solid var(--iz-border);
            background: linear-gradient(180deg, #fcfcff, #fff)
        }

        .iz-acc .iz-ico {
            flex: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: var(--iz-1);
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            border: 1px solid #e0e7ff
        }

        .iz-acc .iz-card-h h3 {
            margin: 0;
            font-size: 16.5px;
            font-weight: 700;
            color: var(--iz-ink)
        }

        .iz-acc .iz-card-h p {
            margin: 2px 0 0;
            font-size: 13px;
            color: var(--iz-muted)
        }

        .iz-acc .iz-card-b {
            padding: 26px
        }

        /* fields */
        .iz-acc .iz-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px
        }

        .iz-acc .iz-field {
            position: relative
        }

        .iz-acc .iz-field .ic {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px !important;
            height: 18px !important;
            color: #94a3b8;
            pointer-events: none;
            z-index: 2;
            transition: .2s
        }

        .iz-acc .iz-field:focus-within .ic {
            color: var(--iz-1)
        }

        .iz-acc .iz-field input.form-control {
            height: 50px;
            padding-left: 46px !important;
            border-radius: 12px;
            background: #f8fafc !important;
            border: 1.5px solid #e2e8f0;
            font-size: 14.5px;
            color: var(--iz-ink);
            transition: .2s
        }

        .iz-acc .iz-field input.form-control.has-eye {
            padding-right: 46px !important
        }

        .iz-acc .iz-field input.form-control:focus {
            background: #fff !important;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14)
        }

        .iz-acc .iz-field input.form-control[readonly] {
            background: #f1f5f9 !important;
            color: #64748b;
            cursor: not-allowed
        }

        .iz-acc .iz-field input.form-control.is-invalid {
            border-color: #f43f5e;
            background-image: none
        }

        .iz-acc .iz-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: 0;
            color: #94a3b8;
            padding: 6px;
            cursor: pointer;
            z-index: 2
        }

        .iz-acc .iz-eye:hover {
            color: var(--iz-1)
        }

        .iz-acc .invalid-feedback {
            display: block;
            font-size: 12.5px;
            font-weight: 500
        }

        .iz-acc .iz-hint {
            font-size: 12.5px;
            color: #94a3b8;
            margin-top: 7px
        }

        .iz-acc .iz-badge-lock {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 99px;
            padding: 2px 9px;
            margin-left: 8px
        }

        /* strength */
        .iz-acc .iz-meter {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px
        }

        .iz-acc .iz-meter .track {
            flex: 1;
            height: 6px;
            border-radius: 99px;
            background: #e2e8f0;
            overflow: hidden
        }

        .iz-acc .iz-meter .fill {
            height: 100%;
            width: 0;
            border-radius: 99px;
            transition: .3s
        }

        .iz-acc .iz-meter span {
            font-size: 12px;
            font-weight: 600;
            min-width: 60px;
            text-align: right;
            color: #64748b
        }

        .iz-acc .iz-match {
            font-size: 12.5px;
            margin-top: 7px;
            font-weight: 500
        }

        /* profile card */
        .iz-acc .iz-profile {
            text-align: center;
            position: relative
        }

        .iz-acc .iz-banner {
            height: 110px;
            background: radial-gradient(400px 160px at 0% 0%, #818cf8 0%, transparent 70%), radial-gradient(300px 160px at 100% 100%, #c084fc 0%, transparent 70%), linear-gradient(135deg, #4f46e5, #7c3aed)
        }

        .iz-acc .iz-avatar {
            width: 92px;
            height: 92px;
            border-radius: 26px;
            margin: -46px auto 0;
            display: grid;
            place-items: center;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .02em;
            position: relative;
            background: linear-gradient(135deg, #4f46e5, #a855f7);
            border: 5px solid #fff;
            box-shadow: 0 14px 30px -12px rgba(79, 70, 229, .6)
        }

        .iz-acc .iz-profile h4 {
            margin: 16px 0 2px;
            font-size: 19px;
            font-weight: 700;
            color: var(--iz-ink)
        }

        .iz-acc .iz-profile .em {
            color: var(--iz-muted);
            font-size: 13.5px;
            word-break: break-all;
            padding: 0 16px
        }

        .iz-acc .iz-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 14px 0 22px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #a7f3d0
        }

        .iz-acc .iz-meta {
            border-top: 1px solid var(--iz-border);
            display: grid;
            grid-template-columns: 1fr 1fr
        }

        .iz-acc .iz-meta div {
            padding: 16px 10px
        }

        .iz-acc .iz-meta div+div {
            border-left: 1px solid var(--iz-border)
        }

        .iz-acc .iz-meta b {
            display: block;
            font-size: 14px;
            color: var(--iz-ink)
        }

        .iz-acc .iz-meta small {
            color: #94a3b8;
            font-size: 12px
        }

        /* tips */
        .iz-acc .iz-tips {
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            border-color: #e0e7ff
        }

        .iz-acc .iz-tips h6 {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #3730a3;
            margin: 0 0 12px
        }

        .iz-acc .iz-tips ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 9px
        }

        .iz-acc .iz-tips li {
            display: flex;
            gap: 9px;
            font-size: 13px;
            line-height: 1.55;
            color: #475569
        }

        .iz-acc .iz-tips li::before {
            content: "✓";
            color: var(--iz-1);
            font-weight: 700
        }

        @media (max-width:575px) {
            .iz-acc .iz-top h2 {
                font-size: 22px
            }

            .iz-acc .iz-card-h,
            .iz-acc .iz-card-b {
                padding: 18px
            }

            .iz-acc .iz-actions {
                width: 100%
            }

            .iz-acc .iz-actions>* {
                flex: 1;
                justify-content: center
            }
        }


        .iz-acc {
            position: relative;
            z-index: 1
        }

        .iz-acc .iz-top {
            position: relative;
            z-index: 50
        }

        .iz-acc .iz-actions .iz-btn,
        .iz-acc .iz-actions .iz-btn-ghost {
            position: relative;
            z-index: 51;
            pointer-events: auto;
            cursor: pointer
        }

        .iz-acc svg.lucide {
            pointer-events: none
        }

        .iz-acc .iz-btn:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none
        }

        .iz-acc .iz-alert {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500
        }

        .iz-acc .iz-alert.ok {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857
        }

        .iz-acc .iz-alert.err {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c
        }

        .iz-acc .iz-alert ul {
            margin: 0;
            padding-left: 18px
        }
    </style>

    @php
    $u = Auth::user();
    $initials = strtoupper(mb_substr($u->first_name ?? '', 0, 1) . mb_substr($u->last_name ?? '', 0, 1)) ?: 'U';
    @endphp

    <div class="iz-acc">
        <form action="{{ route('settings.account.update') }}" method="POST" id="iz_account_form" novalidate>
            @csrf
            @if (session('success') || session('status'))
            <div class="iz-alert ok"><i data-lucide="check-circle-2" style="width:18px;height:18px"></i>
                <div>{{ session('success') ?? session('status') }}</div>
            </div>
            @endif
            @if ($errors->any())
            <div class="iz-alert err"><i data-lucide="alert-circle" style="width:18px;height:18px"></i>
                <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif
            @if (session('error'))
            <div class="iz-alert err"><i data-lucide="alert-circle" style="width:18px;height:18px"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif
            <!-- Header -->
            <div class="iz-top">



                <div>
                    <h2>Account Settings</h2>
                    <p>Manage your personal details and keep your account secure.</p>
                </div>
                <div class="iz-actions">
                    <a href="{{ route('invoice.list') }}" class="iz-btn-ghost"><i data-lucide="arrow-left"></i> Back</a>
                    <button type="submit" form="iz_account_form" id="iz_save" class="iz-btn"><i data-lucide="save"></i> <span>Save changes</span></button>
                </div>
            </div>

            <div class="row g-6">

                <!-- LEFT: forms -->
                <div class="col-lg-8">

                    <!-- Personal info -->
                    <div class="iz-card">
                        <div class="iz-card-h">
                            <span class="iz-ico"><i data-lucide="user-round"></i></span>
                            <div>
                                <h3>Personal information</h3>
                                <p>Your name and the email linked to this account.</p>
                            </div>
                        </div>
                        <div class="iz-card-b">
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <label for="first_name" class="iz-label">First name</label>
                                    <div class="iz-field">
                                        <i data-lucide="user" class="ic"></i>
                                        <input type="text" name="first_name" id="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $u->first_name ?? '') }}" placeholder="First name">
                                    </div>
                                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="iz-label">Last name</label>
                                    <div class="iz-field">
                                        <i data-lucide="user" class="ic"></i>
                                        <input type="text" name="last_name" id="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $u->last_name ?? '') }}" placeholder="Last name">
                                    </div>
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="iz-label">
                                        Email address
                                        <span class="iz-badge-lock"><i data-lucide="lock" style="width:11px;height:11px"></i> Read only</span>
                                    </label>
                                    <div class="iz-field">
                                        <i data-lucide="mail" class="ic"></i>
                                        <input type="email" name="email" readonly id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $u->email ?? '') }}">
                                    </div>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="iz-hint">Your email is used to sign in and can't be changed here.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="iz-card">
                        <div class="iz-card-h">
                            <span class="iz-ico"><i data-lucide="shield-check"></i></span>
                            <div>
                                <h3>Password &amp; security</h3>
                                <p>Leave these blank if you don't want to change your password.</p>
                            </div>
                        </div>
                        <div class="iz-card-b">
                            <div class="row g-5">
                                <div class="col-12">
                                    <label for="current_password" class="iz-label">Current password</label>
                                    <div class="iz-field">
                                        <i data-lucide="key-round" class="ic"></i>
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control has-eye @error('current_password') is-invalid @enderror"
                                            placeholder="Enter current password" autocomplete="new-password">
                                        <button type="button" class="iz-eye" aria-label="Toggle password"><i data-lucide="eye"></i></button>
                                    </div>
                                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="new_password" class="iz-label">New password</label>
                                    <div class="iz-field">
                                        <i data-lucide="lock" class="ic"></i>
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control has-eye @error('new_password') is-invalid @enderror"
                                            placeholder="Enter new password" autocomplete="new-password">
                                        <button type="button" class="iz-eye" aria-label="Toggle password"><i data-lucide="eye"></i></button>
                                    </div>
                                    <div class="iz-meter" id="iz_meter" style="display:none">
                                        <div class="track">
                                            <div class="fill" id="iz_fill"></div>
                                        </div>
                                        <span id="iz_label"></span>
                                    </div>
                                    @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="confirm_password" class="iz-label">Confirm new password</label>
                                    <div class="iz-field">
                                        <i data-lucide="lock" class="ic"></i>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control has-eye @error('confirm_password') is-invalid @enderror"
                                            placeholder="Re-enter new password" autocomplete="new-password">
                                        <button type="button" class="iz-eye" aria-label="Toggle password"><i data-lucide="eye"></i></button>
                                    </div>
                                    <div class="iz-match" id="iz_match"></div>
                                    @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: profile summary -->
                <div class="col-lg-4">
                    <div class="iz-card iz-profile">
                        <div class="iz-banner"></div>
                        <div class="iz-avatar" id="iz_avatar">{{ $initials }}</div>
                        <h4 id="iz_fullname">{{ trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')) ?: 'Your name' }}</h4>
                        <div class="em">{{ $u->email }}</div>
                        <span class="iz-chip"><i data-lucide="badge-check" style="width:14px;height:14px"></i> Active account</span>
                        <div class="iz-meta">
                            <div><b>{{ optional($u->created_at)->format('M Y') ?? '-' }}</b><small>Member since</small></div>
                            <div><b>Invoicezy</b><small>Workspace</small></div>
                        </div>
                    </div>

                    <div class="iz-card iz-tips">
                        <div class="iz-card-b">
                            <h6><i data-lucide="sparkles" style="width:16px;height:16px"></i> Security tips</h6>
                            <ul>
                                <li>Use at least 8 characters with a mix of letters, numbers and symbols.</li>
                                <li>Don't reuse passwords from other websites.</li>
                                <li>Never share your password or OTP with anyone.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        (function() {

            // Save: native submit (layout ke kisi global script se bachne ke liye)
            const form = document.getElementById('iz_account_form');
            const saveBtn = document.getElementById('iz_save');
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                saveBtn.disabled = true;
                saveBtn.querySelector('span').textContent = 'Saving...';
                form.submit();
            });
            const $ = (id) => document.getElementById(id);

            // Lucide icons
            if (window.lucide) lucide.createIcons();

            // Show / hide password
            document.querySelectorAll('.iz-acc .iz-eye').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const input = btn.parentElement.querySelector('input');
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });

            // Live avatar + name
            function syncProfile() {
                const f = $('first_name').value.trim(),
                    l = $('last_name').value.trim();
                $('iz_avatar').textContent = ((f[0] || '') + (l[0] || '')).toUpperCase() || 'U';
                $('iz_fullname').textContent = (f + ' ' + l).trim() || 'Your name';
            }
            $('first_name').addEventListener('input', syncProfile);
            $('last_name').addEventListener('input', syncProfile);

            // Password strength
            const levels = [{
                    t: 'Too weak',
                    c: '#f87171'
                }, {
                    t: 'Weak',
                    c: '#fb923c'
                },
                {
                    t: 'Okay',
                    c: '#fbbf24'
                }, {
                    t: 'Good',
                    c: '#34d399'
                }, {
                    t: 'Strong',
                    c: '#22c55e'
                }
            ];
            $('new_password').addEventListener('input', function() {
                const v = this.value,
                    meter = $('iz_meter');
                if (!v) {
                    meter.style.display = 'none';
                    checkMatch();
                    return;
                }
                let s = 0;
                if (v.length >= 8) s++;
                if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
                if (/[0-9]/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                meter.style.display = 'flex';
                $('iz_fill').style.width = (s / 4 * 100) + '%';
                $('iz_fill').style.background = levels[s].c;
                $('iz_label').textContent = levels[s].t;
                $('iz_label').style.color = levels[s].c;
                checkMatch();
            });

            // Confirm match
            function checkMatch() {
                const a = $('new_password').value,
                    b = $('confirm_password').value,
                    el = $('iz_match');
                if (!b) {
                    el.textContent = '';
                    return;
                }
                const ok = a === b;
                el.textContent = ok ? '✓ Passwords match' : 'Passwords do not match';
                el.style.color = ok ? '#16a34a' : '#e11d48';
            }
            $('confirm_password').addEventListener('input', checkMatch);
        })();
    </script>
</x-default-layout>