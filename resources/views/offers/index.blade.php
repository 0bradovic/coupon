@extends('adminlte::page')

@section('title','Offers')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All offers</h3>
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
                  <th>Highlight</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Type</th>
                  <th>Author</th>
                  <th>Position</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($offers as $offer)
                <tr>
                  <td>{{ $offer->sku }}</td>
                  <td>{{ $offer->name }}</td>
                  <td>{{ $offer->highlight }}</td>
                  <td>{{ $offer->dateFormat($offer->startDate)->toFormattedDateString() }}</td>
                  <td>{{ $offer->dateFormat($offer->endDate)->toFormattedDateString() }}</td>
                  <td>{{ $offer->offerType->name }}</td>
                  <td>{{ $offer->user->name }}</td>
                  <td>{{$offer->position}}</td>
                  <td><a href="{{ route('edit.offer', ['id' => $offer->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.offer', ['id' => $offer->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop