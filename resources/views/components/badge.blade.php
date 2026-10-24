<span {{
    $attributes->class([
        'badge',
        'badge-'.$variant,
        'badge-pill' => $pill,
    ])
}}>
    {{-- Render the icon when provided. --}}
    @if ($icon)
        <i class="fas {{ $icon }} mr-1"></i>
    @endif

    {{-- Badge label. --}}
    {{ $label }}
</span>
