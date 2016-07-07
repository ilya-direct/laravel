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

Route::get('/', function () {
    return 'dfdfdf' .   view('welcome');
});

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/item/{id}', function ($id) {
    $item = App\Item::find($id);
    print $item->name;
    var_dump($item);
});

Route::get('/records', function () {
    /** @var \App\Record[] $records */
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
    $redis->set('la', 'java');
    print_r($redis->get('la'));
});



