{{-- ===== START: Filter Bar ===== --}}
<div class="row">
    <div class="col-12">
        <x-dashboard-filter-bar>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="form-group">
                        <label for="dashboard-search">Cari Barang</label>
                        <input
                            id="dashboard-search"
                            type="search"
                            class="form-control"
                            placeholder="Cari nama atau kode barang"
                            wire:model.live.debounce.500ms="filters.search"
                        />
                        @error('filters.search')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="brandId" label="Merek" wire:model.live="filters.brandId">
                        <option value="">Semua Merek</option>
                        @foreach ($pageData['filterOptions']['brands'] as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </x-select>
                    @error('filters.brandId')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="materialId" label="Bahan" wire:model.live="filters.materialId">
                        <option value="">Semua Bahan</option>
                        @foreach ($pageData['filterOptions']['materials'] as $material)
                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
                    </x-select>
                    @error('filters.materialId')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="locationId" label="Lokasi" wire:model.live="filters.locationId">
                        <option value="">Semua Lokasi</option>
                        @foreach ($pageData['filterOptions']['locations'] as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </x-select>
                    @error('filters.locationId')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="condition" label="Kondisi" wire:model.live="filters.condition">
                        <option value="">Semua Kondisi</option>
                        @foreach ($pageData['filterOptions']['conditions'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select>
                    @error('filters.condition')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <x-select name="purchaseYear" label="Tahun Pembelian" wire:model.live="filters.purchaseYear">
                        <option value="">Semua Tahun</option>
                        @foreach ($pageData['filterOptions']['purchaseYears'] as $purchaseYear)
                            <option value="{{ $purchaseYear }}">{{ $purchaseYear }}</option>
                        @endforeach
                    </x-select>
                    @error('filters.purchaseYear')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span
                    wire:loading
                    wire:target="filters.search,filters.brandId,filters.materialId,filters.locationId,filters.condition,filters.purchaseYear"
                    class="text-muted small mb-2"
                >
                    Memuat data inventaris...
                </span>
                <button
                    type="button"
                    class="btn btn-light btn-sm ml-auto"
                    wire:click="resetFilters"
                    wire:loading.attr="disabled"
                    wire:target="resetFilters"
                >
                    <i class="fas fa-undo mr-1" aria-hidden="true"></i>
                    Reset Filter
                </button>
            </div>
        </x-dashboard-filter-bar>
    </div>
</div>
{{-- ===== END: Filter Bar ===== --}}
