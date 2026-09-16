<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save">
                        <div class="row">
                            <div class="col-md-3">
                                <x-input
                                    wire:model="form.name"
                                    name="form.name"
                                    label="Nama Barang"
                                    icon="fa-box"
                                    placeholder="Masukkan nama barang"
                                    required
                                    autofocus
                                />
                            </div>

                            <div class="col-md-3">
                                <x-input
                                    wire:model="form.item_code"
                                    name="form.item_code"
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
                                    name="form.commodity_location_id"
                                    label="Lokasi"
                                    wire:model="form.commodity_location_id"
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
                                    name="form.commodity_funding_source_id"
                                    label="Perolehan"
                                    wire:model="form.commodity_funding_source_id"
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
                                    name="form.material_id"
                                    label="Material"
                                    wire:model="form.material_id"
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
                                    name="form.brand_id"
                                    label="Merek"
                                    wire:model="form.brand_id"
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
                                    name="form.purchase_year"
                                    label="Tahun Pembelian"
                                    wire:model="form.purchase_year"
                                    required
                                >
                                    <option value="">Pilih Tahun</option>
                                    @foreach (range(1900, date('Y')) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="col-md-6">
                                <x-select
                                    icon="fa-check-circle"
                                    name="form.condition"
                                    label="Kondisi Barang"
                                    wire:model="form.condition"
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
                                    wire:model.live="form.quantity"
                                    name="form.quantity"
                                    label="Jumlah"
                                    type="number"
                                    icon="fa-sort-numeric-up"
                                    placeholder="Masukkan jumlah"
                                    required
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input
                                    wire:model.live="form.unit_price"
                                    name="form.unit_price"
                                    label="Harga Satuan (Rp)"
                                    type="number"
                                    icon="fa-money-bill"
                                    placeholder="Masukkan harga per unit"
                                    required
                                />
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_price">
                                        <i class="fas fa-calculator mr-1"></i>
                                        Total Harga (Rp)
                                    </label>

                                    <div id="total_price" class="bg-light rounded border px-3 py-2">
                                        <div class="font-weight-bold">{{ $this->totalPriceFormatted }}</div>
                                        @if ($this->totalPrice > 0)
                                            <hr />
                                            <small class="font-weight-bold font-italic">
                                                {{ $this->totalInWords }}
                                            </small>
                                        @endif
                                    </div>

                                    <small class="form-text text-muted">
                                        <i class="fas fa-equals"></i> Jumlah <i class="fas fa-times"></i> harga satuan
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">
                                        <i class="fas fa-image mr-1"></i>
                                        Foto Barang
                                    </label>

                                    <div class="custom-file">
                                        <input
                                            wire:model="form.image"
                                            type="file"
                                            id="form.image"
                                            class="custom-file-input @error('form.image') is-invalid @enderror"
                                            accept="image/*"
                                            required
                                        />
                                        <label class="custom-file-label" for="form.image"> Pilih file gambar... </label>
                                    </div>
                                    @error('form.image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div wire:loading wire:target="form.image" class="mt-2">
                                        <span
                                            class="spinner-border spinner-border-sm text-primary"
                                            role="status"
                                        ></span>
                                        <small class="text-muted ml-1">Mengunggah gambar...</small>
                                    </div>

                                    <div class="mt-2" wire:loading.remove wire:target="form.image">
                                        @if ($form->image)
                                            <img
                                                src="{{ $form->image->temporaryUrl() }}"
                                                alt="Preview Foto Barang"
                                                class="img-thumbnail"
                                                style="max-height: 120px; max-width: 120px; object-fit: cover"
                                            />
                                            <small class="form-text text-muted d-block">
                                                <i class="fas fa-check-circle text-success mr-1"></i>
                                                Gambar siap diunggah
                                            </small>
                                        @else
                                            <div
                                                class="d-flex align-items-center justify-content-center bg-light rounded border"
                                                style="width: 120px; height: 120px"
                                            >
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                            <small class="form-text text-muted">
                                                Format: JPG, PNG, atau WEBP. Maks. 2 MB.
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <x-textarea
                                    wire:model="form.notes"
                                    name="form.notes"
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
                            <x-button
                                type="submit"
                                icon="fa-plus-circle"
                                label="Simpan Data"
                                class="btn-primary mb-2"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
