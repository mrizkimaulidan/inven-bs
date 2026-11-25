@php
    $fieldId = filled($id ?? null) ? (string) $id : $name;
    $iconClass = is_string($icon) ? trim($icon) : '';
@endphp

<div class="form-group">
    @if (filled($label))
        <label for="{{ $fieldId }}">
            @if ($iconClass !== '')
                <i class="fas {{ $iconClass }} mr-1" aria-hidden="true"></i>
            @endif
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
        id="{{ $fieldId }}"
        name="{{ $name }}"
        @required($required)
        @disabled($disabled)
    >
        {{ $slot }}
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if (filled($help))
        <div class="form-text text-muted">{{ $help }}</div>
    @endif
</div>
