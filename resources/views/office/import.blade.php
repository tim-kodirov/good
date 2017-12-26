@extends('layouts.main')

@section('scripts')

	<script type="text/javascript">

        app.controller('myCtrl', function($scope) {

        	$scope.imports = {!! $imports !!},
            $scope.stores = {!! $stores !!},
            $scope.owners = {!! $owners !!}

        });
	</script>

@endsection


@section('content')


	<div class="row">
		<div class="col-sm-4">
			<input type = "text" ng-model = "search" class = "form-control" placeholder="Поиск" />
		</div>
	</div>

	<table class = "table table-striped table-hover">
		<thead>
		<tr>
			<th>Товар</th>
			<th>Количество</th>
			<th>Склад</th>
			<th>От кого</th>
			<th>Дата</th>
		</tr>

		</thead>

		<tbody>
		<tr ng-repeat = "import in imports | filter : search | orderBy : 'date' : true">
			<td>@{{ import.name }}</td>
			<td>@{{ import.number }}</td>
			<td>@{{ import.store.name }} (@{{ import.store.owner }})</td>
			<td>@{{ import.who }}</td>
			<td>@{{ import.date | date: "dd.MM.yyyy" }}</td>
		</tr>
		</tbody>
	</table>
@endsection