<div
    class="modal fade show d-block"
    id="detailModal"
    tabindex="-1"
    role="dialog"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    data-backdrop="static"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Ruangan</h5>
                <button wire:click="$dispatch('closeModal')" type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="mb-4">
                    <h4 class="font-weight-bold mb-2">{{ $commodityLocation->name }}</h4>
                    <p class="text-muted mb-0">{{ $commodityLocation->description }}</p>
                </div>

                <hr />

                <h6 class="text-uppercase text-muted font-weight-bold mb-3">Statistik Barang</h6>

                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <x-badge
                        :label="$commodityLocation->commodities_count"
                        icon="fa-boxes-alt"
                        class="badge-primary mr-1"
                    />
                    <x-badge
                        :label="$commodityLocation->good_conditions_count"
                        icon="fa-check-circle"
                        class="badge-success mr-1"
                    />
                    <x-badge
                        :label="$commodityLocation->poor_conditions_count"
                        icon="fa-exclamation-circle"
                        class="badge-warning mr-1"
                    />
                    <x-badge
                        :label="$commodityLocation->heavily_damaged_conditions_count"
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
                            <span class="badge badge-primary badge-pill">{{ $commodityLocation->commodities_count }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Kondisi Baik
                            </span>
                            <span class="badge badge-success badge-pill">{{ $commodityLocation->good_conditions_count }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>
                                <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                                Kondisi Kurang Baik
                            </span>
                            <span class="badge badge-warning badge-pill">{{ $commodityLocation->poor_conditions_count }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>
                                <i class="fas fa-circle-xmark text-danger mr-2"></i>
                                Rusak Berat
                            </span>
                            <span class="badge badge-danger badge-pill">{{ $commodityLocation->heavily_damaged_conditions_count }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <x-button wire:click="$dispatch('closeModal')" class="btn-secondary" label="Tutup" />
            </div>
        </div>
    </div>
</div>
