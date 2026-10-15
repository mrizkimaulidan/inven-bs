<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi Barang - {{ $commodity->name }}</title>

    {{-- Bootstrap 4.6.2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    {{-- FontAwesome 7 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
</head>
<body class="bg-light">
    <div class="container py-4" style="max-width: 520px">
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Success Header --}}
                <div class="border-bottom mb-3 pb-3 text-center">
                    <i class="fas fa-circle-check fa-3x text-success mb-2"></i>
                    <h5 class="font-weight-bold mb-1">Barang Terverifikasi</h5>
                    <small class="text-muted">Data barang tercatat dalam sistem inventaris</small>
                </div>

                {{-- Commodity image --}}
                @if ($commodity->image)
                    <img
                        src="{{ asset('storage/' . $commodity->image) }}"
                        alt="{{ $commodity->name }}"
                        class="img-fluid mb-3 w-100 rounded border"
                        style="height: 220px; object-fit: cover"
                    />
                @else
                    <div
                        class="bg-light d-flex align-items-center justify-content-center mb-3 rounded border"
                        style="height: 220px"
                    >
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif

                {{-- Commodity details --}}
                <table class="table-sm table-borderless mb-0 table">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width: 45%"><i class="fas fa-box mr-2"></i>Nama Barang</td>
                            <td class="font-weight-bold">{{ $commodity->name }}</td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-code mr-2"></i>Kode Barang</td>
                            <td>
                                <x-badge :label="$commodity->item_code" icon="fa-code" class="badge-primary" />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-qrcode mr-2"></i>Kode QR</td>
                            <td><code>{{ $commodity->qr_code }}</code></td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-trademark mr-2"></i>Merek</td>
                            <td>
                                <x-badge :label="$commodity->brand->name ?? '-'" class="badge-light" />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-cube mr-2"></i>Bahan</td>
                            <td>
                                <x-badge :label="$commodity->material->name ?? '-'" class="badge-light" />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</td>
                            <td>
                                <x-badge
                                    :label="$commodity->commodityLocation->name ?? '-'"
                                    icon="fa-map-marker-alt"
                                    class="badge-dark"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-hand-holding mr-2"></i>Sumber Dana</td>
                            <td>
                                <x-badge
                                    :label="$commodity->commodityFundingSource->name ?? '-'"
                                    icon="fa-hand-holding"
                                    class="badge-info"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-calendar-alt mr-2"></i>Tahun</td>
                            <td>
                                <x-badge
                                    :label="$commodity->purchase_year"
                                    icon="fa-calendar-alt"
                                    class="badge-light"
                                />
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-cubes mr-2"></i>Jumlah</td>
                            <td class="font-weight-bold">{{ $commodity->quantity }} unit</td>
                        </tr>

                        <tr>
                            <td class="text-muted"><i class="fas fa-clipboard-check mr-2"></i>Kondisi</td>
                            <td>
                                <span class="badge {{ $conditionStyle['badge'] }} px-3 py-2">
                                    <i class="fas {{ $conditionStyle['icon'] }} mr-1"></i>
                                    {{ $commodity->condition?->label() ?? '-' }}
                                </span>
                            </td>
                        </tr>

                        @if ($commodity->notes)
                            <tr>
                                <td class="text-muted"><i class="fas fa-note-sticky mr-2"></i>Catatan</td>
                                <td class="font-weight-bold">{{ $commodity->notes }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Verification timestamp --}}
            <div class="card-footer text-muted border-0 bg-white py-3 text-center">
                <small>
                    <i class="fas fa-lock mr-1"></i>
                    Diverifikasi pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </small>
            </div>
        </div>
    </div>
</body>
</html>
