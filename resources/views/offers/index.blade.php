@extends('adminlte::page')

@section('title','Offers')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
        <div>{{ $offers->links() }}</div>
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All offers</h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">
              <a href="{{ route('offers.index') }}" class="btn btn-primary">ALL</a> &nbsp; 
              <a href="{{ route('live.offer') }}" class="btn btn-primary">LIVE</a> &nbsp;
              <a href="{{ route('expired.offer') }}" class="btn btn-primary">EXPIRED</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Detail</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Type</th>
                  <th>Author</th>
                  <th>Position</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  @can("manage seo")
                  <th>Seo</th>
                  @endcan
                </tr>
                @foreach($offers as $offer)
                <tr>
                  <td>{{ $offer->sku }}</td>
                  <td>{{ $offer->name }}</td>
                  <td>{!! $offer->detail !!}</td>
                  <td>{{ $offer->dateFormat($offer->startDate)->toFormattedDateString() }}</td>
                  <td>@if($offer->endDate){{ $offer->dateFormat($offer->endDate)->toFormattedDateString() }}@else Ongoing @endif</td>
                  <td>@if($offer->offerType){{ $offer->offerType->name }}@else Don't have @endif</td>
                  <td>{{ $offer->user->name }}</td>
                  <td>{{$offer->position}}</td>
                  <td><a href="{{ route('edit.offer', ['id' => $offer->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.offer', ['id' => $offer->id]) }}"><i class="fa fa-trash"></i></a></td>
                  @can("manage seo")
                  <td><a href="{{ route('offer.seo.edit', ['id' => $offer->id]) }}"><i class="fa fa-cog"></i></a></td>
                  @endcan
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->

          </div>
          <div>{{ $offers->links() }}</div>
          

          <!-- /.box -->
        </div>
@stop