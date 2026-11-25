@php
    $iconClass = is_string($icon) ? trim($icon) : '';
    $trimmedLabel = trim($label);
@endphp

<button
    {{
        $attributes->class([
            'btn',
            'btn-'.$variant,
            'btn-icon' => $iconClass !== '',
        ])
    }}
    type="{{ $type }}"
>
    @if ($iconClass !== '')
        <i class="fas {{ $iconClass }} {{ $trimmedLabel !== '' ? 'mr-1' : '' }}" aria-hidden="true"></i>
    @endif

    {{ $label }}
</button>
