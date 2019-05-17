@extends('adminlte::page')

@if($siteSetings->logo == null)

    @section('title','Upload Logo')

@else

    @section('title','Change Logo')

@endif

@section('content_header')
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
            @if($siteSetings->logo == null)
                <h3 class="box-title">Upload Logo</h3>
            @else
                <h3 class="box-title">Change Logo</h3>
            @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
            @if($siteSetings->logo == null)
              <form role="form" action="{{ route('store.logo') }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                    <label>Upload logo</label>
                    <input type="file" name="logo">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Upload Logo</button>
              </div>
                {!! csrf_field() !!}
              </form>
              @else
                <form role="form" action="{{ route('update.logo') }}" method="POST" enctype="multipart/form-data">
                    <!-- text input -->
                    <div class="form-group">
                        <label>Change logo</label>
                        <input type="file" name="logo">
                    </div>
                    <div class="form-group">
                        <img src="{{ $siteSetings->logo }}" style="height:100px;width:auto;">
                    </div>

                <div class="form-group">
                        <button id="submit" class="btn btn-primary">Update Logo</button>
                </div>
                    {!! csrf_field() !!}
                </form>
              @endif
            </div>
            <!-- /.box-body -->
          </div>
@stop


