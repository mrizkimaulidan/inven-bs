@extends('verifications.app')

@section('title', $title ?? 'Tidak Ditemukan')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body py-4 text-center">
            {{-- Error header --}}
            <i class="fas {{ $icon ?? 'fa-times-circle' }} fa-3x text-{{ $color ?? 'danger' }} mb-3"></i>
            <h5 class="font-weight-bold mb-2">{{ $title ?? 'Tidak Ditemukan' }}</h5>
            <p class="text-muted mb-4">
                {!! $message ?? 'Data yang Anda cari <strong>tidak ditemukan</strong> dalam sistem. Pastikan data yang dimasukkan sudah benar.' !!}
            </p>

            <a href="{{ $backUrl ?? url('/') }}" class="btn btn-{{ $color ?? 'danger' }}">
                <i class="fas {{ $backIcon ?? 'fa-home' }} mr-1"></i> {{ $backLabel ?? 'Kembali ke Beranda' }}
            </a>
        </div>

        {{-- Timestamp --}}
        <div class="card-footer text-muted bg-white py-3 text-center">
            <small>
                <i class="fas fa-clock mr-1"></i>
                {{ now()->translatedFormat('d F Y, H:i') }} WIB
            </small>
        </div>
    </div>
@endsection
