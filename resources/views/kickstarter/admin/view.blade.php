@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <meta name="csrf-token" content="{{ Session::token() }}">
    <h1>{{$kick->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-content">

            <form action="#" id="form">
                @csrf <!-- {{ csrf_field() }} -->
                <table class="table">
                    <tr>
                        <td>Название</td>
                        <td>{{$kick->name}}
                    </tr>
                    <tr>
                        <td>Ссылка</td>
                        <th><a href="{{$kick->url}}">{{$kick->url}}</a></th>
                    </tr>
                    <tr>
                        <td>Цена</td>
                        <td>{{ $kick->price }}</td>
                    </tr>

                    <tr>
                        <td>Комментарий</td>
                        <td>{{ $kick->comment }}</td>
                    </tr>
                    <tr>
                        <td>Комментарий</td>
                        <td>{{ $kick->comment2 }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" id="save"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Лоты</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-default"
                        title="Добавить лот">
                    <i class="fas fa-plus"></i>
                </button>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($kick->lots as $lot)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Название {{$lot->lot_name}}</h3>
                            </div>
                            <form name="lot_order">
                                <input type="hidden" name="lot_id" value="{{ $lot->id }}" id="lot_id"/>
                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Цена {{$lot->lot_price}} {{ $lot->currency  }}</td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                        </tr>
                                        <tr>
                                            <td>{{$lot->description}}</td>
                                        </tr>
                                        @if($user > 0)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="count">Количество</label>
                                                    <input type="number" class="form-control" id="count"
                                                           name="count_{{$kick->id}}"
                                                           placeholder="Количество">
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <button type="submit" class="submit btn btn-danger" data="{{$lot->id}}">
                                                    Save
                                                    changes
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="lot_add">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить лот</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="kick_id" value="{{ $kick->id }}"/>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Название</label>
                                <input type="text" class="form-control" id="name" placeholder="Название лота">
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea class="form-control" id="text"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <label for="price">Цена</label>
                                    <input type="text" class="form-control p-6" id="price" placeholder="Цена">
                                </div>
                                <div class="col-4">
                                    <label for="currency">Цена</label>
                                    <select class="form-control" name="currency" id="currency">
                                        <option value="Rur">Рублей</option>
                                        <option value="Rur">Евро</option>
                                        <option value="Rur">Долларов</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Вес</label>
                                <input type="text" class="form-control" id="weight" placeholder="Опционально">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('#lot_add').on("submit", function (e) {
            e.preventDefault();
            _name = $('#name').val();
            _text = $('#text').val();
            _price = $('#price').val();
            _weight = $('#weight').val();
            _currency = $('#currency').val();
            _kick_id = $('#kick_id').val();
            $.post('/admin/kickstarter/lot/save',
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    lot_name: _name,
                    lot_price: _price,
                    description: _text,
                    weight: _weight,
                    currency: _currency,
                    kick_id: _kick_id,
                    success: function (data) {
                        return false;
                    }
                }).done(function (data) {
                $('#modal-default').modal('hide');

                return false;

            })

            e.preventDefault(); //This will prevent the default click
            return false;
        });

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        $('.submit').on("click", function (e) {
            var _lot_id = $(this).attr('data');
            var count_name = 'input[name="count_' + _lot_id + '"]';
            var _count = $(count_name).val();
            $.post('/admin/kickstarter/lot/addorder',
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    lot_id: _lot_id,
                    user_id: {{ $user }} ,
                    count: _count,
                    dataType: 'JSON',
                    success: function (data) {
                        return false;
                    }
                }).done(function (data) {
                $('#modal-default').modal('hide');

                return false;

            })
            e.preventDefault(); //This will prevent the default click
            return false;
        });
    </script>
    <script> console.log('Hi!'); </script>
@stop