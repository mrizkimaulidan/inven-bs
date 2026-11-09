<?php

/** Register application web routes. */

use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::authentication.login')->name('login');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/beranda', 'pages::dashboard');

    Route::livewire('/barang', 'pages::commodities.index');
    Route::livewire('/barang/tambah', 'pages::commodities.create');
    Route::livewire('/barang/{commodity}/ubah', 'pages::commodities.edit');

    Route::get('/barang/{commodity:qr_code}/pdf', [CommodityController::class, 'generatePdf'])
        ->name('barang.pdf');

    Route::livewire('/ruangan', 'pages::commodity-locations.index');

    Route::livewire('/merek', 'pages::brands.index');

    Route::livewire('/bahan', 'pages::materials.index');

    Route::livewire('/perolehan', 'pages::commodity-funding-sources.index');

    Route::livewire('/pengaturan/profil', 'pages::settings.profile');

    Route::livewire('/peran-dan-hak-akses', 'pages::roles.index');
    Route::livewire('/peran-dan-hak-akses/tambah', 'pages::roles.create');
    Route::livewire('/peran-dan-hak-akses/{role}/ubah', 'pages::roles.edit');

    Route::livewire('/pengguna', 'pages::users.index');
});

Route::get('/verifikasi/barang/{commodity:qr_code}', CommodityVerificationController::class)
    ->middleware('throttle:30,1')
    ->name('verifikasi.barang');
