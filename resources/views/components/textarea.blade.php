@php
    $fieldId = filled($id ?? null) ? (string) $id : $name;
    $iconClass = is_string($icon) ? trim($icon) : '';
    $rowCount = max(1, (int) $rows);
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

    <textarea
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
        id="{{ $fieldId }}"
        name="{{ $name }}"
        rows="{{ $rowCount }}"
        @required($required)
    >{{ $slot }}</textarea>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if (filled($help))
        <div class="form-text text-muted">{{ $help }}</div>
    @endif
</div>
