<button
    {{
        $attributes->class([
            'btn',
            'btn-'.$variant,
            'btn-icon' => (bool) $icon,
        ])
    }}
    type="{{ $type }}"
>
    {{-- Render the icon when provided. --}}
    @if ($icon)
        <i class="fas {{ $icon }} mr-1"></i>
    @endif

    {{ $label }}
</button>
