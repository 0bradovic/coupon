@extends('adminlte::page')

@section('title','Exclude keywords')

@section('content_header')
@stop

@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Update default keywords to exclude</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('layouts.messages')
        @include('layouts.errors')
        <form role="form" action="{{ route('update.exclude-keywords') }}" method="POST">
            <!-- text input -->
            <div class="form-group">
                <label>Default keywords to exclude</label>
                <input type="text" class="form-control" name="keywords" value="{{ $excludeKeywords->keywords }}">
            </div>
            <div class="form-group">
                <button id="submit" class="btn btn-primary">Update Keywords</button>
            </div>

            {!! csrf_field() !!}
        </form>
    </div>
@stop