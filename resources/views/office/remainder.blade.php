@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection


@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

	var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {
		$scope.goods = {!! $goods !!}
//        $scope.goods = [
//        	{name: 'Audi 02/3421/23', stores: [
//        		{name: 'Склад 1', number: 67, requests:
//        			{up: [
//        				{who: 'Темур Кодиров', number: 30, date: "01.08.2017"}],
//        			down: false,
//        			totalUp: 30,
//        			totalDown: 0
//        			}
//        		},
//        		{name: 'Склад 2', number: 70, requests:
//        			{
//	        			up: false,
//	        			down: [
//	        				{who: 'Темур Кодиров', number: 30, date: "01.08.2017"},
//	        				{who: 'Алишер Кодиров', number: 20, date: "02.08.2017"}],
//	        			totalUp: 0,
//	        			totalDown: 50
//        			}
//        		},
//        		{name: 'Склад 3', number: 23, requests:
//        			{
//        				up: [
//	        				{who: 'Темур Кодиров', number: 10, date: "01.08.2017"},
//	        				{who: 'Алишер Кодиров', number: 5, date: "02.08.2017"}],
//        				down: false,
//        				totalUp: 15,
//        				totalDown: 0
//        			}
//        		}
//        	],
//        	totalFull: 160,
//        	total: 130
//        	},
//
//        	{name: 'Daewoo 02/3421/23', stores: [
//        		{name: 'Склад 1', number: 23,requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 2', number: 126, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 3', number: 53, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		}
//        	],
//        	totalFull: 202,
//        	total: 202
//        	},
//
//        	{name: 'Opel 02/3421/23', stores: [
//        		{name: 'Склад 1', number: 12, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 2', number: 43, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 3', number: 23, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		}
//        	],
//        	totalFull: 78,
//        	total: 78
//        	},
//
//        	{name: 'Toyota 02/3421/23', stores: [
//        		{name: 'Склад 1', number: 34, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 2', number: 120, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		},
//        		{name: 'Склад 3', number: 20, requests:
//        			{up: false, down: false, totalUp: 0,totalDown: 0}
//        		}
//        	],
//        	totalFull: 174,
//        	total: 174
//        	},
//        ]

        /*$scope.total = function(stores)
        	{
        		var total = 0;
        		for(var i =0; i< stores.length; i++)
        		{
        			total += stores[i].number;
        		}

        		return total;
        	}*/
    	
        
    });

    $(document).ready(function()
        {
            $('tr[id^=request]').click(function()
            {
                var id = $(this).attr('id');
                var element = $("input[type='checkbox'][name="+id+"]").attr('checked');

                if( element == 'checked')
                {   
                    $("input[type='checkbox'][name='"+id+"']").attr('checked', false);
                }else
                {
                    $("input[type='checkbox'][name='"+id+"']").attr('checked', true);
                }
            });
            
        });
</script>

@endsection

@section('content')

<div ng-app = "myApp" ng-controller = "myCtrl">

<div class="row">
    <div class="col-sm-4">
        <input type = "text" placeholder = "Поиск..." ng-model = "search" class = "form-control" id = "tags"/>
    </div>

    <div class = "col-sm-4">
    	<select class = "form-control" ng-model = "filtByStore">
    		<option></option>
    		<option ng-repeat = "store in goods[0].stores">@{{ store.name }}</option>
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
			<th>Количество</th>
			<th></th>
			<th></th>
		</tr>
	</thead>

	<tbody ng-repeat = "good in goods | filter: search">
		<!-- <tr ng-repeat = "good in goods | filter: search">
			<th>@{{ $index+1 }}</th>
			<td>@{{ good.name }}</td>
			<td>@{{ good.totalFull }} (@{{ good.total }})</td>
			<td class = "td-inside">
				<table class = "table-inside table">
					<tr ng-repeat = "store in good.stores | filter: { name:filtByStore} ">
						<td>@{{ store.name }}</td>
					</tr>
				</table>
			</td>
		
			<td class = "td-inside">
				<table class = "table-inside table">
					<tr ng-repeat = "store in good.stores | filter: { name:filtByStore}">
						<td>
							@{{ store.number }} ( @{{ store.requests.up ? store.number - total(store.requests.up) : store.number }} )
		
							<a data-toggle="modal" href="#download@{{$parent.$index+'-'+$index}}"><span  class = "ex-im-span glyphicon glyphicon-arrow-down pull-right"></span></a>
		
							<div class="modal fade" id="download@{{$parent.$index+'-'+$index}}">
			                    <div class="modal-dialog">
			                        <div class="modal-content">
			                            <div class="modal-header">
			                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                <h4 class="modal-title text-center">Подать заявку на приход</h4>
			                            </div>
			                            <div class="modal-body">
			                                <table class = "table">
			                                    <tbody>
			                                        <tr>
			                                            <th>Товар</th>
			                                            <td>@{{ good.name }}</td>
			                                            
			                                        </tr>
		
			                                        <tr>
			                                            <th>Склад</th>
			                                            <td>@{{ store.name }}</td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>Остаток</th>
			                                            <td>@{{ store.number }}</td>
			                                            
			                                        </tr>
			                                        <tr>
			                                            <th>Количество</th>
			                                            <td>
			                                                <input type="number" class = "form-control"/>
			                                            </td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>От кого</th>
			                                            <td>
			                                                <input type = "text" class = "form-control" />
			                                            </td>
			                                        </tr>
			                                    </tbody>
			                                </table>
		
			                                <div class="row">
			                                    <div class="col-sm-6">
			                                        <button class = "btn btn-info btn-block">Добавить</button>
			                                    </div>
			                                    <div class="col-sm-6">
			                                        <button class = "btn btn-danger btn-block" data-dismiss = "modal">Отмена</button>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                </div>
		
			                <a data-toggle="modal" href="#upload@{{$parent.$index+'-'+$index}}"><span  class = "glyphicon glyphicon-arrow-up pull-right"></span></a>
		
							<div class="modal fade" id="upload@{{$parent.$index+'-'+$index}}">
			                    <div class="modal-dialog">
			                        <div class="modal-content">
			                            <div class="modal-header">
			                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                <h4 class="modal-title text-center">Подать заявку на расход</h4>
			                            </div>
			                            <div class="modal-body">
			                                <table class = "table">
			                                    <tbody>
			                                        <tr>
			                                            <th>Товар</th>
			                                            <td>@{{ good.name }}</td>
			                                            
			                                        </tr>
		
			                                        <tr>
			                                            <th>Склад</th>
			                                            <td>@{{ store.name }}</td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>Остаток</th>
			                                            <td>@{{ store.number }}</td>
			                                            
			                                        </tr>
			                                        <tr>
			                                            <th>Количество</th>
			                                            <td>
			                                                <input type="number" class = "form-control" max = "@{{ store.number }}"/>
			                                            </td>
			                                        </tr>
		
			                                        <tr>
			                                            <th>От кого</th>
			                                            <td>
			                                                <input type = "text" class = "form-control" />
			                                            </td>
			                                        </tr>
			                                    </tbody>
			                                </table>
		
			                                <div class="row">
			                                    <div class="col-sm-6">
			                                        <button class = "btn btn-info btn-block">Добавить</button>
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
				</table>
			</td>
		
			<td class = "text-right">
				<a data-toggle = "modal" href="#edit@{{$index}}"><span class = "glyphicon glyphicon-pencil"></span></a>
		
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
										<th>Товар</th>
										<td>
											<input type="text" class = "form-control" value = "@{{good.name}}"/>
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
		</tr> -->


		<tr>
			<th rowspan="@{{ filteredStores.length+1 }}">@{{ $index + 1 }}</th>
			<td rowspan="@{{ filteredStores.length+1 }}">@{{ good.name }}</td>
			<td rowspan="@{{ filteredStores.length+1 }}">@{{ good.totalFull }} (@{{ good.total }})</td>
		</tr>

		<tr ng-repeat = "store in filteredStores = ( good.stores | filter: filtByStore)">
			<td>@{{ store.name }}</td>
			<td>
				@{{ store.number }} (@{{ store.number - store.requests.totalUp }})

			</td>
			<td>
				<a class = "my-btn btn btn-default btn-sm" data-toggle="modal" href="#download@{{$parent.$index+'-'+$index}}"><span  class = "glyphicon glyphicon-arrow-down"></span></a>
				<div class="modal fade" id="download@{{$parent.$index+'-'+$index}}">
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
												<td>@{{ good.name }}</td>

											</tr>

											<tr>
												<th>Склад</th>
												<td>@{{ store.name }}</td>
											</tr>

											<tr>
												<th>Остаток</th>
												<td>@{{ store.number }}</td>

											</tr>
											<tr>
												<th>Количество</th>
												<td>

													<input type="hidden" name="request_isExport" value="0">
													<input type="hidden" name="remainder_id" value="@{{ store.remainder_id }}">
													<input type="number" class = "form-control" name="request_quantity" min="0"/>
												</td>
											</tr>

											<tr>
												<th>От кого</th>
												<td>
													<input list = "names" type = "text" name="client_name" class = "form-control"/>
													<datalist id = "names">
														<option value = "Temur Kodirov"></option>
														<option value = "Alisher Kodirov"></option>
														<option value = "Mahmud Kodirov"></option>
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
			
                <a class = "my-btn btn btn-default btn-sm" data-toggle="modal" href="#upload@{{$parent.$index+'-'+$index}}"><span  class = "glyphicon glyphicon-arrow-up"></span></a>
	            <div class="modal fade" id="upload@{{$parent.$index+'-'+$index}}">
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
												<td>@{{ good.name }}</td>

											</tr>

											<tr>
												<th>Склад</th>
												<td>@{{ store.name }}</td>
											</tr>

											<tr>
												<th>Остаток</th>
												<td>@{{ store.number }}</td>

											</tr>
											<tr>
												<th>Количество</th>
												<td>
													<input type="hidden" name="request_isExport" value="1">
													<input type="hidden" name="remainder_id" value="@{{ store.remainder_id }}">
													<input type="number" class = "form-control" name="request_quantity" min="0" max = "@{{ store.number }}"/>
												</td>
											</tr>

											<tr>
												<th>Кому</th>
												<td>
													<input type = "text" list = "who_up" name="client_name" class = "form-control" id = "whom"/>

													<datalist id = "who_up">
														<option value = "Temur Kodirov"></option>
														<option value = "Alisher Kodirov"></option>
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

	            <span ng-if = "store.requests.up">
					<button class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modalUp@{{$index}}">
						<span class = "glyphicon glyphicon-time text-danger"></span>
					</button>

					<div class="modal fade" id="modalUp@{{$index}}">
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
													<th>Кому</th>
													<th>Дата</th>
													<th>Кол-во</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat = "up in store.requests.up" id = "requestUp@{{$parent.$index+'-'+$index}}">
													<td><input name = "selected_requests_id[]" value="@{{ up.id }}" type="checkbox"/></td>
													<td>@{{ good.name }}</td>
													<td>
														<span ng-if = "!requestUp[$parent.$index][$index]">@{{ up.who }}</span>
														<span ng-if = "requestUp[$parent.$index][$index]">
															<input type = "text" list = "who_up_change" class = "form-control" value = "@{{ up.who }}">

															<datalist id = "who_up_change">
																<option value = "Temur Kodirov"></option>
																<option value = "Alisher Kodirov"></option>
															</datalist>
														</span>
													</td>
													<td>@{{ up.date }}</td>
													<td>
														<span ng-if = "!requestUp[$parent.$index][$index]">@{{ up.number }}</span>
														<span ng-if = "requestUp[$parent.$index][$index]">
															<input type = "number" class = "form-control" value = "@{{ up.number }}">
														</span>
													</td>
													<td>
														<a href="#" ng-click = "requestUp[$parent.$index][$index] ? requestUp[$parent.$index][$index] = false : requestUp[$parent.$index][$index] = true">
															<span ng-if = "!requestUp[$parent.$index][$index]" class = "glyphicon glyphicon-pencil"></span>
															<span ng-if = "requestUp[$parent.$index][$index]" class = "glyphicon glyphicon-floppy-disk"></span>
														</a>
													</td>
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
				</span>

				<span ng-if = "store.requests.down">
					<button class = "my-btn btn btn-default btn-sm" data-toggle = "modal" href = "#modalDown@{{$index}}">
						<span class = "glyphicon glyphicon-time text-info"></span>
					</button>

					<div class="modal fade" id="modalDown@{{$index}}">
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
													<th>От кого</th>
													<th>Дата</th>
													<th>Кол-во</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat = "down in store.requests.down" id = "requestDown@{{$parent.$index+'-'+$index}}">
													<td><input name ="selected_requests_id[]" value="@{{ down.id }}" type="checkbox"/></td>
													<td>@{{ good.name }}</td>
													<td>
														<span ng-if = "!requestDown[$parent.$index][$index]">@{{ down.who }}</span>
														<span ng-if = "requestDown[$parent.$index][$index]">
															<input type = "text" list = "who_down_change" class = "form-control" value = "@{{ down.who }}">
															<datalist id = "who_down_change">
																<option value = "Temur Kodirov"></option>
																<option value = "Alisher Kodirov"></option>
															</datalist>
														</span>
													</td>
													<td>@{{ down.date }}</td>
													<td>
														<span ng-if = "!requestDown[$parent.$index][$index]">@{{ down.number }}</span>
														<span ng-if = "requestDown[$parent.$index][$index]">
															<input type = "number" class = "form-control" value = "@{{ down.number }}">
														</span>
													</td>
													<td>
														<a href="#" ng-click = "requestDown[$parent.$index][$index] ? requestDown[$parent.$index][$index] = false : requestDown[$parent.$index][$index] = true">
															<span ng-if = "!requestDown[$parent.$index][$index]" class = "glyphicon glyphicon-pencil"></span>
															<span ng-if = "requestDown[$parent.$index][$index]" class = "glyphicon glyphicon-floppy-disk"></span>
														</a>
													</td>
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
				</span>	
			</td>
			<td ng-if = "$index==0" rowspan="@{{ filteredStores.length }}">
				<a data-toggle = "modal" href="#edit@{{$index}}"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

				<div class="modal fade" id="edit@{{$index}}">
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
												<input type="hidden" name="product_id" value="@{{ good.id }}">
												<input type="text" class = "form-control" name="new_product_name" value = "@{{good.name}}"/>
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
							</form>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>

</div>

@endsection