```blade
<x-modal title="Detail Merek" size="lg">
    <x-slot:body>
        {{-- Informasi merek --}}
        <div class="mb-4">
            <h4 class="font-weight-bold mb-2">{{ $brand->name }}</h4>
        </div>

        <hr />

        {{-- Statistik barang --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-uppercase text-muted font-weight-bold mb-0">Statistik Barang</h6>
            <small class="text-muted"> Ringkasan kondisi barang </small>
        </div>

        <div class="row">
            {{-- Total barang --}}
            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1"> Total Barang </small>
                            <h4 class="font-weight-bold text-primary mb-0">
                                {{ number_format($brand->commodities_count, 0, ',', '.') }}
                            </h4>
                        </div>

                        <i class="fas fa-boxes-alt fa-2x text-primary" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            {{-- Kondisi baik --}}
            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1"> Kondisi Baik </small>
                            <h4 class="font-weight-bold text-success mb-0">
                                {{ number_format($brand->good_conditions_count, 0, ',', '.') }}
                            </h4>
                        </div>

                        <i class="fas fa-check-circle fa-2x text-success" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            {{-- Kondisi kurang baik --}}
            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1"> Kondisi Kurang Baik </small>
                            <h4 class="font-weight-bold text-warning mb-0">
                                {{ number_format($brand->poor_conditions_count, 0, ',', '.') }}
                            </h4>
                        </div>

                        <i class="fas fa-exclamation-circle fa-2x text-warning" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            {{-- Rusak berat --}}
            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1"> Rusak Berat </small>
                            <h4 class="font-weight-bold text-danger mb-0">
                                {{ number_format($brand->heavily_damaged_conditions_count, 0, ',', '.') }}
                            </h4>
                        </div>

                        <i class="fas fa-times-circle fa-2x text-danger" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:body>
</x-modal>
```
