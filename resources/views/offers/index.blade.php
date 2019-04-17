@extends('adminlte::page')

@section('title','Offers')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">

        {{ $offers->appends(Request::except('page'))->links() }}
        <div style="overflow:hidden">
              <a href="{{ route('offers.index') }}" class="btn btn-primary pull-right">ALL</a> 
              <a href="{{ route('live.offer') }}" class="btn btn-primary pull-right">LIVE</a> 
              <a href="{{ route('expired.offer') }}" class="btn btn-primary pull-right">EXPIRED</a>
              <a href="{{ route('most.popular.offers') }}" class="btn btn-primary pull-right">MOST POPULAR</a>
              <div>Shows {{$offers->firstItem()}} to {{$offers->lastItem()}} offers of {{$offers->total()}}</div></br>
        </div>

          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All offers</h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">

              <form method="get" action="{{ route('search.offers') }}">
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
            <div class="box-body table-responsive no-padding">
            </br>
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Detail</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Type</th>
                  <th>Author</th>
                  <th>Clicks p.24h</th>
                  <th>Date/Time Last Edited</th>
                  <th>Display</th>
                  <th>Copy</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <th>SEO</th>
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
                  <td>{{$offer->click}}</td>
                  @if($offer->updated_at == $offer->created_at)
                  <td>Not edited</td>
                  @else
                  <td>{{ $offer->updated_at->toDayDateTimeString() }}</td>
                  @endif
                  @if($offer->display==1)
                  <td> <a href="{{ route('display.offer', ['id' => $offer->id]) }}" class="btn btn-success">Yes</a></td>
                  @else
                  <td> <a href="{{ route('display.offer', ['id' => $offer->id]) }}" class="btn btn-danger">No</a></td>
                  @endif
                  <td><a href="{{ route('copy.offer', ['id' => $offer->id]) }}"><i class="fa fa-clone"></i></a></td>
                  <td><a href="{{ route('edit.offer', ['id' => $offer->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.offer', ['id' => $offer->id]) }}"><i class="fa fa-trash"></i></a></td>
                  <td><a href="{{ route('offer.seo.edit', ['id' => $offer->id]) }}"><i class="fa fa-cog"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->

          </div>
          

          <!-- /.box -->
        </div>
        <div>{{ $offers->appends(Request::except('page'))->links() }}</div>
          <div>Shows {{$offers->firstItem()}} to {{$offers->lastItem()}} offers of {{$offers->total()}}</div></br>
          
          
@stop