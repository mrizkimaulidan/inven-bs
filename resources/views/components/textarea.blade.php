<div>
    <div class="form-group">
        @if ($label)
            <label for="{{ $name }}">
                @if ($icon)
                    <i class="fas {{ $icon }} mr-1"></i>
                @endif
                {{ $label }}
            </label>
        @endif

        <textarea {{ $attributes->class(['form-control']) }} id="{{ $name }}" name="{{ $name }}"></textarea>
    </div>
</div>
