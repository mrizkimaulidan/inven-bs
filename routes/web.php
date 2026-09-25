<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/dashboard', 'pages::dashboard');

Route::livewire('/barang', 'pages::commodities.index');
Route::livewire('/barang/tambah', 'pages::commodities.create');
Route::livewire('/barang/{commodity}/ubah', 'pages::commodities.edit');

Route::livewire('/ruangan', 'pages::commodity-locations.index');

Route::livewire('/merek', 'pages::brands.index');
