

<style>
    .btn.btn-add-saas {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 42px;
        padding: 0 20px;
        border: 0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        white-space: nowrap;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        box-shadow: 0 8px 18px -8px rgba(79, 70, 229, .65);
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .btn.btn-add-saas svg,
    .btn.btn-add-saas i { width: 16px; height: 16px; }

    .btn.btn-add-saas:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -8px rgba(79, 70, 229, .75);
    }

    .btn.btn-add-saas:focus-visible {
        outline: 0;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .35), 0 8px 18px -8px rgba(79, 70, 229, .65);
    }

    @media (max-width: 575.98px) {
        .btn.btn-add-saas { width: 100%; }
    }
</style>


<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'btn btn-add-saas']) }}
>
    @isset($icon)
        <i data-lucide="{{ $icon }}"></i>
    @endisset

    <span>{{ $slot }}</span>
</a>
