@extends('adminlte::page')

@section('title','Slider')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All slides</h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Up text</th>
                  <th>Down text</th>
                  <th>Center text</th>
                  <th>Left text</th>
                  <th>Right text</th>
                  <th>Link</th>
                  <th>Position</th>
                  <th>Active</th>
                </tr>
                @foreach($slides as $slide)
                <tr>
                  <td>{{ $slide->id }}</td>
                  <td><img src="{{ $slide->img_src }}" style="width:100px;height:50px;"></td>
                  <td>{{ $slide->up_text }}</td>
                  <td>{{ $slide->down_text }}</td>
                  <td>{{ $slide->center_text }}</td>
                  <td>{{ $slide->left_text }}</td>
                  <td>{{ $slide->right_text }}</td>
                  <td>{{ $slide->link }}</td>
                  <td>{{ $slide->position }}</td>
                  <td>{{ $slide->active }}</td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <a href="{{ route('preview.slider') }}" target="_blank" class="btn btn-primary">Preview slider</a>
        </div>
@stop
