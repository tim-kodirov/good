@extends('layouts.main')

@section('scripts')

<script type="text/javascript">
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

<table class = "table table-striped table-hover">
    <thead>
        <tr>
            <th>№</th>
            <th>Товар</th>
            <th></th>
            <th>Количество</th>
            <th>Варианты</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>1</th>
            <td>Audi 02/3421/23</td>
            <td></td>
            <td>234</td>
            <td>
                <button data-toggle="modal" data-target="#download" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-down"></span></button>
                

                <div class="modal fade" id="download">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Приход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>Audi 02/3421/23</td>
                                            
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
                            </div>
                        </div>
                    </div>
                </div>
                <button data-toggle="modal" data-target="#upload" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-up"></span></button>

                <div class="modal fade" id="upload">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Расход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>Audi 02/3421/23</td>
                                            
                                        </tr>

                                        <tr>
                                            <th>Количество</th>
                                            <td>
                                                <input type="number" class = "form-control" max="234"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Кому</th>
                                            <td>
                                                <select class = "form-control">
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <th>2</th>
            <td>Daewoo 02/3421/23</td>
            <td>
                <button data-toggle="modal" data-target="#requestDown" class = "my-btn btn btn-danger btn-sm"><span class="glyphicon glyphicon-envelope"></span></button>

                <div class="modal fade" id="requestDown">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Заявки на расход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Товар</th>
                                            <th>Кому</th>
                                            <th>Дата</th>
                                            <th>Кол-во</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id = "requestDown1">
                                            <td><input name ="requestDown1" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>

                                        <tr id = "requestDown2">
                                            <td><input name ="requestDown2" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-4">
                                        <button class = "btn btn-success btn-block">Подтвердить</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class = "btn btn-danger btn-block">Отклонить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button data-toggle="modal" data-target="#requestUp" class = "my-btn btn btn-info btn-sm"><span class="glyphicon glyphicon-envelope"></span></button>

                <div class="modal fade" id="requestUp">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Заявки на приход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Товар</th>
                                            <th>От кого</th>
                                            <th>Дата</th>
                                            <th>Кол-во</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id = "requestUp1">
                                            <td><input name ="requestUp1" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>

                                        <tr id = "requestUp2">
                                            <td><input name ="requestUp2" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>
                                        <tr id = "requestUp3">
                                            <td><input name ="requestUp3" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>
                                        <tr id = "requestUp4">
                                            <td><input name ="requestUp4" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>
                                        <tr id = "requestUp5">
                                            <td><input name ="requestUp5" type="checkbox"/></td>
                                            <td>Daewoo 02/3421/23</td>
                                            <td>Темур Кодиров</td>
                                            <td>19.08.2017</td>
                                            <td>30</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-4">
                                        <button class = "btn btn-success btn-block">Подтвердить</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class = "btn btn-info btn-block" data-dismiss="modal" aria-hidden="true">Отмена</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class = "btn btn-danger btn-block">Отклонить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </td>
            <td>342</td>
            <td>
                <button data-toggle="modal" data-target="#download1" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-down"></span></button>
                

                <div class="modal fade" id="download1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Приход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>Daewoo 02/3421/23</td>
                                            
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
                                                <select class = "form-control">
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button data-toggle="modal" data-target="#upload1" class = "my-btn btn btn-default btn-sm"><span  class = "glyphicon glyphicon-arrow-up"></span></button>

                <div class="modal fade" id="upload1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Расход</h4>
                            </div>
                            <div class="modal-body">
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Товар</th>
                                            <td>Daewoo 02/3421/23</td>
                                            
                                        </tr>
                                        <tr>
                                            <th>Количество</th>
                                            <td>
                                                <input type="number" class = "form-control" max="234"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Кому</th>
                                            <td>
                                                <select class = "form-control">
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                    <option>Темур Кодиров</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

@endsection