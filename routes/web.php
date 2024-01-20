<?php

use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityLocationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolOperationalAssistanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('barang', CommodityController::class)->except('create', 'edit', 'show')->parameter('barang', 'commodity');
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/print', [CommodityController::class, 'generatePDF'])->name('print');
        Route::get('/print/{id}', [CommodityController::class, 'generatePDFIndividually'])->name('print-individual');
        Route::get('/export', [CommodityController::class, 'export'])->name('export');
        Route::get('/import', [CommodityController::class, 'export'])->name('import');
    });

    Route::resource('bantuan-dana-operasional', SchoolOperationalAssistanceController::class)
        ->except('create', 'edit', 'show')
        ->parameter('bantuan-dana-operasional', 'school_operational_assistance');

    Route::resource('ruangan', CommodityLocationController::class)->except('create', 'edit', 'show')
        ->parameter('ruangan', 'commodity_location');

    Route::resource('pengguna', UserController::class)->except('create', 'edit', 'show', 'update', 'destroy')
        ->parameter('pengguna', 'user');
});
