<div>
    @foreach ($alertTypes as $type => $config)
        @if (session()->has($type))
            <div class="alert alert-{{ $type }} alert-dismissible show fade alert-has-icon">
                <div class="alert-icon">
                    <i class="fas {{ $config['icon'] }}"></i>
                </div>
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <div class="alert-title">{{ $config['title'] }}</div>
                    {{ session($type) }}
                </div>
            </div>
        @endif
    @endforeach
</div>
