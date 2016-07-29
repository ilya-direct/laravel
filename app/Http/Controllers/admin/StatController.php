<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class StatController extends Controller
{
    protected function stat()
    {
        $pages = [];
        $redis = app()->make('redis');
        $pages = $redis->sMembers('pages');
        return view('admin/stat/index', ['pages' => $pages]);
    }

    public function pageBlocks($id = null)
    {
        $page = is_null($id) ? 'Все страницы' : 'Страница ' . $id;
        $id =  is_null($id) ? 'all' : $id;
        return view('admin/stat/pageBlocks', [
            'title' => $page,
            'pageId' => $id,
        ]);
    }

    public function browserStat($id)
    {
        $redis = app()->make('redis');
        $browsers = $redis->sMembers('page:' . $id . ':browsers');

        $header = ['Браузер', 'Уникальные IP', 'Уникальные пользователи', 'Кол-во просмотров'];
        $table = [];
        foreach ($browsers as $browser) {
            $row = [];
            $row['entity'] = $browser;
            $row['ip'] = $redis->sCard('page:' . $id . ':browser:' . $browser . ':ip');
            $row['session'] = $redis->sCard('page:' . $id . ':browser:' . $browser . ':session');
            $row['hits'] = $redis->get('page:' . $id . ':browser:' . $browser . ':hits');
            $table[] = $row;
        }

        return view('admin/stat/table', [
            'pageId' => $id,
            'title' => 'Браузеры',
            'page' => 'Страница ' . $id,
            'header' => $header,
            'table' => $table,
        ]);
    }


    public function osStat($id)
    {
        $redis = app()->make('redis');
        $oses = $redis->sMembers('page:' . $id . ':oses');

        $header = ['Операционная система', 'Уникальные IP', 'Уникальные пользователи', 'Кол-во просмотров'];
        $table = [];
        foreach ($oses as $os) {
            $row = [];
            $row['entity'] = $os;
            $row['ip'] = $redis->sCard('page:' . $id . ':os:' . $os . ':ip');
            $row['session'] = $redis->sCard('page:' . $id . ':os:' . $os . ':session');
            $row['hits'] = $redis->get('page:' . $id . ':os:' . $os . ':hits');
            $table[] = $row;
        }

        return view('admin/stat/table', [
            'pageId' => $id,
            'title' => 'Операционные системы',
            'page' => 'Страница ' . $id,
            'header' => $header,
            'table' => $table,
        ]);
    }

    public function allBrowserStat()
    {
        $redis = app()->make('redis');
        $browsers = $redis->sMembers('total:browsers');

        $header = ['Браузер', 'Уникальные IP', 'Уникальные пользователи', 'Кол-во просмотров'];
        $table = [];
        foreach ($browsers as $browser) {
            $row = [];
            $row['entity'] = $browser;
            $row['ip'] = $redis->sCard('total:browser:' . $browser . ':ip');
            $row['session'] = $redis->sCard('total:browser:' . $browser . ':session');
            $row['hits'] = $redis->get('total:browser:' . $browser . ':hits');
            $table[] = $row;
        }

        return view('admin/stat/table', [
            'pageId' => 'all',
            'title' => 'Браузеры',
            'page' => 'Все страницы',
            'header' => $header,
            'table' => $table,
        ]);

    }
}
