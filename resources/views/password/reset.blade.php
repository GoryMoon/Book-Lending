@extends('layouts.default')

@section('css')

    {!! Html::style( asset('css/remind.css')) !!}

@stop

@section('main-content')

    {!! Form::open(array('action' => 'RemindersController@postReset', 'class' => 'form-remind')) !!}
        <h2 class="form-remind-heading">Återställ lösenordet</h2>
        {!! Form::hidden('token', $token) !!}
        {!! Form::email('email', null, array('class' => 'form-control top', 'placeholder' => 'E-post')) !!}
        {!! Form::password('password', array('class' => 'form-control both', 'placeholder' => 'Lösenord')) !!}
        {!! Form::password('password_confirmation', array('class' => 'form-control both', 'placeholder' => 'Bekräfta Lösenordet')) !!}
        {!! Form::submit('Updatera Lösenordet', array('class' => 'btn btn-lg btn-primary btn-block bottom')) !!}
        {!! Session::get('error') != null ? '<div class="alert alert-danger" role="alert">' . Session::get('error') . '</div>': ''!!}

    {!! Form::close() !!}

@stop
