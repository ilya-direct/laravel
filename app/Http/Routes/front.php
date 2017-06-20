<?php


Route::get('/', 'SiteController@index');
Route::get('/page/{id}', 'SiteController@showPage');
Route::get('/love', function(\App\Http\Requests\TestBlog $request) {
    return 'xxx';
});

Route::get('/dispatch', 'SiteController@dispatchPage');