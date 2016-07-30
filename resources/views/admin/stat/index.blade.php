<?php

$breadcrumb = [];
$breadcrumb[] = ['label' => 'Cтатистика посещений'];
?>
@extends('admin.layouts.main')
@section('title', 'Cтатистика посещений')
@section('content')
    <h1>Статистика посещений</h1>
    <p class="btn-link"><a href="{{ URL::to('stat/page/all/') }}">По всем страницам</a></p>
    <ul class="list-unstyled">
        @foreach($pages as $id => $page)
            <li><a href="{{ URL::to('stat/page/' . $id) }}">{{ $id }}. {{$page}}</a></li>
        @endforeach
    </ul>

@stop