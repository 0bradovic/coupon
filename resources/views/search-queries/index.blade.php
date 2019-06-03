@extends('adminlte::page')

@section('title','Search Queries')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
            <form method="get" action="{{ route('get.search-queries') }}" class="pull-right">
                <div class="form-group">
                    <label for="from">Date from</label>
                    <input type="date" name="from" @if(Request::get('from')) value="{{Request::get('from')}}" @endif>&nbsp;
                    <label for="to">Date to</label>
                    <input type="date" name="to" @if(Request::get('to')) value="{{Request::get('to')}}" @endif>&nbsp;
                    @csrf
                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">&nbsp;
                </div>
            </form>
        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Queries</h3>
              @include('layouts.messages')
              @include('layouts.errors')
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Query</th>
                  <th>Count</th>
                </tr>
                @foreach($queries as $query)
                <tr>
                  <td>{{ $query->query }}</td>
                  <td>{{ $query->total }}</td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop