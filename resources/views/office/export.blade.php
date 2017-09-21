@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

	var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {

        $scope.exports = {!! $exports !!},
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
			<th>Возврат</th>
			<th>Дата возврата</th>
		</tr>
		
	</thead>

	<tbody>
		<tr ng-repeat = "export in exports | filter : search | filter : filterByStore">
			<td>@{{ export.name }}</td>
			<td>@{{ export.store }}</td>
			<td>@{{ export.who }}</td>
			<td>@{{ export.number }}</td>
			<td>@{{ export.date | date: "dd.MM.yyyy" }}</td>
			<td>
				<span ng-if = "export.return">
					@{{ export.return }}
				</span>
			</td>
		<td>
				<span ng-if = "export.return">@{{ export.returnDate | date : "dd.MM.yyyy" }}</span>
			</td>
		</tr>
	</tbody>
</table>
</div>
@endsection