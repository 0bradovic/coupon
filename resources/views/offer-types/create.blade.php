@extends('adminlte::page')

@section('title','Create Offer Type')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('public/css/colorpicker.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Add new offer type</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('store.offer-type') }}" method="POST">
                <!-- text input -->
                <div class="form-group">
                  <label>Offer type name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter category name...">
                </div>

                <div class="form-group">
                    <label>Pick color:</label>
                    <input type="text" name="color" class="form-control my-colorpicker1">
                </div>
    

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Add Offer Type</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
<script src="{{ asset('public/js/colorpicker.js') }}"></script>

<script>
$(function () {
   

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    
    
  })
</script>
@stop

