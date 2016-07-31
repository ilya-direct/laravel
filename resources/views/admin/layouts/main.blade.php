<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/site.css') }}"/>
</head>
<body>
<div class="wrap">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('/') }}">Админ-панель</a>
            </div>
            @if (Auth::check())
                <div id="w0-collapse" class="collapse navbar-collapse">
                    <ul id="w1" class="navbar-nav navbar-right nav">
                        <li class="active"><a href="{{ URL::to('/logout') }}">Выйти</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
    <div class="container">
        @if (!empty($breadcrumb))
            @include('layouts.breadcrumb', ['list' => $breadcrumb])
        @endif
        @yield('content')
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Крипто 2016</p>
        <p class="pull-right">Илья</p>
    </div>
</footer>

<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
</body>
</html>