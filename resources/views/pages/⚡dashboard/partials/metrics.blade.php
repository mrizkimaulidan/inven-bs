{{-- ===== START: KPI Cards ===== --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-box"
            bg-color="primary"
            title="Data Barang"
            :value="number_format($summary['totalItems'], 0, ',', '.')"
        />
    </div>
    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-cubes"
            bg-color="info"
            title="Total Unit"
            :value="number_format($summary['totalUnits'], 0, ',', '.')"
        />
    </div>
    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-wallet"
            bg-color="success"
            title="Nilai Inventaris"
            :value="Number::currency($summary['inventoryValue'], in: 'IDR', locale: 'id')"
        />
    </div>
    <div class="col-lg-3 col-md-6 col-12">
        <x-statistic-card
            icon="fa-map-marker-alt"
            bg-color="warning"
            title="Lokasi Terpakai"
            :value="number_format($summary['totalLocations'], 0, ',', '.')"
        />
    </div>
</div>
{{-- ===== END: KPI Cards ===== --}}
