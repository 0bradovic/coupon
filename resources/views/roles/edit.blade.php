@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Role</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('update.role',['id' => $role->id]) }}" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" value="{{ $role->name }}">
            </div>
          

          <div class="form-group">
            <label>Select permissions</label>
              <select class="form-control select2" multiple="multiple" name="permissions[]" data-placeholder="Select a Permission"
                        style="width: 100%;">
                  @foreach($permissions as $permission)
                   
                        @if($role->permissions->contains($permission->id))
                            <option value="{{ $permission->id }}" selected="selected">{{ $permission->name }}</option>
                        @else
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endif
                    
                  @endforeach
                </select>
            </div>
            </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update Role</button>
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