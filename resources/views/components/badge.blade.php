<span {{
    $attributes->class([
        'badge',
        'badge-'.$variant,
        'badge-pill' => $pill,
    ])
}}>
    {{-- Optional badge icon --}}
    @if ($icon)
        <i class="fas {{ $icon }} mr-1"></i>
    @endif

    {{-- Badge text --}}
    {{ $label }}
</span>
