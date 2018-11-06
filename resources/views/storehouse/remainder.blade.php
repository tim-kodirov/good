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

    

        app.controller('myCtrl', function($scope) {
            $scope.goods = {!! $goods !!},
            $scope.whos = {!! $whos !!},
            $scope.stores = {!! $stores !!},
            $scope.owners = {!! $owners !!},

            $scope.goodChosen = {};
            $scope.storeChosen = {};

            $scope.requestsUp = [];
            $scope.requestsDown = [];

            $scope.chooseGood = function(good, store)
            {

                $scope.goodChosen = good;
                $scope.storeChosen = store;
            };

            $scope.chooseRequest = function($event, isExport, id)
            {
                if($event.target.nodeName != 'INPUT')
                {
                    
                    if(!isExport)
                    {   
                        $scope.requestsUp[id] = $scope.requestsUp[id] ? false : true;
                    }else
                    {
                        $scope.requestsDown[id] = $scope.requestsDown[id] ? false : true;
                    }
                }
            };
            
        });
</script>

@endsection
@section('content')

<div ng-controller="myCtrl">
    <div class="row">
        <div class="col-sm-4">
            <input type = "text" ng-model = "search" class = "form-control" placeholder="Поиск..." />
        </div>

        <div class = "col-sm-4">
            <select class = "form-control" ng-model = "filtByStore">
                <option></option>
                <option ng-repeat = "store in stores">@{{ store.name }}</option>
            </select>
        </div>
    </div>

    <table class = "table my-office-table my-table-striped margin-top-20">
        <thead>
            <tr>
                <th>№</th>
                <th>Товар</th>
                <th>Общ. кол-во</th>
                <th>Склад</th>
                <th>Количество</th>
                <th></th>
            </tr>
        </thead>

        <tbody ng-repeat = "good in goods | filter: { $: search,  stores: { $: filtByStore} }">
            <tr>
                <th rowspan="@{{ filteredStores.length+1 }}">@{{ $index+1 }}</th>
                <td rowspan="@{{ filteredStores.length+1 }}">@{{ good.name }}</td>
                <td rowspan="@{{ filteredStores.length+1 }}">@{{ good.totalFull }} (@{{ good.total }})</td>
            </tr>
            <tr ng-repeat = "store in filteredStores = ( good.stores | filter: filtByStore )">
                <td>@{{ store.name }}</td>
                <td>
                    @{{ store.number }}
                </td>
                <td>
                    <button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm btn-primary" data-toggle="modal" data-target="#download"><span  class = "glyphicon glyphicon-arrow-down"></span></button>
                    

                    <button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm btn-danger" data-toggle="modal" data-target="#upload"><span class = "glyphicon glyphicon-arrow-up"></span></button>

                    <span ng-if = "store.requests.down">
                        <button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modal-requestsDown">
                            <span class = "glyphicon glyphicon-envelope text-info"></span>
                        </button>
                    </span>
                    
                    <span ng-if = "store.requests.up">
                        <button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modal-requestsUp">
                            <span class = "glyphicon glyphicon-envelope text-danger"></span>
                        </button>
                    </span>                    
                </td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade" id="download">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('store.product.import')}}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Приход</h4>
                    </div>
                    <div class="modal-body">
                        <table class = "table">
                            <tbody>
                                <tr>
                                    <th>Товар</th>
                                    <td>@{{ goodChosen.name }}</td>

                                </tr>

                                <tr>
                                    <th>Склад</th>
                                    <td>@{{ storeChosen.name }}</td>
                                    <input type="hidden" name="import_store_id" value="@{{ storeChosen.id }}">
                                </tr>

                                <tr>
                                    <th>Остаток</th>
                                    <td>@{{ storeChosen.number }}</td>

                                </tr>

                                <tr>
                                    <th>Количество</th>
                                    <td>
                                        <input type="hidden" name="import_product_id" value="@{{ goodChosen.id }}">
                                        <input type="number" class = "form-control" name="import_product_quantity" min="0" required/>
                                    </td>
                                </tr>

                                <tr>
                                    <th>От кого</th>
                                    <td>
                                        <input type = "text" list = "who_down" class = "form-control" name="import_client_name" required/>
                                        <datalist id = "who_down">
                                            <option ng-repeat = "who in whos | orderBy ">@{{ who }}</option>
                                        </datalist>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class = "btn btn-info btn-block">Добавить</button>
                            </div>
                            <div class="col-sm-6">
                                <button class = "btn btn-danger btn-block" data-dismiss = "modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('store.product.export')}}">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center">Расход</h4>
                    </div>
                    <div class="modal-body">
                        <table class = "table">
                            <tbody>
                                <tr>
                                    <th>Товар</th>
                                    <td>@{{ goodChosen.name}}</td>

                                </tr>

                                <tr>
                                    <th>Склад</th>
                                    <td>@{{ storeChosen.name }}</td>
                                    <input type="hidden" name="export_store_id" value="@{{ storeChosen.id }}">
                                </tr>

                                <tr>
                                    <th>Остаток</th>
                                    <td>@{{ storeChosen.number }}</td>

                                </tr>
                                <tr>
                                    <th>Количество</th>
                                    <td>
                                        <input type="hidden" name="export_product_id" value="@{{ goodChosen.id }}">
                                        <input type="number" class = "form-control" name="export_product_quantity" min="0" max="@{{ storeChosen.number}}" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Кому</th>
                                    <td>
                                        <input type = "text" list = "who_up" class = "form-control" name="export_client_name" required/>
                                        <datalist id = "who_up">
                                            <option ng-repeat = "who in whos | orderBy ">@{{who}}</option>
                                        </datalist>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class = "btn btn-info btn-block">Добавить</button>
                            </div>
                            <div class="col-sm-6">
                                <button class = "btn btn-danger btn-block" data-dismiss = "modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-requestsDown">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('store.request.import.accept')}}">
                    {{csrf_field()}}
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
                                    <th>Кол-во</th>
                                    <th>От кого</th>
                                    <th>Дата</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-click = "chooseRequest($event, 1, down.id)" ng-repeat = "down in storeChosen.requests.down" class = "requests">
                                    <td><input name ="selected_requests_id[]" value="@{{ down.id }}" type="checkbox" ng-model = "requestsDown[down.id]"/></td>
                                    <td>@{{ goodChosen.name }}</td>
                                    <td>
                                        <input type="number" class="form-control" name="request_import_quantity" value="@{{ down.number }}" min="0">
                                    </td>
                                    <td>@{{ down.who }}</td>
                                    <td>@{{ down.date }}</td>
                                    
                                </tr>


                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class = "btn btn-success btn-block">Подтвердить</button>
                            </div>
                            <div class="col-md-4">
                                <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                            </div>
                            <div class="col-md-4">
                                <button formaction="{{route('store.request.reject')}}" class = "btn btn-danger btn-block">Отклонить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-requestsUp">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('store.request.export.accept')}}">
                    {{csrf_field()}}
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
                                    <th>Кол-во</th>
                                    <th>Кому</th>
                                    <th>Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-click = "chooseRequest($event, 0, up.id)" ng-repeat = "up in storeChosen.requests.up" class = "requests">
                                    <td><input name = "selected_requests_id[]" value="@{{ up.id }}" type="checkbox" ng-model = "requestsUp[up.id]"/></td>
                                    <td>@{{ goodChosen.name }}</td>
                                    <td>
                                        <input type="number" class="form-control" name="request_export_quantity" value="@{{ up.number }}" min="0" max="@{{ storeChosen.number }}">
                                    </td>
                                    <td>@{{ up.who }}</td>
                                    <td>@{{ up.date }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class = "btn btn-success btn-block">Подтвердить</button>
                            </div>
                            <div class="col-md-4">
                                <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" formaction="{{route('store.request.reject')}}" class = "btn btn-danger btn-block">Отклонить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection