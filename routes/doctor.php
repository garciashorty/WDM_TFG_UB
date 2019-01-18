<?php

Route::get('/', 'Dashboard@index')->name('doctor_dashboard');

// Sección de usuarios
Route::get('/users', 'UserController@index')->name('doctor_users');
Route::get('/users/{user}', 'UserController@show')->name('doctor_show_users')->where('user', '[0-9]+');
Route::get('/users/{user}/edit', 'UserController@edit')->name('doctor_edit_users')->where('user', '[0-9]+');
Route::get('/users/create', 'UserController@create')->name('doctor_create_users');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@delete')->name('doctor_delete_users');

// Seccion de queries
Route::get('/queries', 'QueryController@index')->name('doctor_queries');
Route::get('/queries/detail/{query}', 'QueryController@showDetail')->name('doctor_show_detail_queries')->where('query', '[0-9]+');
Route::get('/queries/update/{query}', 'QueryController@update')->name('doctor_update_queries')->where('query', '[0-9]+');
Route::put('/queries/{query}', 'QueryController@resolve')->where('query', '[0-9]+');
Route::post('/queries/success', 'QueryController@add')->name('doctor_success_queries');

Route::get('/queries/image/{query}', 'QueryController@image')->name('doctor_image_queries')->where('query', '[0-9]+');
