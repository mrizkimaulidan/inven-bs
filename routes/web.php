<?php

/**
 * Register application web routes.
 */

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityFundingSourceController;
use App\Http\Controllers\CommodityLocationController;
use App\Http\Controllers\CommodityVerificationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): RedirectResponse => auth()->check()
    ? redirect()->route('beranda')
    : redirect()->route('login'));

Route::middleware('guest')->group(function (): void {
    Route::livewire('/login', 'pages::authentication.login')->name('login');
});

Route::middleware('auth')->group(function (): void {
    Route::livewire('/beranda', 'pages::dashboard')->name('beranda');

    Route::prefix('barang')->name('barang.')->group(function (): void {
        Route::livewire('/', 'pages::commodities.index')
            ->middleware('permission:lihat barang')
            ->name('index');

        Route::livewire('/tambah', 'pages::commodities.create')
            ->middleware('permission:tambah barang')
            ->name('create');

        Route::livewire('/{commodity}/ubah', 'pages::commodities.edit')
            ->middleware('permission:ubah barang')
            ->name('edit');

        Route::get('/pdf', [CommodityController::class, 'generateAllPdf'])
            ->middleware('permission:print barang')
            ->name('pdf.all');

        Route::get('/{commodity:qr_code}/pdf', [CommodityController::class, 'generatePdf'])
            ->middleware('permission:print barang')
            ->name('pdf');
    });

    Route::prefix('ruangan')->name('ruangan.')->group(function (): void {
        Route::livewire('/', 'pages::commodity-locations.index')
            ->middleware('permission:lihat ruangan')
            ->name('index');

        Route::get('/pdf', [CommodityLocationController::class, 'generateAllPdf'])
            ->middleware('permission:print ruangan')
            ->name('pdf');
    });

    Route::prefix('merek')->name('merek.')->group(function (): void {
        Route::livewire('/', 'pages::brands.index')
            ->middleware('permission:lihat merek')
            ->name('index');

        Route::get('/pdf', [BrandController::class, 'generateAllPdf'])
            ->middleware('permission:print merek')
            ->name('pdf');
    });

    Route::prefix('bahan')->name('bahan.')->group(function (): void {
        Route::livewire('/', 'pages::materials.index')
            ->middleware('permission:lihat bahan')
            ->name('index');

        Route::get('/pdf', [MaterialController::class, 'generateAllPdf'])
            ->middleware('permission:print bahan')
            ->name('pdf');
    });

    Route::prefix('perolehan')->name('perolehan.')->group(function (): void {
        Route::livewire('/', 'pages::commodity-funding-sources.index')
            ->middleware('permission:lihat perolehan')
            ->name('index');

        Route::get('/pdf', [CommodityFundingSourceController::class, 'generateAllPdf'])
            ->middleware('permission:print perolehan')
            ->name('pdf');
    });

    Route::livewire('/pengaturan/profil', 'pages::settings.profile')
        ->name('pengaturan.profil');

    Route::livewire('/log-aktivitas', 'pages::activity-logs.index')
        ->middleware('permission:lihat log aktivitas')
        ->name('log-aktivitas.index');

    Route::prefix('peran-dan-hak-akses')->name('peran-dan-hak-akses.')->group(function (): void {
        Route::livewire('/', 'pages::roles.index')
            ->middleware('permission:lihat peran')
            ->name('index');

        Route::get('/pdf', [RoleController::class, 'generateAllPdf'])
            ->middleware('permission:print peran')
            ->name('pdf');

        Route::livewire('/tambah', 'pages::roles.create')
            ->middleware('permission:tambah peran')
            ->name('create');

        Route::livewire('/{role}/ubah', 'pages::roles.edit')
            ->middleware('permission:ubah peran')
            ->name('edit');
    });

    Route::prefix('pengguna')->name('pengguna.')->group(function (): void {
        Route::livewire('/', 'pages::users.index')
            ->middleware('permission:lihat pengguna')
            ->name('index');

        Route::get('/pdf', [UserController::class, 'generateAllPdf'])
            ->middleware('permission:print pengguna')
            ->name('pdf');
    });
});

Route::get('/verifikasi/barang/{commodity:qr_code}', CommodityVerificationController::class)
    ->middleware('throttle:30,1')
    ->name('verifikasi.barang');
