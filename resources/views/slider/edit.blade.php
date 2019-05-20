@extends('adminlte::page')

@section('title','Edit Slide')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/texteditor.css">
@stop

@section('content')
    <div class="box box-info">
        <div style="position:absolute;top:0;right:0;z-index:1000;">
            @if($undoEdited != null)
              <a href="{{ route('undo.edited.slide',['id' => $slide->id]) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo</a>
            @endif
        </div>
            <div class="box-header">
              <h3 class="box-title">Edit slide</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.slide',['id' => $slide->id]) }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                 <div class="form-group">
                    <img src="{{$slide->img_src}}" style="width:250px;height:150px;">
                 </div>
                
                <div class="form-group">
                    <label>Upload new slide image (optional)</label>
                    <input type="file" name="photo">
                </div>

                <div class="form-group">
                    <label for="alt_tag">Slide alt tag</label>
                    <input type="text" class="form-control" name="alt_tag" value="{{ $slide->alt_tag }}">
                </div>

                <!-- <div class="form-group" style="display:none">
                    <label for="up_text">Up text</label>
                    <input type="text" class="form-control" name="up_text" value="{{ $slide->up_text }}">
                </div> -->

                <div class="form-group">
                  <label for="detail">Up text</label>
                  <div>
                      <textarea name="up_text" class="textarea"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $slide->up_text }}</textarea>
                  </div>
                </div>

                <div class="form-group" style="display:none">
                    <label>Pick up text color:</label>
                    <input type="text" name="up_text_color" class="form-control my-colorpicker1" value="{{ $slide->up_text_color }}">
                </div>

                <div class="form-group" style="display:none">
                    <label for="down_text">Down text</label>
                    <input type="text" class="form-control" name="down_text" value="{{ $slide->down_text }}">
                </div>

                <div class="form-group" style="display:none">
                    <label>Pick down text color:</label>
                    <input type="text" name="down_text_color" class="form-control my-colorpicker1" value="{{ $slide->down_text_color }}">
                </div>

                <!-- <div class="form-group">
                    <label for="center_text">Center text</label>
                    <input type="text" class="form-control" name="center_text" value="{{ $slide->center_text }}">
                </div> -->

                 <div class="form-group">
                  <label for="detail">Up text</label>
                  <div>
                      <textarea name="center_text" class="textarea"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $slide->center_text }}</textarea>
                  </div>
                </div>

                <div class="form-group">
                    <label>Pick center text color:</label>
                    <input type="text" name="center_text_color" class="form-control my-colorpicker1" value="{{ $slide->center_text_color }}">
                </div>

                <div class="form-group">
                    <label for="left_text">Left text</label>
                    <input type="text" class="form-control" name="left_text" value="{{ $slide->left_text }}">
                </div>

                <div class="form-group">
                    <label>Pick left text color:</label>
                    <input type="text" name="left_text_color" class="form-control my-colorpicker1" value="{{ $slide->left_text_color }}">
                </div>

                <div class="form-group">
                    <label for="right_text">Right text</label>
                    <input type="text" class="form-control" name="right_text" value="{{ $slide->right_text }}">
                </div>

                <div class="form-group">
                    <label>Pick right text color:</label>
                    <input type="text" name="right_text_color" class="form-control my-colorpicker1" value="{{ $slide->right_text_color }}">
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="number" class="form-control" name="position" value="{{ $slide->position }}">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update Slide</button>
              </div>
				<input type="hidden" name="link">
                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
<script src="{{ asset('js/colorpicker.js') }}"></script>
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

