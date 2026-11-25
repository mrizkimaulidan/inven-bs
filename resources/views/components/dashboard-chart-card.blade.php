@props(['chart'])

@php
    $labels = is_array($chart['labels'] ?? null) ? $chart['labels'] : [];
    $values = is_array($chart['values'] ?? null) ? $chart['values'] : [];
    $variants = is_array($chart['variants'] ?? null) ? $chart['variants'] : [];
    $unitLabel = is_string($chart['unitLabel'] ?? null) ? trim($chart['unitLabel']) : '';
    $valueFormat = (string) ($chart['valueFormat'] ?? 'number');
    $totalValues = array_sum(array_map(
        static fn (mixed $item): float => is_numeric($item) ? (float) $item : 0.0,
        $values,
    ));
@endphp

<div class="card">
    <div class="card-header">
        <div>
            <h4>{{ $chart['title'] }}</h4>
            <p class="text-muted small mb-0">{{ $chart['description'] }}</p>
        </div>
    </div>

    <div class="card-body">
        {{-- Prevent Livewire DOM diffing from overwriting Chart.js canvas state. --}}
        <div wire:ignore>
            <canvas
                id="{{ $chart['canvasId'] }}"
                height="{{ $chart['height'] }}"
                role="img"
                aria-label="{{ $chart['chartLabel'] }}"
            ></canvas>
        </div>

        @if (($chart['key'] ?? '') === 'conditionDistribution')
            <ul class="list-unstyled list-unstyled-border mt-4 mb-0">
                @foreach ($labels as $index => $label)
                    @php
                        $unitCount = (int) ($values[$index] ?? 0);
                        $badgeVariant = (string) ($variants[$index] ?? 'primary');
                    @endphp
                    <li class="d-flex justify-content-between align-items-center py-2">
                        <x-badge :label="(string) $label" :variant="$badgeVariant" />
                        <strong>{{ number_format($unitCount, 0, ',', '.') }} unit</strong>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="sr-only">
                @foreach ($labels as $index => $label)
                    @php
                        $rawValue = $values[$index] ?? 0;
                        $numericValue = is_numeric($rawValue) ? (float) $rawValue : 0.0;
                        $formattedValue = match ($valueFormat) {
                            'currency' => \Illuminate\Support\Number::currency($numericValue, in: 'IDR', locale: 'id'),
                            'decimal' => number_format($numericValue, 1, ',', '.'),
                            default => number_format($numericValue, 0, ',', '.'),
                        };
                    @endphp
                    <li>
                        {{ $label }}: {{ $formattedValue }}
                        @if ($valueFormat !== 'currency' && $unitLabel !== '')
                            {{ $unitLabel }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($totalValues === 0.0)
            <p class="text-muted small mt-3 mb-0 text-center">Belum ada data untuk grafik ini.</p>
        @endif
    </div>
</div>
