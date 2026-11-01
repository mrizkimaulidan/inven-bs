{{-- Render a reusable form input. --}}
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

    @if ($type === 'file')
        <div class="custom-file">
            <input
                {{ $attributes->class(['custom-file-input', 'is-invalid' => $errors->has($name)]) }}
                type="{{ $type }}"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                @required($required)
            />
            <label class="custom-file-label text-truncate" for="{{ $id ?? $name }}">
                {{ $selectedFileName ?? 'Pilih file...' }}
            </label>
        </div>
    @else
        {{-- Input field. Caller-supplied attributes (wire:model, placeholder, etc.)
             are merged onto the element. --}}
        <input
            {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
            type="{{ $type }}"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            @required($required)
        />
    @endif

    {{-- Helper text. --}}
    @if ($help)
        <div class="form-text text-muted">{{ $help }}</div>
    @endif

    {{-- Validation error message. --}}
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
