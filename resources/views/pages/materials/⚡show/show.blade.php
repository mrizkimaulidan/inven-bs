<x-modal title="Detail Bahan" size="lg">
    <x-slot:body>
        <div class="mb-4">
            <h4 class="font-weight-bold mb-2">{{ $material->name }}</h4>
        </div>

        <hr />

        <h6 class="text-uppercase text-muted font-weight-bold mb-3">Statistik Barang</h6>

        <div class="d-flex align-items-center mb-3 flex-wrap">
            <x-badge :label="$material->commodities_count" icon="fa-boxes-alt" class="badge-primary mr-1" />
            <x-badge :label="$material->good_conditions_count" icon="fa-check-circle" class="badge-success mr-1" />
            <x-badge
                :label="$material->poor_conditions_count"
                icon="fa-exclamation-circle"
                class="badge-warning mr-1"
            />
            <x-badge :label="$material->heavily_damaged_conditions_count" icon="fa-circle-xmark" class="badge-danger" />
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-boxes-alt text-primary mr-2"></i>
                        Total Barang
                    </span>
                    <span class="badge badge-primary badge-pill">{{ $material->commodities_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        Kondisi Baik
                    </span>
                    <span class="badge badge-success badge-pill">{{ $material->good_conditions_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                        Kondisi Kurang Baik
                    </span>
                    <span class="badge badge-warning badge-pill">{{ $material->poor_conditions_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-circle-xmark text-danger mr-2"></i>
                        Rusak Berat
                    </span>
                    <span class="badge badge-danger badge-pill">{{ $material->heavily_damaged_conditions_count }}</span>
                </div>
            </div>
        </div>
    </x-slot:body>
</x-modal>
