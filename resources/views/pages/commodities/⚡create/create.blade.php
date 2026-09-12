<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-3">
                                <x-input
                                    name="name"
                                    label="Nama Barang"
                                    icon="fa-box"
                                    placeholder="Masukkan nama barang"
                                    required
                                    autofocus
                                />
                            </div>

                            <div class="col-md-3">
                                <x-input
                                    name="item_code"
                                    label="Kode Barang"
                                    icon="fa-barcode"
                                    placeholder="Masukkan kode barang"
                                    help="Kode barang harus unik"
                                    required
                                />
                            </div>

                            <div class="col-md-3">
                                <x-select
                                    icon="fa-map-marker-alt"
                                    name="location_id"
                                    label="Lokasi"
                                    wire:model="location_id"
                                    required
                                >
                                    <option value="">Pilih Lokasi</option>
                                    @foreach ($this->commodityLocations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="col-md-3">
                                <x-select
                                    icon="fa-hand-holding"
                                    name="commodity_funding_source_id"
                                    label="Perolehan"
                                    wire:model="commodity_funding_source_id"
                                    required
                                >
                                    <option value="">Pilih Perolehan</option>
                                    @foreach ($this->commodityFundingSources as $commodityFundingSource)
                                        <option value="{{ $commodityFundingSource->id }}">
                                            {{ $commodityFundingSource->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-select
                                    icon="fa-cube"
                                    name="material_id"
                                    label="Material"
                                    wire:model="material_id"
                                    required
                                >
                                    <option value="">Pilih Material</option>
                                    @foreach ($this->materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="col-md-6">
                                <x-select
                                    icon="fa-trademark"
                                    name="brand_id"
                                    label="Merek"
                                    wire:model="brand_id"
                                    required
                                >
                                    <option value="">Pilih Merek</option>
                                    @foreach ($this->brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-select
                                    icon="fa-calendar-alt"
                                    name="purchase_year"
                                    label="Tahun Pembelian"
                                    wire:model="purchase_year"
                                    required
                                >
                                    <option value="">Pilih Tahun</option>
                                    @foreach (range(2000, date('Y')) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="col-md-6">
                                <x-select
                                    icon="fa-check-circle"
                                    name="condition"
                                    label="Kondisi Barang"
                                    wire:model="condition"
                                    required
                                >
                                    <option value="">Pilih Kondisi</option>
                                    @foreach ($conditions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input
                                    name="quantity"
                                    label="Jumlah"
                                    type="number"
                                    icon="fa-sort-numeric-up"
                                    placeholder="Masukkan jumlah"
                                    required
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input
                                    name="unit_price"
                                    label="Harga Satuan (Rp)"
                                    type="number"
                                    icon="fa-money-bill"
                                    placeholder="Masukkan harga per unit"
                                    required
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input
                                    name="total_price"
                                    label="Total Harga (Rp)"
                                    type="text"
                                    icon="fa-calculator"
                                    placeholder="Otomatis terhitung"
                                    help="Jumlah akan dikali dengan harga satuan"
                                    readonly
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input
                                    name="qr_code"
                                    label="QR Code"
                                    icon="fa-qrcode"
                                    placeholder="Kosongkan untuk generate otomatis"
                                />
                            </div>

                            <div class="col-md-6">
                                <x-textarea
                                    name="notes"
                                    icon="fa-sticky-note"
                                    label="Catatan"
                                    placeholder="Masukan catatan (opsional)"
                                />
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                            <div class="d-flex flex-wrap">
                                <a wire:navigate href="/barang" class="btn btn-outline-secondary mr-2 mb-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <x-button
                                    wire:click="resetForm"
                                    icon="fa-rotate-left"
                                    label="Reset"
                                    class="btn-outline-warning mr-2 mb-2"
                                />
                            </div>
                            <x-button icon="fa-plus-circle" label="Simpan Data" class="btn-primary mb-2" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
