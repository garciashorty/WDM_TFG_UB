<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', 'Dashboard@index')->name('admin_dashboard');

Route::catch(function ($id){
    throw new NotFoundHttpException();
});
