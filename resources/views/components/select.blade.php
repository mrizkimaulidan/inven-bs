<div class="form-group">
    {{-- Label with optional icon and required marker. --}}
    @if ($label)
        <label for="{{ $id ?? $name }}">
            @if ($icon)
                <i class="fas {{ $icon }} mr-1"></i>
            @endif
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    {{-- Select field. Caller-supplied attributes (wire:model, multiple, etc.)
         are merged onto the element. --}}
    <select
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        @required($required)
        @disabled($disabled)
    >
        {{ $slot }}
    </select>

    {{-- Validation error message. --}}
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    {{-- Helper text. --}}
    @if ($help)
        <div class="form-text text-muted">{{ $help }}</div>
    @endif
</div>
