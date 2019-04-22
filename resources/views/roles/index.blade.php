@extends('adminlte::page')

@section('title','Roles')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div style="position:absolute;top:0;right:0;z-index:1000;">
              @if($undoDeleted != null)
                <a href="{{ route('undo.deleted.role') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
              @endif
            </div>
            <div class="box-header">
              <h3 class="box-title">All roles</h3>
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
                  <th>Name</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($roles as $role)
                <tr>
                  <td>{{ $role->id }}</td>
                  <td>{{ $role->name }}</td>
                  <td>{{ $role->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.role', ['id' => $role->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.role', ['id' => $role->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop