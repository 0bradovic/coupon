@extends('adminlte::page')

@section('title','Redirect Popup')

@section('content_header')
@stop

@section('css')
    <link rel="stylesheet" href="/css/texteditor.css">
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Redirect Popup</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.redirect-popup') }}" method="POST">

                <div class="form-group">
                    <label for="detail">Popup text</label>
                    <div>
                        <textarea name="text" class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $popup->text }}</textarea>
                    </div>
                </div>
    
                <div class="form-group">
                    <label>Button text</label>
                    <input type="text" name="button_text" value="{{ $popup->button_text }}" class="form-control">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update popup</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
    <script src="{{ asset('/js/texteditor.js') }}"></script>
    <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
@stop

