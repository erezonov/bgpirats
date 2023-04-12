@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Посылки</h3>
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
                    <th>Код</th>
                    <th>Откуда</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($packages as $package)
                    <tr>
                        <td>{{$package->id}}</td>
                        <td>{{$package->name}}</td>
                        <td>{{$package->code}}</td>
                        <td>{{ $package::getSource($package->from)}}</td>
                        <td>{{$package::getStatus($package->status)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="package_add">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить посылку</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="kick_id" value=""/>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="code">Название</label>
                                <input type="text" class="form-control" id="name" placeholder="Название">
                            </div>
                            <div class="form-group">
                                <label for="code">Код</label>
                                <input type="text" class="form-control" id="code" placeholder="Код посылки">
                            </div>
                            <div class="form-group">
                                <label for="from">Откуда</label>
                                <select class="form-control" name="from" id="from">
                                    <option value="1">Kickstarter</option>
                                    <option value="2">Локзакуп</option>
                                    <option value="3">Зарубежные магазины</option>
                                </select>
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
    {{-- Compressed with style options / fill data using the plugin config --}}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@stop

@section('js')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script>
        $('#package_add').on("submit", function (e) {
            e.preventDefault();
            _code = $('#code').val();
            _from = $('#from').val()
            _weight = $('#weight').val();
            _name = $('#name').val();
            $.post('/admin/packages/save',
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    code: _code,
                    from: _from,
                    weight: _weight,
                    name: _name,
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
    <script>
        $('#table1').on("dblclick", function (e) {
            var data = table.row( this ).data();
            alert( 'You clicked on '+data[0]+'\'s row' );
        } );
    </script>
@stop