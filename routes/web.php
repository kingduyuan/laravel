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

    // 文件上传功能
    Route::get('/uploads/list', 'FileController@list')->name('admin.uploads.list');
    Route::post('/uploads/upload', 'FileController@upload')->name('admin.uploads.upload');
    Route::post('/uploads/delete', 'FileController@delete')->name('admin.uploads.delete');
    Route::post('/uploads/update', 'FileController@update')->name('admin.uploads.update');
    Route::get('/uploads/download', 'FileController@download')->name('admin.uploads.download');
});