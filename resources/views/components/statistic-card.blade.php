<div {{ $attributes->class(['card', 'card-statistic-1']) }}>
    <div class="card-icon bg-{{ $bgColor }}">
        <i class="fas {{ $icon }}" aria-hidden="true"></i>
    </div>

    <div class="card-wrap">
        <div class="card-header">
            <h4>{{ $title }}</h4>
        </div>
        <div class="card-body">{{ $value }}</div>
    </div>
</div>
