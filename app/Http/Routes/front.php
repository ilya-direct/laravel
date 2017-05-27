<?php


Route::get('/', 'SiteController@index');
Route::get('/page/{id}', 'SiteController@showPage');