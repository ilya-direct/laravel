<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class StatController extends Controller
{
    protected $tableHeaders = ['', 'Уникальные IP', 'Уникальные пользователи', 'Кол-во просмотров'];

    protected function stat()
    {
        $redis = app()->make('redis');
        $pages = $redis->sMembers('pages');
        return view('admin/stat/index', ['pages' => $pages ?: []]);
    }

    public function pageBlocks($id = null)
    {
        $title = is_null($id) ? 'Все страницы' : 'Страница ' . $id;
        $id =  is_null($id) ? 'all' : $id;
        return view('admin/stat/pageBlocks', [
            'title' => $title,
            'pageId' => $id,
        ]);
    }

    protected function generateTable($pageName, $entityName, $entities)
    {
        $table = [];
        $redis = app()->make('redis');

        foreach ($entities as $entity) {
            $row = [];
            $row['entity'] = $entity;
            $row['ip'] = $redis->sCard($pageName . ':' . $entityName . ':' . $entity . ':ip');
            $row['session'] = $redis->sCard($pageName . ':' . $entityName . ':' . $entity . ':session');
            $row['hits'] = $redis->get($pageName . ':' . $entityName . ':' . $entity . ':hits');
            $table[] = $row;
        }

        return $table;
    }

    public function browserStat($id = null)
    {
        $this->tableHeaders[0] = 'Браузер';
        $redis = app()->make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $browsers = $redis->sMembers($pageName . ':browsers');
        $table = $this->generateTable($pageName, 'browser', $browsers);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Браузеры',
            'page' => $id ? 'Страница ' . $id : 'Все страницы',
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function osStat($id = null)
    {
        $this->tableHeaders[0] = 'Операционная система';
        $redis = app()->make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $oses = $redis->sMembers($pageName . ':oses');
        $table = $this->generateTable($pageName, 'os', $oses);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Операционные системы',
            'page' => $id ? 'Страница ' . $id : 'Все страницы',
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function refererStat($id = null)
    {
        $this->tableHeaders[0] = 'Реферал';
        $redis = app()->make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $referers = $redis->sMembers($pageName . ':referers');
        $table = $this->generateTable($pageName, 'referer', $referers);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Лиды (Рефы)',
            'page' => $id ? 'Страница ' . $id : 'Все страницы',
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function cityStat($id = null)
    {
        $this->tableHeaders[0] = 'Город';
        $redis = app()->make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $cities = $redis->sMembers($pageName . ':cities');
        $table = $this->generateTable($pageName, 'city', $cities);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Города',
            'page' => $id ? 'Страница ' . $id : 'Все страницы',
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }
}
