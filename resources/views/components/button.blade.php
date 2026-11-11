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
    {{-- Optional button icon --}}
    @if ($icon)
        <i class="fas {{ $icon }} {{ $label !== '' ? 'mr-1' : '' }}"></i>
    @endif

    {{ $label }}
</button>
