@extends('adminlte::page')

@section('title','CustomPages')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">

       
          <div class="box">
          
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
                  <th>Updated At</th>
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
                  <td>{{ $customPage->updated_at->toFormattedDateString() }}</td>
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