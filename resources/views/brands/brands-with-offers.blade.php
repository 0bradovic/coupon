@extends('adminlte::page')

@section('title','Brands with offers')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('back/css/style.css') }}" />
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          
              <form role="form" method="GET" action="{{ route('brands-with-offers') }}" class="pull-right" style="background-color:#fff;padding:5px;display: flex;
    align-items: center;
    width: 50%;
    justify-content: space-around;">
                  @csrf
                  
                  <div class="form-group">
                    <label>Select which offers to show</label>
                    <select class="form-control select2 filter" name="filter" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="all" @if(Request::get('filter') == 'all') selected="selected" @endif>Show All Brands</option>
                    <option value="live-offers" @if(Request::get('filter') == 'live-offers') selected="selected" @endif>Show only Brands with Live Offers</option>
                    <option value="live-offers-no-top" @if(Request::get('filter') == 'live-offers-no-top') selected="selected" @endif>Show only Brands with Live Offers and no Top Offer</option>
                    </select>
                  </div>
                  <input type="hidden" name="term" @if(Request::get('term')) value="{{ Request::get('term') }}" @else value="" @endif id="hdn-term-input">
                <div class="pull-right">
                  <button type="submit" class="btn btn-primary">Filter offers</button>
                </div>
              </form>  
            
        {{ $brands->appends(Request::except('page'))->links() }}
        <div >
              
              <div>Shows {{$brands->firstItem()}} to {{$brands->lastItem()}} brands of {{$brands->total()}}</div></br>
        </div>
        </div>

        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                Brands with offers
              </h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">

              <form method="get" action="{{ route('brands-with-offers') }}">
              <div class="input-group input-group-sm" style="width: 300px;">
              
                  <input type="text" name="term" id="search_term" class="form-control pull-right" @if(Request::get('term')) value="{{ Request::get('term') }}" @else placeholder="Search for a Brand..." @endif>
                  {!! csrf_field() !!}
                  <input type="hidden" name="filter" @if(Request::get('filter')) value="{{ Request::get('filter') }}" @else value="" @endif id="hdn-filter-input">
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
              @foreach($brands as $brand)
                <tr>
                    <th colspan="7" style="text-align:center;text-transform:uppercase;color:#FFA500;">{{ $brand->name }}</th>
                </tr>
                <tr>
                    <th>Offer name</th>
                    <th>Offer Detail</th>
                    <th>Type</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Created</th>
                    <th>Top Offer</th>
                </tr>
                    @if( !Request::get('filter') || Request::get('filter') == 'all')
                    @foreach($brand->offers as $offer)
                    <tr>
                        <td>{{ $offer->name }}</td>
                        <td>{!! $offer->detail !!}</td>
                        <td>@if($offer->offerType){{ $offer->offerType->name }}@else Don't have @endif</td>
                        <td>{{ $offer->dateFormat($offer->startDate)->toFormattedDateString() }}</td>
                        <td>@if($offer->endDate){{ $offer->dateFormat($offer->endDate)->toFormattedDateString() }}@else Ongoing @endif</td>
                        <td>{{ $offer->created_at->toFormattedDateString() }}</td>
                        <td> 
                            @if($offer->top == 0)
                            <a href="{{ route('set-top-offer.brand',['id' => $offer->id]) }}" class="btn btn-primary">Set</a>
                            @else
                            <a href="{{ route('unset-top-offer.brand',['id' => $offer->id]) }}" class="btn btn-warning">Unset</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @foreach($brand->liveOffers as $offer)
                    <tr>
                        <td>{{ $offer->name }}</td>
                        <td>{!! $offer->detail !!}</td>
                        <td>@if($offer->offerType){{ $offer->offerType->name }}@else Don't have @endif</td>
                        <td>{{ $offer->dateFormat($offer->startDate)->toFormattedDateString() }}</td>
                        <td>@if($offer->endDate){{ $offer->dateFormat($offer->endDate)->toFormattedDateString() }}@else Ongoing @endif</td>
                        <td>{{ $offer->created_at->toFormattedDateString() }}</td>
                        <td> 
                            @if($offer->top == 0)
                            <a href="{{ route('set-top-offer.brand',['id' => $offer->id]) }}" class="btn btn-primary">Set</a>
                            @else
                            <a href="{{ route('unset-top-offer.brand',['id' => $offer->id]) }}" class="btn btn-warning">Unset</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->

          </div>
          

          <!-- /.box -->
        </div>
        <div>{{ $brands->appends(Request::except('page'))->links() }}</div>
          <div>Shows {{$brands->firstItem()}} to {{$brands->lastItem()}} brands of {{$brands->total()}}</div></br>
          
          
@stop

@section('js')
<script src="{{ asset('back/js/main.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
<script>
    $(document).ready(function(){
      $('#hdn-filter-input').val($('select.filter').children("option:selected").val());
    })
    $('select.filter').change(function(){
      var filter = $(this).children("option:selected").val();
      $('#hdn-filter-input').val(filter);
    });
    $('#search_term').keyup(function(e){
      var term = e.target.value;
      $('#hdn-term-input').val(term);
    })
</script>
@endsection