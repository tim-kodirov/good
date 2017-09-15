<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Good Tires Trade</title>

    <!-- Styles -->
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    
    @yield('styles')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>

    @yield('scripts')
    
    
    
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row margin-top-30">
                <div class="col-sm-2">
                    @if(Request::is(['store','store/*']))
                        @include('partials._storehouse_navbar')
                    @elseif(Request::is(['office', 'office/*']))
                        @include('partials._office_navbar')
                    @endif
                </div>

                <div class="col-sm-10">
                    @yield('content')
                </div>
            </div>

            <div class = "new-good">
                <button class = "my-btn btn btn-primary btn-lg" data-toggle="modal" data-target="#addGood"><span class = "glyphicon glyphicon-plus"></span></button>
            </div>

            <div class="modal fade" id="addGood">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center">Добавить товар</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('store.addGood')}}">
                                {{csrf_field()}}
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Полное название товара</th>

                                            <td>
                                                <input type = "text" class = "form-control" name="product_name"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info btn-block" >Создать</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Отмена</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>