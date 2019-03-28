@extends('adminlte::page')

@section('title','Create Category')

@section('content_header')
@stop

@section('content')

    <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add new category</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                  <label>Category name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter category name...">
                </div>
                <div class="form-group">
                     <label for="position">Position</label>
                     <input type="number" class="form-control" name="position" placeholder="Provide position">
                </div>

                <div class="form-group">
                    <label>Upload category image (optional)</label>
                    <input type="file" name="photo">
                </div>
                
                

                <div class="form-group">
                  <label>Select parent category (optional)</label>
                  <select class="form-control" name="parent_id">
                    <option value="" disabled selected>Select...</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Display?</label><br>
                  <input checked type="radio" name="display" value="1">Yes
                  <input type="radio" name="display" value="0">No
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Add Category</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>

@stop