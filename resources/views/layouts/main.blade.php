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

    <link rel="stylesheet" type="text/css" href="style.css">
    
    @yield('styles')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('scripts')
    
    
    
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row margin-top-30">
                <div class="col-sm-2">
                    <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="20">
                      <li class="active"><a href="#">Остаток</a></li>
                      <li><a href="#">Расходы</a></li>
                      <li><a href="#">Приходы</a></li>
                    </ul>
                </div>

                <div class="col-sm-10">
                    @yield('content')
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>