

@props([
'id',
'name',
'label',
'placeholder' => '',
'value' => '',
'icon' => 'calendar-event',
'required' => false,
'helper' => null,
])

<div class="invoice-date-field">

    <label
        for="{{ $id }}"
        class="invoice-date-label {{ $required ? 'required' : '' }}">

        <i class="bi bi-{{ $icon }}"></i>

        {{ $label }}

    </label>

    <div class="input-group invoice-date-group">

        <span class="input-group-text">

            <i class="bi bi-calendar3"></i>

        </span>

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="text"
            class="form-control date-bg-blue"

            placeholder="{{ $placeholder }}"

            value="{{ old($name,$value) }}">

    </div>

    @if($helper)

    <small class="invoice-date-helper">

        {{ $helper }}

    </small>

    @endif

</div>