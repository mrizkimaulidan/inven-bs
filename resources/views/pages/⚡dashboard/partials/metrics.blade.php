@php
    $summaryData = is_array($summary ?? null) ? $summary : [];
    $totalItems = (int) ($summaryData['totalItems'] ?? 0);
    $totalUnits = (int) ($summaryData['totalUnits'] ?? 0);
    $inventoryValue = is_numeric($summaryData['inventoryValue'] ?? null)
        ? (float) $summaryData['inventoryValue']
        : 0.0;
    $totalLocations = (int) ($summaryData['totalLocations'] ?? 0);
@endphp

<div class="row">
    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-box"
            bg-color="primary"
            title="Data Barang"
            :value="number_format($totalItems, 0, ',', '.')"
        />
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-cubes"
            bg-color="info"
            title="Total Unit"
            :value="number_format($totalUnits, 0, ',', '.')"
        />
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-wallet"
            bg-color="success"
            title="Nilai Inventaris"
            :value="\Illuminate\Support\Number::currency($inventoryValue, in: 'IDR', locale: 'id')"
        />
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-map-marker-alt"
            bg-color="warning"
            title="Ruangan Terpakai"
            :value="number_format($totalLocations, 0, ',', '.')"
        />
    </div>
</div>
