@extends('layouts.main')
@section('scripts')

<script type="text/javascript">
    $(document).ready(function()
        {
            

            $('tr[id^=request]').click(function()
            {
                var id = $(this).attr('id');
                var element = $("input[type='checkbox'][name="+id+"]").attr('checked');

                if( element == 'checked')
                {   
                    $("input[type='checkbox'][name='"+id+"']").attr('checked', false);
                }else
                {
                    $("input[type='checkbox'][name='"+id+"']").attr('checked', true);
                }
            });

            
            
            

        });

        var app = angular.module('myApp', []);

        app.controller('myCtrl', function($scope) {
            $scope.goods = {!! $goods !!},
            $scope.whos = [
                {name: 'Temur Kodirov', contact: '191-01-02' },
                {name: 'Alisher Kodirov', contact: '191-01-02' },
                {name: 'Ulug Kodirov', contact: '191-01-02' },
            ]

//            $scope.goods = [
//                { name: 'Audi 02/3421/23', number: 234, requests: {up: false, down: false} },
//                { name: 'Daewoo 02/3213/23', number: 200,
//                    requests: {
//                    up: [
//                        {who: 'Темур Кодиров', number: 30, date: 2017-08-01},
//                        {who: 'Темур Кодиров', number: 30, date: 2017-08-01},
//                        {who: 'Темур Кодиров', number: 30, date: 2017-08-01},
//                        {who: 'Темур Кодиров', number: 30, date: 2017-08-01}],
//                    down: [
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                    ]} },
//                { name: 'Honda 02/3213/23', number: 100,
//                    requests: {
//                    down: [
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                        {who: 'Темур Кодиров', number: 23, date: 2017-08-02},
//                    ]} }
//            ]
        });
</script>

@endsection
@section('content')

<div ng-app = "myApp" ng-controller="myCtrl">
<div class="row">
    <div class="col-sm-4">
        <input type = "text" ng-model = "filt" class = "form-control" />
    </div>
</div>

<table class = "table table-striped table-hover">
    <thead>
        <tr>
            <th>№</th>
            <th>Товар</th>
            <th></th>
            <th>Количество</th>
            <th>Варианты</th>
        </tr>
    </thead>

    <tbody>
        <tr ng-repeat = "good in goods | filter : { name : filt }">
            <th>@{{ $index+1 }}</th>
            <td>@{{ good.name }}</td>
            <td>
                <span ng-if = "good.requests.up">
                    <button data-toggle="modal" data-target="#modalUp@{{$index}}" class = "my-btn btn btn-danger btn-sm"><span class="glyphicon glyphicon-envelope"></span></button>

                    <div class="modal fade" id="modalUp@{{$index}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title text-center">Заявки на расход</h4>
                                </div>
                                <div class="modal-body">
                                    
                                    <table class = "table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Товар</th>
                                                <th>Кому</th>
                                                <th>Дата</th>
                                                <th>Кол-во</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat = "up in good.requests.up" id = "requestUp@{{$parent.$index+'-'+$index}}">
                                                <td><input name = "requestUp@{{$parent.$index+'-'+$index}}" type="checkbox"/></td>
                                                <td>@{{ good.name }}</td>   
                                                <td>@{{ up.who }}</td>
                                                <td>@{{ up.date }}</td>
                                                <td>@{{ up.number }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class = "btn btn-success btn-block">Подтвердить</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class = "btn btn-danger btn-block">Отклонить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>

                <span ng-if = "good.requests.down">
                    <button data-toggle="modal" data-target="#modalDown@{{$index}}" class = "my-btn btn btn-info btn-sm"><span class="glyphicon glyphicon-envelope"></span></button>

                    <div class="modal fade" id="modalDown@{{$index}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title text-center">Заявки на приход</h4>
                                </div>
                                <div class="modal-body">
                                    <table class = "table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Товар</th>
                                                <th>От кого</th>
                                                <th>Дата</th>
                                                <th>Кол-во</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat = "down in good.requests.down" id = "requestDown@{{$parent.$index+'-'+$index}}">
                                                <td><input name ="requestDown@{{$parent.$index+'-'+$index}}" type="checkbox"/></td>
                                                <td>@{{ good.name }}</td>
                                                <td>@{{ down.who }}</td>
                                                <td>@{{ down.date }}</td>
                                                <td>@{{ down.number }}</td>
                                            </tr>

                                           
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class = "btn btn-success btn-block">Подтвердить</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class = "btn btn-danger btn-block">Отклонить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
            </td>
            <td>@{{ good.number }}</td>
            <td>
                <button data-toggle="modal" data-target="#download@{{$index}}" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-down"></span></button>
                

                <div class="modal fade" id="download@{{$index}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Приход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>@{{ good.name }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <th>Количество</th>
                                            <td>
                                                <input type="number" class = "form-control"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>От кого</th>
                                            <td>
                                                <input type = "text" list = "who_down" class = "form-control" />
                                                <datalist id = "who_down">
                                                    <option ng-repeat = "who in whos | orderBy: 'name' ">@{{who.name}}</option>
                                                </datalist>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <button class = "btn btn-info btn-block">Добавить</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class = "btn btn-danger btn-block" data-dismiss = "modal">Отмена</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button data-toggle="modal" data-target="#upload@{{$index}}" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-up"></span></button>

                <div class="modal fade" id="upload@{{$index}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Расход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>@{{ good.name}}</td>
                                            
                                        </tr>

                                        <tr>
                                            <th>Количество</th>
                                            <td>
                                                <input type="number" class = "form-control" max="@{{good.number}}"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Кому</th>
                                            <td>
                                                <input type = "text" list = "who_up" class = "form-control" />
                                                <datalist id = "who_up">
                                                    <option ng-repeat = "who in whos | orderBy: 'name' ">@{{who.name}}</option>
                                                </datalist>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <button class = "btn btn-info btn-block">Добавить</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class = "btn btn-danger btn-block" data-dismiss = "modal">Отмена</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</div>
@endsection