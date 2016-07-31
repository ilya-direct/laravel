@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Панель</div>
                    <div class="panel-body">
                        <a href="{{ URL::to('stat') }}" class="list-group-item">Статистика</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
