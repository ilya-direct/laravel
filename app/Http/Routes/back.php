<?php


Route::get('/login', 'Admin\SiteController@login');
Route::post('/login', 'Admin\SiteController@login');
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'Admin\SiteController@home');
    Route::get('logout', 'Admin\SiteController@logout');
    Route::get('/stat', 'Admin\StatController@stat');
    Route::get('/stat/page/{id}', 'Admin\StatController@pageBlocks')->where('id', '[0-9]+');
    Route::get('/stat/page/all', 'Admin\StatController@pageBlocks');
    Route::get('/stat/page/{id}/browsers', 'Admin\StatController@browserStat')->where('id', '[0-9]+');
    Route::get('/stat/page/all/browsers', 'Admin\StatController@browserStat');
    Route::get('/stat/page/{id}/oses', 'Admin\StatController@osStat')->where('id', '[0-9]+');
    Route::get('/stat/page/all/oses', 'Admin\StatController@osStat');
    Route::get('/stat/page/{id}/referers', 'Admin\StatController@refererStat')->where('id', '[0-9]+');
    Route::get('/stat/page/all/referers', 'Admin\StatController@refererStat');
    Route::get('/stat/page/{id}/cities', 'Admin\StatController@cityStat')->where('id', '[0-9]+');
    Route::get('/stat/page/all/cities', 'Admin\StatController@cityStat');
});