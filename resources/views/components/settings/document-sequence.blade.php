<div class="set-card {{ $class ?? '' }}">
    <h6 class="set-card-title">{{ $title }}</h6>
    <p class="set-card-desc">{{ $description }}</p>

    <div class="row g-3">

        <div class="col-md-3 set-field">
            <label class="form-label">
                {{ $label }} Prefix <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="{{ $name }}_prefix"
                class="form-control @error($name.'_prefix') is-invalid @enderror"
                value="{{ old($name.'_prefix', $sequence->prefix) }}"
                placeholder="{{ $placeholder }}"
            >

            <small class="set-hint">
                Example: {{ $placeholder }}
            </small>

            @error($name.'_prefix')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-3 set-field">
            <label class="form-label">
                Number Padding <span class="text-danger">*</span>
            </label>

            <select
                name="{{ $name }}_padding"
                class="form-select @error($name.'_padding') is-invalid @enderror">

                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}"
                        {{ old($name.'_padding', $sequence->padding) == $i ? 'selected' : '' }}>
                        {{ $i }} Digit{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor

            </select>

            <small class="set-hint">
                Example: 0001, 00001
            </small>

            @error($name.'_padding')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-3 set-field">
            <label class="form-label">
                Start From <span class="text-danger">*</span>
            </label>

            <input
                type="number"
                min="1"
                name="{{ $name }}_start_from"
                class="form-control @error($name.'_start_from') is-invalid @enderror"
                value="{{ old($name.'_start_from', $sequence->start_from) }}"
                {{ $sequence->next_number != $sequence->start_from ? 'readonly' : '' }}
            >

            <small class="set-hint">
                Starting {{ strtolower($label) }} sequence number.
            </small>

            @error($name.'_start_from')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-3 set-field">
            <label class="form-label">
                Next {{ $label }} Number
            </label>

            <input
                type="text"
                class="form-control fw-bold bg-light"
                value="{{ $sequence->preview() }}"
                readonly
            >
        </div>

    </div>
</div>