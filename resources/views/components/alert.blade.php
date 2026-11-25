<div>
    {{-- Render an alert for each session key that is currently present. --}}
    @foreach ($alertTypes as $type => $config)
        @if (session()->has($type))
            @php
                $message = session($type);
            @endphp

            @if (is_scalar($message) || $message instanceof \Stringable)
                <div class="alert alert-{{ $type }} alert-has-icon" role="alert">
                    <div class="alert-icon">
                        <i class="fas {{ $config['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <div class="alert-body">
                        @if (! empty($config['title']))
                            <div class="alert-title">{{ $config['title'] }}</div>
                        @endif

                        {{ (string) $message }}
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>
