@extends('adminlte::page')

@section('title','Users')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All users</h3>
              @include('layouts.messages')
              @include('layouts.errors')
              <div class="box-tools">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if(count($user->roles) > 0)
                        @foreach($user->roles as $role)
                            {{ $role->name }},
                        @endforeach
                    @else
                        This user doesn't have roles
                    @endif
                  </td>
                  <td>{{ $user->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.user', ['id' => $user->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  @if($user->id == Auth::user()->id)
                  <td>You can't delete yourself</td>
                  @else
                  <td><a href="{{ route('delete.user', ['id' => $user->id]) }}"><i class="fa fa-trash"></i></a></td>
                  @endif
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop