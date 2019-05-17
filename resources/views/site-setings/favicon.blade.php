@extends('adminlte::page')

@if($siteSetings->favicon == null)

    @section('title','Upload Favicon')

@else

    @section('title','Change Favicon')

@endif

@section('content_header')
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
            @if($siteSetings->favicon == null)
                <h3 class="box-title">Upload Favicon</h3>
            @else
                <h3 class="box-title">Change Favicon</h3>
            @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
            @if($siteSetings->favicon == null)
              <form role="form" action="{{ route('store.favicon') }}" method="POST" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                    <label>Upload favicon</label>
                    <input type="file" name="favicon">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Upload Favicon</button>
              </div>
                {!! csrf_field() !!}
              </form>
              @else
                <form role="form" action="{{ route('update.favicon') }}" method="POST" enctype="multipart/form-data">
                    <!-- text input -->
                    <div class="form-group">
                        <label>Change favicon</label>
                        <input type="file" name="favicon">
                    </div>
                    <div class="form-group">
                        <img src="{{ $siteSetings->favicon }}" style="height:100px;width:auto;">
                    </div>

                <div class="form-group">
                        <button id="submit" class="btn btn-primary">Update Favicon</button>
                </div>
                    {!! csrf_field() !!}
                </form>
              @endif
            </div>
            <!-- /.box-body -->
          </div>
@stop


