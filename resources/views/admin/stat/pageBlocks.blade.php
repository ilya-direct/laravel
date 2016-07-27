<?php

$breadcrumb = [];
$breadcrumb[] = [
        'label' => 'Cтатистика посещений',
        'link' => URL::to('/stat'),
];
$breadcrumb[] = ['label' => $title];
?>

@extends('layouts.main')
@section('title', 'Cтатистика посещений')
@section('content')
    <h1>{{ $title }}</h1>
    <div class="panel panel-default">
        <div class="list-group">
            <a href="{{ URL::to('/stat/page/' . $pageId . '/browsers') }}" class="list-group-item">
                <h4 class="list-group-item-heading">Браузеры</h4>
                <p class="list-group-item-text">Статистика посещений по каждому браузеру</p>
            </a>
        </div>
        <div class="list-group">
            <a href="{{ URL::to('/stat/page/' . $pageId . '/oses') }}" class="list-group-item">
                <h4 class="list-group-item-heading">Операционные системы</h4>
                <p class="list-group-item-text">Статистика посещений по каждой ОС</p>
            </a>
        </div>
        <div class="list-group">
            <a href="{{ URL::to('/stat/page/' . $pageId . '/cities') }}" class="list-group-item">
                <h4 class="list-group-item-heading">Гео</h4>
                <p class="list-group-item-text">Статистика посещений по каждому городу</p>
            </a>
        </div>
        <div class="list-group">
            <a href="{{ URL::to('/stat/page/' . $pageId . '/referers') }}" class="list-group-item">
                <h4 class="list-group-item-heading">Лиды (Рефы)</h4>
                <p class="list-group-item-text">Статистика ресурсов, с которых переходили на сайт</p>
            </a>
        </div>
    </div>

@stop