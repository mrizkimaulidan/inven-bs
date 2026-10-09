<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/beranda', 'pages::dashboard');

Route::livewire('/barang', 'pages::commodities.index');
Route::livewire('/barang/tambah', 'pages::commodities.create');
Route::livewire('/barang/{commodity}/ubah', 'pages::commodities.edit');

Route::livewire('/ruangan', 'pages::commodity-locations.index');

Route::livewire('/merek', 'pages::brands.index');

Route::livewire('/bahan', 'pages::materials.index');

Route::livewire('/perolehan', 'pages::commodity-funding-sources.index');

Route::livewire('/pengaturan/profil', 'pages::settings.profile');

Route::livewire('/peran-dan-hak-akses', 'pages::roles.index');
Route::livewire('/peran-dan-hak-akses/tambah', 'pages::roles.create');
Route::livewire('/peran-dan-hak-akses/{role}/ubah', 'pages::roles.edit');

Route::livewire('/pengguna', 'pages::users.index');
