<div>
    {{-- Label --}}
    @if ($label)
        <label for="{{ $name }}" class="font-weight-bold">
            @if ($icon)
                <i class="fas {{ $icon }} mr-1"></i>
            @endif
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    {{-- Select --}}
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{
            $attributes->class([
                'form-control',
                'is-invalid' => $errors->has($name),
            ])
        }}
        {{ $attributes->whereStartsWith('wire:model') }}
        @if ($required) required @endif
        @if ($disabled) disabled @endif
    >
        {{ $slot }}
    </select>

    {{-- Error --}}
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    {{-- Help Text --}}
    @if ($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
</div>
