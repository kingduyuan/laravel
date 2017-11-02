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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'IndexController@index')->name('admin.index');

    Route::get('/file/list', 'FileController@list')->name('admin.file.list');
    Route::post('/file/upload', 'FileController@upload')->name('admin.file.upload');
    Route::post('/file/delete', 'FileController@delete')->name('admin.file.delete');
    Route::get('/file/download', 'FileController@download')->name('admin.file.download');
});