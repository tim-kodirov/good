<?php

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

Route::get('/', 'StoreHouseController@getIndex');

Route::prefix('store')->group(function () {

    Route::get('/',  'StoreHouseController@getIndex')->name('store');

    Route::get('export', 'StoreHouseController@getExport')->name('store.export');

    Route::get('import', 'StoreHouseController@getImport')->name('store.import');

    Route::post('addGood', 'StoreHouseController@createProduct')->name('store.addGood');

});


Route::prefix('office')->group(function(){

	Route::get('/', 'OfficeController@getIndex')->name('office');

	Route::get('export', 'OfficeController@getExport')->name('office.export');

	Route::get('import', 'OfficeController@getImport')->name('office.import');
});
