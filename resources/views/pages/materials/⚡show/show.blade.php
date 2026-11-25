@php
    $materialName = $material?->name ?? '-';
    $totalCommodities = (int) ($material?->commodities_count ?? 0);
    $goodConditions = (int) ($material?->good_conditions_count ?? 0);
    $poorConditions = (int) ($material?->poor_conditions_count ?? 0);
    $heavilyDamagedConditions = (int) ($material?->heavily_damaged_conditions_count ?? 0);
@endphp

<div>
    <x-modal title="Detail Bahan" size="lg">
        <x-slot:body>
            <div class="mb-4">
                <h4 class="font-weight-bold mb-2">{{ $materialName }}</h4>
            </div>

            <hr />

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-uppercase text-muted font-weight-bold mb-0">Statistik Barang</h6>
                <small class="text-muted">Ringkasan kondisi barang</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1">Total Barang</small>
                                <h4 class="font-weight-bold text-primary mb-0">
                                    {{ number_format($totalCommodities, 0, ',', '.') }}
                                </h4>
                            </div>

                            <i class="fas fa-boxes-alt fa-2x text-primary" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1">Kondisi Baik</small>
                                <h4 class="font-weight-bold text-success mb-0">
                                    {{ number_format($goodConditions, 0, ',', '.') }}
                                </h4>
                            </div>

                            <i class="fas fa-check-circle fa-2x text-success" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1">Kondisi Kurang Baik</small>
                                <h4 class="font-weight-bold text-warning mb-0">
                                    {{ number_format($poorConditions, 0, ',', '.') }}
                                </h4>
                            </div>

                            <i class="fas fa-exclamation-circle fa-2x text-warning" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1">Rusak Berat</small>
                                <h4 class="font-weight-bold text-danger mb-0">
                                    {{ number_format($heavilyDamagedConditions, 0, ',', '.') }}
                                </h4>
                            </div>

                            <i class="fas fa-times-circle fa-2x text-danger" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot:body>
    </x-modal>
</div>
