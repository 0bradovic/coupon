@extends('adminlte::page')

@section('title','Categories')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          <div style="position:absolute;top:0;right:0;z-index:1000;">
            @if($undoDeleted != null)
              <a href="{{ route('undo.deleted.category') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
            @endif
          </div>
          
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
                  <th>Slug</th>
                  <th>Image</th>
                  <th>Parent Category</th>
                  <th>Position</th>
                  <th>Created</th>
                  <th>Display</th>
                  <th>Brands</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <th>SEO</th>
                </tr>
                @foreach($categories as $category)
                <tr>
                  <td>{{ $category->sku }}</td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->slug }}</td>
                  <td>@if($category->img_src) <img src="{{$category->img_src}}" style="width:50px;height:50px;"> @else No photo @endif </td>
                  <td>@if($category->parent_id==null)<i>This is Parent Category.</i>
                  @else
                  @php $par = App\Category::find($category->parent_id); @endphp 
                  {{$par->name}}
                  @endif
                  </td>
                  <td>{{$category->position}}</td>
                  <td>{{ $category->created_at->toFormattedDateString() }}</td>
                  @if($category->display == 1)
                  <td> <a href="{{ route('display.category', ['id' => $category->id]) }}" class="btn btn-success">Yes</a></td>
                  @else
                  <td> <a href="{{ route('display.category', ['id' => $category->id]) }}" class="btn btn-danger">No</a></td>
                  @endif
                  <td><a href="{{ route('top-brands.category',['id' => $category->id]) }}"><i class="fa fa-registered"></i></a></td>
                  <td><a href="{{ route('edit.category', ['id' => $category->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.category', ['id' => $category->id]) }}"><i class="fa fa-trash"></i></a></td>
                  <td><a href="{{ route('category.seo.edit', ['id' => $category->id]) }}"><i class="fa fa-cog"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop