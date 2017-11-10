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

    Route::get('/', function () {
        return view('admin.uploads.index');
    })->name('admin.index');

    // 导航栏目
    Route::get('/menus/index', 'MenusController@index')->name('admin.menus.index');
    Route::get('/menus/search', 'MenusController@search')->name('admin.menus.search');
    Route::post('/menus/update', 'MenusController@update')->name('admin.menus.update');
    Route::post('/menus/create', 'MenusController@create')->name('admin.menus.create');
    Route::post('/menus/delete', 'MenusController@delete')->name('admin.menus.delete');

    // 日程管理
    Route::get('/calendars/index', 'CalendarsController@index')->name('admin.calendars.index');
    Route::get('/calendars/search', 'CalendarsController@search')->name('admin.calendars.search');
    Route::get('/calendars/me', 'CalendarsController@me')->name('admin.calendars.me');
    Route::post('/calendars/update', 'CalendarsController@update')->name('admin.calendars.update');
    Route::post('/calendars/create', 'CalendarsController@create')->name('admin.calendars.create');
    Route::post('/calendars/delete', 'CalendarsController@delete')->name('admin.calendars.delete');
    Route::get('/calendars/events', 'CalendarsController@events')->name('admin.calendars.events');

    // 文件上传功能
    Route::get('/uploads/index', 'UploadsController@index')->name('admin.uploads.index');
    Route::get('/uploads/list', 'UploadsController@list')->name('admin.uploads.list');
    Route::post('/uploads/upload', 'UploadsController@upload')->name('admin.uploads.upload');
    Route::post('/uploads/delete', 'UploadsController@delete')->name('admin.uploads.delete');
    Route::post('/uploads/update', 'UploadsController@update')->name('admin.uploads.update');
    Route::get('/uploads/download', 'UploadsController@download')->name('admin.uploads.download');
});