@extends('adminlte::page')

@section('title','Tagline')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('/css/colorpicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/texteditor.css">
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Tagline</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.tagline') }}" method="POST">
                <!-- text input -->
                <!-- <div class="form-group">
                  <label>Tagline text</label>
                  <input type="text" class="form-control" name="text" value="{{ $tagline->text }}">
                </div> -->

                <div class="form-group">
                  <label for="detail">Tagline text</label>
                  <div>
                      <textarea name="text" class="textarea"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $tagline->text }}</textarea>
                  </div>
                </div>

                <div class="form-group">
                    <label>Pick text color:</label>
                    <input type="text" name="color" value="{{ $tagline->color }}" class="form-control my-colorpicker1">
                </div>
    

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update tagline</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
<script src="{{ asset('/js/colorpicker.js') }}"></script>
<script src="{{ asset('/js/texteditor.js') }}"></script>
<script>
$(function () {
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
  })
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
@stop

