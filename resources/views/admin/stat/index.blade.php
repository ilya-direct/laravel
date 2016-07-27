<?php

$breadcrumb = [];
$breadcrumb[] = ['label' => 'Cтатистика посещений'];
?>
@extends('layouts.main')
@section('title', 'Cтатистика посещений')
@section('content')
    <h1>Статистика посещений</h1>
    <p class="lead"><a href="{{ URL::to('stat/page/all/') }}">По всем страницам</a></p>
    <ul>
        @foreach($pages as $page)
            <li><a href="{{URL::to('stat/page/' . $page)}}">Страница {{$page}}</a></li>
        @endforeach
    </ul>

@stop