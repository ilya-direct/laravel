<?php

$breadcrumb = [];
$breadcrumb[] = [
        'label' => 'Cтатистика посещений',
        'link' => URL::to('/stat'),
];
$breadcrumb[] = ['label' => $page];
$breadcrumb[] = [
        'label' => 'Блоки',
        'link' => URL::to('stat/page/' . $pageId),
];
$breadcrumb[] = ['label' => $title];

?>
@extends('admin.layouts.main')
@section('title', $title)
@section('content')
    <h1>{{$page}}</h1>
    <h2>{{$title}}</h2>
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th>{{$header[0]}}</th>
            <th>{{$header[1]}}</th>
            <th>{{$header[2]}}</th>
            <th>{{$header[3]}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($table as $row)
            <tr>
                <td>{{ $row['entity'] }}</td>
                <td>{{ $row['ip'] }}</td>
                <td>{{ $row['session'] }}</td>
                <td>{{ $row['hits'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop