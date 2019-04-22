@extends('adminlte::page')

@section('title','Offer types')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div style="position:absolute;top:0;right:0;z-index:1000;">
            @if($undoDeleted != null)
              <a href="{{ route('undo.deleted.offer-type') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
            @endif
          </div>
            <div class="box-header">
              <h3 class="box-title">All offer types</h3>
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
                  <th>Color</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($offerTypes as $offerType)
                <tr>
                  <td>{{ $offerType->id }}</td>
                  <td>{{ $offerType->name }}</td>
                  <td><div style="width:25px;height:25px;background-color:{{$offerType->color}}"></div></td>
                  <td>{{ $offerType->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.offer-type', ['id' => $offerType->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.offer-type', ['id' => $offerType->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop