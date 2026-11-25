@php
    $pageTitle = filled($title ?? null) ? (string) $title : 'Tidak Ditemukan';
    $iconClass = filled($icon ?? null) ? (string) $icon : 'fa-times-circle';
    $colorVariant = filled($color ?? null) ? (string) $color : 'danger';
    $backHref = filled($backUrl ?? null) ? (string) $backUrl : url('/');
    $backIconClass = filled($backIcon ?? null) ? (string) $backIcon : 'fa-home';
    $backText = filled($backLabel ?? null) ? (string) $backLabel : 'Kembali ke Beranda';
    $hasCustomMessage = filled($message ?? null);
    $printedTimestamp = now()->translatedFormat('d F Y, H:i');
@endphp

@extends('verifications.app')

@section('title', $pageTitle)

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body py-4 text-center">
            <i class="fas {{ $iconClass }} fa-3x text-{{ $colorVariant }} mb-3" aria-hidden="true"></i>
            <h5 class="font-weight-bold mb-2">{{ $pageTitle }}</h5>
            <p class="text-muted mb-4">
                @if ($hasCustomMessage)
                    {{ $message }}
                @else
                    Data yang Anda cari
                    <strong>tidak ditemukan</strong>
                    dalam sistem. Pastikan data yang dimasukkan sudah benar.
                @endif
            </p>

            <a href="{{ $backHref }}" class="btn btn-{{ $colorVariant }}">
                <i class="fas {{ $backIconClass }} mr-1" aria-hidden="true"></i>
                {{ $backText }}
            </a>
        </div>

        <div class="card-footer text-muted bg-white py-3 text-center">
            <small>
                <i class="fas fa-clock mr-1" aria-hidden="true"></i>
                {{ $printedTimestamp }} WIB
            </small>
        </div>
    </div>
@endsection
