<style>
    .upi-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .upi-form-wrap .ue-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:18px 20px;border-radius:22px;color:#fff;margin-bottom:18px;
        background:radial-gradient(520px 200px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(380px 200px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .upi-form-wrap .ue-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .upi-form-wrap .ue-head > *{position:relative;z-index:1}
    .upi-form-wrap .ue-av{flex:none;width:50px;height:50px;border-radius:15px;display:grid;place-items:center;font-size:18px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .upi-form-wrap .ue-av,.upi-form-wrap .ue-av i{color:#fff!important}
    .upi-form-wrap .ue-htext{min-width:0;flex:1}
    .upi-form-wrap .ue-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .upi-form-wrap .ue-head h4{margin:0;color:#fff;font-size:19px;font-weight:800;letter-spacing:-.02em;word-break:break-word}
    .upi-form-wrap .ue-hright{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .upi-form-wrap .ue-chip{display:inline-flex;align-items:center;padding:7px 13px;border-radius:99px;font-size:13px;font-weight:800;font-variant-numeric:tabular-nums;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#fff}
    .upi-form-wrap .ue-dot{flex:none;width:7px;height:7px;border-radius:50%;background:currentColor}
    .upi-form-wrap .ue-stat{display:inline-flex;align-items:center;gap:10px;margin:0;padding:5px 8px 5px 14px;border-radius:99px;font-size:12.5px;font-weight:700;cursor:pointer;
        background:rgba(251,113,133,.18);border:1px solid rgba(251,113,133,.4);color:#fda4af;transition:.2s}
    .upi-form-wrap .ue-stat.on{background:rgba(52,211,153,.18);border-color:rgba(52,211,153,.4);color:#6ee7b7}

    /* ---------- custom switch ---------- */
    .upi-form-wrap .ue-sw{-webkit-appearance:none;appearance:none;flex:none;position:relative;width:46px;height:26px;margin:0;padding:0;border:0;border-radius:99px;background:#cbd5e1;cursor:pointer;transition:.2s;outline:0}
    .upi-form-wrap .ue-sw::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.3);transition:.2s}
    .upi-form-wrap .ue-sw:checked{background:#10b981}
    .upi-form-wrap .ue-sw:checked::after{transform:translateX(20px)}
    .upi-form-wrap .ue-sw:focus-visible{box-shadow:0 0 0 4px rgba(99,102,241,.28)}
    .upi-form-wrap .ue-sw.sm{width:40px;height:24px;background:rgba(255,255,255,.28)}
    .upi-form-wrap .ue-sw.sm::after{width:18px;height:18px}
    .upi-form-wrap .ue-sw.sm:checked{background:#10b981}
    .upi-form-wrap .ue-sw.sm:checked::after{transform:translateX(16px)}

    /* ---------- card ---------- */
    .upi-form-wrap .ue-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .upi-form-wrap .ue-card-h{display:flex;align-items:center;gap:14px;padding:16px 22px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .upi-form-wrap .ue-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;background:linear-gradient(135deg,#d97706,#fbbf24);box-shadow:0 10px 18px -10px rgba(245,158,11,.7)}
    .upi-form-wrap .ue-chipi,.upi-form-wrap .ue-chipi i,.upi-form-wrap .ue-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .upi-form-wrap .ue-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .upi-form-wrap .ue-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .upi-form-wrap .ue-card-b{display:grid;gap:22px;padding:22px}
    .upi-form-wrap .ue-card-f{padding:16px 22px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}

    /* ---------- fields ---------- */
    .upi-form-wrap .ue-field{min-width:0}
    .upi-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .upi-form-wrap .ue-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .upi-form-wrap .ue-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .upi-form-wrap .ue-help:hover{background:#6366f1;color:#fff}
    .upi-form-wrap .form-control{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .upi-form-wrap .form-control::placeholder{color:#a3b0c2}
    .upi-form-wrap .form-control:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .upi-form-wrap .form-control.is-invalid{border-color:#f43f5e;background-image:none}
    .upi-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}
    .upi-form-wrap input[type=number]::-webkit-outer-spin-button,.upi-form-wrap input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .upi-form-wrap input[type=number]{-moz-appearance:textfield}

    /* input box with chip */
    .upi-form-wrap .ue-box{display:flex;align-items:stretch;height:48px;border:1.5px solid #e2e8f0;border-radius:12px;background:#f8fafc;overflow:hidden;transition:.2s}
    .upi-form-wrap .ue-box .suf{flex:none;width:46px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:var(--i1);font-weight:800;font-size:15px;line-height:1;border-left:1.5px solid #e0e7ff}
    .upi-form-wrap .ue-box .form-control{flex:1;min-width:0;height:100%;min-height:0;border:0;border-radius:0;background:transparent;box-shadow:none;padding:0 14px;font-weight:600;font-variant-numeric:tabular-nums;line-height:normal}
    .upi-form-wrap .ue-box .form-control:focus{background:transparent;box-shadow:none;border:0}
    .upi-form-wrap .ue-box .form-control.is-invalid{border:0;background-image:none}
    .upi-form-wrap .ue-box:focus-within{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .upi-form-wrap .ue-box:focus-within .suf{background:#e0e7ff}
    .upi-form-wrap .ue-box.is-invalid{border-color:#f43f5e}

    /* live preview */
    .upi-form-wrap .ue-preview{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:14px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .upi-form-wrap .ue-preview .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .upi-form-wrap .ue-preview .mi,.upi-form-wrap .ue-preview .mi i{color:var(--i1)!important}
    .upi-form-wrap .ue-preview small{display:block;font-size:12px;color:var(--mut);font-weight:600}
    .upi-form-wrap .ue-preview b{display:block;font-size:16px;font-weight:800;color:var(--ink);letter-spacing:-.01em}

    /* status switch card */
    .upi-form-wrap .ue-switch{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 16px;border-radius:14px;border:1.5px solid #e2e8f0;background:#f8fafc;transition:.2s}
    .upi-form-wrap .ue-switch.on{border-color:#a7f3d0;background:#ecfdf5}
    .upi-form-wrap .ue-switch .tx b{display:block;font-size:14px;color:var(--ink)}
    .upi-form-wrap .ue-switch .tx small{font-size:12px;color:var(--mut)}

    /* button */
    .upi-form-wrap .ue-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:48px;border:0;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;font-size:14.5px;font-weight:700;cursor:pointer;box-shadow:0 14px 24px -14px rgba(79,70,229,.75);transition:.2s}
    .upi-form-wrap .ue-btn i{color:inherit!important;font-size:13px}
    .upi-form-wrap .ue-btn:hover{transform:translateY(-1px);box-shadow:0 18px 28px -14px rgba(79,70,229,.8)}

    .upi-form-wrap .ue-hide{display:none!important}

    @media (max-width:575px){
        .upi-form-wrap .ue-head{padding:16px}
        .upi-form-wrap .ue-head h4{font-size:17px}
        .upi-form-wrap .ue-card-h,.upi-form-wrap .ue-card-b,.upi-form-wrap .ue-card-f{padding-left:16px;padding-right:16px}
    }

    /* upi id box: icon chip on the left */
    .upi-form-wrap .ue-box .pre{flex:none;width:46px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:var(--i1);font-size:14px;border-right:1.5px solid #e0e7ff}
    .upi-form-wrap .ue-box .pre i{color:inherit!important}
    .upi-form-wrap .ue-box:focus-within .pre{background:#e0e7ff}
    .upi-form-wrap .ue-chip{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:700}
    .upi-form-wrap .ue-preview b{word-break:break-all}
    .upi-form-wrap .ue-preview.pos .mi,.upi-form-wrap .ue-preview.pos .mi i{color:#047857!important}
    .upi-form-wrap .ue-preview.pos{background:linear-gradient(135deg,#ecfdf5,#f0fdf4);border-color:#a7f3d0}
</style>

@php
    $up      = $data['upi_id'] ?? null;
    $uName   = old('upi_name', optional($up)->upi_name);
    $uId     = old('upi_id', optional($up)->upi_id);
    $uActive = old('status', optional($up)->status) !== 'N';
@endphp

<div class="upi-form-wrap">
    <form action="{{ route('upi_id.update') }}" id="edit-upi-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- ===================== HEADER ===================== --}}
        <div class="ue-head">
            <div class="ue-av"><i class="fas fa-qrcode"></i></div>
            <div class="ue-htext">
                <small>Editing UPI ID</small>
                <h4 id="ue_title">{{ $uName ?: 'Untitled UPI' }}</h4>
            </div>
            <div class="ue-hright">
                <span class="ue-chip" id="ue_chip">{{ $uId ?: 'name@bank' }}</span>
                <label class="ue-stat {{ $uActive ? 'on' : '' }}" id="ue_stat" for="ue_status_switch">
                    <span class="ue-dot"></span>
                    <span id="ue_status_txt">{{ $uActive ? 'Active' : 'Inactive' }}</span>
                    <input type="checkbox" class="ue-sw sm" id="ue_status_switch" {{ $uActive ? 'checked' : '' }}>
                </label>
            </div>
        </div>

        {{-- ===================== FORM CARD ===================== --}}
        <div class="ue-card">
            <div class="ue-card-h">
                <div class="ue-chipi"><i class="fas fa-qrcode"></i></div>
                <div><h6>UPI details</h6><span>Name, UPI ID &amp; visibility</span></div>
            </div>

            <div class="ue-card-b">

                {{-- UPI Name --}}
                <div class="ue-field">
                    <label class="form-label" for="id_upi_name">
                        <i class="fas fa-user ue-li"></i>UPI name
                        <button type="button" class="ue-help" data-bs-toggle="tooltip" data-bs-placement="top" title="A name to recognise this UPI ID, e.g. your business name.">?</button>
                    </label>
                    <input type="text" name="upi_name" id="id_upi_name" class="form-control"
                        value="{{ old('upi_name', optional($up)->upi_name) }}"
                        placeholder="Upi Name">
                </div>

                {{-- UPI ID --}}
                <div class="ue-field">
                    <label class="form-label" for="id_upi_id">
                        <i class="fas fa-at ue-li"></i>UPI ID
                        <button type="button" class="ue-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Your UPI address, e.g. name@okhdfcbank. Customers pay to this ID.">?</button>
                    </label>
                    <div class="ue-box">
                        <span class="pre"><i class="fas fa-at"></i></span>
                        <input type="text" name="upi_id" id="id_upi_id" class="form-control"
                            value="{{ old('upi_id', optional($up)->upi_id) }}"
                            placeholder="Upi Id" autocomplete="off" spellcheck="false">
                    </div>
                </div>

                {{-- Live preview (UI only) --}}
                <div class="ue-preview" id="ue_preview">
                    <span class="mi"><i class="fas fa-qrcode" id="ue_preview_icon"></i></span>
                    <div>
                        <small id="ue_preview_label">Payments will go to</small>
                        <b id="ue_preview_val">Enter a UPI ID to preview</b>
                    </div>
                </div>

                {{-- Status --}}
                <div class="ue-field">
                    <label class="form-label">
                        <i class="fas fa-toggle-on ue-li"></i>Status
                        <button type="button" class="ue-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivated UPI IDs will not be available on invoices.">?</button>
                    </label>
                    <div class="ue-switch {{ $uActive ? 'on' : '' }}" id="ue_switch">
                        <div class="tx">
                            <b id="ue_switch_txt">{{ $uActive ? 'Active' : 'Inactive' }}</b>
                            <small>Available for receiving payments</small>
                        </div>
                        <input type="checkbox" class="ue-sw" id="ue_switch_input" {{ $uActive ? 'checked' : '' }}>
                    </div>
                    <select name="status" id="id_status" class="ue-hide">
                        <option value="Y" {{ $uActive ? 'selected' : '' }}>Active</option>
                        <option value="N" {{ !$uActive ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>

                <input type="hidden" name="upi_log_id" id="id_upi_log_id" value="{{ optional($up)->upi_log_id }}">

                <div id="ue_errs"></div>
            </div>

            <div class="ue-card-f">
                <button type="submit" class="ue-btn update-upi">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var form = document.getElementById('edit-upi-form');
    if (!form) return;
    var root = form.closest('.upi-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }

    /* ---------- tooltips (scoped) ---------- */
    if (window.bootstrap) {
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (t) { new bootstrap.Tooltip(t); });
    }

    /* ---------- header + live preview (UI only, submit ko block nahi karta) ---------- */
    var nameInp = q('#id_upi_name'), idInp = q('#id_upi_id');
    var fmt = /^[A-Za-z0-9._\-]{2,256}@[A-Za-z][A-Za-z0-9]{1,63}$/;

    function refresh() {
        var n = nameInp.value.trim();
        var id = idInp.value.trim();
        q('#ue_title').textContent = n || 'Untitled UPI';
        q('#ue_chip').textContent = id || 'name@bank';

        var box = q('#ue_preview'), val = q('#ue_preview_val'), lbl = q('#ue_preview_label'), ico = q('#ue_preview_icon');
        box.classList.remove('pos');
        if (!id) {
            val.textContent = 'Enter a UPI ID to preview';
            lbl.textContent = 'Payments will go to';
            ico.className = 'fas fa-qrcode';
        } else if (fmt.test(id)) {
            val.textContent = id;
            lbl.textContent = 'Looks like a valid UPI ID';
            ico.className = 'fas fa-circle-check';
            box.classList.add('pos');
        } else {
            val.textContent = id;
            lbl.textContent = 'UPI IDs usually look like name@bank';
            ico.className = 'fas fa-qrcode';
        }
    }
    nameInp.addEventListener('input', refresh);
    idInp.addEventListener('input', refresh);
    refresh();

    /* ---------- status (hidden select stays the source of truth) ---------- */
    function setStatus(on) {
        q('#id_status').value = on ? 'Y' : 'N';
        q('#ue_status_switch').checked = on;
        q('#ue_switch_input').checked = on;
        q('#ue_stat').classList.toggle('on', on);
        q('#ue_switch').classList.toggle('on', on);
        q('#ue_status_txt').textContent = on ? 'Active' : 'Inactive';
        q('#ue_switch_txt').textContent = on ? 'Active' : 'Inactive';
    }
    q('#ue_status_switch').addEventListener('change', function () { setStatus(this.checked); });
    q('#ue_switch_input').addEventListener('change', function () { setStatus(this.checked); });

    /* ---------- Enter key => update ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.update-upi');
        if (btn) btn.click();
    });

    /* ---------- AJAX update ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.ueUpdate').on('click.ueUpdate', '.update-upi', function (e) {
        var f = document.getElementById('edit-upi-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        Swal.fire({
            title: "Updating...",
            text: "Please wait while we update the Upi Id.",
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
                $('#edit-upi-form .error').remove();
                $('#edit-upi-form .is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        // original code name se dhundta tha (inputs par id nahi thi), wahi rakha hai
                        let inputField = $('#edit-upi-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');
                        inputField.closest('.ue-box').addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.ue-field');
                        // hidden fields (jaise upi_log_id) ka holder nahi hota, unka error neeche dikhega
                        if (holder.length) holder.append(errorHtml); else $('#ue_errs').append(errorHtml);
                    });

                    const first = $('#edit-upi-form .error').first();
                    if (first.length && first[0].scrollIntoView) first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please fix the errors.",
                        position: "center",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Upi Id Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        // Modal ke andar ho to band karke reload, warna list page par wapas
                        if ($('#editUpi-modal').length) {
                            $('#editUpi-modal').modal('hide');
                            location.reload();
                        } else {
                            window.location.href = "{{ route('upi_id.list') }}";
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                console.error("Error:", xhr.responseText);
            }
        });
    });
})();
</script>