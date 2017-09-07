@extends('layouts.main')
@section('content')

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
		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>30</td>
			<td>
				22.01.2018
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

		<tr>
			<td>Audi 02/3421/23</td>
			<td>Темур Кодиров</td>
			<td>230</td>
			<td>21.01.2018</td>
			<td>
				<button data-toggle = "modal" data-target = "#return1" class = "my-btn btn btn-info btn-sm"><span class = "glyphicon glyphicon-plus"></span></button>
				<div class="modal fade" id="return1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title text-center">Возврат</h4>
							</div>
							<div class="modal-body">
								<table class = "table">
									<tbody>
										<tr>
											<th>Количество</th>
											<td>
												<input type="number" class = "form-control" />
											</td>
										</tr>

										<tr>
											<th>Дата</th>
											<td>
												<input type = "date" class = "form-control"/>
											</td>
										</tr>
									</tbody>
								</table>

								<div class="row">
									<div class="col-sm-6">
										<button class = "btn btn-info btn-block">Добавить</button>
									</div>
									<div class="col-sm-6">
										<button data-dismiss = "modal" class = "btn btn-danger btn-block">Отмена</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="#edit" data-toggle="modal"><span class = "glyphicon glyphicon-pencil pull-right"></span></a>

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
										<th>Кому</th>
										<td>
											<input type="text" class = "form-control" value = "Темур Кодиров"/>
										</td>
									</tr>

									<tr>
										<th>Количество</th>
										<td>
											<input type="number" class = "form-control" value = "230" />
										</td>
									</tr>

									<tr>
										<th>Дата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
										</td>
									</tr>

									<tr>
										<th>Возврат</th>
										<td>
											<input type="number" class = "form-control" value = "30"/>
										</td>
									</tr>

									<tr>
										<th>Дата возврата</th>
										<td>
											<input type="date" class = "form-control" value = "21.01.2018"/>
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

@endsection