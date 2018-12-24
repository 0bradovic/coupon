@extends('adminlte::page')

@section('title','Create Slide')

@section('content_header')
@stop

@section('css')
    <link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet">
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
                    <label>Upload offer image (optional)</label>
                    <input type="file" name="photo">
                </div>

                <div class="form-group">
                    <label for="up_text">Up text</label>
                    <input type="text" class="form-control" name="up_text" placeholder="Enter up text...">
                </div>

                <div class="form-group">
                    <label for="down_text">Down text</label>
                    <input type="text" class="form-control" name="down_text" placeholder="Enter down text...">
                </div>

                <div class="form-group">
                    <label for="center_text">Center text</label>
                    <input type="text" class="form-control" name="center_text" placeholder="Enter center text...">
                </div>

                <div class="form-group">
                    <label for="left_text">Left text</label>
                    <input type="text" class="form-control" name="left_text" placeholder="Enter left text...">
                </div>

                <div class="form-group">
                    <label for="right_text">Right text</label>
                    <input type="text" class="form-control" name="right_text" placeholder="Enter right text...">
                </div>

                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" name="link" placeholder="Enter link...">
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="number" class="form-control" name="position" placeholder="Enter position for slide...">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Add Slide</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop


