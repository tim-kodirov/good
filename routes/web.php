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

<<<<<<< HEAD
Route::get('/', 'StoreHouseController@getIndex');
=======
Route::get('/','Auth\LoginController@showLoginForm')->name('login');

Route::post('/', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
>>>>>>> 81cffc82488e3714944f6d5dbfe8c60aba56e461

Route::prefix('store')->group(function () {

    Route::get('/',  'StoreHouseController@getIndex')->name('store');

    Route::get('export', 'StoreHouseController@getExport')->name('store.export');

    Route::get('import', 'StoreHouseController@getImport')->name('store.import');

    Route::post('product/create', 'StoreHouseController@createProduct')->name('store.product.create');

    Route::post('product/export', 'StoreHouseController@productExport')->name('store.product.export');

    Route::post('product/import', 'StoreHouseController@productImport')->name('store.product.import');

    Route::post('request/export/accept', 'StoreHouseController@requestExportAccept')->name('store.request.export.accept');

    Route::post('request/import/accept', 'StoreHouseController@requestImportAccept')->name('store.request.import.accept');

    Route::post('request/export/reject', 'StoreHouseController@requestExportReject')->name('store.request.export.reject');

    Route::post('request/import/reject', 'StoreHouseController@requestImportReject')->name('store.request.import.reject');
});

Route::prefix('office')->group(function () {

    Route::get('/', 'OfficeController@getIndex')->name('office');

});

Route::prefix('admin')->group(function () {

    Route::get('/', 'AdminController@getIndex')->name('admin');

});


<<<<<<< HEAD
Route::prefix('office')->group(function(){

	Route::get('/', 'OfficeController@getIndex')->name('office');

	Route::get('export', 'OfficeController@getExport')->name('office.export');

	Route::get('import', 'OfficeController@getImport')->name('office.import');
});
=======
>>>>>>> 81cffc82488e3714944f6d5dbfe8c60aba56e461
