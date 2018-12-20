@extends('adminlte::page')

@section('title', 'Evelin')

@section('content_header')
    
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Offer</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('offer.store') }}" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Provide name">
            </div>
            <div class="form-group">
              <label for="highlight">Highlight</label>
              <input type="text" class="form-control" name="highlight" placeholder="Provide highlight">
            </div>
            <div class="form-group">
              <label for="summary">Summary</label>
              <input type="text" class="form-control" name="summary" placeholder="Provide summary">
            </div>
            <div class="form-group">
              <label for="detail">Detail</label>
              <input type="text" class="form-control" name="detail" placeholder="Provide detail">
            </div>
            <div class="form-group">
              <label for="link">Link</label>
              <input type="text" class="form-control" name="link" placeholder="Provide link">
            </div>
            <div class="form-group">
              <label for="startDate">Start Date</label>
              <input type="date" class="form-control" name="startDate" placeholder="Provide start date">
            </div>
            <div class="form-group">
              <label for="endDate">End Date</label>
              <input type="date" class="form-control" name="endDate" placeholder="Provide end date">
            </div>
            <div class="form-group">
              <label for="position">Position</label>
              <input type="number" class="form-control" name="position" placeholder="Provide position">
            </div>
            
            
            <div class="form-group">
              <label>Offer Type</label>
              <select class="form-control select2 " name="offer_type_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              @foreach($offerTypes as $t)
                <option value="{{$t->id}}">{{$t->name}}</option>
              @endforeach
              
              </select>
            </div>
            <div class="form-group">
              <label>Reseller</label>
              <select class="form-control select2 " name="user_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              @foreach($users as $u)
                <option value="{{$u->id}}">{{$u->name}}</option>
              @endforeach
              </select>
            </div>
            
            
          </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Add Offer</button>
          </div>
        </form>
      </div>
    </div>
    </div>
@stop