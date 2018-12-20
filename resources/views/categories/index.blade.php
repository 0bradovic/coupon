@extends('adminlte::page')

@section('title','Categories')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All categories</h3>
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
                  <th>Image</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($categories as $category)
                <tr>
                  <td>{{ $category->sku }}</td>
                  <td>{{ $category->name }}</td>
                  <td>@if($category->img_src) <img src="{{$category->img_src}}" style="width:50px;height:50px;"> @else No photo @endif </td>
                  <td>{{ $category->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.category', ['id' => $category->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.category', ['id' => $category->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop