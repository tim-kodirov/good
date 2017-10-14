@extends('layouts.main')

@section('scripts')

<script type="text/javascript">


    app.controller('myCtrl', function($scope) {
    	$scope.exports = [
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
        		date: '02.08.2016',
        		returns: [
        			{
        				number: 5,
        				date: '02.08.2016',
        			},
        			{
        				number: 10,
        				date: '03.08.2016',
        			},
        			{
        				number: 12,
        				date: '03.08.2016'
        			},
        			{
        				number: 14,
        				date: '03.08.2016'
        			}
        		]
        	},
        	{
        		id: 3,
        		name: 'Audi 02/3421/23',
        		store:{
        			id: 1,
        			name: 'Store 1',
        			owner: 'Temur'
        		},
        		who: 'Sulton',
        		number: 50,
        		date: '03.08.2016',
        		returns: false
        	}
        ];

        $scope.whos = [
       		'Sulton', 
       		'Saidmurod',
       		'Shox',
       		'Sunnat',
       		'Alisher'
       	];
        $scope.exportChosen = {};

        $scope.chooseExport = function(exp)
        {
        	$scope.exportChosen = exp;
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
			<th>Склад</th>
			<th>Кому</th>
			<th>Дата</th>
			<th>Возврат</th>
			<th>Дата возврата</th>
		</tr>
		
	</thead>

	<tbody>
		<tr ng-repeat = "export in exports | filter : search | orderBy: 'date' : true ">
			<td>@{{ export.name }}</td>
			<td>@{{ export.number - export.returns[export.returns.length - 1].number }}</td>
			<td>@{{ export.store.name }}</td>
			<td>@{{ export.who }}</td>
			<td>@{{ export.date | date: "dd.MM.yyyy" }}</td>
			<td>
				<span ng-if = "export.returns">
					@{{ export.returns[export.returns.length-1].number }}
				</span>
				<span ng-if = "!export.returns">
					<button ng-click = "chooseExport(export)" data-toggle = "modal" data-target = "#returnModal" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				</span>
				
			</td>
			<td>
				<span ng-if = "export.returns">@{{ export.returns[export.returns.length-1].date}}</span>
				<a ng-click = "chooseExport(export)" href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>
			</td>
		</tr>
	</tbody>
</table><!-- end of main table -->

<div class="modal fade" id="returnModal">
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
                            	<td>@{{ exportChosen.name }}</td>
							</tr>

							<tr>
								<th>Количество</th>
                            	<td>@{{ exportChosen.number }}</td>
							</tr>

							<tr>
								<th>Склад</th>
                            	<td>@{{ exportChosen.store.name }}</td>
							</tr>

							<tr>
								<th>Кому</th>
                            	<td>@{{ exportChosen.who }}</td>
							</tr>

							<tr>
								<th>Количество возврата</th>
								<td>
									<input type="hidden" name="export_id" value="@{{ exportChosen.id }}">
									<input type="number" class = "form-control" name="return_quantity" min="0" max = "@{{exportChosen.number}}"/>
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
</div><!-- end of return modal-->

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
						<td>@{{ exportChosen.name }}</td>
					</tr>

					<tr>
						<th>Количество</th>
						<td>@{{ exportChosen.number }}</td>
					</tr>

					<tr>
						<th>Склад</th>
						<td>@{{ exportChosen.store.name }}</td>
					</tr>
					<tr>
						<th>Кому</th>
						<td>
							<input type="text" list = "who-list" class = "form-control" value = "@{{exportChosen.who}}"/>

							<datalist id = "who-list">
								<option ng-repeat = "who in whos">@{{ who }}</option>
							</datalist>
							
						</td>
					</tr>
					<tr ng-if = "exportChosen.returns">
						<th>Возврат</th>
						<td>
							<input type="number" class = "form-control" value = "@{{exportChosen.returns[exportChosen.returns.length-1].number}}" />
						</td>
					</tr>

					<tr ng-if = "exportChosen.returns">
						<th>Дата возврата</th>
						<td>
							@{{ exportChosen.returns[exportChosen.returns.length-1].date}}
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
</div><!-- end of edit modal-->
@endsection