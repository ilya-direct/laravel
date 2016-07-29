@extends('layouts.main')
@section('title')
    {{ $title }}
@stop

@section('content')
    <h1> {{ $id }}. {{ $title }} </h1>
    @yield('description')
@stop