@extends("layouts.default")

@section("main-content")
    <div class="page-header">
        <h1>Administrera
            <small>Lägg till en bok</small>
        </h1>
    </div>
    @if($errors->count() > 0)    
        <div class="alert alert-danger">
            {!! $errors->first('isbn') !!}
            <br>
            {!! $errors->first('title') !!}
        </div>
    @endif
    <div class="row">
        <div class="container col-sm-12 col-md-12">
            {!! Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'route' => 'admin.books.store', 'method' => 'post', 'enctype' => 'multipart/form-data')) !!}
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <label for="isbn" class="col-sm-1 control-label">ISBN <a href="" class="info" data-toggle="popover" data-content="ISBN är nummret som står ovanför strekkoden på baksidan utav boken eller inuti boken där info om tryck och publicerare" data-container="body" data-trigger="hover">?</a></label>
                    <div class="col-sm-3">
                        {!! Form::text('isbn', null, array('class' => 'form-control', 'placeholder' => 'ISBN nummret', 'required' => 'true', 'id' => 'isbn')) !!}
                    </div>
                    <div class="col-sm-1">
                        <button type="button" id="search-isbn" class="btn btn-default fa fa-search info" data-toggle="popover" data-content="Klicka för att söka på ISBN numeret" data-container="body" data-trigger="hover">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('title', 'Boktitel', array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) !!}
                    </div>
                    <div class="col-sm-1">
                        <button type="button" id="search-title" class="btn btn-default fa fa-search info" data-toggle="popover" data-content="Klicka för att söka på titeln" data-container="body" data-trigger="hover">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('author', 'Författare', array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::text('author', null, array('class' => 'form-control', 'placeholder' => 'Doe, John')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('genres', 'Genre', array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::select('genres[]', $genres, null, array('class' => 'form-control', 'id' => 'genre', 'multiple')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('description', "Beskrivning (Valfritt)", array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::textarea('description', null, array('class' => 'form-control', 'cols' => 15, 'rows' => 5)) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('amount', "Antal", array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::input('number', 'amount', 1, array('min' => 1, 'class' => 'form-control', 'placeholder' => 'Antal')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4"></div>
                    {!! Form::label('image', "Bokomslag", array('class' => 'col-sm-1 control-label')) !!}
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-info btn-file">
                                    Bläddra&hellip; {!! Form::file('image') !!}
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3">
                        <input type="hidden" name="imageUrl" id="imageUrl" value="">
                        {!! Form::submit('Lägg till', array('class' => 'btn btn-primary btn-lg btn-block')) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="modal fade" id="bookSearch" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="searchModalLabel">Välj Bok</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div> <!-- Modal end -->
@stop

@section("javascript")
    {!! Html::script( asset('select2/js/select2.min.js')) !!}
    {!! Html::script( asset('select2/js/i18n/sv.js')) !!}

    <script>
    $(function () {
        $("#genre").select2({
            tags: true,
            tokenSeparators: [',', ' '],
            language: "sv"
        });
        
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' filer valda' : label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
            
        });
    });
    </script>
@stop

@section("css")
    {!! Html::style( asset('select2/css/select2.min.css')) !!}
@stop