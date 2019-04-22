@extends('adminlte::page')

@section('title','Edit Category')

@section('content_header')
@stop

@section('content')

    <div class="box box-warning">
      @if($undoEdited != null)
        <div style="position:absolute;top:0;right:0;z-index:1000;">
            <a href="{{ route('undo.edited.category',['id' => $category->id]) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo</a>
        </div>
      @endif
            <div class="box-header with-border">
              <h3 class="box-title">Edit category {{ $category->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.category', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                  <label>Category name</label>
                  <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                </div>
                <div class="form-group">
                     <label for="position">Position</label>
                     <input type="number" class="form-control" name="position" value="{{$category->position}}">
                </div>
                @if($category->img_src)
                 <div class="form-group">
                    <img src="{{$category->img_src}}" style="width:150px;height:150px;">
                 </div>
                @endif
                <div class="form-group">
                    <label>Upload category image (optional)</label>
                    <input type="file" name="photo">
                </div>

                <div class="form-group">
                  <label>Select parent category (optional)</label>
                  <select class="form-control" name="parent_id">
                    <option value="">No parent category</option>
                    @foreach($categories as $parentCategory)
                        @if($category->parent_id)
                            @if($category->parent_id == $parentCategory->id)
                                <option value="{{$parentCategory->id}}" selected="selected">{{ $parentCategory->name }}</option>
                            @else
                                <option value="{{$parentCategory->id}}">{{ $parentCategory->name }}</option>
                            @endif
                        @else
                            <option value="{{$parentCategory->id}}">{{ $parentCategory->name }}</option>
                        @endif
                    @endforeach
                  </select>
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Edit Category</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>

@stop