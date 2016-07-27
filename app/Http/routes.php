<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SiteController@index');
Route::get('/page/{id}', 'SiteController@showPage');


// Authentication Routes...
Route::group(['prefix' => 'admin'], function() {
    Route::get('/login', 'Admin\SiteController@login');
    Route::post('/login', 'Auth\AuthController@login');
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/', 'Admin\SiteController@home');
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('/stat', 'Admin\StatController@stat');
        Route::get('/stat/page/{id}', 'Admin\StatController@pageBlocks')->where('id', '[0-9]+');;
        Route::get('/stat/page/all', 'Admin\StatController@pageBlocks');
        Route::get('/stat/page/all/browsers', 'Admin\StatController@allBrowserStat');
        Route::get('/stat/page/{id}/browsers', 'Admin\StatController@browserStat');
        Route::get('/stat/page/{id}/oses', 'Admin\StatController@osStat');
    });
});
