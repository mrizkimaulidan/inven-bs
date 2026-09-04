<div>
    {{-- Modal --}}
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::commodities.export />
        @endteleport
    @endif

    {{-- Statistics Cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-box"
                bgColor="primary"
                title="Total Barang"
                value="{{ $this->totalCommoditiesCount }}"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-check-circle"
                bgColor="success"
                title="Kondisi Baik"
                value="{{ $this->goodConditionCount }}"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-exclamation-circle"
                bgColor="warning"
                title="Kondisi Kurang Baik"
                value="{{ $this->poorConditionCount }}"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-circle-xmark"
                bgColor="danger"
                title="Kondisi Rusak Berat"
                value="{{ $this->heavilyDamagedCount }}"
            />
        </div>
    </div>

    {{-- Main Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Toolbar: Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                        <div class="d-flex flex-wrap">
                            <x-button icon="fa-file-import" label="Import" class="btn-success mr-2 mb-2" />
                            <x-button
                                wire:click="$dispatch('showModal', {modalName: 'export'})"
                                icon="fa-file-export"
                                label="Export"
                                class="btn-info mr-2 mb-2"
                            />
                            <x-button icon="fa-trash-alt" label="Hapus Terpilih" class="btn-danger mr-2 mb-2" />
                            <x-button icon="fa-print" label="Print" class="btn-secondary mr-2 mb-2" />
                            <x-button
                                wire:click="$refresh"
                                icon="fa-sync-alt"
                                label="Refresh"
                                class="btn-light mb-2"
                                data-toggle="tooltip"
                                title="Refresh"
                            />
                        </div>
                        <x-button icon="fa-plus-circle" label="Tambah Data" class="btn-primary mb-2" />
                    </div>

                    {{-- Filter Accordion --}}
                    <div class="accordion pb-3" id="accordionFilter">
                        <div wire:ignore class="accordion-item">
                            <div
                                class="accordion-header"
                                role="button"
                                data-toggle="collapse"
                                data-target="#panel-filter"
                                aria-expanded="false"
                            >
                                <h4>
                                    <i class="fas fa-filter mr-2"></i>
                                    Filter Data
                                    <span class="badge badge-primary ml-2">0</span>
                                    <i class="fas fa-chevron-down float-right mt-1"></i>
                                </h4>
                            </div>
                            <div class="accordion-body collapse" id="panel-filter" data-parent="#accordionFilter">
                                <form>
                                    {{-- Filter: Select Inputs --}}
                                    <div class="row">
                                        {{-- Kategori --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.category"
                                                label="Kategori"
                                                icon="fa-tags"
                                                wire:model.live="filters.category"
                                            >
                                                <option value="">Semua Kategori</option>
                                                <option value="elektronik">Elektronik</option>
                                                <option value="fashion">Fashion</option>
                                                <option value="makanan">Makanan</option>
                                                <option value="buku">Buku</option>
                                                <option value="peralatan">Peralatan</option>
                                                <option value="kendaraan">Kendaraan</option>
                                                <option value="perabotan">Perabotan</option>
                                                <option value="alat_tulis">Alat Tulis</option>
                                            </x-select>
                                        </div>

                                        {{-- Kondisi --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.condition"
                                                label="Kondisi"
                                                icon="fa-check-circle"
                                                wire:model.live="filters.condition"
                                            >
                                                <option value="">Semua Kondisi</option>
                                                <option value="1">Baik</option>
                                                <option value="2">Kurang Baik</option>
                                                <option value="3">Rusak Berat</option>
                                            </x-select>
                                        </div>

                                        {{-- Tahun Pembelian --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.purchase_year"
                                                label="Tahun Pembelian"
                                                icon="fa-calendar-alt"
                                                wire:model.live="filters.purchase_year"
                                            >
                                                <option value="">Semua Tahun</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2019">2019</option>
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                                <option value="2016">2016</option>
                                                <option value="2015">2015</option>
                                            </x-select>
                                        </div>

                                        {{-- Perolehan --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.funding_source"
                                                label="Perolehan"
                                                icon="fa-hand-holding"
                                                wire:model.live="filters.funding_source"
                                            >
                                                <option value="">Semua Perolehan</option>
                                                <option value="apbd">APBD</option>
                                                <option value="apbn">APBN</option>
                                                <option value="hibah">Hibah</option>
                                                <option value="bantuan">Bantuan</option>
                                                <option value="swadaya">Swadaya</option>
                                                <option value="donasi">Donasi</option>
                                            </x-select>
                                        </div>

                                        {{-- Bahan --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.material"
                                                label="Bahan"
                                                icon="fa-cube"
                                                wire:model.live="filters.material"
                                            >
                                                <option value="">Semua Bahan</option>
                                                <option value="kayu">Kayu</option>
                                                <option value="besi">Besi</option>
                                                <option value="plastik">Plastik</option>
                                                <option value="kaca">Kaca</option>
                                                <option value="kain">Kain</option>
                                                <option value="aluminium">Aluminium</option>
                                                <option value="kertas">Kertas</option>
                                                <option value="karet">Karet</option>
                                                <option value="keramik">Keramik</option>
                                            </x-select>
                                        </div>

                                        {{-- Merek --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.brand"
                                                label="Merek"
                                                icon="fa-trademark"
                                                wire:model.live="filters.brand"
                                            >
                                                <option value="">Semua Merk</option>
                                                <option value="samsung">Samsung</option>
                                                <option value="apple">Apple</option>
                                                <option value="sony">Sony</option>
                                                <option value="lg">LG</option>
                                                <option value="philips">Philips</option>
                                                <option value="panasonic">Panasonic</option>
                                                <option value="asus">Asus</option>
                                                <option value="acer">Acer</option>
                                                <option value="dell">Dell</option>
                                                <option value="hp">HP</option>
                                                <option value="canon">Canon</option>
                                                <option value="nike">Nike</option>
                                                <option value="adidas">Adidas</option>
                                            </x-select>
                                        </div>

                                        {{-- Lokasi --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.location"
                                                label="Lokasi"
                                                icon="fa-map-marker-alt"
                                                wire:model.live="filters.location"
                                            >
                                                <option value="">Semua Lokasi</option>
                                                <option value="gudang_1">Gudang 1</option>
                                                <option value="gudang_2">Gudang 2</option>
                                                <option value="ruang_1">Ruang 1</option>
                                                <option value="ruang_2">Ruang 2</option>
                                                <option value="ruang_3">Ruang 3</option>
                                                <option value="laboratorium">Laboratorium</option>
                                                <option value="perpustakaan">Perpustakaan</option>
                                            </x-select>
                                        </div>

                                        {{-- Dibuat Oleh --}}
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <x-select
                                                name="filters.created_by"
                                                label="Dibuat Oleh"
                                                icon="fa-user"
                                                wire:model.live="filters.created_by"
                                            >
                                                <option value="">Semua User</option>
                                                <option value="admin">Admin</option>
                                                <option value="user_1">User 1</option>
                                                <option value="user_2">User 2</option>
                                                <option value="user_3">User 3</option>
                                            </x-select>
                                        </div>
                                    </div>

                                    {{-- Filter: Price & Quantity Range --}}
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-dollar-sign mr-1"></i> Range Harga
                                            </label>
                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    wire:model.live.debounce.500ms="filters.price_min"
                                                    placeholder="Min"
                                                    min="0"
                                                />
                                                <div class="input-group-prepend input-group-append">
                                                    <span class="input-group-text">-</span>
                                                </div>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    wire:model.live.debounce.500ms="filters.price_max"
                                                    placeholder="Max"
                                                    min="0"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-cubes mr-1"></i> Range Jumlah
                                            </label>
                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    wire:model.live.debounce.500ms="filters.quantity_min"
                                                    placeholder="Min"
                                                    min="0"
                                                />
                                                <div class="input-group-prepend input-group-append">
                                                    <span class="input-group-text">-</span>
                                                </div>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    wire:model.live.debounce.500ms="filters.quantity_max"
                                                    placeholder="Max"
                                                    min="0"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Filter: Reset Button --}}
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-secondary" wire:click="resetFilters">
                                                <i class="fas fa-undo mr-1"></i> Reset Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table Controls: Per Page & Search --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <x-select name="perPage" wire:model.live="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-select>

                        <form style="max-width: 300px" class="mt-md-0 mt-2">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cari data"
                                    wire:model.live.debounce.500ms="search"
                                />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <x-table :paginator="$this->commodities">
                        <x-slot:thead>
                            <tr>
                                <th class="text-center" style="width: 40px">
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
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Kondisi</th>
                            </tr>
                        </x-slot:thead>

                        <x-slot:tbody>
                            @forelse ($this->commodities as $commodity)
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="custom-checkbox custom-control">
                                            <input
                                                type="checkbox"
                                                data-checkboxes="mygroup"
                                                class="custom-control-input"
                                                id="checkbox-{{ $commodity->id }}"
                                            />
                                            <label for="checkbox-{{ $commodity->id }}" class="custom-control-label"
                                                >&nbsp;</label>
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        <div class="font-weight-bold text-dark mb-2" style="font-size: 0.95rem">
                                            {{ $commodity->name }}
                                        </div>

                                        <div class="mb-2">
                                            <x-badge
                                                :label="$commodity->commodityLocation->name"
                                                icon="fa-map-marker-alt"
                                                class="badge-dark"
                                            />
                                        </div>

                                        <div class="d-flex align-items-center mb-3 flex-wrap">
                                            <x-badge
                                                :label="$commodity->item_code"
                                                icon="fa-code"
                                                class="badge-primary mr-2 mb-1"
                                            />

                                            <x-badge
                                                :label="$commodity->commodityFundingSource->name"
                                                icon="fa-hand-holding"
                                                class="badge-info mb-1"
                                            />
                                        </div>

                                        <div class="table-links">
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="QR Code"
                                            >
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-info"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Detail"
                                            >
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-success"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ubah"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-secondary"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Print"
                                            >
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-danger"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="align-middle">
                                        <x-badge
                                            :label="$commodity->material->name"
                                            class="badge-light d-block mb-2 py-1"
                                        />

                                        <x-badge
                                            :label="$commodity->brand->name"
                                            class="badge-light d-block mb-2 py-1"
                                        />
                                    </td>

                                    <td class="text-center align-middle">
                                        <img
                                            alt="image"
                                            src="https://picsum.photos/50/50?random={{ $commodity->id }}"
                                            class="rounded-circle border"
                                            width="45"
                                            height="45"
                                            style="object-fit: cover"
                                            data-toggle="tooltip"
                                            title="Klik untuk melihat gambar"
                                        />
                                    </td>

                                    <td class="text-center align-middle">
                                        <x-badge
                                            :label="$commodity->purchase_year"
                                            icon="fa-calendar-alt"
                                            class="badge-light d-block"
                                        />
                                    </td>

                                    <td class="text-center align-middle">
                                        <span class="font-weight-bold h6 mb-0">{{ $commodity->quantity }}</span>
                                    </td>

                                    <td class="text-right align-middle">
                                        <div class="font-weight-bold text-primary">
                                            {{ Number::currency($commodity->total_price, in: 'IDR', locale: 'id') }}
                                        </div>
                                        @if ($commodity->quantity > 1)
                                            <small class="text-muted">
                                                {{ $commodity->quantity }} × {{ Number::currency($commodity->unit_price, in: 'IDR', locale: 'id') }}
                                            </small>
                                        @endif
                                    </td>

                                    @php $conditionStyle = $this->conditionStyle($commodity->condition) @endphp
                                    <td class="text-center align-middle">
                                        <span class="badge {{ $conditionStyle['badge'] }} px-3 py-2">
                                            <i class="fas {{ $conditionStyle['icon'] }} mr-1"></i>
                                            {{ $commodity->condition->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <x-empty-state :search="$this->search" colspan="8" />
                                </tr>
                            @endforelse
                        </x-slot:tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</div>
