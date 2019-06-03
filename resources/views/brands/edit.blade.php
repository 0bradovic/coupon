@extends('adminlte::page')

@section('title','Edit Brand')

@section('content_header')
@stop

@section('content')

    <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Edit brand {{ $brand->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.brand',['id' => $brand->id]) }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                  <label>Brand name</label>
                  <input type="text" class="form-control" name="name" value="{{ $brand->name }}">
                </div>

                 @if($brand->img_src)
                 <div class="form-group">
                    <img src="{{$brand->img_src}}" style="width:150px;height:150px;">
                 </div>
                @endif

                <div class="form-group">
                    <label>Change brand image</label>
                    <input type="file" name="image">
                </div>
                
              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update Brand</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>

@stop
