@extends('layouts.default')

@section('main-content')
    <div class="page-header">
        <h1>{{$book->title}} 
            <small>{{$book->author}}</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4" id="previewImage">
                    {!! $book->image !!}
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <table class="table" id="book-info">
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

        <div class="col-lg-2 col-md-2 col-sm-2">
            <!-- Låna bok knapp -->
        </div>
    </div>
@stop