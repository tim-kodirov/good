@extends('layouts.main')

@section('scripts')

<script type="text/javascript">

    app.controller('myCtrl', function($scope) {

        $scope.exports = {!! $exports !!},
        $scope.stores = {!! $stores !!},
        $scope.owners = {!! $owners !!},
        $scope.returns = [],

		$scope.exports.forEach(function(exp){
			exp.dateObj = new Date(exp.date);
		});
        
        $scope.chooseExport = function(export_returns)
        {
        	if(export_returns != false)
        	{
        		$scope.returns = export_returns;
        		$('#returns').modal('show');
        	}
        }
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
				<th>Кому</th>
				<th>Дата</th>
				<th>Возврат</th>
			</tr>
			
		</thead>

		<tbody>
			<tr class = "requests" ng-click =  "chooseExport(export.returns)" ng-repeat = "export in exports | filter : search  | orderBy: '-dateObj'">
				<td>@{{ export.name }}</td>
				<td>@{{ export.number - export.returns[export.returns.length - 1].number }}</td>
				<td>@{{ export.store.name }} (@{{ export.store.owner}})</td>
				<td>@{{ export.who }}</td>
				<td>@{{ export.date | date: "dd.MM.yyyy" }}</td>
				<td>
					<span ng-if = "export.returns">
						@{{ export.returns[export.returns.length - 1].number }}
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="modal" id="returns">
	    <div class="modal-dialog">
	        <div class="modal-content">
				<form method="post" action="">
					{{csrf_field()}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center">История изменения возвратов</h4>
					</div>
					<div class="modal-body">
						<table class = "table table-striped">
							<thead>
								<tr>
									<th>№</th>
									<th>Возврат</th>
									<th>Дата</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat = "return in returns | orderBy: 'date': true ">
									<th>@{{ returns.length - $index }}</th>
									<td>@{{ return.number }}</td>
									<td>@{{ return.date }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
	        </div>
	    </div>
	</div>

</div>
@endsection