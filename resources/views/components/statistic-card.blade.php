<div class="card card-statistic-1">
    {{-- Statistic icon --}}
    <div class="card-icon bg-{{ $bgColor }}">
        <i class="fas {{ $icon }}" aria-hidden="true"></i>
    </div>

    {{-- Statistic title and value --}}
    <div class="card-wrap">
        <div class="card-header">
            <h4>{{ $title }}</h4>
        </div>
        <div class="card-body">{{ $value }}</div>
    </div>
</div>
