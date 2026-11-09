<?php

/** Register application web routes. */

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityFundingSourceController;
use App\Http\Controllers\CommodityLocationController;
use App\Http\Controllers\CommodityVerificationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::get('/barang/pdf', [CommodityController::class, 'generateAllPdf']);

    Route::livewire('/ruangan', 'pages::commodity-locations.index');
    Route::get('/ruangan/pdf', [CommodityLocationController::class, 'generateAllPdf'])->name('ruangan.pdf');

    Route::livewire('/merek', 'pages::brands.index');
    Route::get('/merek/pdf', [BrandController::class, 'generateAllPdf'])->name('merek.pdf');

    Route::livewire('/bahan', 'pages::materials.index');
    Route::get('/bahan/pdf', [MaterialController::class, 'generateAllPdf'])->name('bahan.pdf');

    Route::livewire('/perolehan', 'pages::commodity-funding-sources.index');
    Route::get('/perolehan/pdf', [CommodityFundingSourceController::class, 'generateAllPdf'])->name('perolehan.pdf');

    Route::livewire('/pengaturan/profil', 'pages::settings.profile');

    Route::livewire('/peran-dan-hak-akses', 'pages::roles.index');
    Route::get('/peran-dan-hak-akses/pdf', [RoleController::class, 'generateAllPdf'])->name('peran.pdf');
    Route::livewire('/peran-dan-hak-akses/tambah', 'pages::roles.create');
    Route::livewire('/peran-dan-hak-akses/{role}/ubah', 'pages::roles.edit');

    Route::livewire('/pengguna', 'pages::users.index');
    Route::get('/pengguna/pdf', [UserController::class, 'generateAllPdf'])->name('pengguna.pdf');
});

Route::get('/verifikasi/barang/{commodity:qr_code}', CommodityVerificationController::class)
    ->middleware('throttle:30,1')
    ->name('verifikasi.barang');
