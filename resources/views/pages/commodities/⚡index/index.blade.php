<div>
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::commodities.export />
        @endteleport
    @endif

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card icon="fas fa-box" bgColor="primary" title="Total Barang" value="10" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card icon="fas fa-check-circle" bgColor="success" title="Kondisi Baik" value="10" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-exclamation-circle"
                bgColor="warning"
                title="Kondisi Kurang Baik"
                value="10"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card icon="fas fa-circle-xmark" bgColor="danger" title="Kondisi Rusak Berat" value="10" />
        </div>
    </div>

    <!-- Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end flex-wrap pb-3">
                        <x-button icon="fa-file-import" label="Import" class="btn-success mr-2 mb-2" />

                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Export"
                            class="btn-info mr-2 mb-2"
                        />

                        <button class="btn btn-icon icon-left btn-primary mr-2 mb-2">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </button>
                        <button class="btn btn-icon icon-left btn-danger mr-2 mb-2">
                            <i class="fas fa-trash-alt"></i> Hapus Terpilih
                        </button>
                        <button class="btn btn-icon icon-left btn-secondary mr-2 mb-2">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button class="btn btn-icon btn-light mr-2 mb-2">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>

                    <div class="float-left">
                        <select wire:model.live="perPage" class="form-control selectric">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="float-right">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                        <table class="table-striped table">
                            <tr>
                                <th class="pt-2 text-center">
                                    <div class="custom-checkbox custom-checkbox-table custom-control">
                                        <input
                                            type="checkbox"
                                            data-checkboxes="mygroup"
                                            data-checkbox-role="dad"
                                            class="custom-control-input"
                                            id="checkbox-all"
                                        />
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Nama Barang</th>
                                <th>Bahan & Merk</th>
                                <th>Gambar</th>
                                <th>Tahun Pembelian</th>
                                <th>Kondisi</th>
                            </tr>
                            @foreach ($this->commodities as $commodity)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input
                                                type="checkbox"
                                                data-checkboxes="mygroup"
                                                class="custom-control-input"
                                                id="checkbox-2"
                                            />
                                            <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td class="pb-2">
                                        <span class="font-weight-bold">{{ $commodity->name }}</span>

                                        <div class="d-flex align-items-center">
                                            <x-badge
                                                :label="$commodity->item_code"
                                                icon="fa-code"
                                                class="badge-primary"
                                            />
                                            <x-badge
                                                :label="$commodity->commodityFundingSource->name"
                                                icon="fa-hand-holding"
                                                class="badge-info ml-2"
                                            />
                                        </div>

                                        <div class="table-links">
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-dark btn-sm"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="QR Code"
                                            >
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-info btn-sm"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Detail"
                                            >
                                                <i class="fas fa-magnifying-glass"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-success btn-sm"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ubah"
                                            >
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-secondary btn-sm"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Print"
                                            >
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-danger btn-sm"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#">{{ $commodity->material->name }}</a>,
                                        <a href="#">{{ $commodity->brand->name }}</a>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img
                                                alt="image"
                                                src="https://picsum.photos/50"
                                                class="rounded"
                                                width="50"
                                                data-toggle="title"
                                                title=""
                                            />
                                        </a>
                                    </td>
                                    <td>
                                        <x-badge
                                            :label="$commodity->purchase_year"
                                            icon="fa-calendar-alt"
                                            class="badge-dark"
                                        />
                                    </td>
                                    <td>
                                        @php
                                            $conditionStyle = $this->conditionStyle($commodity->condition)
                                        @endphp
                                        <x-badge
                                            :label="$commodity->condition->label()"
                                            :icon="$conditionStyle['icon']"
                                            :class="$conditionStyle['badge']"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted mb-md-0 mb-2">Menampilkan 1-10 dari 25 data</div>
                        <nav class="d-inline-block">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
