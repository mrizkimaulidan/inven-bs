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

    Route::livewire('/barang', 'pages::commodities.index')->middleware('permission:lihat barang');
    Route::livewire('/barang/tambah', 'pages::commodities.create')->middleware('permission:tambah barang');
    Route::livewire('/barang/{commodity}/ubah', 'pages::commodities.edit')->middleware('permission:ubah barang');

    Route::get('/barang/{commodity:qr_code}/pdf', [CommodityController::class, 'generatePdf'])
        ->middleware('permission:print barang')
        ->name('barang.pdf');
    Route::get('/barang/pdf', [CommodityController::class, 'generateAllPdf'])->middleware('permission:print barang');

    Route::livewire('/ruangan', 'pages::commodity-locations.index')->middleware('permission:lihat ruangan');
    Route::get('/ruangan/pdf', [CommodityLocationController::class, 'generateAllPdf'])
        ->middleware('permission:print ruangan')->name('ruangan.pdf');

    Route::livewire('/merek', 'pages::brands.index')->middleware('permission:lihat merek');
    Route::get('/merek/pdf', [BrandController::class, 'generateAllPdf'])
        ->middleware('permission:print merek')->name('merek.pdf');

    Route::livewire('/bahan', 'pages::materials.index')->middleware('permission:lihat bahan');
    Route::get('/bahan/pdf', [MaterialController::class, 'generateAllPdf'])
        ->middleware('permission:print bahan')->name('bahan.pdf');

    Route::livewire('/perolehan', 'pages::commodity-funding-sources.index')->middleware('permission:lihat perolehan');
    Route::get('/perolehan/pdf', [CommodityFundingSourceController::class, 'generateAllPdf'])
        ->middleware('permission:print perolehan')->name('perolehan.pdf');

    Route::livewire('/pengaturan/profil', 'pages::settings.profile');

    Route::livewire('/peran-dan-hak-akses', 'pages::roles.index')->middleware('permission:lihat peran');
    Route::get('/peran-dan-hak-akses/pdf', [RoleController::class, 'generateAllPdf'])
        ->middleware('permission:print peran')->name('peran.pdf');
    Route::livewire('/peran-dan-hak-akses/tambah', 'pages::roles.create')->middleware('permission:tambah peran');
    Route::livewire('/peran-dan-hak-akses/{role}/ubah', 'pages::roles.edit')->middleware('permission:ubah peran');

    Route::livewire('/pengguna', 'pages::users.index')->middleware('permission:lihat pengguna');
    Route::get('/pengguna/pdf', [UserController::class, 'generateAllPdf'])
        ->middleware('permission:print pengguna')->name('pengguna.pdf');
});

Route::get('/verifikasi/barang/{commodity:qr_code}', CommodityVerificationController::class)
    ->middleware('throttle:30,1')
    ->name('verifikasi.barang');
