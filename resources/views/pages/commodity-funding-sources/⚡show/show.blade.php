<x-modal title="Detail Perolehan" size="lg">
    <x-slot:body>
        <div class="mb-4">
            <h4 class="font-weight-bold mb-2">{{ $commodityFundingSource->name }}</h4>
            <p class="text-muted mb-0">{{ $commodityFundingSource->description }}</p>
        </div>

        <hr />

        <h6 class="text-uppercase text-muted font-weight-bold mb-3">Statistik Barang</h6>

        <div class="d-flex align-items-center mb-3 flex-wrap">
            <x-badge
                :label="$commodityFundingSource->commodities_count"
                icon="fa-boxes-alt"
                class="badge-primary mr-1"
            />
            <x-badge
                :label="$commodityFundingSource->good_conditions_count"
                icon="fa-check-circle"
                class="badge-success mr-1"
            />
            <x-badge
                :label="$commodityFundingSource->poor_conditions_count"
                icon="fa-exclamation-circle"
                class="badge-warning mr-1"
            />
            <x-badge
                :label="$commodityFundingSource->heavily_damaged_conditions_count"
                icon="fa-circle-xmark"
                class="badge-danger"
            />
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-boxes-alt text-primary mr-2"></i>
                        Total Barang
                    </span>
                    <span class="badge badge-primary badge-pill">{{ $commodityFundingSource->commodities_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        Kondisi Baik
                    </span>
                    <span class="badge badge-success badge-pill">{{ $commodityFundingSource->good_conditions_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                        Kondisi Kurang Baik
                    </span>
                    <span class="badge badge-warning badge-pill">{{ $commodityFundingSource->poor_conditions_count }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span>
                        <i class="fas fa-circle-xmark text-danger mr-2"></i>
                        Rusak Berat
                    </span>
                    <span class="badge badge-danger badge-pill">{{ $commodityFundingSource->heavily_damaged_conditions_count }}</span>
                </div>
            </div>
        </div>
    </x-slot:body>
</x-modal>
