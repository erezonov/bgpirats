@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <meta name="csrf-token" content="{{ Session::token() }}">
    <h1>{{$package->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-content">

            <form action="#" id="form">
                @csrf <!-- {{ csrf_field() }} -->
                <table class="table">
                    <tr>
                        <td>Название</td>
                        <td>{{$package->name}}
                    </tr>
                    <tr>
                        <td>Трэк</td>
                        <td>{{$package->code}}
                    </tr>
                    <tr>
                        <td>Вес</td>
                        <td>{{$package->from}}
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td>{{$package->statusText}}
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Заказы</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-default"
                        title="Добавить лот">
                    <i class="fas fa-plus"></i>
                </button>

            </div>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Пользователь</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($package->orders as $pack)
                    <tr>
                        <td>{{$pack->id}}</td>
                        <td>{{$pack->lot->kickname->name}} {{$pack['lot']->lot_name}}</td>
                        <td>{{$pack->lot->lot_price}} {{$pack->lot->currency}}</td>
                        <td>{{$pack->count}}</td>
                        <td>{{$pack->user->email}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

    </script>
    <script> console.log('Hi!'); </script>
@stop