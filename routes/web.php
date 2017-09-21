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




Route::get('/','Auth\LoginController@showLoginForm')->name('login');

Route::post('/', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::prefix('store')->group(function () {

    Route::get('/',  'StoreHouseController@getIndex')->name('store');

    Route::get('export', 'StoreHouseController@getExport')->name('store.export');

    Route::get('import', 'StoreHouseController@getImport')->name('store.import');

    Route::post('product/create', 'StoreHouseController@createProduct')->name('store.product.create');

    Route::post('product/export', 'StoreHouseController@productExport')->name('store.product.export');

    Route::post('product/import', 'StoreHouseController@productImport')->name('store.product.import');

    Route::post('request/export/accept', 'StoreHouseController@requestExportAccept')->name('store.request.export.accept');

    Route::post('request/import/accept', 'StoreHouseController@requestImportAccept')->name('store.request.import.accept');

    Route::post('request/reject', 'StoreHouseController@requestReject')->name('store.request.reject');

    Route::post('export/return','StoreHouseController@returnExport')->name('store.export.return');
});

Route::prefix('admin')->group(function () {

    Route::get('/', 'AdminController@getIndex')->name('admin');

});

Route::prefix('office')->group(function(){

	Route::get('/', 'OfficeController@getIndex')->name('office');

	Route::get('export', 'OfficeController@getExport')->name('office.export');

	Route::get('import', 'OfficeController@getImport')->name('office.import');

    Route::post('store/create', 'OfficeController@createStore')->name('office.store.create');

    Route::post('product/create', 'OfficeController@createProduct')->name('office.product.create');

    Route::post('product/edit', 'OfficeController@editProduct')->name('office.product.edit');

    Route::post('request/create', 'OfficeController@createRequest')->name('office.request.create');

    Route::post('request/edit', 'OfficeController@editRequest')->name('office.request.edit');

    Route::post('request/delete', 'OfficeController@deleteRequest')->name('office.request.delete');
});
