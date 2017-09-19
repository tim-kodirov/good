@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

	var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {

		$scope.imports = {!! $imports !!}
//        $scope.imports = [
//            { name: 'Audi 02/3421/23', number: 234, who: 'Темур Кодиров', date: '2017-08-01' },
//            { name: 'Daewoo 02/3421/23', number: 134, who: 'Алишер Кодиров', date: '2017-08-02' },
//            { name: 'Honda 02/3421/23', number: 44, who: 'Темур Кодиров', date: '2017-08-01'},
//            { name: 'BMW 02/3421/23', number: 12, who: 'Махмуд Кодиров', date: '2017-08-02' },
//            { name: 'Chevrolet 02/3421/23', number: 23, who: 'Комил Кодиров', date: '2017-08-01' },
//
//        ]
    });
</script>

@endsection

@section('content')

<div ng-app = "myApp" ng-controller = "myCtrl">

<div class="row">
    <div class="col-sm-4">
        <input type = "text" ng-model = "search" class = "form-control" placeholder="Поиск" />
    </div>
</div>

<table class = "table table-striped table-hover">
	<thead>
		<tr>
			<th>Товар</th>
			<th>От кого</th>
			<th>Количество</th>
			<th>Дата</th>
		</tr>
		
	</thead>

	<tbody>
		<tr ng-repeat = "import in imports | filter: search">
			<td>@{{ import.name }}</td>
			<td>@{{ import.who }}</td>
			<td>@{{ import.number }}</td>
			<td>
				@{{ import.date }}
				<a href="#edit@{{$index}}" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>От кого</th>
										<td>
											<input type="text" class = "form-control" value = "@{{import.who}}"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "@{{import.number}}" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "@{{import.date}}"/>
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