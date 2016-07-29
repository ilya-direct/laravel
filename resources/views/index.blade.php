@extends('layouts.main')
@section('title', 'Главная')
@section('content')
    <h1>Криптографические методы защиты информации</h1>
    <ol>
        @foreach ($pages as $id => $title)
            <li><a href="{{ URL::to('page/' . $id) }}">{{ $title }}</a></li>
        @endforeach
    </ol>
@stop