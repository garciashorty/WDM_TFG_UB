<?php

Route::get('/', 'Dashboard@index')->name('doctor_dashboard');

Route::get('/users', 'UserController@index')->name('doctor_users');
Route::get('/users/{user}', 'UserController@show')->name('doctor_show_users')->where('user', '[0-9]+');
Route::get('/users/{user}/edit', 'UserController@edit')->name('doctor_edit_users')->where('user', '[0-9]+');
Route::get('/users/create', 'UserController@create')->name('doctor_create_users');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@delete')->name('doctor_delete_users');
