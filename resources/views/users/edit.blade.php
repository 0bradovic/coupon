@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
      <div style="position:absolute;top:0;right:0;z-index:1000;">
        @if($undoEdited != null)
          <a href="{{ route('undo.edited.user',['id' => $user->id]) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Undo</a>
        @endif
      </div>
        <div class="box-header with-border">
          <h3 class="box-title">Edit User</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('update.user',['id' => $user->id]) }}" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Provide new password if you want...">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Password repeat</label>
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password...">
            </div>

            <div class="form-group">
            <label>Select roles</label>
              <select class="form-control select2" multiple="multiple" name="roles[]" data-placeholder="Select a Role"
                        style="width: 100%;">
                  @foreach($roles as $role)
                    @if(count($user->roles) > 0)
                    @foreach($user->roles as $r)
                        @if($r->id == $role->id)
                            <option value="{{ $role->id }}" selected="selected">{{ $role->name }}</option>
                        @else
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif
                    @endforeach
                    @else
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                  @endforeach
                </select>
            </div>
          </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update User</button>
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