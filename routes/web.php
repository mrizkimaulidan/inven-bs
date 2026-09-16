<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/dashboard', 'pages::dashboard');

Route::livewire('/barang', 'pages::commodities.index');
Route::livewire('/barang/tambah', 'pages::commodities.create');

Route::livewire('/lokasi', 'pages::commodity-locations.index');
