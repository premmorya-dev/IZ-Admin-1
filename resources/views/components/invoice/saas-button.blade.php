<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'btn btn-add-saas']) }}
>
    @isset($icon)
        <i data-lucide="{{ $icon }}"></i>
    @endisset

    <span>{{ $slot }}</span>
</a>