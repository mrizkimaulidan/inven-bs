<?php

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

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});

Route::group(['prefix' => 'excel', 'as' => 'excel.barang.', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'barang'], function () {
        Route::get('/export', 'Commodities\CommodityExportImportController@export')->name('export');
        Route::post('/import', 'Commodities\CommodityExportImportController@import')->name('import');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'barang', 'as' => 'barang.'], function () {
        Route::get('/print', 'Commodities\PdfController@generatePdf')->name('print');
        Route::get('/print/{id}', "Commodities\PdfController@generatePdfOne")->name('print.one');
    });

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::resource('/barang', 'Commodities\CommodityController');
    Route::resource('/bantuan-dana-operasional', 'SchoolOperationalAssistances\SchoolOperationalAssistance');
    Route::resource('/ruang', 'CommodityLocations\CommodityLocationController');

    Route::resource('/commodities/json', 'Commodities\Ajax\CommodityAjaxController');
    Route::resource('/school-operational/json', 'SchoolOperationalAssistances\Ajax\SchoolOperationalAssistanceAjaxController');
    Route::resource('/commodity-locations/json', 'CommodityLocations\Ajax\CommodityLocationAjaxController');
});

// Route::group(['prefix' => 'commodities', 'as' => 'commodities.'], function () {
// });
