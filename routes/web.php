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
})->name('main_page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth:web,admin');

//Login admin
Route::get('admin/login', 'Admin\LoginController@showLoginForm')->name('admin_login');
Route::post('admin/login', 'Admin\LoginController@login');
Route::post('admin/logout', 'Admin\LoginController@logout')->name('admin_logout');

