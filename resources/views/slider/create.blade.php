@extends('adminlte::page')

@section('title','Create Slide')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700,700i|Exo:400,400i,700,700i|Kodchasan:400,400i,700,700i|Lato:400,400i,700,700i|Montserrat:400,400i,700,700i|Muli:400,400i,700,700i|Open+Sans:400,400i,700,700i|Poppins:400,400i,700,700i|Roboto:400,400i,700,700i|Titillium+Web:400,400i,700,700i&display=swap" rel="stylesheet">
@stop
@section('content')
    <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Add new slide</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('store.slide') }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                    <label>Upload slide image</label>
                    <input type="file" name="photo">
                </div>

                <div class="form-group">
                    <label for="alt_tag">Slide alt tag</label>
                    <input type="text" class="form-control" name="alt_tag" placeholder="Enter image alt tag...">
                </div>

                <div class="form-group" style="display:none;">
                    <label for="down_text">Up text</label>
                    <input type="text" class="form-control" name="up_text" placeholder="Enter up text...">
                </div>

                <div class="form-group" style="display:none;">
                    <label>Pick up text color:</label>
                    <input type="text" name="up_text_color" class="form-control my-colorpicker1">
                </div>

                <div class="form-group" style="display:none;">
                    <label for="down_text">Slide text</label>
                    <input type="text" class="form-control" name="down_text" placeholder="Enter down text...">
                </div>

                <div class="form-group" style="display:none;">
                    <label>Pick text color:</label>
                    <input type="text" name="down_text_color" class="form-control my-colorpicker1">
                </div>

                <div class="form-group">
                    <label for="center_text">Center text</label>
                    <input type="text" class="form-control" name="center_text" placeholder="Enter center text...">
                </div>

                <div class="form-group">
                    <label>Pick center text color:</label>
                    <input type="text" name="center_text_color" class="form-control my-colorpicker1">
                </div>

                <div class="form-group">
                    <label for="left_text">Left text</label>
                    <input type="text" class="form-control" name="left_text" placeholder="Enter left text...">
                </div>

                <div class="form-group">
                    <label>Pick left text color:</label>
                    <input type="text" name="left_text_color" class="form-control my-colorpicker1">
                </div>

                <div class="form-group">
                    <label for="right_text">Right text</label>
                    <input type="text" class="form-control" name="right_text" placeholder="Enter right text...">
                </div>

                <div class="form-group">
                    <label>Pick right text color:</label>
                    <input type="text" name="right_text_color" class="form-control my-colorpicker1">
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="number" class="form-control" name="position" placeholder="Enter position for slide...">
                </div>

                <div class="form-group" style="background:#ECF0F5; padding:10px;">
                  <p id="font-example">Example of choosen font family and font size</p>
                </div>

                <div class="form-group">
                  <label>Select font</label>
                  <select class="form-control select2 font-family" name="font_family" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="">Select font</option>
                  @foreach($fonts as $font)
                    <option value="{{$font}}">{{$font}}</option>
                  @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Select font size</label>
                  <select class="form-control select2 font-size" name="font_size" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="">Select font size</option>
                 @for($i = 8; $i < 27; $i++)
                    <option value="{{$i}}px">{{$i}} px</option>
                  @endfor
                  </select>
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Add Slide</button>
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
<script>
$(function () {
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
<script>

$('select.font-family').change(function(){
  var font = $(this).children("option:selected").val();
  $('#font-example').css('font-family',font);
});

$('select.font-size').change(function(){
  var size = $(this).children("option:selected").val();
  $('#font-example').css('font-size',size);
});

</script>
@stop

