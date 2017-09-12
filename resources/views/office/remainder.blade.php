@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

	var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {
        
        $scope.goods = [
        	{name: 'Audi 02/3421/23', stores: [
        		{name: 'Склад 1', number: 67, requests: 
        			{up: [
        				{who: 'Темур Кодиров', number: 30, date: 2017-08-01}], 
        			down: false}
        		},
        		{name: 'Склад 2', number: 70, requests: 
        			{up: false, down: [
        				{who: 'Темур Кодиров', number: 30, date: 2017-08-01},
        				{who: 'Алишер Кодиров', number: 20, date: 2017-08-02}]}
        		},
        		{name: 'Склад 3', number: 23, requests: 
        			{up: [
        				{who: 'Темур Кодиров', number: 10, date: 2017-08-01},
        				{who: 'Алишер Кодиров', number: 5, date: 2017-08-02}],
        			down: false}
        		}
        	], 
        	totalFull: 160,
        	total: 130
        	},

        	{name: 'Daewoo 02/3421/23', stores: [
        		{name: 'Склад 1', number: 23,requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 2', number: 126, requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 3', number: 53, requests: 
        			{up: false, down: false}
        		}
        	],
        	totalFull: 202,
        	total: 202
        	},

        	{name: 'Opel 02/3421/23', stores: [
        		{name: 'Склад 1', number: 12, requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 2', number: 43, requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 3', number: 23, requests: 
        			{up: false, down: false}
        		}
        	], 
        	totalFull: 78,
        	total: 78
        	},

        	{name: 'Toyota 02/3421/23', stores: [
        		{name: 'Склад 1', number: 34, requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 2', number: 120, requests: 
        			{up: false, down: false}
        		},
        		{name: 'Склад 3', number: 20, requests: 
        			{up: false, down: false}
        		}
        	], 
        	totalFull: 174,
        	total: 174
        	},
        ],

        $scope.total = function(stores)
        	{
        		var total = 0;
        		for(var i =0; i< stores.length; i++)
        		{
        			total += stores[i].number;
        		}

        		return total;
        	}

        
    });
</script>

@endsection

@section('content')

<div ng-app = "myApp" ng-controller = "myCtrl">

<div class="row">
    <div class="col-sm-4">
        <input type = "text" placeholder = "Поиск..." ng-model = "search" class = "form-control" />
    </div>

    <div class = "col-sm-4">
    	<select class = "form-control" ng-model = "filtByStore">
    		<option></option>
    		<option>Склад 1</option>
    		<option>Склад 2</option>
    		<option>Склад 3</option>
    	</select>
    </div>
</div>

<table class = "table table-hover table-striped">
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

	<tbody>
		<tr ng-repeat = "good in goods | filter: search">
			<th>@{{ $index+1 }}</th>
			<td>@{{ good.name }}</td>
			<td>@{{ good.totalFull }} (@{{ good.total }})</td>
			<td class = "td-inside">
				<table class = "table-inside table">
					<tr ng-repeat = "store in good.stores | filter: { name:filtByStore} ">
						<td>@{{ store.name }}</td>
					</tr>
				</table>
			</td>
		
			<td class = "td-inside">
				<table class = "table-inside table">
					<tr ng-repeat = "store in good.stores | filter: { name:filtByStore}">
						<td>
							@{{ store.number }} ( @{{ store.requests.up ? store.number - total(store.requests.up) : store.number }} )
		
							<a data-toggle="modal" href="#download@{{$parent.$index+'-'+$index}}"><span  class = "glyphicon glyphicon-arrow-down pull-right"></span></a>
		
							<div class="modal fade" id="download@{{$parent.$index+'-'+$index}}">
			                    <div class="modal-dialog">
			                        <div class="modal-content">
			                            <div class="modal-header">
			                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                <h4 class="modal-title text-center">Подать заявку на приход</h4>
			                            </div>
			                            <div class="modal-body">
			                                <table class = "table">
			                                    <tbody>
			                                        <tr>
			                                            <th>Товар</th>
			                                            <td>@{{ good.name }}</td>
			                                            
			                                        </tr>
		
			                                        <tr>
			                                            <th>Склад</th>
			                                            <td>@{{ store.name }}</td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>Остаток</th>
			                                            <td>@{{ store.number }}</td>
			                                            
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
			                                                <input type = "text" class = "form-control" />
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

			                <a data-toggle="modal" href="#upload@{{$parent.$index+'-'+$index}}"><span  class = "glyphicon glyphicon-arrow-up pull-right"></span></a>
		
							<div class="modal fade" id="upload@{{$parent.$index+'-'+$index}}">
			                    <div class="modal-dialog">
			                        <div class="modal-content">
			                            <div class="modal-header">
			                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                <h4 class="modal-title text-center">Подать заявку на расход</h4>
			                            </div>
			                            <div class="modal-body">
			                                <table class = "table">
			                                    <tbody>
			                                        <tr>
			                                            <th>Товар</th>
			                                            <td>@{{ good.name }}</td>
			                                            
			                                        </tr>
		
			                                        <tr>
			                                            <th>Склад</th>
			                                            <td>@{{ store.name }}</td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>Остаток</th>
			                                            <td>@{{ store.number }}</td>
			                                            
			                                        </tr>
			                                        <tr>
			                                            <th>Количество</th>
			                                            <td>
			                                                <input type="number" class = "form-control" max = "@{{ store.number }}"/>
			                                            </td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>От кого</th>
			                                            <td>
			                                                <input type = "text" class = "form-control" />
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
				</table>
			</td>

			<td class = "text-right">
				<a data-toggle = "modal" href="#edit@{{$index}}"><span class = "glyphicon glyphicon-pencil"></span></a>

				<div class="modal fade" id="edit@{{$index}}">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Изменить</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tr>
										<th>Товар</th>
										<td>
											<input type="text" class = "form-control" value = "@{{good.name}}"/>
										</td>
									</tr>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Сохранить</button>
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