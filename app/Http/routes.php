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

/*Route::get('/', function () {

    return view('index', ['title' => 'Криптография']);
});*/

/*Route::get('/page/{id}', function ($id) {
    return view('pages/' . $id, ['id' => $id]);
});*/

Route::get('/', 'SiteController@index');
Route::get('/page/{id}', 'SiteController@showPage');

Route::get('/item/{id}', function ($id) {
    $item = App\Item::find($id);
    print $item->name;
    var_dump($item);
});

Route::get('/records', function () {

    $records = App\Record::with('item')
        ->orderBy('id', SORT_DESC)
        ->limit(100)
        ->get();
    foreach ($records as $record) {
        print $record->id . ' ' . $record->date . ' ' . $record->item->name . '<br>';
    }
});

Route::get('/redis', function () {
    $redis = app()->make('redis');
    $redis->incr('lar');
    print_r($redis->get('lar'));
});

Route::get('/stat', 'AdminController@stat');
Route::get('/stat/page/{id}', 'AdminController@pageBlocks')->where('id', '[0-9]+');;
Route::get('/stat/page/all', 'AdminController@pageBlocks');
Route::get('/stat/page/all/browsers', 'AdminController@allBrowserStat');
Route::get('/stat/page/{id}/browsers', 'AdminController@browserStat');
Route::get('/stat/page/{id}/oses', 'AdminController@osStat');

Route::group(['prefix' => 'admin', 'before' => 'auth'], function() {
   Route::get('/', 'AdminController@home');
});


