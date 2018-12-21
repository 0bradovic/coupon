@extends('adminlte::page')

@section('title','Tags')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All tags</h3>
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
                @foreach($tags as $tag)
                <tr>
                  <td>{{ $tag->id }}</td>
                  <td>{{ $tag->name }}</td>
                  <td>{{ $tag->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.tag', ['id' => $tag->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.tag', ['id' => $tag->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop