@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera</h1>
    </div>

    <div class="row">
        @if(Auth::user()->userLvl < 1)
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-users fa-5x"></i>
                    <h3>Användare</h3>
                    <p>Här kan du hantera dina tillfälliga konton samt lägga till nya konton</p>
                    <p><a href="{{ URL::route('admin.users.index') }}" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera konton</a></p>
                    <p><a href="{{ URL::route('admin.users.create') }}" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till konto</a></p>
                </div>
            </div>
        </div>
        @endif
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-book fa-5x"></i>
                    <h3>Böcker</h3>
                    @if(Auth::user()->userLvl < 2)
                        <p>Här kan du hantera existerande böcker och lägga till nya böcker</p>
                        <p><a href="{{ URL::route('admin.books.index') }}" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera böcker</a></p>
                    @else
                        <p>Här kan du lägga till nya böcker</p>
                    @endif
                    <p><a href="{{ URL::route('admin.books.create') }}" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till en bok</a></p>
                </div>
            </div>
        </div>
        @if(Auth::user()->userLvl < 2)
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-user fa-5x"></i>
                    <h3>Författare</h3>
                    <div class="alert alert-danger" role="alert" style="display:inline-block;padding:5px;"><i class="fa fa-exclamation-triangle"></i> Ej implementerat</div>
                    <p>Här kan du hantera existerande författare och lägga till nya författare</p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera författare</a></p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till en författare</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <i class="fa fa-th-list fa-5x"></i>
                    <h3>Genrer</h3>
                    <div class="alert alert-danger" role="alert" style="display:inline-block;padding:5px;"><i class="fa fa-exclamation-triangle"></i> Ej implementerat</div>
                    <p>Här kan du hantera existerande genrer och lägga till nya genrer</p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-database"></i> Hantera genrer</a></p>
                    <p><a href="" class="btn btn-default btn-block"><i class="fa fa-plus"></i> Lägg till en genre</a></p>
                </div>
            </div>
        </div>
        @endif
    </div>
@stop