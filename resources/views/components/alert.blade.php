<div>
    {{-- Render an alert for each session key that is currently present. --}}
    @foreach ($alertTypes as $type => $config)
        @if (session()->has($type))
            <div class="alert alert-{{ $type }} alert-has-icon" role="alert">
                <div class="alert-icon">
                    <i class="fas {{ $config['icon'] }}"></i>
                </div>
                <div class="alert-body">
                    {{-- Alert title. --}}
                    @if (! empty($config['title']))
                        <div class="alert-title">{{ $config['title'] }}</div>
                    @endif

                    {{-- Alert message. --}}
                    {{ session($type) }}
                </div>
            </div>
        @endif
    @endforeach
</div>
