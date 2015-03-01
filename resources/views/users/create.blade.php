@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera
            <small>Lägg till användare</small> 
        </h1>
    </div>
    @if($errors->count() > 0)    
        <div class="alert alert-danger">
            {!! $errors->first('username') !!}
            {!! $errors->first('email') !!}
        </div>
    @endif
    {!! Form::open(array('route' => 'admin.users.store', 'method' => 'post', 'class' => 'form-horizontal')) !!}
        <div class="form-group">
            {!! Form::label('username', 'Användarnamn', array('class' => 'control-label col-sm-2')) !!}
            <div class="col-sm-8">
                {!! Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Användarnamn')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'E-Post', array('class' => 'control-label col-sm-2')) !!}
            <div class="col-sm-8">
                {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'E-Post')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('userLvl', 'Behörighet', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-8">
                {!! Form::select('userLvl', array('1' => 'Lärare', '2' => 'Minimalt'), 2, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('passwordType', 'Typ av Lösenord', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-8">
                {!! Form::select('passwordType', array('0' => 'Skriv in', '1' => 'Generera Lösenord', '2' => 'Be användaren mata in lösenord'), Input::get('pw') ,array('class' => 'form-control', 'id' => 'pwtype')) !!}
            </div>
        </div>
        <div class="form-group" id="passwordField">
            {!! Form::label('password', 'Lösenord', array('class' => 'control-label col-sm-2')) !!}
            <div class="col-sm-8">
                {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Lösenord')) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Spara', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Html::linkRoute('admin.users.index', 'Avbryt', null, array('type' => 'button', 'class' => 'btn btn-danger')) !!}
            </div>
        </div>

    {!! Form::close() !!}
@stop


@section('javascript')
    <script>


    $('#pwtype').change(function(e) {
        console.log("hh")
    });

    </script>

@stop