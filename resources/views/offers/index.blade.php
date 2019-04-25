@extends('adminlte::page')

@section('title','Offers')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('back/css/style.css') }}" />
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          
              <form role="form" method="GET" action="{{ route('get-offers') }}" class="pull-right" style="background-color:#fff;padding:5px;display: flex;
    align-items: center;
    width: 50%;
    justify-content: space-around;">
                  @csrf
                  
                  <div class="form-group">
                    <label>Select parent category</label>
                    <select class="form-control select2 " name="category" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="all" @if(Request::get('category') == null || Request::get('category') == 'all') selected="selected" @endif>All</option>
                    @foreach($categories as $cat)
                      <option value="{{$cat->id}}" @if(Request::get('category') == $cat->id) selected="selected" @endif >{{$cat->name}}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select which offers to show</label>
                    <select class="form-control select2 " name="offers" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="all" @if(Request::get('offers') == 'all') selected="selected" @endif>All</option>
                    <option value="most-popular" @if(Request::get('offers') == 'most-popular') selected="selected" @endif>Most popular</option>
                    <option value="live" @if(Request::get('offers') == 'live') selected="selected" @endif>Live</option>
                    <option value="expired" @if(Request::get('offers') == 'expired') selected="selected" @endif>Expired</option>
                    </select>
                  </div>
                
                <div class="pull-right">
                  <button type="submit" class="btn btn-primary">Filter offers</button>
                </div>
              </form>  
            
            
        {{ $offers->appends(Request::except('page'))->links() }}
        <div >
              
              <div>Shows {{$offers->firstItem()}} to {{$offers->lastItem()}} offers of {{$offers->total()}}</div></br>
        </div>

          <div class="box">
            <div style="z-index:1000;">
              @if($undoDeleted != null)
                <a href="{{ route('undo.deleted.offer') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo last deleted</a>
              @endif
            </div>
            <div class="box-header">
              <h3 class="box-title">
                Offers
              </h3>
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

@section('js')
<script src="{{ asset('back/js/main.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
@endsection