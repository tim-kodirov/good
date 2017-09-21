@extends('layouts.main')

@section('scripts')

	<script type="text/javascript">

        var app = angular.module('myApp', []);

        app.controller('myCtrl', function($scope) {

            $scope.imports = {!! $imports !!},
            $scope.stores = {!! $stores !!}
        });
	</script>

@endsection


@section('content')

	<div ng-app = "myApp" ng-controller = "myCtrl">

		<div class="row">
			<div class="col-sm-4">
				<input type = "text" ng-model = "search" class = "form-control" placeholder="Поиск" />
			</div>

			<div class = "col-sm-4">
				<select class = "form-control" ng-model = "filterByStore">
					<option></option>
					<option ng-repeat = "store in stores">@{{ store.name }}</option>
				</select>
			</div>
		</div>

		<table class = "table table-striped table-hover">
			<thead>
			<tr>
				<th>Товар</th>
				<th>Склад</th>
				<th>Кому</th>
				<th>Количество</th>
				<th>Дата</th>
			</tr>

			</thead>

			<tbody>
			<tr ng-repeat = "import in imports | filter : search | filter : filterByStore">
				<td>@{{ import.name }}</td>
				<td>@{{ import.store }}</td>
				<td>@{{ import.who }}</td>
				<td>@{{ import.number }}</td>
				<td>@{{ import.date | date: "dd.MM.yyyy" }}</td>
			</tr>
			</tbody>
		</table>
	</div>
@endsection