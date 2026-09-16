<div>
    <div class="form-group">
        @if ($label)
            <label for="{{ $name }}">
                @if ($icon)
                    <i class="fas {{ $icon }} mr-1"></i>
                @endif
                {{ $label }}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </label>
        @endif

        <input
            {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
            id="{{ $name }}"
            name="{{ $name }}"
            @required($required)
        />

        @if ($help)
            <div class="form-text text-muted">{{ $help }}</div>
        @endif

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
