<div>
    <span {{
        $attributes->class([
            'badge',
        ])
    }}>
        @if ($hasIcon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $label }}
    </span>
</div>
