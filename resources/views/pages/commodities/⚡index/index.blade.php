@php
    $commodityPaginator = $this->commodities;
    $counts = is_array($this->conditionCounts ?? null) ? $this->conditionCounts : [];
    $totalCount = (int) ($counts['total'] ?? 0);
    $goodCount = (int) ($counts['good'] ?? 0);
    $poorCount = (int) ($counts['poor'] ?? 0);
    $damagedCount = (int) ($counts['heavily_damaged'] ?? 0);

    $modalId = $modalParams['id'] ?? null;
    $modalQrCode = $modalParams['qrcode'] ?? null;
    $selectedRecords = $this->selectedRecords;
    $selectedNames = $selectedRecords->pluck('name')->all();
    $selectedKeys = implode('-', $selectedRecords->modelKeys());

    $categories = [
        'elektronik' => 'Elektronik',
        'fashion' => 'Fashion',
        'makanan' => 'Makanan',
        'buku' => 'Buku',
        'peralatan' => 'Peralatan',
        'kendaraan' => 'Kendaraan',
        'perabotan' => 'Perabotan',
        'alat_tulis' => 'Alat Tulis',
    ];
@endphp

<div>
    @if ($activeModal === 'import')
        @teleport('body')
            <livewire:pages::commodities.import wire:key="modal-commodity-import" />
        @endteleport
    @endif

    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::commodities.export wire:key="modal-commodity-export" />
        @endteleport
    @endif

    @if ($activeModal === 'show' && filled($modalId))
        @teleport('body')
            <livewire:pages::commodities.show :commodityId="$modalId" wire:key="modal-show-{{ $modalId }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="barang"
                :records="$selectedNames"
                wire:key="modal-bulk-destroy-{{ $selectedKeys !== '' ? $selectedKeys : 'empty' }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'qrcode' && filled($modalQrCode))
        @teleport('body')
            <livewire:pages::commodities.qrcode :qrcode="$modalQrCode" wire:key="modal-qrcode-{{ $modalQrCode }}" />
        @endteleport
    @endif

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card icon="fas fa-box" bg-color="primary" title="Total Barang" :value="$totalCount" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card icon="fas fa-check-circle" bg-color="success" title="Kondisi Baik" :value="$goodCount" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-exclamation-circle"
                bg-color="warning"
                class="text-dark"
                title="Kondisi Kurang Baik"
                :value="$poorCount"
            />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <x-statistic-card
                icon="fas fa-circle-xmark"
                bg-color="danger"
                title="Kondisi Rusak Berat"
                :value="$damagedCount"
            />
        </div>
    </div>

    <x-page :searchable="true">
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                <div class="d-flex flex-wrap">
                    @can('impor barang')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'import'})"
                            icon="fa-file-import"
                            label="Impor"
                            variant="success"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('ekspor barang')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('hapus barang')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan

                    @can('print barang')
                        <a
                            href="{{ route('barang.pdf.all') }}"
                            class="btn btn-secondary mr-2 mb-2"
                            title="Cetak"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i class="fas fa-print mr-1" aria-hidden="true"></i>
                            Cetak
                        </a>
                    @endcan

                    <x-button
                        wire:click="$refresh"
                        icon="fa-sync-alt"
                        label="Muat Ulang"
                        variant="light"
                        class="mb-2"
                        wire:loading.attr="disabled"
                        wire:target="$refresh"
                        data-toggle="tooltip"
                        title="Muat Ulang"
                    />
                </div>

                @can('tambah barang')
                    <a wire:navigate href="{{ route('barang.create') }}" class="btn btn-primary mb-2">
                        <i class="fas fa-plus-circle mr-1" aria-hidden="true"></i>
                        Tambah Data
                    </a>
                @endcan
            </div>
        </x-slot:toolbar>

        <x-filter-accordion id="filter-accordion" title="Filter Data" :active-filters-count="$this->activeFiltersCount">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.category"
                        label="Kategori"
                        icon="fa-tags"
                        wire:model.live="filters.category"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $categoryValue => $categoryLabel)
                            <option value="{{ $categoryValue }}" wire:key="filter-category-{{ $categoryValue }}">
                                {{ $categoryLabel }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.condition"
                        label="Kondisi"
                        icon="fa-check-circle"
                        wire:model.live="filters.condition"
                    >
                        <option value="">Semua Kondisi</option>
                        @foreach ($this->conditions as $value => $label)
                            <option value="{{ $value }}" wire:key="filter-condition-{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.purchase_year"
                        label="Tahun Pembelian"
                        icon="fa-calendar-alt"
                        wire:model.live="filters.purchase_year"
                    >
                        <option value="">Semua Tahun</option>
                        @foreach ($this->purchaseYears as $purchaseYear)
                            <option value="{{ $purchaseYear }}" wire:key="filter-year-{{ $purchaseYear }}">
                                {{ $purchaseYear }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.funding_source"
                        label="Perolehan"
                        icon="fa-hand-holding"
                        wire:model.live="filters.funding_source"
                    >
                        <option value="">Semua Perolehan</option>
                        @foreach ($this->commodityFundingSources as $fundingSource)
                            <option value="{{ $fundingSource->id }}" wire:key="filter-funding-{{ $fundingSource->id }}">
                                {{ $fundingSource->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select name="filters.material" label="Bahan" icon="fa-cube" wire:model.live="filters.material">
                        <option value="">Semua Bahan</option>
                        @foreach ($this->materials as $material)
                            <option value="{{ $material->id }}" wire:key="filter-material-{{ $material->id }}">
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select name="filters.brand" label="Merek" icon="fa-trademark" wire:model.live="filters.brand">
                        <option value="">Semua Merek</option>
                        @foreach ($this->brands as $brand)
                            <option value="{{ $brand->id }}" wire:key="filter-brand-{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.location"
                        label="Ruangan"
                        icon="fa-map-marker-alt"
                        wire:model.live="filters.location"
                    >
                        <option value="">Semua Ruangan</option>
                        @foreach ($this->commodityLocations as $location)
                            <option value="{{ $location->id }}" wire:key="filter-location-{{ $location->id }}">
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select
                        name="filters.created_by"
                        label="Dibuat Oleh"
                        icon="fa-user"
                        wire:model.live="filters.created_by"
                    >
                        <option value="">Semua Pengguna</option>
                        @foreach ($this->createdBy as $user)
                            <option value="{{ $user->id }}" wire:key="filter-user-{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-dollar-sign mr-1" aria-hidden="true"></i>
                        Range Harga
                    </label>
                    <div class="input-group">
                        <input
                            type="number"
                            class="form-control"
                            wire:model.live.debounce.500ms="filters.price_min"
                            placeholder="Min."
                            min="0"
                            step="any"
                            inputmode="numeric"
                        />
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <input
                            type="number"
                            class="form-control"
                            wire:model.live.debounce.500ms="filters.price_max"
                            placeholder="Maks."
                            min="0"
                            step="any"
                            inputmode="numeric"
                        />
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-cubes mr-1" aria-hidden="true"></i>
                        Range Jumlah
                    </label>
                    <div class="input-group">
                        <input
                            type="number"
                            class="form-control"
                            wire:model.live.debounce.500ms="filters.quantity_min"
                            placeholder="Min."
                            min="0"
                            step="1"
                            inputmode="numeric"
                        />
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <input
                            type="number"
                            class="form-control"
                            wire:model.live.debounce.500ms="filters.quantity_max"
                            placeholder="Maks."
                            min="0"
                            step="1"
                            inputmode="numeric"
                        />
                    </div>
                </div>
            </div>
        </x-filter-accordion>

        <x-table
            :targets="[
                'filters.condition',
                'filters.purchase_year',
                'filters.funding_source',
                'filters.material',
                'filters.brand',
                'filters.location',
                'filters.created_by',
            ]"
            :paginator="$commodityPaginator"
        >
            <x-slot:thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="checkbox-all"
                                wire:model.live="selectAll"
                            />
                            <label for="checkbox-all" class="custom-control-label" aria-hidden="true"></label>
                        </div>
                    </th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Merek &amp; Bahan</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Tahun</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Kondisi</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($commodityPaginator as $commodity)
                    @php
                        $imagePath = $commodity->image;
                        $hasStoredImage = filled($imagePath) && Storage::disk('public')->exists($imagePath);
                        $hasPublicImage = filled($imagePath) && file_exists(public_path($imagePath));
                        $imageUrl = $hasStoredImage
                            ? Storage::url($imagePath)
                            : ($hasPublicImage ? asset($imagePath) : 'https://placehold.co/96x72?text=No+Picture');

                        $quantity = (int) ($commodity->quantity ?? 0);
                        $unitPrice = is_numeric($commodity->unit_price ?? null) ? (float) $commodity->unit_price : 0.0;
                        $totalPrice = is_numeric($commodity->total_price ?? null)
                            ? (float) $commodity->total_price
                            : ($quantity * $unitPrice);

                        $conditionStyle = $commodity->condition !== null
                            ? $this->conditionStyle($commodity->condition)
                            : ['icon' => 'fa-circle-question', 'badge' => 'badge-secondary'];
                        $conditionLabel = $commodity->condition?->label() ?? '-';
                    @endphp

                    <tr wire:key="commodity-{{ $commodity->id }}">
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $commodity->id }}"
                                    wire:model.live="selected"
                                    value="{{ $commodity->id }}"
                                />
                                <label
                                    for="checkbox-{{ $commodity->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $commodity->name ?? '-' }}</div>

                            <div class="mb-2">
                                <x-badge
                                    :label="$commodity->commodityLocation?->name ?? '-'"
                                    icon="fa-map-marker-alt"
                                    variant="dark"
                                />
                            </div>

                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <x-badge
                                    :label="$commodity->item_code ?? '-'"
                                    icon="fa-code"
                                    variant="primary"
                                    class="mr-2 mb-1"
                                />

                                <x-badge
                                    :label="$commodity->commodityFundingSource?->name ?? '-'"
                                    icon="fa-hand-holding"
                                    variant="primary"
                                    class="mb-1"
                                />
                            </div>
                        </td>

                        <td class="align-middle">
                            <x-badge
                                :label="$commodity->material?->name ?? '-'"
                                variant="light"
                                class="d-block mb-2 py-1"
                            />
                            <x-badge
                                :label="$commodity->brand?->name ?? '-'"
                                variant="light"
                                class="d-block mb-2 py-1"
                            />
                        </td>

                        <td class="text-center align-middle">
                            <img
                                alt="{{ $hasStoredImage || $hasPublicImage ? 'Foto ' . ($commodity->name ?? 'Barang') : 'No Picture' }}"
                                src="{{ $imageUrl }}"
                                class="rounded border"
                                width="96"
                                height="72"
                                style="object-fit: cover"
                                loading="lazy"
                                decoding="async"
                            />
                        </td>

                        <td class="text-center align-middle">
                            <x-badge
                                :label="$commodity->purchase_year ?? '-'"
                                icon="fa-calendar-alt"
                                variant="light"
                                class="d-block"
                            />
                        </td>

                        <td class="text-center align-middle">
                            <span class="font-weight-bold">{{ number_format($quantity, 0, ',', '.') }}</span>
                        </td>

                        <td class="text-right align-middle">
                            <div class="font-weight-bold text-primary">
                                {{ \Illuminate\Support\Number::currency($totalPrice, in: 'IDR', locale: 'id') }}
                            </div>
                            @if ($quantity > 1)
                                <small class="text-muted">
                                    {{ $quantity }} &times; {{ \Illuminate\Support\Number::currency($unitPrice, in: 'IDR', locale: 'id') }}
                                </small>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            <span class="badge {{ $conditionStyle['badge'] }} px-3 py-2">
                                <i class="fas {{ $conditionStyle['icon'] }} mr-1" aria-hidden="true"></i>
                                {{ $conditionLabel }}
                            </span>
                        </td>

                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi barang">
                                @if (filled($commodity->qr_code))
                                    @can('detail barang')
                                        <button
                                            type="button"
                                            wire:click="$dispatch('showModal', {modalName: 'qrcode', params: {qrcode: @js($commodity->qr_code)}})"
                                            class="btn btn-sm btn-dark"
                                            aria-label="Lihat kode QR barang"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Kode QR"
                                        >
                                            <i class="fas fa-qrcode" aria-hidden="true"></i>
                                        </button>
                                    @endcan
                                @else
                                    @can('ubah barang')
                                        <button
                                            type="button"
                                            wire:click="generateQrCode({{ $commodity->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="generateQrCode({{ $commodity->id }})"
                                            class="btn btn-sm btn-dark"
                                            aria-label="Buat kode QR barang"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Buat Kode QR"
                                        >
                                            <i
                                                class="fas fa-spinner"
                                                aria-hidden="true"
                                                wire:loading.class="fa-spin"
                                                wire:target="generateQrCode({{ $commodity->id }})"
                                            ></i>
                                        </button>
                                    @endcan
                                @endif

                                @can('detail barang')
                                    <x-button
                                        label=""
                                        icon="fa-search"
                                        variant="info"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $commodity->id }}}})"
                                        aria-label="Detail barang"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Detail"
                                    />
                                @endcan

                                @can('ubah barang')
                                    <a
                                        wire:navigate
                                        href="{{ route('barang.edit', $commodity) }}"
                                        class="btn btn-sm btn-success"
                                        aria-label="Ubah barang"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    >
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                @endcan

                                @if (filled($commodity->qr_code))
                                    @can('print barang')
                                        <a
                                            href="{{ route('barang.pdf', $commodity->qr_code) }}"
                                            class="btn btn-sm btn-secondary"
                                            aria-label="Cetak kode QR barang"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Cetak"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <i class="fas fa-print" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                @endif

                                @can('hapus barang')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $commodity->id }})"
                                        wire:confirm="Yakin ingin menghapus barang '{{ $commodity->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy({{ $commodity->id }})"
                                        aria-label="Hapus barang"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Hapus"
                                    />
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <x-empty-state :search="$this->search" colspan="9" />
                    </tr>
                @endforelse
            </x-slot:tbody>
        </x-table>
    </x-page>
</div>
