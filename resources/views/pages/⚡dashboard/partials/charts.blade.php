<div class="row">
    @foreach ($charts ?? [] as $index => $chart)
        @php
            $chartData = is_array($chart) ? $chart : [];
            $columnClass = is_string($chartData['columnClass'] ?? null) && trim($chartData['columnClass']) !== ''
                ? trim($chartData['columnClass'])
                : 'col-12 col-lg-6';
            $chartKey = is_scalar($chartData['key'] ?? null) && trim((string) $chartData['key']) !== ''
                ? trim((string) $chartData['key'])
                : (string) $index;
        @endphp

        <div class="{{ $columnClass }}" wire:key="dashboard-chart-{{ $chartKey }}">
            <x-dashboard-chart-card :chart="$chartData" />
        </div>
    @endforeach
</div>
