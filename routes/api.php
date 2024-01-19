<?php

use App\Http\Controllers\API\CommodityController;
use App\Http\Controllers\API\CommodityLocationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::get('/barang/{commodity}', [CommodityController::class, 'show'])->name('barang.show');
    Route::get('/ruangan/{commodity_location}', [CommodityLocationController::class, 'show'])->name('ruangan.show');
});
