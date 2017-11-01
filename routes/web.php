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

///**
// * admin 后台路由
// */
Route::group(['prefix' => 'admin'], function () {

    Route::group(['namespace' => 'Admin'], function() {
        Route::get('/', 'IndexController@index')->name('admin.index');
        Route::get('/index/test', 'IndexController@test')->name('admin.index');
    });
});