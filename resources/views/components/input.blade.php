@php
    $fieldId = filled($id ?? null) ? (string) $id : $name;
    $iconClass = is_string($icon) ? trim($icon) : '';
    $fileLabel = is_string($selectedFileName) && trim($selectedFileName) !== ''
        ? trim($selectedFileName)
        : 'Pilih file...';
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

    @if ($type === 'file')
        <div class="custom-file">
            <input
                {{ $attributes->class(['custom-file-input', 'is-invalid' => $errors->has($name)]) }}
                type="{{ $type }}"
                id="{{ $fieldId }}"
                name="{{ $name }}"
                @required($required)
            />
            <label class="custom-file-label text-truncate" for="{{ $fieldId }}"> {{ $fileLabel }} </label>
        </div>
    @else
        <input
            {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
            type="{{ $type }}"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            @required($required)
        />
    @endif

    @if (filled($help))
        <div class="form-text text-muted">{{ $help }}</div>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
