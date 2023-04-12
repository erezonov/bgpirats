@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <table id="table1" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Пользователь</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order['lot']->lot_name}}</td>
                <td>{{$order->lot->lot_price}}</td>
                <td>{{$order->count}}</td>
                <td>{{$order->user->email}}</td>
                <td>{{$order->StatusText}}</td>
                <td>
                    @if($order->status !==3)
                        <button type="button" class="btn btn-add-package" title="Добавить лот"
                                id_order="{{$order->id}}">
                            Добавить в посылку
                        </button>
                    @else
                        <a href="/admin/packages/{{$order->package->id}}">{{$order->package->name}}</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="modal-default">

        <div class="modal-dialog">
            <div class="modal-content">
                <form id="add_to_package">
                    <input type="hidden" id="id_order_val" name="id_order_val" value=""/>
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить лот</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="col-12">
                                <label for="currency">В какую посылку добавить?</label>
                                <select class="form-control" name="package" id="package">
                                    @foreach($packages as $pack)
                                        <option value="{{$pack->id}}">{{$pack->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Вес</label>
                            <input type="text" class="form-control" id="weight" placeholder="Опционально">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="modal-footer justify-content-between">

        </div>

    </div>

    </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@stop

@section('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"/>
    <script>
        $(function () {

        };
    </script>
    <script>
        $(function () {
            $('.btn-add-package').click(function () {
                console.log($(this).attr("id_order"));
                $('#id_order_val').val($(this).attr("id_order"));
                $('#modal-default').modal('show');
            });
            $('#add_to_package').on("submit", function (e) {
                e.preventDefault();
                _id_order_val = $('#id_order_val').val();
                _package = $('#package').val();
                console.log("ID_ORDER_VAL = " + $('#id_order_val').attr('value'));
                $.post('/admin/orders/addtopackage',
                    {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id_order_val: _id_order_val,
                        package: _package,
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
            $('#table1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

    </script>
@stop