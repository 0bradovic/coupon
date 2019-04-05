@extends('adminlte::page')

@section('title', 'Upload Offer')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Upload Offer</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('upload.offer') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            @csrf
            <div class="form-group">
              <label>Upload CSV file</label>
              <input type="file" name="csv">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Upload Offer</button>
          </div>
        </form>
      </div>
    </div>
    </div>
@stop