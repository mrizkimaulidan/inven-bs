@php
    $style = $this->conditionStyle;
    $imagePath = $commodity?->image;
    $hasStoredImage = filled($imagePath) && Storage::disk('public')->exists($imagePath);
    $hasPublicImage = filled($imagePath) && file_exists(public_path($imagePath));
    $imageUrl = $hasStoredImage
        ? Storage::url($imagePath)
        : ($hasPublicImage ? asset($imagePath) : 'https://placehold.co/96x72?text=No+Picture');

    $quantity = (int) ($commodity?->quantity ?? 0);
    $unitPrice = is_numeric($commodity?->unit_price ?? null) ? (float) $commodity->unit_price : 0.0;
    $totalPrice = is_numeric($commodity?->total_price ?? null)
        ? (float) $commodity->total_price
        : ($quantity * $unitPrice);

    $conditionLabel = $commodity?->condition?->label() ?? $style['label'];
    $createdAtFormatted = $commodity?->created_at?->translatedFormat('d F Y H:i') ?? '-';
    $updatedAtFormatted = $commodity?->updated_at?->translatedFormat('d F Y H:i') ?? '-';
    $creatorName = $commodity?->creator?->name ?? '-';
    $updaterName = $commodity?->updater?->name ?? '-';
@endphp

<x-modal title="Detail Komoditas" size="lg" :scrollable="true">
    <x-slot:body>
        <div class="row">
            <div class="col-md-5 mb-md-0 mb-3">
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $hasStoredImage || $hasPublicImage ? 'Foto ' . ($commodity?->name ?? 'Barang') : 'No Picture' }}"
                    class="img-fluid w-100 rounded border"
                    style="height: 280px; object-fit: cover"
                />
                <small class="form-text text-muted d-block mt-2 text-center">
                    <i class="fas fa-camera mr-1" aria-hidden="true"></i>
                    Foto Barang
                </small>
            </div>

            <div class="col-md-7">
                <h4 class="font-weight-bold mb-2">{{ $commodity?->name ?? '-' }}</h4>

                <div class="mb-3">
                    <span class="badge {{ $style['badge'] }} px-3 py-2">
                        <i class="fas {{ $style['icon'] }} mr-1" aria-hidden="true"></i>
                        {{ $conditionLabel }}
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-barcode mr-1" aria-hidden="true"></i>
                        Kode Barang
                    </span>
                    <span class="font-weight-bold font-monospace">{{ $commodity?->item_code ?? '-' }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-cube mr-1" aria-hidden="true"></i>
                        Bahan
                    </span>
                    <span class="font-weight-bold">{{ $commodity?->material?->name ?? '-' }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-trademark mr-1" aria-hidden="true"></i>
                        Merek
                    </span>
                    <span class="font-weight-bold">{{ $commodity?->brand?->name ?? '-' }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i>
                        Tahun Pembelian
                    </span>
                    <span class="font-weight-bold">{{ $commodity?->purchase_year ?? '-' }}</span>
                </div>
            </div>
        </div>

        <hr class="my-4" />

        <div class="row">
            <div class="col-md-4 mb-md-0 mb-3">
                <div class="bg-light h-100 rounded border px-3 py-2">
                    <div class="d-flex align-items-center mb-2">
                        <div
                            class="bg-primary d-flex align-items-center justify-content-center mr-2 rounded text-white"
                            style="width: 36px; height: 36px"
                        >
                            <i class="fas fa-sort-numeric-up" aria-hidden="true"></i>
                        </div>
                        <span class="text-muted">Jumlah</span>
                    </div>
                    <div class="h4 font-weight-bold mb-0">{{ number_format($quantity, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-md-0 mb-3">
                <div class="bg-light h-100 rounded border px-3 py-2">
                    <div class="d-flex align-items-center mb-2">
                        <div
                            class="bg-success d-flex align-items-center justify-content-center mr-2 rounded text-white"
                            style="width: 36px; height: 36px"
                        >
                            <i class="fas fa-money-bill" aria-hidden="true"></i>
                        </div>
                        <span class="text-muted">Harga Satuan</span>
                    </div>
                    <div class="h5 font-weight-bold mb-0">
                        {{ \Illuminate\Support\Number::currency($unitPrice, in: 'IDR', locale: 'id') }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-light h-100 rounded border px-3 py-2">
                    <div class="d-flex align-items-center mb-2">
                        <div
                            class="bg-info d-flex align-items-center justify-content-center mr-2 rounded text-white"
                            style="width: 36px; height: 36px"
                        >
                            <i class="fas fa-calculator" aria-hidden="true"></i>
                        </div>
                        <span class="text-muted">Total Harga</span>
                    </div>
                    <div class="h5 font-weight-bold mb-0">
                        {{ \Illuminate\Support\Number::currency($totalPrice, in: 'IDR', locale: 'id') }}
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4" />

        <div class="form-group mb-0">
            <label class="mb-2">
                <i class="fas fa-map-marker-alt mr-1" aria-hidden="true"></i>
                Penempatan &amp; Perolehan
            </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="text-muted">Ruangan</span>
                        <span class="font-weight-bold">{{ $commodity?->commodityLocation?->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="text-muted">Perolehan</span>
                        <span class="font-weight-bold">{{ $commodity?->commodityFundingSource?->name ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-4 mb-0">
            <label class="mb-2">
                <i class="fas fa-sticky-note mr-1" aria-hidden="true"></i>
                Catatan
            </label>
            <div class="bg-light rounded border px-3 py-2">
                <i class="fas fa-info-circle text-warning mr-1" aria-hidden="true"></i>
                {{ filled($commodity?->notes) ? $commodity->notes : '-' }}
            </div>
        </div>

        <hr class="my-4" />

        <div class="row text-muted">
            <div class="col-md-6 mb-1">
                <small>
                    <i class="fas fa-calendar-plus mr-1" aria-hidden="true"></i>
                    Dibuat: {{ $createdAtFormatted }} ({{ $creatorName }})
                </small>
            </div>
            <div class="col-md-6 mb-1">
                <small>
                    <i class="fas fa-calendar-check mr-1" aria-hidden="true"></i>
                    Diperbarui: {{ $updatedAtFormatted }} ({{ $updaterName }})
                </small>
            </div>
        </div>
    </x-slot:body>
</x-modal>
