<?php

Route::get('/', 'Dashboard@index')->name('user_dashboard');

Route::get('/queries', 'QueryController@index')->name('user_queries');
Route::get('/queries/{query}', 'QueryController@show')->name('user_show_queries')->where('query', '[0-9]+');
Route::get('/queries/detail/{query}', 'QueryController@showDetail')->name('user_show_detail_queries')->where('query', '[0-9]+');
Route::get('/queries/create', 'QueryController@create')->name('user_create_queries');
Route::get('/queries/update/{query}', 'QueryController@update')->name('user_update_queries')->where('query', '[0-9]+');;
Route::post('/queries', 'QueryController@store');
Route::post('/queries/success', 'QueryController@add')->name('user_success_queries');
