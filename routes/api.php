<?php

use App\Http\Controllers\API\CommodityAcquisitionController;
use App\Http\Controllers\API\CommodityController;
use App\Http\Controllers\API\CommodityLocationController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', action: function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::get('/barang/{commodity}', [CommodityController::class, 'show'])->name('barang.show');
    Route::get('/barang/{commodity}/qrcode', [CommodityController::class, 'generateQrCode'])->name('barang.generate-qrcode');
    Route::get('/ruangan/{commodity_location}', [CommodityLocationController::class, 'show'])->name('ruangan.show');
    Route::get(
        '/perolehan/{commodity_acquisition}',
        [CommodityAcquisitionController::class, 'show']
    )->name('perolehan.show');
    Route::get(
        '/prodi/{department}',
        [DepartmentController::class, 'show']
    )->name('prodi.show');
    Route::get('/pengguna/{user}', [UserController::class, 'show'])->name('pengguna.show');
    Route::get('/peran-dan-hak-akses/{role}', [RoleController::class, 'show'])->name('peran-dan-hak-akses.show');
});
