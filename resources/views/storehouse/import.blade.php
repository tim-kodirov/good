@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

	var app = angular.module('myApp', []);

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
        		
        	}
        ];

        $scope.whos = [
       		'Sulton', 
       		'Saidmurod',
       		'Shox',
       		'Sunnat',
       		'Alisher'
       	];
        $scope.importChosen = {};

        $scope.chooseImport = function(imp)
        {
        	$scope.importChosen = imp;
        };
		

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
			<th>От кого</th>
			<th>Дата</th>
		</tr>
		
	</thead>

	<tbody>
		<tr ng-repeat = "import in imports | filter: search | orderBy : 'date' : true">
			<td>@{{ import.name }}</td>
			<td>@{{ import.who }}</td>
			<td>@{{ import.number }}</td>
			<td>
				@{{ import.date }}
				<a ng-click = "chooseImport(import)" href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>
			</td>
		</tr>
		
	</tbody>
</table>

<div class="modal fade" id="edit">
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
						<td>@{{ importChosen.name }}</td>
					</tr>

					<tr>
						<th>Количество</th>
						<td>
							<input type="number" class = "form-control" value = "@{{importChosen.number}}" />
						</td>
					</tr>

					<tr>
						<th>От кого</th>
						<td>
							<input type="text" list = "who-list" class = "form-control" value = "@{{importChosen.who}}"/>

							<datalist id = "who-list">
								<option ng-repeat = "who in whos">@{{ who }}</option>
							</datalist>
						</td>
					</tr>
			
					<tr>
						<th>Дата</th>
						<td>@{{ importChosen.date }}</td>
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

@endsection