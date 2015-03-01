@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>Alla böcker</h1>
    </div>

    <div class="row">
        @foreach($books as $book)
            <div class="col-sm-3 col-md-3">
                <a href="{{ URL::route('books.show', array($book->id)) }}" class="thumbnail">
                    {!! $book->image !!}
                    <div class="caption">
                        <h3>{{ $book->title }}</h3>
                        <p>{{ $book->author }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <style>
        .thumbnail {
            min-height: 440px;
        }
    </style>
@stop
