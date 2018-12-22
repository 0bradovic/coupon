@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
    
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add New User</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('store.user') }}" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Provide name">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Provide email">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Provide password">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Password repeat</label>
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
            </div>

            <div class="form-group">
            <label>Select roles</label>
              <select class="form-control select2" multiple="multiple" name="roles[]" data-placeholder="Select a Role"
                        style="width: 100%;">
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
            </div>
          </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>
    </div>
    </div>
@stop
@section('js')
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
  </script>
  @stop