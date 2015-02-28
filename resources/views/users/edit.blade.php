@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera
            <small>Ändra användare</small>
        </h1>
    </div>
    @if($user->userLvl == 0)
        <div class="alert alert-danger" role="alert"><strong>Ej Behörighet</strong> Du har ej behörighet att ändra denna användaren</div>
    @else
        {!! Form::model($user, array('route' => array('admin.users.update', $user->id), 'method' => 'put', 'class' => 'form-horizontal')) !!}
            @if($errors->count() > 0)    
                <div class="alert alert-danger">
                    {!! $errors->first('username') !!}
                    <br>
                    {!! $errors->first('email') !!}
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('username', 'Användarnamn', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Användarnamn')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'E-Post', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'E-Post')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('userLvl', 'Behörighet', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('userLvl', array('1' => 'Lärare', '2' => 'Minimalt'), null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Spara', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                    {!! Html::linkRoute('admin.users.index', 'Avbryt', null, array('type' => 'button', 'class' => 'btn btn-danger')) !!}
                </div>
            </div>
        {!! Form::close() !!}
    @endif
@stop