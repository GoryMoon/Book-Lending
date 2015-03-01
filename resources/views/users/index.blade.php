@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera
            <small>Hantera användare</small>
        </h1>
        
    </div>
    <a href="{!! URL::route('admin.users.create') !!}" class="btn btn-success">Lägg till användare</a>
    <br>
    <br>
    <div class="table-responsive">
        @if($users->toArray())
        <table class="table table-striped table-hover">
            <tr>
                <th>Användare</th>
                <th>E-Post</th>
                <th>Behörighet</th>
                <th>Hantera</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{!! $user->username !!}</td>
                <td>{!! $user->email !!}</td>
                <td>{!! $user->userLvl == 1 ? "Lärare": "Minimalt" !!}</td>
                <td>
                    <a href="{!! URL::route('admin.users.edit', array($user->id)) !!}" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i></a>
                    <a type="button" class="btn btn-danger deleteBtn" data-id="{!! $user->id !!}"><i class="fa fa-times"></i></a>
                </td>
            </tr>
            @endforeach

        </table>
        @else
            <div class="alert alert-info">Inga användare som kan ändras</div>
        @endif
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteModalLabel">Ta bort användaren?</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => array('admin.users.destroy', '@id@'), 'method' => 'delete')) !!}
                        <div class="alert alert-warning">
                            <strong>Är du säker att du vill ta bort användaren?</strong>
                        </div>
                        {!! Form::submit('Ta Bort', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#deleteModal">Avbryt</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function($) {
            var form = $('#deleteModal form');
            form.attr('data-default', form.attr('action'));

            $('.deleteBtn').click(function(e) {
                var form = $('#deleteModal form');
                form.attr('action', form.attr('data-default'));

                var value = form.attr('action');
                console.log(e);
                value = value.replace("@id@", $(this).attr('data-id'));
                form.attr('action', value);

                $('#deleteModal').modal('show');
            });
        });
    </script>
@stop
