<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Tidak Ditemukan' }}</title>

    {{-- Bootstrap 4.6.2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    {{-- FontAwesome 7 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
</head>
<body class="bg-light">
    {{-- Centered container with a maximum width --}}
    <div class="container py-4" style="max-width: 520px">
        <div class="card">
            <div class="card-body py-4 text-center">
                {{-- Error Header --}}
                <i class="fas {{ $icon ?? 'fa-circle-xmark' }} fa-3x text-{{ $color ?? 'danger' }} mb-3"></i>
                <h5 class="font-weight-bold mb-2">{{ $title ?? 'Tidak Ditemukan' }}</h5>
                <p class="text-muted mb-4">
                    {!! $message ?? 'Data yang Anda cari <strong>tidak ditemukan</strong> dalam sistem. Pastikan data yang dimasukkan sudah benar.' !!}
                </p>

                <a href="{{ $backUrl ?? url('/') }}" class="btn btn-{{ $color ?? 'danger' }}">
                    <i class="fas {{ $backIcon ?? 'fa-home' }} mr-1"></i> {{ $backLabel ?? 'Kembali ke Beranda' }}
                </a>
            </div>

            {{-- Timestamp --}}
            <div class="card-footer text-muted border-0 bg-white py-3 text-center">
                <small>
                    <i class="fas fa-clock mr-1"></i>
                    {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </small>
            </div>
        </div>
    </div>
</body>
</html>
