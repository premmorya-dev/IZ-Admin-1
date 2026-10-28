@props([
    'submitText'  => 'Save',
    'submitClass' => '',
    'cancelText'  => 'Cancel',
    'icon'        => 'fa-save',
])

@once
<style>
    .iz-sticky-actions{position:sticky;bottom:0;z-index:20;display:flex;align-items:center;justify-content:flex-end;gap:12px;
        margin-top:24px;padding:14px 0 4px;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 28%);}
    .iz-sticky-actions::before{content:"";position:absolute;left:0;right:0;top:0;height:1px;background:#e8ebf3}

    .iz-sticky-actions .iz-sa-cancel,
    .iz-sticky-actions .iz-sa-submit{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:46px;padding:0 24px;border-radius:12px;
        font-size:14px;font-weight:700;line-height:1;white-space:nowrap;cursor:pointer;transition:.2s;text-decoration:none!important}

    /* Cancel (ghost) */
    .iz-sticky-actions .iz-sa-cancel{background:#fff;color:#334155;border:1.5px solid #e2e8f0;box-shadow:none}
    .iz-sticky-actions .iz-sa-cancel:hover{background:#f8f9ff;border-color:#c7d2fe;color:#4f46e5}

    /* Submit (gradient) */
    .iz-sticky-actions .iz-sa-submit{border:0;color:#fff!important;background:linear-gradient(135deg,#4f46e5,#7c3aed);
        box-shadow:0 12px 24px -12px rgba(79,70,229,.8)}
    .iz-sticky-actions .iz-sa-submit:hover{transform:translateY(-2px);box-shadow:0 18px 30px -14px rgba(79,70,229,.9)}
    .iz-sticky-actions .iz-sa-submit:active{transform:translateY(0)}
    .iz-sticky-actions .iz-sa-submit:disabled{opacity:.7;cursor:not-allowed;transform:none}

    /* icon hamesha white (theme ki global icon color rule override na kare) */
    .iz-sticky-actions .iz-sa-submit,
    .iz-sticky-actions .iz-sa-submit i,
    .iz-sticky-actions .iz-sa-submit i::before{color:#fff!important;-webkit-text-fill-color:#fff!important}
    .iz-sticky-actions .iz-sa-submit i{margin:0!important;font-size:14px}

    @media (max-width:575px){
        .iz-sticky-actions{gap:10px}
        .iz-sticky-actions .iz-sa-cancel,
        .iz-sticky-actions .iz-sa-submit{flex:1;padding:0 14px}
    }
</style>
@endonce

<div {{ $attributes->merge(['class' => 'iz-sticky-actions']) }}>
    <button type="button" class="btn iz-sa-cancel" data-bs-dismiss="modal">
        {{ $cancelText }}
    </button>

    <button type="submit" class="btn iz-sa-submit {{ $submitClass }}">
        <i class="fas {{ $icon }}"></i>
        {{ $submitText }}
    </button>
</div>