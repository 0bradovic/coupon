@extends('adminlte::page')

@section('title','Edit Search Text')

@section('content_header')
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Edit Search Text</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.search-text') }}" method="POST">
                <!-- text input -->
                <div class="form-group">
                    <label>Front Page Search Text</label>
                    <input type="text" class="form-control" name="front_page_search_text" value="{{ $siteSetings->front_page_search_text }}">
                </div>

                <div class="form-group">
                    <label>Category Page Search Text</label>
                    <input type="text" class="form-control" name="category_page_search_text" value="{{ $siteSetings->category_page_search_text }}">
                </div>

                <div class="form-group">
                    <label>Brand Page Search Text</label>
                    <input type="text" class="form-control" name="brand_page_search_text" value="{{ $siteSetings->brand_page_search_text }}">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update</button>
              </div>
                {!! csrf_field() !!}
              </form>
              
            </div>
            <!-- /.box-body -->
          </div>
@stop


