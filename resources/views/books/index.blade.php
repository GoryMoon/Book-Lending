@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Administrera
            <small>Hantera Böcker</small>
        </h1>
        
    </div>
    <a href="{!! URL::route('admin.books.create') !!}" class="btn btn-success">Lägg till bok</a>
    <br>
    <br>
    <div class="table-responsive">
        @if($books->toArray())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>ISBN</th>
                    <th>Författare</th>
                    <th>Genre</th>
                    <th>Beskriving</th>
                    <th>Mängd</th>
                    <th>Omslag</th>
                    <th>Hantera</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td width="150px">{{ $book->title }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{!! $book->genres !!}</td>
                    <td>{!! $book->description !!}</td>
                    <td>{{ $book->amount }}</td>
                    <td>{!! $book->image !!}</td>
                    <td width="100px">
                        <a style="display:inline-block" href="{{ URL::route('admin.books.edit', array($book->id)) }}" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i></a>
                        <a style="display:inline-block" type="button" class="btn btn-danger deleteBtn" data-id="{{ $book->id }}"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-info">Inga böcker som kan ändras</div>
        @endif
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteModalLabel">Ta bort boken?</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => array('admin.books.destroy', '@id@'), 'method' => 'delete')) !!}
                        <div class="alert alert-warning">
                            <strong>Är du säker att du vill ta bort boken?</strong>
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
