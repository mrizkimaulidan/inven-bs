@php
    $iconClass = is_string($icon) ? trim($icon) : '';
@endphp

<span {{
    $attributes->class([
        'badge',
        'badge-'.$variant,
        'badge-pill' => $pill,
    ])
}}>
    @if ($iconClass !== '')
        <i class="fas {{ $iconClass }} mr-1" aria-hidden="true"></i>
    @endif

    {{ $label }}
</span>
