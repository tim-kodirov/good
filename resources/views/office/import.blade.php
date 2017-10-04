@extends('layouts.main')

@section('scripts')

	<script type="text/javascript">

        app.controller('myCtrl', function($scope) {

            $scope.imports = [
            	{
	        		id: 1,
	        		name: 'Audi 02/3421/23',
	        		store:{
	        			id: 1,
	        			name: 'Store 1',
	        			owner: 'Temur'
	        		},
	        		who: 'Saidmurod',
	        		number: 30,
	        		date: '01.08.2016',
	        		
	        	},

	        	{
	        		id: 2,
	        		name: 'Audi 02/3421/23',
	        		store:{
	        			id: 1,
	        			name: 'Store 1',
	        			owner: 'Temur'
	        		},
	        		who: 'Saidmurod',
	        		number: 50,
	        		date: '02.08.2016',
	        		
	        	},

	        	{
	        		id: 3,
	        		name: 'Toyota 02/3421/23',
	        		store:{
	        			id: 2,
	        			name: 'Store 2',
	        			owner: 'Erkin'
	        		},
	        		who: 'Sulton',
	        		number: 24,
	        		date: '03.08.2016',
	        		
	        	},
            ]


        });
	</script>

@endsection


@section('content')

	<div ng-controller = "myCtrl">

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
		</table><!-- end of main table -->
	</div>
@endsection