@extends('layouts.nonav')

@section('nav')
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li class="{{ Request::is('/') ? 'active': '' }}">{{ HTML::linkRoute('home', "Hem") }}</li>
                    <li><a href="#">Bläddra</a></li>
                </ul>
                <form action="" method="get" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="search" id="search-bar" class="form-control" name="s" placeholder="Sök på titlar &amp; författare">
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Välj Genre <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Sci-Fi</a></li>
                            <li><a href="#">Dekare</a></li>
                            <li><a href="#">Barn</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right nav">
                    @if (Auth::check())
                        <li class="dropdown {{ Request::is('admin*') ? 'active': '' }}">
                            <a href="" id="dropAdmin" aria-haspopup="true" role="button" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown">
                                Administrera <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropAdmin">
                                <li class="{{ Request::is('admin') ? 'active': '' }}">{{ HTML::linkRoute('admin', 'Administrera') }}</li>
                                <li class="divider"></li>
                                <li class="dropdown-header"><i class="fa fa-book"></i> Böcker</li>
                                @if(Auth::user()->userLvl < 2)
                                    <li class="{{ Request::is('*books') ? 'active': '' }}">         <a href=""><i class="fa fa-database"></i> Hantera böcker</a></li>
                                @endif

                                <li class="{{ Request::is('*books/create') ? 'active': '' }}">      <a href=""><i class="fa fa-plus"></i> Lägg till en bok</a></li>

                                @if(Auth::user()->userLvl < 2)
                                    <li class="divider"></li>
                                    <li class="dropdown-header"><i class="fa fa-users"></i> Användare</li>
                                    <li class="{{ Request::is('*users') ? 'active': '' }}">         <a href="{{ URL::route('admin.users.index') }}"><i class="fa fa-database"></i> Hantera konton</a></li>
                                    <li class="{{ Request::is('*users/create') ? 'active': '' }}">  <a href="{{ URL::route('admin.users.create') }}"><i class="fa fa-plus"></i> Lägg till konto</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header"><i class="fa fa-th-list"></i> Genrer</li>
                                    <li class="{{ Request::is('*genre') ? 'active': '' }}">         <a href=""><i class="fa fa-database"></i> Hantera genrer</a></li>
                                    <li class="{{ Request::is('*genre/create') ? 'active': '' }}">  <a href=""><i class="fa fa-plus"></i> Lägg till genrer</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="" id="dropUser" aria-haspopup="true" role="button" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropUser">
                                <li>{{ HTML::linkRoute('logout', 'Logga ut') }}</li>
                            </ul>
                        </li>
                    @else
                        <li><a href="#" data-toggle="modal" data-target="#loginModal">Logga in</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@stop

@section('content')
    @yield('main-content')

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="loginModalLabel">Logga in</h4>
                </div>
                <div id="signin-form-model" class="modal-body">
                    <div id="login-error" role="alert"></div>
                    {{ Form::open(array('class' => 'form-signin', 'role' => 'form', 'route' => 'sessions.store')) }}
                        {{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'E-post', 'required')) }}
                        {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Lösenord', 'required')) }}
                        <div class="checkbox-area">
                            {{ Form::checkbox('remember', 1, null, array('id' => 'remember')) }}
                            {{ Form::label('remember', 'Kom ihåg mig') }}
                            <br>    
                            {{ HTML::link('password/remind', 'Glömt lösenordet?') }}
                        </div>
                        {{ Form::button('Logga in', array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'login-btn', 'type' => 'submit', 'data-loading-text' => '<i class=\'fa fa-spinner fa-spin\'></i> Loading...')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        var showLoginDefault = {{ Session::get('login') == null ? 'false': 'true' }};
    </script>
@stop