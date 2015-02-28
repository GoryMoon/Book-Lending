@extends('layouts.default')

@section('css')

    {!! Html::style( asset('css/remind.css')) !!}

@stop

@section('main-content')

    {!! Form::open(array('action' => 'RemindersController@postRemind', 'class' => 'form-remind')) !!}
        <h2 class="form-remind-heading">Glömt lösenord?</h2>
        {!! Form::email('email', null, array('class' => 'form-control top', 'placeholder' => 'E-post')) !!}
        {!! Form::submit('Skicka återsällning', array('class' => 'btn btn-lg btn-primary btn-block bottom')) !!}
        {!! Session::get('error') != null ? '<div class="alert alert-danger" role="alert">' . Session::get('error') . '</div>': ''!!}
        {!! Session::get('status') != null ? '<div class="alert alert-success" role="alert">' . Session::get('status') . '</div>': '' !!}
    {!! Form::close() !!}

@stop