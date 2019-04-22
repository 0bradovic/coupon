@extends('adminlte::page')

@section('title','Slider')

@section('content_header')
@stop

@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div style="position:absolute;top:0;right:0;z-index:1000;">
            @if($undoDeleted != null)
              <a href="{{ route('undo.deleted.slide') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
            @endif
          </div>
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
                  <th>Center text</th>
                  <th>Left text</th>
                  <th>Right text</th>
                  <th>Position</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($slides as $slide)
                <tr>
                  <td>{{ $slide->id }}</td>
                  <td><img src="{{ $slide->img_src }}" style="width:100px;height:50px;"></td>
                  <td @if($slide->center_text_color) style="color:{{ $slide->center_text_color }}" @endif>{{ $slide->center_text }}</td>
                  <td @if($slide->left_text_color) style="color:{{ $slide->left_text_color }}" @endif>{{ $slide->left_text }}</td>
                  <td @if($slide->right_text_color) style="color:{{ $slide->right_text_color }}" @endif>{{ $slide->right_text }}</td>
                  <td>{{ $slide->position }}</td>
                  <td><input data-id="{{ $slide->id }}" type="button" @if($slide->active == 1)class="btn btn-success update-activity"  value="Active" @else class="btn btn-danger update-activity" value="Inactive" @endif>{!! csrf_field() !!}</td>
                  <td><a href="{{ route('edit.slide', ['id' => $slide->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.slide', ['id' => $slide->id]) }}"><i class="fa fa-trash"></i></a></td>
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

@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
$(document).ready(function(){
  console.log($('input[name="_token"]').val());
  $('.update-activity').on('click',function(e){
    e.preventDefault();
   if($(this).val() == 'Active')
   {
    $(this).val('Inactive');
    $(this).removeClass('btn-success').addClass('btn-danger');
    var id = $(this).data('id');
    var active = 0;
    $.ajax({
					  method: "GET",
					  url: "/update/slide/activity",
					  data: {
                id:id,
                active:active,
					  	'_token': $('input[name="_token"]').val()
					  },
					});
   }
   else if($(this).val() == 'Inactive')
   {
    $(this).val('Active');
    $(this).removeClass('btn-danger').addClass('btn-success');
    var id = $(this).data('id');
    var active = 1;
    $.ajax({
					  method: "GET",
					  url: "/update/slide/activity",
					  data: {
                id:id,
                active:active,
					  	'_token': $('input[name="_token"]').val()
					  },
					});
   }
  });
});
  
</script>
@stop
