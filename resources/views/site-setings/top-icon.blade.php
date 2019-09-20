@extends('adminlte::page')

@section('title','Change Top Offer Icon')

@section('content_header')
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
           
                <h3 class="box-title">Change Top Offer Icon</h3>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
                <form role="form" action="{{ route('update.top-icon') }}" method="POST" enctype="multipart/form-data">
                    <!-- text input -->
                    <div class="form-group">
                        <label>Change Top Offer Icon</label>
                        <input type="file" name="top_icon">
                    </div>
                    <div class="form-group">
                        <img src="{{ $siteSetings->top_icon }}" style="height:100px;width:auto;">
                    </div>

                <div class="form-group">
                        <button id="submit" class="btn btn-primary">Update Top Offer Icon</button>
                </div>
                    {!! csrf_field() !!}
                </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop


