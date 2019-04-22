@extends('adminlte::page')

@section('title','Edit Offer Type')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="box box-info">
      <div style="position:absolute;top:0;right:0;z-index:1000;">
        @if($undoEdited != null)
          <a href="{{ route('undo.edited.offer-type',['id' => $offerType->id]) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo</a>
        @endif
      </div>
            <div class="box-header">
              <h3 class="box-title">Edit offer type {{ $offerType->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.offer-type', ['id' => $offerType->id]) }}" method="POST">
                <!-- text input -->
                <div class="form-group">
                  <label>Offer type name</label>
                  <input type="text" class="form-control" name="name" value="{{ $offerType->name }}">
                </div>

                <div class="form-group">
                    <label>Pick color:</label>
                    <input type="text" name="color" value="{{ $offerType->color }}" class="form-control my-colorpicker1">
                </div>
    

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Edit Offer Type</button>
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

