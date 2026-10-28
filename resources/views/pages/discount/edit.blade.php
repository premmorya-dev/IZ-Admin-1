<style>
    .discount-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .discount-form-wrap .de-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:18px 20px;border-radius:22px;color:#fff;margin-bottom:18px;
        background:radial-gradient(520px 200px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(380px 200px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .discount-form-wrap .de-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .discount-form-wrap .de-head > *{position:relative;z-index:1}
    .discount-form-wrap .de-av{flex:none;width:50px;height:50px;border-radius:15px;display:grid;place-items:center;font-size:18px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .discount-form-wrap .de-av,.discount-form-wrap .de-av i{color:#fff!important}
    .discount-form-wrap .de-htext{min-width:0;flex:1}
    .discount-form-wrap .de-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .discount-form-wrap .de-head h4{margin:0;color:#fff;font-size:19px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .discount-form-wrap .de-hright{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .discount-form-wrap .de-chip{display:inline-flex;align-items:center;padding:7px 13px;border-radius:99px;font-size:13px;font-weight:800;font-variant-numeric:tabular-nums;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .discount-form-wrap .de-dot{flex:none;width:7px;height:7px;border-radius:50%;background:currentColor}
    .discount-form-wrap .de-stat{display:inline-flex;align-items:center;gap:10px;margin:0;padding:5px 8px 5px 14px;border-radius:99px;font-size:12.5px;font-weight:700;cursor:pointer;
        background:rgba(251,113,133,.18);border:1px solid rgba(251,113,133,.4);color:#fda4af;transition:.2s}
    .discount-form-wrap .de-stat.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}

    /* ---------- custom switch ---------- */
    .discount-form-wrap .de-sw{-webkit-appearance:none;appearance:none;flex:none;position:relative;width:46px;height:26px;margin:0;padding:0;border:0;border-radius:99px;background:#cbd5e1;cursor:pointer;transition:.2s;outline:0}
    .discount-form-wrap .de-sw::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.3);transition:.2s}
    .discount-form-wrap .de-sw:checked{background:#10b981}
    .discount-form-wrap .de-sw:checked::after{transform:translateX(20px)}
    .discount-form-wrap .de-sw:focus-visible{box-shadow:0 0 0 4px rgba(99,102,241,.28)}
    .discount-form-wrap .de-sw.sm{width:40px;height:24px;background:rgba(255,255,255,.28)}
    .discount-form-wrap .de-sw.sm::after{width:18px;height:18px}
    .discount-form-wrap .de-sw.sm:checked{background:#10b981}
    .discount-form-wrap .de-sw.sm:checked::after{transform:translateX(16px)}

    /* ---------- card ---------- */
    .discount-form-wrap .de-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .discount-form-wrap .de-card-h{display:flex;align-items:center;gap:14px;padding:16px 22px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .discount-form-wrap .de-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;background:linear-gradient(135deg,#d97706,#fbbf24);box-shadow:0 10px 18px -10px rgba(245,158,11,.7)}
    .discount-form-wrap .de-chipi,.discount-form-wrap .de-chipi i,.discount-form-wrap .de-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .discount-form-wrap .de-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .discount-form-wrap .de-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .discount-form-wrap .de-card-b{display:grid;gap:22px;padding:22px}
    .discount-form-wrap .de-card-f{padding:16px 22px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}

    /* ---------- fields ---------- */
    .discount-form-wrap .de-field{min-width:0}
    .discount-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .discount-form-wrap .de-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .discount-form-wrap .de-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .discount-form-wrap .de-help:hover{background:#6366f1;color:#fff}
    .discount-form-wrap .form-control{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .discount-form-wrap .form-control::placeholder{color:#a3b0c2}
    .discount-form-wrap .form-control:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .discount-form-wrap .form-control.is-invalid{border-color:#f43f5e;background-image:none}
    .discount-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .discount-form-wrap input[type=number]::-webkit-outer-spin-button,.discount-form-wrap input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .discount-form-wrap input[type=number]{-moz-appearance:textfield}

    /* percent input: number + % chip in one box */
    .discount-form-wrap .de-pct{display:flex;align-items:stretch;height:48px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;overflow:hidden;transition:.2s}
    .discount-form-wrap .de-pct .suf{flex:none;width:46px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:var(--i1);font-weight:800;font-size:15px;line-height:1;border-left:1.5px solid #e0e7ff}
    .discount-form-wrap .de-pct .form-control{flex:1;min-width:0;height:100%;min-height:0;border:0;border-radius:0;background:transparent;box-shadow:none;padding:0 14px;font-weight:600;font-variant-numeric:tabular-nums;line-height:normal}
    .discount-form-wrap .de-pct .form-control:focus{background:transparent;box-shadow:none;border:0}
    .discount-form-wrap .de-pct .form-control.is-invalid{border:0;background-image:none}
    .discount-form-wrap .de-pct:focus-within{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .discount-form-wrap .de-pct:focus-within .suf{background:#e0e7ff}
    .discount-form-wrap .de-pct.is-invalid{border-color:#f43f5e}

    /* live preview */
    .discount-form-wrap .de-preview{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:14px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .discount-form-wrap .de-preview .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .discount-form-wrap .de-preview .mi,.discount-form-wrap .de-preview .mi i{color:var(--i1)!important}
    .discount-form-wrap .de-preview small{display:block;font-size:12px;color:var(--mut);font-weight:600}
    .discount-form-wrap .de-preview b{display:block;font-size:16px;font-weight:800;color:var(--ink);letter-spacing:-.01em}

    /* status switch card */
    .discount-form-wrap .de-switch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 16px;border-radius:14px;border:1.5px solid #e2e8f0;background:#f8fafc;transition:.2s}
    .discount-form-wrap .de-switch.on{border-color:#a7f3d0;background:#ecfdf5}
    .discount-form-wrap .de-switch .tx b{display:block;font-size:14px;color:var(--ink)}
    .discount-form-wrap .de-switch .tx small{font-size:12px;color:var(--mut)}

    /* button */
    .discount-form-wrap .de-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:48px;border:0;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;font-size:14.5px;font-weight:700;cursor:pointer;box-shadow:0 14px 24px -14px rgba(79,70,229,.75);transition:.2s}
    .discount-form-wrap .de-btn i{color:inherit!important;font-size:13px}
    .discount-form-wrap .de-btn:hover{transform:translateY(-1px);box-shadow:0 18px 28px -14px rgba(79,70,229,.8)}

    .discount-form-wrap .de-hide{display:none!important}

    @media (max-width:575px){
        .discount-form-wrap .de-head{padding:16px}
        .discount-form-wrap .de-head h4{font-size:17px}
        .discount-form-wrap .de-card-h,.discount-form-wrap .de-card-b,.discount-form-wrap .de-card-f{padding-left:16px;padding-right:16px}
    }
</style>

@php
    $ds      = $data['discount'] ?? null;
    $dName   = old('name', optional($ds)->name);
    $dPct    = old('percent', optional($ds)->percent);
    $dActive = optional($ds)->status !== 'N';
@endphp

<div class="discount-form-wrap">
    <form action="{{ route('discount.update') }}" id="edit-discount-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- ===================== HEADER ===================== --}}
        <div class="de-head">
            <div class="de-av"><i class="fas fa-tag"></i></div>
            <div class="de-htext">
                <small>Editing discount</small>
                <h4 id="de_title">{{ $dName ?: 'Untitled discount' }}</h4>
            </div>
            <div class="de-hright">
                <span class="de-chip" id="de_chip">{{ ($dPct !== null && $dPct !== '') ? $dPct : '0' }}%</span>
                <label class="de-stat {{ $dActive ? 'on' : '' }}" id="de_stat" for="de_status_switch">
                    <span class="de-dot"></span>
                    <span id="de_status_txt">{{ $dActive ? 'Active' : 'Inactive' }}</span>
                    <input type="checkbox" class="de-sw sm" id="de_status_switch" {{ $dActive ? 'checked' : '' }}>
                </label>
            </div>
        </div>

        {{-- ===================== FORM CARD ===================== --}}
        <div class="de-card">
            <div class="de-card-h">
                <div class="de-chipi"><i class="fas fa-tag"></i></div>
                <div><h6>Discount details</h6><span>Name, rate &amp; visibility</span></div>
            </div>

            <div class="de-card-b">

                {{-- Discount Name --}}
                <div class="de-field">
                    <label class="form-label" for="id_name">
                        <i class="fas fa-tag de-li"></i>Discount name
                        <button type="button" class="de-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Shown on invoices next to the discount amount, e.g. Festive offer.">?</button>
                    </label>
                    <input type="text" name="name" id="id_name" class="form-control"
                        value="{{ old('name', optional($ds)->name) }}"
                        placeholder="Enter discount name">
                </div>

                {{-- Percent --}}
                <div class="de-field">
                    <label class="form-label" for="id_percent">
                        <i class="fas fa-calculator de-li"></i>Percent
                        <button type="button" class="de-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Discount rate deducted from the item amount.">?</button>
                    </label>
                    <div class="de-pct">
                        <input type="number" step="0.01" name="percent" id="id_percent" class="form-control"
                            value="{{ old('percent', optional($ds)->percent) }}"
                            placeholder="Enter percent">
                        <span class="suf">%</span>
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="de-preview">
                    <span class="mi"><i class="fas fa-calculator"></i></span>
                    <div>
                        <small>Example on ₹1,000.00</small>
                        <b id="de_preview_val">Enter a percent to preview</b>
                    </div>
                </div>

                {{-- Status --}}
                <div class="de-field">
                    <label class="form-label">
                        <i class="fas fa-toggle-on de-li"></i>Status
                        <button type="button" class="de-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivated discounts will not appear in the discount dropdowns.">?</button>
                    </label>
                    <div class="de-switch {{ $dActive ? 'on' : '' }}" id="de_switch">
                        <div class="tx">
                            <b id="de_switch_txt">{{ $dActive ? 'Active' : 'Inactive' }}</b>
                            <small>Available when adding items &amp; invoices</small>
                        </div>
                        <input type="checkbox" class="de-sw" id="de_switch_input" {{ $dActive ? 'checked' : '' }}>
                    </div>
                    <select name="status" id="id_status" class="de-hide">
                        <option value="Y" {{ $dActive ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ !$dActive ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <input type="hidden" name="discount_id" id="id_discount_id" value="{{ optional($ds)->discount_id }}">

                <div id="de_errs"></div>
            </div>

            <div class="de-card-f">
                <button type="submit" class="de-btn update-discount">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var form = document.getElementById('edit-discount-form');
    if (!form) return;
    var root = form.closest('.discount-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }

    /* ---------- tooltips (scoped) ---------- */
    if (window.bootstrap) {
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (t) { new bootstrap.Tooltip(t); });
    }

    /* ---------- header + live preview ---------- */
    var nameInp = q('#id_name'), pctInp = q('#id_percent');

    function money(n) { return '₹' + n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

    function refresh() {
        var n = nameInp.value.trim();
        q('#de_title').textContent = n || 'Untitled discount';

        var p = parseFloat(pctInp.value);
        var hasPct = !isNaN(p);
        q('#de_chip').textContent = (hasPct ? p : 0) + '%';

        var val = q('#de_preview_val');
        if (hasPct) {
            var off = 1000 * p / 100;
            val.textContent = 'Save ' + money(off) + ' \u2192 pay ' + money(1000 - off);
        } else {
            val.textContent = 'Enter a percent to preview';
        }
    }
    nameInp.addEventListener('input', refresh);
    pctInp.addEventListener('input', refresh);
    refresh();

    /* ---------- status (hidden select stays the source of truth) ---------- */
    function setStatus(on) {
        q('#id_status').value = on ? 'Y' : 'N';
        q('#de_status_switch').checked = on;
        q('#de_switch_input').checked = on;
        q('#de_stat').classList.toggle('on', on);
        q('#de_switch').classList.toggle('on', on);
        q('#de_status_txt').textContent = on ? 'Active' : 'Inactive';
        q('#de_switch_txt').textContent = on ? 'Active' : 'Inactive';
    }
    q('#de_status_switch').addEventListener('change', function () { setStatus(this.checked); });
    q('#de_switch_input').addEventListener('change', function () { setStatus(this.checked); });

    /* ---------- Enter key => update ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.update-discount');
        if (btn) btn.click();
    });

    /* ---------- AJAX update ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.deUpdate').on('click.deUpdate', '.update-discount', function (e) {
        var f = document.getElementById('edit-discount-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your discount.",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: f.action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#edit-discount-form .error').remove();
                $('#edit-discount-form .is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#edit-discount-form #id_' + field);
                        if (!inputField.length) inputField = $('#edit-discount-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.de-pct').addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.de-field');
                        // hidden fields (jaise discount_id) ka holder nahi hota, unka error neeche dikhega
                        if (holder.length) holder.append(errorHtml); else $('#de_errs').append(errorHtml);
                    });

                    const first = $('#edit-discount-form .error').first();
                    if (first.length && first[0].scrollIntoView) first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please check the form carefully!",
                        position: "center",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Discount Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        // If used inside a modal, close it and reload; otherwise go back to list
                        if ($('#editDiscount-modal').length) {
                            $('#editDiscount-modal').modal('hide');
                            location.reload();
                        } else {
                            window.location.href = "{{ route('discount.list') }}";
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                if (xhr.status === 403 && xhr.responseJSON?.redirect) {
                    window.location.href = xhr.responseJSON.redirect;
                } else {
                    console.error("Error:", xhr.responseText);
                }
            }
        });
    });
})();
</script>