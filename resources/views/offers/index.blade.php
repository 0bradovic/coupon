@extends('adminlte::page')

@section('title', 'Evelin')

@section('content_header')

@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All Offers</h3>
              <div class="box-tools">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Sku</th>
                  <th>Highlight</th>
                  <th>Summary</th>
                  <th>Detail</th>
                  <th>Link</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Position</th>
                  <th>Offer Type</th>
                  <th>User</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($offers as $offer)
                <tr>
                  <td>{{ $offer->id }}</td>
                  <td>{{ $offer->name }}</td>
                  <td>{{ $offer->sku }}</td>
                  <td>{{ $offer->highlight }}</td>
                  <td>{{ $offer->summary }}</td>
                  <td>{{ $offer->detail }}</td>
                  <td>{{ $offer->link }}</td>
                  <td>{{ $offer->startDate }}</td>
                  <td>{{ $offer->endDate }}</td>
                  <td>{{ $offer->position }}</td>
                  <td>{{ $offer->offerType->name }}</td>
                  <td>{{ $offer->user->name }}</td>

                  <td>{{ $offer->created_at->toFormattedDateString() }}</td>
                  <td>{{ $offer->updated_at->toFormattedDateString() }}</td>
                  <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="#"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop