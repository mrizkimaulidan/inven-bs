@php
    $commodityName = filled($commodity->name ?? null) ? (string) $commodity->name : '-';
    $itemCode = filled($commodity->item_code ?? null) ? (string) $commodity->item_code : '-';
    $brandName = $commodity->brand?->name ?? '-';
    $materialName = $commodity->material?->name ?? '-';
    $locationName = $commodity->commodityLocation?->name ?? '-';
    $fundingSourceName = $commodity->commodityFundingSource?->name ?? '-';
    $purchaseYear = filled($commodity->purchase_year ?? null) ? (string) $commodity->purchase_year : '-';
    $quantityCount = (int) ($commodity->quantity ?? 0);
    $quantityLabel = number_format($quantityCount, 0, ',', '.').' unit';
    $conditionBadge = (string) ($conditionStyle['badge'] ?? 'badge-secondary');
    $conditionIcon = (string) ($conditionStyle['icon'] ?? 'fa-info-circle');
    $conditionLabel = $commodity->condition?->label() ?? '-';
    $notesText = filled($commodity->notes ?? null) ? (string) $commodity->notes : null;
    $qrCodeText = filled($commodity->qr_code ?? null) ? (string) $commodity->qr_code : '-';
    $verifiedAt = now()->translatedFormat('d F Y, H:i');

    $imagePath = $commodity->image ?? null;
    $hasStoredImage = filled($imagePath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
    $imageUrl = $hasStoredImage ? \Illuminate\Support\Facades\Storage::url($imagePath) : null;
@endphp

@extends('verifications.app')

@section('title', 'Verifikasi Barang - '.$commodityName)

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="mb-4 text-center">
                <div
                    class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-white"
                    style="width: 64px; height: 64px"
                >
                    <i class="fas fa-check fa-2x" aria-hidden="true"></i>
                </div>
                <h5 class="font-weight-bold mb-1">Barang Terverifikasi</h5>
                <small class="text-muted">Data barang tercatat dalam sistem inventaris</small>
            </div>

            @if ($hasStoredImage && filled($imageUrl))
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $commodityName }}"
                    class="img-fluid mb-4 w-100 rounded border"
                    style="height: 220px; object-fit: cover"
                />
            @else
                <div
                    class="bg-light d-flex align-items-center justify-content-center mb-4 rounded border"
                    style="height: 220px"
                >
                    <i class="fas fa-image fa-3x text-muted" aria-hidden="true"></i>
                </div>
            @endif

            <div class="mb-3 text-center">
                <div class="h5 font-weight-bold mb-1">{{ $commodityName }}</div>
                <div class="text-muted small">
                    <i class="fas fa-code mr-1" aria-hidden="true"></i>
                    <span class="font-weight-bold text-dark">{{ $itemCode }}</span>
                </div>
            </div>

            <hr class="my-3" />

            <div class="mb-1">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"> <i class="fas fa-trademark mr-2" aria-hidden="true"></i>Merek </span>
                    <span class="font-weight-bold">{{ $brandName }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"> <i class="fas fa-cube mr-2" aria-hidden="true"></i>Bahan </span>
                    <span class="font-weight-bold">{{ $materialName }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-map-marker-alt mr-2" aria-hidden="true"></i>Ruangan
                    </span>
                    <span class="font-weight-bold text-right">{{ $locationName }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-hand-holding mr-2" aria-hidden="true"></i>Perolehan
                    </span>
                    <span class="font-weight-bold text-right">{{ $fundingSourceName }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"> <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>Tahun </span>
                    <span class="font-weight-bold">{{ $purchaseYear }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"> <i class="fas fa-cubes mr-2" aria-hidden="true"></i>Jumlah </span>
                    <span class="font-weight-bold">{{ $quantityLabel }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted">
                        <i class="fas fa-clipboard-check mr-2" aria-hidden="true"></i>Kondisi
                    </span>
                    <span class="badge {{ $conditionBadge }} px-3 py-2">
                        <i class="fas {{ $conditionIcon }} mr-1" aria-hidden="true"></i>
                        {{ $conditionLabel }}
                    </span>
                </div>
                @if (filled($notesText))
                    <div class="d-flex justify-content-between align-items-start py-2">
                        <span class="text-muted">
                            <i class="fas fa-sticky-note mr-2" aria-hidden="true"></i>Catatan
                        </span>
                        <span class="font-weight-bold ml-3 text-right">{{ $notesText }}</span>
                    </div>
                @endif
            </div>

            <div class="bg-light mt-3 rounded border px-3 py-3 text-center">
                <div class="text-muted small mb-2"><i class="fas fa-qrcode mr-1" aria-hidden="true"></i>Kode QR</div>
                <code class="d-block text-dark font-weight-bold">{{ $qrCodeText }}</code>
            </div>
        </div>

        <div class="card-footer bg-white py-3 text-center">
            <small class="text-muted">
                <i class="fas fa-lock mr-1" aria-hidden="true"></i>
                Diverifikasi pada {{ $verifiedAt }} WIB
            </small>
        </div>
    </div>
@endsection
