<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', 'Dashboard@index')->name('admin_dashboard');

Route::get('/users', 'UserController@index')->name('admin_users');
Route::get('/users/{user}', 'UserController@show')->name('admin_show_users')->where('user', '[0-9]+');
Route::get('/users/{user}/edit', 'UserController@edit')->name('admin_edit_users')->where('user', '[0-9]+');
Route::get('/users/create', 'UserController@create')->name('admin_create_users');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@delete')->name('admin_delete_users');

Route::get('/doctors', 'DoctorController@index')->name('admin_doctors');
Route::get('/doctors/{doctor}', 'DoctorController@show')->name('admin_show_doctors')->where('doctor', '[0-9]+');
Route::get('/doctors/{doctor}/edit', 'DoctorController@edit')->name('admin_edit_doctors')->where('doctor', '[0-9]+');
Route::get('/doctors/create', 'DoctorController@create')->name('admin_create_doctors');
Route::post('/doctors', 'DoctorController@store');
Route::put('/doctors/{doctor}', 'DoctorController@update');
Route::delete('/doctors/{doctor}', 'DoctorController@delete')->name('admin_delete_doctors');


Route::catch(function ($id){
    throw new NotFoundHttpException();
});
