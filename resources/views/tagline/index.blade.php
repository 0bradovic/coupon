@extends('adminlte::page')

@section('title','Tagline')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('/css/colorpicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/texteditor.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700,700i|Exo:400,400i,700,700i|Kodchasan:400,400i,700,700i|Lato:400,400i,700,700i|Montserrat:400,400i,700,700i|Muli:400,400i,700,700i|Open+Sans:400,400i,700,700i|Poppins:400,400i,700,700i|Roboto:400,400i,700,700i|Titillium+Web:400,400i,700,700i&display=swap" rel="stylesheet">
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
                <div class="form-group">
                  <label>Tagline text</label>
                  <input type="text" class="form-control" name="text" value="{{ $tagline->text }}">
                </div>

                <div class="form-group">
                    <label>Pick text color:</label>
                    <input type="text" name="color" value="{{ $tagline->color }}" class="form-control my-colorpicker1">
                </div>

                <div class="form-group" style="background:#ECF0F5; padding:10px;">
                  <p id="font-example" style="@if($tagline->font_family)font-family:'{{$tagline->font_family}}',sans-serif;@endif @if($tagline->font_size) font-size:{{$tagline->font_size}} @endif">Example of choosen font family and font size</p>
                </div>

                <div class="form-group">
                  <label>Select font</label>
                  <select class="form-control select2 font-family" name="font_family" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="">Select font</option>
                  @foreach($fonts as $font)
                    @if($font == $tagline->font_family)
                    <option selected="selected" value="{{$font}}">{{$font}}</option>
                    @else
                    <option value="{{$font}}">{{$font}}</option>
                    @endif
                  @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Select font size</label>
                  <select class="form-control select2 font-size" name="font_size" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="">Select font size</option>
                 @for($i = 8; $i < 27; $i++)
                    @if($i.'px' == $tagline->font_size)
                    <option selected="selected" value="{{$i}}px">{{$i}} px</option>
                    @else
                    <option value="{{$i}}px">{{$i}} px</option>
                    @endif
                  @endfor
                  </select>
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

