@extends('adminlte::page')

@section('title','Download offers')

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

            <form method="get" action="{{ route('search.offers.download') }}">
            <div class="input-group input-group-sm" style="width: 300px;">
            
                <input type="text" name="term" class="form-control pull-right" placeholder="Search offers by name or id...">
                {!! csrf_field() !!}
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </form>
            
          </div>
          <!-- /.box-header -->
          <form method="POST" id="download" action="{{ route('download.offer') }}">
          @csrf
          <button type="submit" class="btn btn-primary" id="selected_button">Download selected</button>
          <div class="box-body table-responsive no-padding">
          </br>
            <table class="table table-hover">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Detail</th>
                <th>Start</th>
                <th>End</th>
                <th>Select</th>
              </tr>
              @foreach($offers as $offer)
              <tr>
                <td>{{ $offer->sku }}</td>
                <td>{{ $offer->name }}</td>
                <td>{!! $offer->detail !!}</td>
                <td>{{ $offer->dateFormat($offer->startDate)->toFormattedDateString() }}</td>
                <td>@if($offer->endDate){{ $offer->dateFormat($offer->endDate)->toFormattedDateString() }}@else Ongoing @endif</td>
                <td><input type="checkbox" name="offers[]" class="select-offer" value="{{ $offer->id }}"></td>
              </tr>
              @endforeach
            </table>
          </div>
          </form>
          <!-- /.box-body -->

        </div>
        </div>
</div>
@stop