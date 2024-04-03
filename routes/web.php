<?php

use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityLocationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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
})->middleware('guest');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('barang', CommodityController::class)->except('create', 'edit', 'show')->parameter('barang', 'commodity');
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::post('/print', [CommodityController::class, 'generatePDF'])->name('print');
        Route::post('/print/{id}', [CommodityController::class, 'generatePDFIndividually'])->name('print-individual');
        Route::post('/export', [CommodityController::class, 'export'])->name('export');
        Route::post('/import', [CommodityController::class, 'import'])->name('import');
    });

    Route::resource('bantuan-dana-operasional', SchoolOperationalAssistanceController::class)
        ->except('create', 'edit', 'show')
        ->parameter('bantuan-dana-operasional', 'school_operational_assistance');

    Route::resource('ruangan', CommodityLocationController::class)->except('create', 'edit', 'show')
        ->parameter('ruangan', 'commodity_location');
    Route::post('/ruangan/import', [CommodityLocationController::class, 'import'])->name('ruangan.import');
    Route::post('/ruangan/export', [CommodityLocationController::class, 'export'])->name('ruangan.export');

    Route::resource('pengguna', UserController::class)->except('create', 'edit', 'show')
        ->parameter('pengguna', 'user');

    Route::resource('peran-dan-hak-akses', RoleController::class)->parameter('peran-dan-hak-akses', 'role');
});
