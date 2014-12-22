@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera</h1>
    </div>

    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-users fa-5x"></i>
                    <h3>Användare</h3>
                    <p>Här kan du hantera dina tillfälliga konton samt lägga till nya konton</p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera konton</a></p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till konto</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-book fa-5x"></i>
                    <h3>Böcker</h3>
                    <p>Här kan du hantera existerande böcker och lägga till nya böcker</p>
                    <p><a href="{{ URL::route('admin.users.index') }}" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera böcker</a></p>
                    <p><a href="{{ URL::route('admin.users.create') }}" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till en bok</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-th-list fa-5x"></i>
                    <h3>Genrer</h3>
                    <p>Här kan du hantera existerande genrer och lägga till nya genrer</p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera genrer</a></p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till en genre</a></p>
                </div>
            </div>
        </div>
    </div>
@stop