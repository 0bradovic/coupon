@extends('adminlte::page')

@section('title','Edit Slide')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="box box-info">
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

                <div class="form-group" style="display:none">
                    <label for="up_text">Up text</label>
                    <input type="text" class="form-control" name="up_text" value="{{ $slide->up_text }}">
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

                <div class="form-group">
                    <label for="center_text">Center text</label>
                    <input type="text" class="form-control" name="center_text" value="{{ $slide->center_text }}">
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
                    <label for="link">Link</label>
                    <input type="text" class="form-control" name="link" value="{{ $slide->link }}">
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="number" class="form-control" name="position" value="{{ $slide->position }}">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update Slide</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
<script src="{{ asset('js/colorpicker.js') }}"></script>

<script>
$(function () {
   

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    
    
  })
</script>
@stop

