<div {{ $attributes->merge(['class' => 'iz-sticky-actions']) }}>
     <button
        type="button"
        class="btn btn-iz-secondary"
        data-bs-dismiss="modal">
        {{ $cancelText ?? 'Cancel' }}
    </button>

    <button
        type="{{ $submitType ?? 'submit' }}"
        class="btn btn-sm btn-primary {{ $submitClass ?? '' }}">

        @isset($icon)
        <i class="{{ $icon }} me-1 text-white"></i>
        @else
        <i class="fas fa-save me-1 text-white"></i>
        @endisset

        {{ $submitText ?? 'Save' }}
    </button>
</div>