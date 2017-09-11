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

Route::get('/', function()
{
	return view('storehouse.remainder');
});

Route::get('/store',  'StoreHouseController@getIndex')->name('store');

Route::get('/store/export', 'StoreHouseController@getExport')->name('store.export');

Route::get('/store/import', 'StoreHouseController@getImport')->name('store.import');

Route::get('/office', 'OfficeController@getIndex')->name('office');