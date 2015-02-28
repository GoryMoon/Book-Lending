<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booklending</title>
    
    <!-- FontAwesome -->
    {!! Html::style( asset('css/font-awesome/css/font-awesome.css')) !!}
    
    <!-- Bootstrap -->
    {!! Html::style( asset('css/bootstrap/bootstrap.min.css')) !!}

    <!-- Main Css -->
    {!! Html::style( asset('css/style.css')) !!}

    <!-- Special Css imports -->
    @yield('css')
    
    <!-- jQuery -->
    {!! Html::script( asset('js/jquery-1.11.1.min.js')) !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="content">
        @yield('nav')
        <div class="container">
            @yield('content')
        </div>
    </div>
    {!! Html::script( asset('js/bootstrap.min.js')) !!}
    {!! Html::script( asset('js/jquery-ui.min.js')) !!}
    {!! Html::script( asset('js/main.js')) !!}

    @yield('javascript')
</body>
