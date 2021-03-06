@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection


@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

    app.controller('myCtrl', function($scope) {
		
		$scope.goods = {!! $goods !!},
       	$scope.whos = {!! $whos !!},
       	$scope.stores = {!! $stores !!},
       	$scope.owners = {!! $owners !!},


       	$scope.goodChosen = {},
       	$scope.storeChosen = {},

       	$scope.requestsUp = [],
       	$scope.requestsDown = [],

       	$scope.chooseGood = function(good, store)
       	{

       		$scope.goodChosen = good;
       		$scope.storeChosen = store;
       	},


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
       	}
    });
</script>

@endsection

@section('content')

<div ng-controller = "myCtrl">

	<div class="row">
	    <div class="col-sm-4">
	        <input type = "text" placeholder = "Поиск..." ng-model = "search" class = "form-control" id = "tags"/>
	    </div>

	    <div class = "col-sm-4">
	    	<select class = "form-control" ng-model = "filtByStore">
	    		<option></option>
				<option ng-repeat = "store in stores">@{{ store.name }}</option>
	    	</select>
	    </div>

	    <div class = "col-sm-4">
	    	<select class = "form-control" ng-model = "filtByStore">
	    		<option></option>
				<option ng-repeat = "owner in owners">@{{ owner.name }}</option>
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
				<th>Руководитель</th>
				<th>Количество</th>
				<th></th>
				<th></th>
			</tr>
		</thead>

		<tbody ng-repeat = "good in goods | filter: { $: search,  stores: { $: filtByStore} }">
			<tr>
				<th rowspan="@{{ filteredStores.length+1 }}">@{{ $index + 1 }}</th>
				<td rowspan="@{{ filteredStores.length+1 }}">@{{ good.name }}</td>
				<td rowspan="@{{ filteredStores.length+1 }}">@{{ good.totalFull }} (@{{ good.total }})</td>
			</tr>

			<tr ng-repeat = "store in filteredStores = ( good.stores | filter: filtByStore )">
				<td>@{{ store.name }}</td>
				<td>@{{ store.owner }}</td>
				<td>
					@{{ store.number }} (@{{ store.number - store.requests.totalUp }})
				</td>
				<td>
					<button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm btn-primary" data-toggle="modal" data-target="#download"><span  class = "glyphicon glyphicon-arrow-down"></span></button>
					

	                <button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm btn-success" data-toggle="modal" data-target="#upload"><span class = "glyphicon glyphicon-arrow-up"></span></button>

	                <span ng-if = "store.requests.down">
						<button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modal-requestsDown">
							<span class = "glyphicon glyphicon-time text-info"></span>
						</button>
					</span>
		            
		            <span ng-if = "store.requests.up">
						<button ng-click = "chooseGood(good,store)" class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modal-requestsUp">
							<span class = "glyphicon glyphicon-time text-success"></span>
						</button>
					</span>

					
				</td>
				<td ng-if = "$index==0" rowspan="@{{ filteredStores.length }}">
					<a ng-click = "chooseGood(good, null)" data-toggle = "modal" href="#edit"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="modal fade" id="download">
	    <div class="modal-dialog">
	        <div class="modal-content">
				<form method="post" action="{{route('office.request.create')}}">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">Подать заявку на приход</h4>
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
									<td>@{{ storeChosen.name }} (@{{storeChosen.owner}})</td>
								</tr>

								<tr>
									<th>Остаток</th>
									<td>@{{ storeChosen.number }}</td>

								</tr>
								<tr>
									<th>Количество</th>
									<td>
										<input type="hidden" name="request_isExport" value="0">
										<input type="hidden" name="remainder_id" value="@{{ storeChosen.remainder_id }}">
										<input type="number" class = "form-control" name="request_quantity" min="1" required/>
									</td>
								</tr>

								<tr>
									<th>От кого</th>
									<td>
										<input list = "clientsDown" type = "text" class = "form-control" name="client_name" required/>

										<datalist id = "clientsDown">
											<option ng-repeat = "who in whos | orderBy">@{{who}}</option>
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
				<form method="post" action="{{route('office.request.create')}}">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">Подать заявку на расход</h4>
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
									<td>@{{ storeChosen.name }} (@{{storeChosen.owner}})</td>
								</tr>

								<tr>
									<th>Остаток</th>
									<td>@{{ storeChosen.number }}</td>

								</tr>
								<tr>
									<th>Количество</th>
									<td>
										<input type="hidden" name="request_isExport" value="1">
										<input type="hidden" name="remainder_id" value="@{{ storeChosen.remainder_id }}">
										<input type="number" class = "form-control" name="request_quantity" min="1" max="@{{ storeChosen.number }}" required />
									</td>
								</tr>

								<tr>
									<th>Кому</th>
									<td>
										<input type = "text" class = "form-control" list = "clientsUp" name="client_name" required />

										<datalist id = "clientsUp">
											<option ng-repeat = "who in whos | orderBy">@{{who}}</option>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="{{route('office.request.edit')}}">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">Заявки на приход</h4>
					</div>
					<div class="modal-body">
						<table class = "table table-hover table-striped">
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
									<td><input name = "selected_requests_id[]" type="checkbox" ng-model = "requestsDown[down.id]" value="@{{ down.id }}" /></td>
									<td>@{{ goodChosen.name }}</td>
									<td>
										<input type = "number" name="requests_quantity[@{{ down.id }}]" class = "form-control" value = "@{{ down.number }}" required>
									</td>
									<td>
										<input type = "text" name="clients_name[@{{ down.id }}]" list = "clientsDown@{{down.id}}" class = "form-control" value = "@{{ down.who }}" required>

										<datalist id = "clientsDown@{{down.id}}">
											<option ng-repeat = "who in whos | orderBy">@{{who}}</option>
										</datalist>

									</td>
									<td>@{{ down.date }}</td>
								</tr>
							</tbody>
						</table>

						<div class="row">
							<div class="col-md-4">
								<button type="submit" class = "btn btn-success btn-block">Сохранить</button>
							</div>
							<div class="col-md-4">
								<button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
							</div>
							<div class="col-md-4">
								<button formaction="{{route('office.request.delete')}}" class = "btn btn-danger btn-block">Удалить</button>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-requestsUp">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="{{route('office.request.edit')}}">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">Заявки на расход</h4>
					</div>
					<div class="modal-body">

						<table class = "table table-hover table-striped">
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
									<td><input name = "selected_requests_id[]" type="checkbox" ng-model = "requestsUp[up.id]" value="@{{ up.id }}" /></td>
									<td>@{{ goodChosen.name }}</td>
									<td>
										<input type = "number" name="requests_quantity[@{{ up.id }}]" class = "form-control" value = "@{{ up.number }}" max = "@{{ storeChosen.number }}" required>
									</td>
									<td>
										<input type = "text" name="clients_name[@{{ up.id }}]" list = "clientsUp@{{up.id}}" class = "form-control" value = "@{{ up.who }}" required>

										<datalist id = "clientsUp@{{up.id}}">
											<option ng-repeat = "who in whos | orderBy">@{{who}}</option> 
										</datalist>
									</td>
									<td>@{{ up.date }}</td>
								</tr>
									
							</tbody>
						</table>

						<div class="row">
							<div class="col-md-4">
								<button type="submit" class = "btn btn-success btn-block">Сохранить</button>
							</div>
							<div class="col-md-4">
								<button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
							</div>
							<div class="col-md-4">
								<button formaction="{{route('office.request.delete')}}" class = "btn btn-danger btn-block">Удалить</button>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="{{route('office.product.edit')}}">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">Изменить</h4>
					</div>
					<div class="modal-body">
						<table class = "table">
							<tr>
								<th>Товар</th>
								<td>
									<input type="hidden" name="product_id" value="@{{ goodChosen.id }}">
									<input type="text" class = "form-control" name="new_product_name" value = "@{{goodChosen.name}}" required />
								</td>
							</tr>
						</table>

						<div class="row">
							<div class="col-sm-6">
								<button type="submit" class = "btn btn-info btn-block">Сохранить</button>
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

</div>

@endsection