@php
    $filterOptions = is_array($pageData['filterOptions'] ?? null) ? $pageData['filterOptions'] : [];
    $brands = $filterOptions['brands'] ?? [];
    $materials = $filterOptions['materials'] ?? [];
    $locations = $filterOptions['locations'] ?? [];
    $conditions = is_array($filterOptions['conditions'] ?? null) ? $filterOptions['conditions'] : [];
    $purchaseYears = $filterOptions['purchaseYears'] ?? [];
    $filterTargets = 'filters.search,filters.brandId,filters.materialId,filters.locationId,filters.condition,filters.purchaseYear';
@endphp

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
                            class="form-control @error('filters.search') is-invalid @enderror"
                            placeholder="Cari nama atau kode barang"
                            wire:model.live.debounce.500ms="filters.search"
                        />
                        @error('filters.search')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="filters.brandId" label="Merek" wire:model.live="filters.brandId">
                        <option value="">Semua Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" wire:key="filter-brand-{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="filters.materialId" label="Bahan" wire:model.live="filters.materialId">
                        <option value="">Semua Bahan</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" wire:key="filter-material-{{ $material->id }}">
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="filters.locationId" label="Ruangan" wire:model.live="filters.locationId">
                        <option value="">Semua Ruangan</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" wire:key="filter-location-{{ $location->id }}">
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <x-select name="filters.condition" label="Kondisi" wire:model.live="filters.condition">
                        <option value="">Semua Kondisi</option>
                        @foreach ($conditions as $value => $label)
                            <option value="{{ $value }}" wire:key="filter-condition-{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <x-select
                        name="filters.purchaseYear"
                        label="Tahun Pembelian"
                        wire:model.live="filters.purchaseYear"
                    >
                        <option value="">Semua Tahun</option>
                        @foreach ($purchaseYears as $purchaseYear)
                            <option value="{{ $purchaseYear }}" wire:key="filter-year-{{ $purchaseYear }}">
                                {{ $purchaseYear }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span wire:loading wire:target="{{ $filterTargets }}" class="text-muted small mb-2">
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
