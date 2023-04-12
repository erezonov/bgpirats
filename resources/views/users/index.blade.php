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
            <th>Имя</th>
            <th>email</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><a href="/admin/users/view/{{$user->id}}" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a>
                    <a href="/admin/users/edit/{{$user->id}}" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                        <i class="fa fa-lg fa-fw fa-edit"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="modal-default">

        <div class="modal-dialog">
            <div class="modal-content">
                    <input type="hidden" id="id_order_val" name="id_order_val" value=""/>
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить лот</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

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