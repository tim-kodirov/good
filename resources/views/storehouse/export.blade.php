@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

	var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {

        $scope.exports = {!! $exports !!},
        $scope.who = [
        	{name: 'Temur Kodirov', contact: '777 77 77'},
        	{name: 'Alisher Kodirov', contact: '777 77 77'},
        	{name: 'Aziz Kodirov', contact: '777 77 77'},
        	{name: 'Mahmud Kodirov', contact: '777 77 77'},
        ]
//        $scope.exports = [
//            { name: 'Audi 02/3421/23', number: 234, who: 'Темур Кодиров', date: '2017-08-01', return: false, returnDate: false },
//            { name: 'Daewoo 02/3421/23', number: 74, who: 'Алишер Кодиров', date: '2017-08-02', return: false, returnDate: false },
//            { name: 'BMW 02/3421/23', number: 634, who: 'Махмуд Кодиров', date: '2017-08-01', return: 30, returnDate: '2017-08-02' },
//            { name: 'Toyota 02/3421/23', number: 231, who: 'Азиз Кодиров', date: '2017-08-02', return: 30, returnDate: '2017-08-02' },
//            { name: 'Opel 02/3421/23', number: 24, who: 'Темур Кодиров', date: '2017-08-01', return: false, returnDate: false },
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
			<th>Кому</th>
			<th>Количество</th>
			<th>Дата</th>
			<th>Возврат</th>
			<th>Дата возврата</th>
		</tr>
		
	</thead>

	<tbody>
		<tr ng-repeat = "export in exports | filter : search">
			<td>@{{ export.name }}</td>
			<td>@{{ export.who }}</td>
			<td>@{{ export.number }}</td>
			<td>@{{ export.date | date: "dd.MM.yyyy" }}</td>
			<td>
				<span ng-if = "export.return">
					@{{ export.return }}
				</span>
				<span ng-if = "!export.return">
					<button data-toggle = "modal" data-target = "#returnModal@{{$index}}" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>

					<div class="modal fade" id="returnModal@{{$index}}">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" action="{{route('store.export.return')}}">
									{{csrf_field()}}
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title text-center">Возврат</h4>
									</div>
									<div class="modal-body">
										<table class = "table">
											<tbody>
												<tr>
													<th>Товар</th>
                                                	<td>@{{ export.name }}</td>
												</tr>

												<tr>
													<th>Количество</th>
													<td>
														<input type="hidden" name="export_id" value="@{{ export.id }}">
														<input type="number" class = "form-control" name="return_quantity" min="0" max = "@{{export.number}}"/>
													</td>
												</tr>
											</tbody>
										</table>

										<div class="row">
											<div class="col-sm-6">
												<button type="submit" class = "btn btn-info btn-block">Добавить</button>
											</div>
											<div class="col-sm-6">
												<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</span>
				
			</td>
			<td>
				<span ng-if = "export.return">@{{ export.returnDate | date : "dd.MM.yyyy" }}</span>
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
										<th>Кому</th>
										<td>
											<input type="text" list = "who-list" class = "form-control" value = "@{{export.who}}"/>

											<datalist id = "who-list" ng-model = "selected">
												<option ng-repeat = "w in who">@{{ w.name }}</option>
											</datalist>
											
										</td>
									</tr>
									
									<tr>
										<th>Котактные данные</th>
										<td>
											<input type = "text" list ="who-contact" class = "form-control" ng-model = "selected"/>
										</td>
									</tr>
									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "@{{ export.number }}" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "@{{ export.date }}"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "@{{ export.return ? export.return : 0}}"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "@{{ export.return ? export.returnDate : 0}}"/>
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