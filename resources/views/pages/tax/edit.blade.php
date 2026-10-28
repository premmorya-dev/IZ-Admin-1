<style>
    .tax-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .tax-form-wrap .te-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:18px 20px;border-radius:22px;color:#fff;margin-bottom:18px;
        background:radial-gradient(520px 200px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(380px 200px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .tax-form-wrap .te-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .tax-form-wrap .te-head > *{position:relative;z-index:1}
    .tax-form-wrap .te-av{flex:none;width:50px;height:50px;border-radius:15px;display:grid;place-items:center;font-size:18px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .tax-form-wrap .te-av,.tax-form-wrap .te-av i{color:#fff!important}
    .tax-form-wrap .te-htext{min-width:0;flex:1}
    .tax-form-wrap .te-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .tax-form-wrap .te-head h4{margin:0;color:#fff;font-size:19px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .tax-form-wrap .te-hright{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .tax-form-wrap .te-chip{display:inline-flex;align-items:center;padding:7px 13px;border-radius:99px;font-size:13px;font-weight:800;font-variant-numeric:tabular-nums;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .tax-form-wrap .te-dot{flex:none;width:7px;height:7px;border-radius:50%;background:currentColor}
    .tax-form-wrap .te-stat{display:inline-flex;align-items:center;gap:10px;margin:0;padding:5px 8px 5px 14px;border-radius:99px;font-size:12.5px;font-weight:700;cursor:pointer;
        background:rgba(251,113,133,.18);border:1px solid rgba(251,113,133,.4);color:#fda4af;transition:.2s}
    .tax-form-wrap .te-stat.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}

    /* ---------- custom switch ---------- */
    .tax-form-wrap .te-sw{-webkit-appearance:none;appearance:none;flex:none;position:relative;width:46px;height:26px;margin:0;padding:0;border:0;border-radius:99px;background:#cbd5e1;cursor:pointer;transition:.2s;outline:0}
    .tax-form-wrap .te-sw::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.3);transition:.2s}
    .tax-form-wrap .te-sw:checked{background:#10b981}
    .tax-form-wrap .te-sw:checked::after{transform:translateX(20px)}
    .tax-form-wrap .te-sw:focus-visible{box-shadow:0 0 0 4px rgba(99,102,241,.28)}
    .tax-form-wrap .te-sw.sm{width:40px;height:24px;background:rgba(255,255,255,.28)}
    .tax-form-wrap .te-sw.sm::after{width:18px;height:18px}
    .tax-form-wrap .te-sw.sm:checked{background:#10b981}
    .tax-form-wrap .te-sw.sm:checked::after{transform:translateX(16px)}

    /* ---------- card ---------- */
    .tax-form-wrap .te-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .tax-form-wrap .te-card-h{display:flex;align-items:center;gap:14px;padding:16px 22px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .tax-form-wrap .te-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;background:linear-gradient(135deg,#d97706,#fbbf24);box-shadow:0 10px 18px -10px rgba(245,158,11,.7)}
    .tax-form-wrap .te-chipi,.tax-form-wrap .te-chipi i,.tax-form-wrap .te-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .tax-form-wrap .te-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .tax-form-wrap .te-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .tax-form-wrap .te-card-b{display:grid;gap:22px;padding:22px}
    .tax-form-wrap .te-card-f{padding:16px 22px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}

    /* ---------- fields ---------- */
    .tax-form-wrap .te-field{min-width:0}
    .tax-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .tax-form-wrap .te-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .tax-form-wrap .req{color:#f43f5e;margin-left:-3px}
    .tax-form-wrap .te-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .tax-form-wrap .te-help:hover{background:#6366f1;color:#fff}
    .tax-form-wrap .form-control{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .tax-form-wrap .form-control::placeholder{color:#a3b0c2}
    .tax-form-wrap .form-control:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .tax-form-wrap .form-control.is-invalid{border-color:#f43f5e;background-image:none}
    .tax-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .tax-form-wrap input[type=number]::-webkit-outer-spin-button,.tax-form-wrap input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .tax-form-wrap input[type=number]{-moz-appearance:textfield}

    /* percent input: number + % chip in one box */
    .tax-form-wrap .te-pct{display:flex;align-items:stretch;height:48px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;overflow:hidden;transition:.2s}
    .tax-form-wrap .te-pct .suf{flex:none;width:46px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:var(--i1);font-weight:800;font-size:15px;line-height:1;border-left:1.5px solid #e0e7ff}
    .tax-form-wrap .te-pct .form-control{flex:1;min-width:0;height:100%;min-height:0;border:0;border-radius:0;background:transparent;box-shadow:none;padding:0 14px;font-weight:600;font-variant-numeric:tabular-nums;line-height:normal}
    .tax-form-wrap .te-pct .form-control:focus{background:transparent;box-shadow:none;border:0}
    .tax-form-wrap .te-pct .form-control.is-invalid{border:0;background-image:none}
    .tax-form-wrap .te-pct:focus-within{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .tax-form-wrap .te-pct:focus-within .suf{background:#e0e7ff}
    .tax-form-wrap .te-pct.is-invalid{border-color:#f43f5e}

    /* live preview */
    .tax-form-wrap .te-preview{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:14px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .tax-form-wrap .te-preview .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .tax-form-wrap .te-preview .mi,.tax-form-wrap .te-preview .mi i{color:var(--i1)!important}
    .tax-form-wrap .te-preview small{display:block;font-size:12px;color:var(--mut);font-weight:600}
    .tax-form-wrap .te-preview b{display:block;font-size:16px;font-weight:800;color:var(--ink);letter-spacing:-.01em}

    /* status switch card */
    .tax-form-wrap .te-switch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 16px;border-radius:14px;border:1.5px solid #e2e8f0;background:#f8fafc;transition:.2s}
    .tax-form-wrap .te-switch.on{border-color:#a7f3d0;background:#ecfdf5}
    .tax-form-wrap .te-switch .tx b{display:block;font-size:14px;color:var(--ink)}
    .tax-form-wrap .te-switch .tx small{font-size:12px;color:var(--mut)}

    /* button */
    .tax-form-wrap .te-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:48px;border:0;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;font-size:14.5px;font-weight:700;cursor:pointer;box-shadow:0 14px 24px -14px rgba(79,70,229,.75);transition:.2s}
    .tax-form-wrap .te-btn i{color:inherit!important;font-size:13px}
    .tax-form-wrap .te-btn:hover{transform:translateY(-1px);box-shadow:0 18px 28px -14px rgba(79,70,229,.8)}

    .tax-form-wrap .te-hide{display:none!important}

    @media (max-width:575px){
        .tax-form-wrap .te-head{padding:16px}
        .tax-form-wrap .te-head h4{font-size:17px}
        .tax-form-wrap .te-card-h,.tax-form-wrap .te-card-b,.tax-form-wrap .te-card-f{padding-left:16px;padding-right:16px}
    }
</style>

@php
    $tx      = $data['tax'] ?? null;
    $tName   = old('name', optional($tx)->name);
    $tPct    = old('percent', optional($tx)->percent);
    $tActive = optional($tx)->status !== 'N';
@endphp

<div class="tax-form-wrap">
    <form action="{{ route('tax.update') }}" id="edit-tax-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- ===================== HEADER ===================== --}}
        <div class="te-head">
            <div class="te-av"><i class="fas fa-percent"></i></div>
            <div class="te-htext">
                <small>Editing tax</small>
                <h4 id="te_title">{{ $tName ?: 'Untitled tax' }}</h4>
            </div>
            <div class="te-hright">
                <span class="te-chip" id="te_chip">{{ ($tPct !== null && $tPct !== '') ? $tPct : '0' }}%</span>
                <label class="te-stat {{ $tActive ? 'on' : '' }}" id="te_stat" for="te_status_switch">
                    <span class="te-dot"></span>
                    <span id="te_status_txt">{{ $tActive ? 'Active' : 'Inactive' }}</span>
                    <input type="checkbox" class="te-sw sm" id="te_status_switch" {{ $tActive ? 'checked' : '' }}>
                </label>
            </div>
        </div>

        {{-- ===================== FORM CARD ===================== --}}
        <div class="te-card">
            <div class="te-card-h">
                <div class="te-chipi"><i class="fas fa-percent"></i></div>
                <div><h6>Tax details</h6><span>Name, rate &amp; visibility</span></div>
            </div>

            <div class="te-card-b">

                {{-- Tax Name --}}
                <div class="te-field">
                    <label class="form-label" for="id_name">
                        <i class="fas fa-percent te-li"></i>Tax name
                        <button type="button" class="te-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Shown on invoices next to the tax amount, e.g. GST 18%.">?</button>
                    </label>
                    <input type="text" name="name" id="id_name" class="form-control"
                        value="{{ old('name', optional($tx)->name) }}"
                        placeholder="Enter tax name">
                </div>

                {{-- Percent --}}
                <div class="te-field">
                    <label class="form-label" for="id_percent">
                        <i class="fas fa-calculator te-li"></i>Percent
                        <button type="button" class="te-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Tax rate applied on the item amount.">?</button>
                    </label>
                    <div class="te-pct">
                        <input type="number" step="0.01" name="percent" id="id_percent" class="form-control"
                            value="{{ old('percent', optional($tx)->percent) }}"
                            placeholder="Enter percent">
                        <span class="suf">%</span>
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="te-preview">
                    <span class="mi"><i class="fas fa-calculator"></i></span>
                    <div>
                        <small>Example on ₹1,000.00</small>
                        <b id="te_preview_val">Enter a percent to preview</b>
                    </div>
                </div>

                {{-- Status --}}
                <div class="te-field">
                    <label class="form-label">
                        <i class="fas fa-toggle-on te-li"></i>Status
                        <button type="button" class="te-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivated taxes will not appear in the tax dropdowns.">?</button>
                    </label>
                    <div class="te-switch {{ $tActive ? 'on' : '' }}" id="te_switch">
                        <div class="tx">
                            <b id="te_switch_txt">{{ $tActive ? 'Active' : 'Inactive' }}</b>
                            <small>Available when adding items &amp; invoices</small>
                        </div>
                        <input type="checkbox" class="te-sw" id="te_switch_input" {{ $tActive ? 'checked' : '' }}>
                    </div>
                    <select name="status" id="id_status" class="te-hide">
                        <option value="Y" {{ $tActive ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ !$tActive ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <input type="hidden" name="tax_id" id="id_tax_id" value="{{ optional($tx)->tax_id }}">

                <div id="te_errs"></div>
            </div>

            <div class="te-card-f">
                <button type="submit" class="te-btn update-tax">
                    <i class="fas fa-save"></i> Update Tax
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var form = document.getElementById('edit-tax-form');
    if (!form) return;
    var root = form.closest('.tax-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }

    /* ---------- tooltips (scoped) ---------- */
    if (window.bootstrap) {
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (t) { new bootstrap.Tooltip(t); });
    }

    /* ---------- header + live preview ---------- */
    var nameInp = q('#id_name'), pctInp = q('#id_percent');

    function refresh() {
        var n = nameInp.value.trim();
        q('#te_title').textContent = n || 'Untitled tax';

        var p = parseFloat(pctInp.value);
        var hasPct = !isNaN(p);
        q('#te_chip').textContent = (hasPct ? p : 0) + '%';

        var val = q('#te_preview_val');
        if (hasPct) {
            var amt = 1000 * p / 100;
            val.textContent = '₹' + amt.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' tax';
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
        q('#te_status_switch').checked = on;
        q('#te_switch_input').checked = on;
        q('#te_stat').classList.toggle('on', on);
        q('#te_switch').classList.toggle('on', on);
        q('#te_status_txt').textContent = on ? 'Active' : 'Inactive';
        q('#te_switch_txt').textContent = on ? 'Active' : 'Inactive';
    }
    q('#te_status_switch').addEventListener('change', function () { setStatus(this.checked); });
    q('#te_switch_input').addEventListener('change', function () { setStatus(this.checked); });

    /* ---------- Enter key => update ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.update-tax');
        if (btn) btn.click();
    });

    /* ---------- AJAX update ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.teUpdate').on('click.teUpdate', '.update-tax', function (e) {
        var f = document.getElementById('edit-tax-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we save your tax.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
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
                $('#edit-tax-form .error').remove();
                $('#edit-tax-form .is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#edit-tax-form #id_' + field);
                        if (!inputField.length) inputField = $('#edit-tax-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.te-pct').addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.te-field');
                        // hidden fields (jaise tax_id) ka holder nahi hota, unka error neeche dikhega
                        if (holder.length) holder.append(errorHtml); else $('#te_errs').append(errorHtml);
                    });

                    const first = $('#edit-tax-form .error').first();
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
                        title: "Tax Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#editTax-modal').modal('hide');
                        location.reload();
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