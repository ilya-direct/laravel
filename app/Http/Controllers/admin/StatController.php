<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotificationEvent;
use App\Pages;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Redis;

class StatController extends Controller
{
    protected $tableHeaders = ['', 'Уникальные IP', 'Уникальные пользователи', 'Кол-во просмотров'];

    protected function stat()
    {
        
        event(new NotificationEvent());

        return view('admin/stat/index', ['pages' => Pages::get()]);
    }

    public function pageBlocks($id = null)
    {
        if ($id) {
            if (Pages::getPageById($id)) {
                $title = Pages::getPageById($id);
            } else {
                throw new HttpException(404);
            }
        } else {
            $title = 'Все страницы';
            $id = 'all';
        }

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
        if ($id) {
            if (Pages::getPageById($id)) {
                $title = Pages::getPageById($id);
            } else {
                throw new HttpException(404);
            }
        } else {
            $title = 'Все страницы';
        }
        $this->tableHeaders[0] = 'Браузер';
        $redis = app('redis');
        $redis = \App::make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $browsers = $redis->sMembers($pageName . ':browsers');
        $table = $this->generateTable($pageName, 'browser', $browsers);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Браузеры',
            'page' => $title,
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function osStat($id = null)
    {
        if ($id) {
            if (!($title = Pages::getPageById($id))) {
                
                throw new HttpException(404);
            }
        } else {
            $title = 'Все страницы';
        }
        $this->tableHeaders[0] = 'Операционная система';
        $redis = \App::make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
//        $oses = $redis->sMembers($pageName . ':oses');
        $oses = Redis::sMembers($pageName . ':oses');
        $table = $this->generateTable($pageName, 'os', $oses);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Операционные системы',
            'page' => $title,
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function refererStat($id = null)
    {
        if ($id) {
            if (Pages::getPageById($id)) {
                $title = Pages::getPageById($id);
            } else {
                throw new HttpException(404);
            }
        } else {
            $title = 'Все страницы';
        }
        $this->tableHeaders[0] = 'Реферал';
        $redis = app('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $referers = $redis->sMembers($pageName . ':referers');
        $table = $this->generateTable($pageName, 'referer', $referers);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Лиды (Рефы)',
            'page' => $title,
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }

    public function cityStat($id = null)
    {
        if ($id) {
            if (Pages::getPageById($id)) {
                $title = Pages::getPageById($id);
            } else {
                throw new HttpException(404);
            }
        } else {
            $title = 'Все страницы';
        }
        $this->tableHeaders[0] = 'Город';
        $redis = app()->make('redis');
        $pageName = $id ? 'page:' . $id : 'total';
        $cities = $redis->sMembers($pageName . ':cities');
        $table = $this->generateTable($pageName, 'city', $cities);

        return view('admin/stat/table', [
            'pageId' => $id ?: 'all',
            'title' => 'Города',
            'page' => $title,
            'header' => $this->tableHeaders,
            'table' => $table,
        ]);
    }
}
