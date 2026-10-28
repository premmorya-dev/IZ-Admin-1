<style>
    .icat-form-wrap{--i1:#4f46e5;--i2:#7c3aed;--bd:#e8ebf3;--mut:#64748b;--ink:#0f172a;font-family:inherit}

    /* ---------- header ---------- */
    .icat-form-wrap .ic-head{position:relative;overflow:hidden;display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:18px 20px;border-radius:22px;color:#fff;margin-bottom:18px;
        background:radial-gradient(520px 200px at 0% 0%,#4f46e5 0%,transparent 65%),radial-gradient(380px 200px at 100% 100%,#7c3aed 0%,transparent 60%),#0f172a;
        box-shadow:0 22px 44px -26px rgba(79,70,229,.6)}
    .icat-form-wrap .ic-head::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:32px 32px;-webkit-mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%);mask-image:radial-gradient(circle at 15% 20%,#000,transparent 75%)}
    .icat-form-wrap .ic-head > *{position:relative;z-index:1}
    .icat-form-wrap .ic-av{flex:none;width:50px;height:50px;border-radius:15px;display:grid;place-items:center;font-size:18px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28)}
    .icat-form-wrap .ic-av,.icat-form-wrap .ic-av i{color:#fff!important}
    .icat-form-wrap .ic-htext{min-width:0;flex:1}
    .icat-form-wrap .ic-head small{display:block;color:#c7d2fe;font-size:11.5px;text-transform:uppercase;letter-spacing:.14em;margin-bottom:3px}
    .icat-form-wrap .ic-head h4{margin:0;color:#fff;font-size:19px;font-weight:800;letter-spacing:-.02em;word-break:break-word}

    /* ---------- card ---------- */
    .icat-form-wrap .ic-card{background:#fff;border:1px solid var(--bd);border-radius:22px;box-shadow:0 10px 30px -22px rgba(15,23,42,.22)}
    .icat-form-wrap .ic-card-h{display:flex;align-items:center;gap:14px;padding:16px 22px;border-bottom:1px solid var(--bd);background:linear-gradient(180deg,#fcfcff,#fff);border-radius:22px 22px 0 0}
    .icat-form-wrap .ic-chipi{flex:none;width:42px;height:42px;border-radius:13px;display:grid;place-items:center;font-size:17px;background:linear-gradient(135deg,#0284c7,#38bdf8);box-shadow:0 10px 18px -10px rgba(14,165,233,.7)}
    .icat-form-wrap .ic-chipi,.icat-form-wrap .ic-chipi i,.icat-form-wrap .ic-chipi i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .icat-form-wrap .ic-card-h h6{margin:0;font-size:16px;font-weight:700;color:var(--ink)}
    .icat-form-wrap .ic-card-h span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}
    .icat-form-wrap .ic-card-b{display:grid;gap:22px;padding:22px}
    .icat-form-wrap .ic-card-f{padding:16px 22px;border-top:1px solid var(--bd);background:#fafbff;border-radius:0 0 22px 22px}

    /* ---------- fields ---------- */
    .icat-form-wrap .ic-field{min-width:0}
    .icat-form-wrap .form-label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;min-height:22px}
    .icat-form-wrap .ic-li{color:#818cf8;font-size:12px;width:14px;text-align:center;flex:none}
    .icat-form-wrap .ic-help{flex:none;display:inline-grid;place-items:center;width:17px;height:17px;padding:0;border:0;border-radius:50%;font-size:10.5px;font-weight:800;line-height:1;background:#eef2ff;color:#6366f1;cursor:help;transition:.2s}
    .icat-form-wrap .ic-help:hover{background:#6366f1;color:#fff}
    .icat-form-wrap .form-control{min-height:48px;border-radius:12px;border:1.5px solid #e2e8f0;background-color:#f8fafc;font-size:14.5px;color:var(--ink);transition:.2s}
    .icat-form-wrap .form-control::placeholder{color:#a3b0c2}
    .icat-form-wrap .form-control:focus{background-color:#fff;border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.14)}
    .icat-form-wrap .form-control.is-invalid{border-color:#f43f5e;background-image:none}
    .icat-form-wrap .error{font-size:12.5px;font-weight:500;margin-top:6px}

    /* live preview */
    .icat-form-wrap .ic-preview{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:14px 18px;border-radius:16px;background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:1px solid #e0e7ff}
    .icat-form-wrap .ic-preview .mi{flex:none;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#fff;box-shadow:0 6px 14px -8px rgba(79,70,229,.5)}
    .icat-form-wrap .ic-preview .mi,.icat-form-wrap .ic-preview .mi i{color:var(--i1)!important}
    .icat-form-wrap .ic-preview small{display:block;font-size:12px;color:var(--mut);font-weight:600}
    .icat-form-wrap .ic-preview b{display:block;font-size:16px;font-weight:800;color:var(--ink);letter-spacing:-.01em;word-break:break-word}

    /* button */
    .icat-form-wrap .ic-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:48px;border:0;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;font-size:14.5px;font-weight:700;cursor:pointer;box-shadow:0 14px 24px -14px rgba(79,70,229,.75);transition:.2s}
    .icat-form-wrap .ic-btn i{color:inherit!important;font-size:13px}
    .icat-form-wrap .ic-btn:hover{transform:translateY(-1px);box-shadow:0 18px 28px -14px rgba(79,70,229,.8)}

    @media (max-width:575px){
        .icat-form-wrap .ic-head{padding:16px}
        .icat-form-wrap .ic-head h4{font-size:17px}
        .icat-form-wrap .ic-card-h,.icat-form-wrap .ic-card-b,.icat-form-wrap .ic-card-f{padding-left:16px;padding-right:16px}
    }
</style>

@php
    $ic      = $data['item_categories'] ?? null;
    $icName  = old('item_category_name', optional($ic)->item_category_name);
@endphp

<div class="icat-form-wrap">
    <form action="{{ route('item.category.update') }}" id="edit-item-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- ===================== HEADER ===================== --}}
        <div class="ic-head">
            <div class="ic-av"><i class="fas fa-layer-group"></i></div>
            <div class="ic-htext">
                <small>Editing item category</small>
                <h4 id="ic_title">{{ $icName ?: 'Untitled category' }}</h4>
            </div>
        </div>

        {{-- ===================== FORM CARD ===================== --}}
        <div class="ic-card">
            <div class="ic-card-h">
                <div class="ic-chipi"><i class="fas fa-layer-group"></i></div>
                <div><h6>Category details</h6><span>Group similar items together</span></div>
            </div>

            <div class="ic-card-b">

                <div class="ic-field">
                    <label class="form-label" for="id_item_category_name">
                        <i class="fas fa-tag ic-li"></i>Category name
                        <button type="button" class="ic-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Used to group similar items together for easier organization.">?</button>
                    </label>
                    <input type="text" name="item_category_name" id="id_item_category_name" class="form-control"
                        value="{{ old('item_category_name', optional($ic)->item_category_name) }}"
                        placeholder="e.g. Electronics">
                </div>

                {{-- Live preview (UI only) --}}
                <div class="ic-preview">
                    <span class="mi"><i class="fas fa-layer-group"></i></span>
                    <div>
                        <small>Shown in the item category dropdown as</small>
                        <b id="ic_preview_val">Enter a category name to preview</b>
                    </div>
                </div>

                <input type="hidden" name="item_category_code" value="{{ optional($ic)->item_category_code }}">

                <div id="ic_errs"></div>
            </div>

            <div class="ic-card-f">
                <button type="submit" class="ic-btn update-item-category">
                    <i class="fas fa-save"></i> Update Item Category
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var form = document.getElementById('edit-item-form');
    if (!form) return;
    var root = form.closest('.icat-form-wrap') || form;

    function q(sel) { return root.querySelector(sel); }

    /* ---------- tooltips (scoped) ---------- */
    if (window.bootstrap) {
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (t) { new bootstrap.Tooltip(t); });
    }

    /* ---------- header + live preview ---------- */
    var nameInp = q('#id_item_category_name');
    function refresh() {
        var n = nameInp.value.trim();
        q('#ic_title').textContent = n || 'Untitled category';
        q('#ic_preview_val').textContent = n || 'Enter a category name to preview';
    }
    nameInp.addEventListener('input', refresh);
    refresh();

    /* ---------- Enter key => update ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.querySelector('.update-item-category');
        if (btn) btn.click();
    });

    /* ---------- AJAX update ---------- */
    var $ = window.jQuery;
    if (!$) return;

    $(document).off('click.icUpdate').on('click.icUpdate', '.update-item-category', function (e) {
        var f = document.getElementById('edit-item-form');
        if (!f) return;
        e.preventDefault();

        const formData = new FormData(f);

        Swal.fire({
            title: "Processing...",
            text: "Please wait while we update your Item Category.",
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
                $('#edit-item-form .error').remove();
                $('#edit-item-form .is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                Swal.close();

                if (response.error === 1) {
                    $.each(response.errors, function(field, messages) {
                        let inputField = $('#edit-item-form #id_' + field);
                        if (!inputField.length) inputField = $('#edit-item-form [name="' + field + '"]');
                        if (!inputField.length) return;

                        inputField.addClass('is-invalid');

                        const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;
                        const holder = inputField.closest('.ic-field');
                        // hidden fields (jaise item_category_code) ka holder nahi hota, unka error neeche dikhega
                        if (holder.length) holder.append(errorHtml); else $('#ic_errs').append(errorHtml);
                    });

                    const first = $('#edit-item-form .error').first();
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
                        title: "Item Category Updated Successfully!",
                        text: response.message,
                        position: "center",
                        toast: false, // make it popup centered, not small toast
                        showConfirmButton: false,
                        timer: 2000 // show for 2 seconds
                    }).then(function() {
                        $('#editItem-modal').modal('hide');
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