@extends('verifications.app')

@section('title', 'Verifikasi Barang - '.$commodity->name)

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            {{-- Success header --}}
            <div class="mb-4 text-center">
                <div
                    class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-white"
                    style="width: 64px; height: 64px"
                >
                    <i class="fas fa-check fa-2x"></i>
                </div>
                <h5 class="font-weight-bold mb-1">Barang Terverifikasi</h5>
                <small class="text-muted">Data barang tercatat dalam sistem inventaris</small>
            </div>

            {{-- Commodity image --}}
            @if ($commodity->image)
                <img
                    src="{{ asset('storage/' . $commodity->image) }}"
                    alt="{{ $commodity->name }}"
                    class="img-fluid mb-4 w-100 rounded border"
                    style="height: 220px; object-fit: cover"
                />
            @else
                <div
                    class="bg-light d-flex align-items-center justify-content-center mb-4 rounded border"
                    style="height: 220px"
                >
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif

            {{-- Identity --}}
            <div class="mb-3 text-center">
                <div class="h5 font-weight-bold mb-1">{{ $commodity->name }}</div>
                <div class="text-muted small">
                    <i class="fas fa-code mr-1"></i>
                    <span class="font-weight-bold text-dark">{{ $commodity->item_code }}</span>
                </div>
            </div>

            <hr class="my-3" />

            {{-- Detail list --}}
            <div class="mb-1">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-trademark mr-2"></i>Merek</span>
                    <span class="font-weight-bold">{{ $commodity->brand->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-cube mr-2"></i>Bahan</span>
                    <span class="font-weight-bold">{{ $commodity->material->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</span>
                    <span class="font-weight-bold text-right">{{ $commodity->commodityLocation->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-hand-holding mr-2"></i>Sumber Dana</span>
                    <span class="font-weight-bold text-right">{{ $commodity->commodityFundingSource->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-calendar-alt mr-2"></i>Tahun</span>
                    <span class="font-weight-bold">{{ $commodity->purchase_year }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-cubes mr-2"></i>Jumlah</span>
                    <span class="font-weight-bold">{{ $commodity->quantity }} unit</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-muted"><i class="fas fa-clipboard-check mr-2"></i>Kondisi</span>
                    <span class="badge {{ $conditionStyle['badge'] }} px-3 py-2">
                        <i class="fas {{ $conditionStyle['icon'] }} mr-1"></i>
                        {{ $commodity->condition?->label() ?? '-' }}
                    </span>
                </div>
                @if ($commodity->notes)
                    <div class="d-flex justify-content-between align-items-start py-2">
                        <span class="text-muted"><i class="fas fa-sticky-note mr-2"></i>Catatan</span>
                        <span class="font-weight-bold ml-3 text-right">{{ $commodity->notes }}</span>
                    </div>
                @endif
            </div>

            {{-- QR Code --}}
            <div class="bg-light mt-3 rounded border px-3 py-3 text-center">
                <div class="text-muted small mb-2"><i class="fas fa-qrcode mr-1"></i>Kode QR</div>
                <code class="d-block text-dark font-weight-bold">{{ $commodity->qr_code }}</code>
            </div>
        </div>

        {{-- Verification timestamp --}}
        <div class="card-footer bg-white py-3 text-center">
            <small class="text-muted">
                <i class="fas fa-lock mr-1"></i>
                Diverifikasi pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
            </small>
        </div>
    </div>
@endsection
