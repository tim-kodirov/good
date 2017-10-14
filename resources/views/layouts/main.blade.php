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

    <script type="text/javascript">

        var app = angular.module('myApp', []); 
    </script>

    @yield('scripts')
    
    
    
</head>
<body>
    <div ng-app = "myApp" ng-controller = "myCtrl">
        <div class="container">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        @if(Auth::guard('admin')->check()) Админ @elseif(Auth::guard('office')->check()) Офис @elseif(Auth::guard('storehouse')->check())  Склад @else web @endif <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{csrf_field()}}
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>

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

            
            @if(Auth::guard('office')->check())
                <div class = "new-store">
                    <button class = "my-btn btn btn-danger btn-lg" data-toggle="modal" data-target="#addStore"><span class = "fa fa-home"></span></button>
                </div>

                <div class="modal fade" id="addStore">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Создать новый склад</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('office.store.create')}}">
                                    {{csrf_field()}}
                                    <table class = "table">
                                        <tbody>
                                            <tr>
                                                <th>Полное название склада</th>
                                                <td>
                                                    <input type = "text" class = "form-control" name="storehouse_name" required />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Владелец склада</th>
                                                <td>
                                                    <select class = "form-control" name = "storehouse_owner" required>
                                                        <option ng-repeat = "owner in owners">@{{owner.name}}</option>
                                                    </select>
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

                <div class = "new-owner">
                    <button class = "my-btn btn btn-success btn-lg" data-toggle="modal" data-target="#addOwner"><span class = "fa fa-user-plus"></span></button>
                </div>

                <div class="modal fade" id="addOwner">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center">Добавить нового владельца</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="">
                                    {{csrf_field()}}
                                    <table class = "table">
                                        <tbody>
                                            <tr>
                                                <th>Имя</th>
                                                <td>
                                                    <input type = "text" class = "form-control" name="owner_name"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Логин</th>
                                                <td>
                                                    <input type = "text" class = "form-control" name="owner_login" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Пароль</th>
                                                <td>
                                                    <input type = "password" class = "form-control" name="owner_password" required/>
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
            @endif
        

            <div class = "new-good">
                <button class = "my-btn btn btn-primary btn-lg" data-toggle="modal" data-target="#addGood"><span class = "fa fa-cart-plus"></span></button>
            </div>

            <div class="modal fade" id="addGood">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center">Добавить товар</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{Auth::guard('storehouse')->check() ? route('store.product.create') : route('office.product.create')}}">
                                {{csrf_field()}}
                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <th>Полное название товара</th>

                                            <td>
                                                <input type = "text" class = "form-control" name="product_name" required/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Склад</th>

                                            <td>
                                                <select multiple class = "form-control">
                                                    <optgroup ng-repeat = "owner in owners" label = "@{{owner.name}}">
                                                        <option ng-repeat = "store in owner.stores">
                                                            @{{store.name}}
                                                        </option>
                                                    </optgroup>
                                                </select>
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