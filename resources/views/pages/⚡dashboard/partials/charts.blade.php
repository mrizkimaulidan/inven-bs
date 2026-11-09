{{-- ===== START: Inventory Charts ===== --}}
<div class="row">
    @foreach ($charts as $chart)
        <div class="{{ $chart['columnClass'] }}">
            <x-dashboard-chart-card :chart="$chart" />
        </div>
    @endforeach
</div>
{{-- ===== END: Inventory Charts ===== --}}
