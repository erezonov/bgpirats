@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <meta name="csrf-token" content="{{ Session::token() }}">
    <h1>Добавление кикстартер</h1>
@stop

@section('content')
    <form action="#" id="form">
        @csrf <!-- {{ csrf_field() }} -->
        <table class="table">
            <tr>
                <th>Название</th>
                <th><input type="text" id="name" name="name" required/></th>
            </tr>
            <tr>
                <th>Ссылка</th>
                <th><input type="text" name="url" id="url" /></th>
            </tr>
            <tr>
                <th>Цена</th>
                <th><input type="text" name="price" id="price"/></th>
            </tr>
            <tr>
                <th>Вес</th>
                <th><input type="text" name="url"/></th>
            </tr>
            <tr>
                <th>Комментарий</th>
                <th><input type="text" name="comment"/></th>
            </tr>
            <tr>
                <th>Комментарий2</th>
                <th><input type="text" name="comment"/></th>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" id="save"/>
                </td>
            </tr>
        </table>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('#form').on("submit", function (e) {
            e.preventDefault();
            _name = $('#name').val();
            _price = $('#price').val();
            _url = $('#url').val();
            $.post('/admin/kickstarter/save',
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    name: _name,
                    price: _price,
                    url: _url,
                    success: function (data) {
                        var url = data;
                        $(location).attr('href',url);
                    }
                }).done(function (data) {
                $(location).attr('href',data);

            })

            e.preventDefault(); //This will prevent the default click
            return false;
        });


    </script>
    <script> console.log('Hi!'); </script>
@stop