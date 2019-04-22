@extends('adminlte::page')

@section('title','CustomPages')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">

       
          <div class="box">
          <div style="position:absolute;top:0;right:0;z-index:1000;">
            @if($undoDeleted != null)
              <a href="{{ route('undo.deleted.custom-page') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
            @endif
          </div>
            <div class="box-header">
              <h3 class="box-title">All Custom Pages</h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Active</th>
                  <th>Created At</th>
                  <th>Active</th>
                  <th>View</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($customPages as $customPage)
                <tr>
                  <td>{{ $customPage->id }}</td>
                  <td>{{ $customPage->name }}</td>
                  <td>{{ $customPage->position }}</td>
                  <td>{{ $customPage->active }}</td>
                  <td>{{ $customPage->created_at->toFormattedDateString() }}</td>
                  <td><input data-id="{{ $customPage->id }}" type="button" @if($customPage->active == 1)class="btn btn-success update-activity"  value="Active" @else class="btn btn-danger update-activity" value="Inactive" @endif>{!! csrf_field() !!}</td>
                  <td><a href="{{ route('show.customPage', ['id' => $customPage->id]) }}"><i class="fa fa-eye"></i></a></td>
                  <td><a href="{{ route('edit.customPage', ['id' => $customPage->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.customPage', ['id' => $customPage->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->

          </div>
          

          <!-- /.box -->
        </div>
        
          
@stop
@section('js')
<script>
$(document).ready(function(){
  
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
					  url: "/update/customPage/activity",
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
					  url: "/update/customPage/activity",
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