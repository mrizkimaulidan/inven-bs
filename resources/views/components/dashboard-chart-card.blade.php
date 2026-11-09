@props(['chart'])

{{-- ===== START: Dashboard Chart Card ===== --}}
<div class="card">
    <div class="card-header">
        <div>
            <h4>{{ $chart['title'] }}</h4>
            <p class="text-muted small mb-0">{{ $chart['description'] }}</p>
        </div>
    </div>
    <div class="card-body">
        <div wire:ignore>
            <canvas
                id="{{ $chart['canvasId'] }}"
                height="{{ $chart['height'] }}"
                role="img"
                aria-label="{{ $chart['chartLabel'] }}"
            ></canvas>
        </div>

        @if ($chart['key'] === 'conditionDistribution')
            <ul class="list-unstyled list-unstyled-border mt-4 mb-0">
                @foreach ($chart['labels'] as $index => $label)
                    <li class="d-flex justify-content-between align-items-center py-2">
                        <x-badge :label="$label" :variant="$chart['variants'][$index]" />
                        <strong>{{ number_format($chart['values'][$index], 0, ',', '.') }} unit</strong>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="sr-only">
                @foreach ($chart['labels'] as $index => $label)
                    @php
                        $value = $chart['values'][$index];
                        $formattedValue = match ($chart['valueFormat']) {
                            'currency' => Number::currency($value, in: 'IDR', locale: 'id'),
                            'decimal' => number_format($value, 1, ',', '.'),
                            default => number_format($value, 0, ',', '.'),
                        };
                    @endphp
                    <li>
                        {{ $label }}: {{ $formattedValue }}
                        @if ($chart['valueFormat'] !== 'currency' && $chart['unitLabel'])
                            {{ $chart['unitLabel'] }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if (array_sum($chart['values']) === 0)
            <p class="text-muted small mt-3 mb-0 text-center">Belum ada data untuk grafik ini.</p>
        @endif
    </div>
</div>
{{-- ===== END: Dashboard Chart Card ===== --}}
