@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>{{$book->title}} 
            <small>{{$book->author}}</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    {!! $book->image !!}
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th scope="row">ISBN</th>
                            <td>{{ $book->isbn }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Genre</th>
                            <td>{{ $book->genres }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Lediga</th>
                            <td>{{ $book->amount }}st</td>
                        </tr>
                    </table>
                    <p>
                        {!! $book->description !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Låna bok knapp -->
        </div>
    </div>
@stop