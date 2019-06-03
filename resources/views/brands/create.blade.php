@extends('adminlte::page')

@section('title','Create Brand')

@section('content_header')
@stop

@section('content')

    <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add new brand</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                  <label>Brand name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter brand name...">
                </div>

                <div class="form-group">
                    <label>Upload brand image</label>
                    <input type="file" name="image">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Add Brand</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>

@stop
