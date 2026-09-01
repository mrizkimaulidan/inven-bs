<div>
    <button
        {{
            $attributes->class([
                'btn',
                'btn-icon' => $hasIcon,
                'icon-left' => $hasIcon,
            ])
        }}
        type="{{ $type }}"
    >
        @if ($hasIcon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $label }}
    </button>
</div>
