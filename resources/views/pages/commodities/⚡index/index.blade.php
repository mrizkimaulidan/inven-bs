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
                <!-- Action Buttons & Show Entries -->
                <div class="d-flex justify-content-between align-items-center flex-wrap px-2 py-2">
                    <!-- Dropdown Show Entries (Kiri) -->
                    <div class="d-flex align-items-center mb-2">
                        <label class="mr-2 mb-0 text-nowrap">Tampilkan</label>
                        <select class="form-control form-control-sm" style="width: 80px">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="ml-2 text-nowrap">data</span>
                    </div>

                    <!-- Action Buttons (Kanan) -->
                    <div class="d-flex flex-wrap">
                        <button class="btn btn-icon icon-left btn-success mr-2 mb-2">
                            <i class="fas fa-file-import"></i> Import
                        </button>
                        <button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            class="btn btn-icon icon-left btn-info mr-2 mb-2"
                        >
                            <i class="fas fa-file-export"></i> Export
                        </button>
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
                </div>

                <!-- Search Bar & Reset Filter -->
                <div class="card-header d-flex justify-content-end align-items-center">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari berdasarkan..." />
                        </div>
                    </form>
                    <button class="btn btn-outline-secondary ml-2" type="button" title="Reset Filter">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>

                <!-- Table -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input text-center"
                                                type="checkbox"
                                                value=""
                                                id="defaultCheck1"
                                            />
                                        </div>
                                    </th>
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Bahan</th>
                                    <th scope="col">Merk</th>
                                    <th scope="col">Tahun Pembelian</th>
                                    <th scope="col">Kondisi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input text-center"
                                                type="checkbox"
                                                value=""
                                                id="defaultCheck1"
                                            />
                                        </div>
                                    </td>

                                    <td class="font-weight-bold text-center">1</td>

                                    <!-- Item Details -->
                                    <td>
                                        <div class="media align-items-center py-1">
                                            <a href="#">
                                                <img
                                                    alt="image"
                                                    class="mr-3 rounded"
                                                    width="50"
                                                    src="https://picsum.photos/50"
                                                />
                                            </a>
                                            <div class="media-body">
                                                <div class="media-title font-weight-bold">
                                                    <a href="#">iBook Noob</a>
                                                </div>
                                                <div class="text-small">
                                                    <span class="badge badge-primary"><i class="fas fa-code"></i> BRG-001</span>
                                                    <span class="badge badge-info"><i class="fas fa-hand-holding"></i> BOSDA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Material -->
                                    <td>
                                        <span class="badge badge-secondary"> Kayu Jati </span>
                                    </td>

                                    <!-- Brand -->
                                    <td>
                                        <div class="d-flex align-items-center">Merk</div>
                                    </td>

                                    <!-- Purchase Year -->
                                    <td>
                                        <span class="badge badge-dark">
                                            <i class="far fa-calendar-alt mr-1"></i> 2023
                                        </span>
                                    </td>

                                    <!-- Condition -->
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i> Baik
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center flex-wrap" style="gap: 4px">
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination & Info -->
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
