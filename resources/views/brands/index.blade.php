@extends('adminlte::page')

@section('title','Brands')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Brands</h3>
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
                  <th>Slug</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <th>SEO</th>
                </tr>
                @foreach($brands as $brand)
                <tr>
                  <td>{{ $brand->id }}</td>
                  <td>{{ $brand->name }}</td>
                  <td>
                    @if($brand->img_src)
                        <img src="{{ $brand->img_src }}" style="height:50px;width:auto;">
                    @else
                        No image
                    @endif
                  </td>
                  <td>{{ $brand->slug }}</td>
                  <td>{{ $brand->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.brand', ['id' => $brand->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.brand', ['id' => $brand->id]) }}"><i class="fa fa-trash"></i></a></td>
                  <td><a href="{{ route('brand.seo.edit', ['id' => $brand->id]) }}"><i class="fa fa-cog"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop