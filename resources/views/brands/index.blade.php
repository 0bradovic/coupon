@extends('adminlte::page')

@section('title','Brands')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Brands</h3>
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
                  <th>Image</th>
                  <th>Slug</th>
                  <th>Homepage</th>
                  <th>Offers</th>
                  <th>Created</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <th>SEO</th>
                </tr>
                @foreach($brands as $brand)
                <tr>
                  <td>{{ $brand->id }}</td>
                  <td>{{ $brand->name }}</td>
                  <td>
                    @if($brand->img_src)
                        <img src="{{ $brand->img_src }}" style="height:50px;width:auto;">
                    @else
                        No image
                    @endif
                  </td>
                  <td>{{ $brand->slug }}</td>
                  <td>
                    @if($brand->fp_position == null)
                      <button class="btn btn-primary add-fp-position">Add</button>
                      <form method="POST" action="{{ route('update-fp-position',['id' => $brand->id]) }}" style="display:none;">
                        <input type="number" name="position" placeholder="Position" style="width:70px;">
                        <button type="submit" class="btn btn-sm btn-primary">Add</button>
                        <button type="button" class="btn btn-sm btn-secondary cancel-btn">Cancel</button>
                        {!! csrf_field() !!}
                      </form>
                    @else
                      <div class="btn-group">
                        <button class="btn btn-warning edit-fp-position">Edit</button>
                        <a href="{{ route('remove-from-fp.brand',['id' => $brand->id]) }}" class="btn btn-danger">Remove</a>
                      </div>
                      <form method="POST" action="{{ route('update-fp-position',['id' => $brand->id]) }}" style="display:none;">
                        <input type="number" name="position" value="{{ $brand->fp_position }}" style="width:70px;">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <button type="button" class="btn btn-sm btn-secondary cancel-btn">Cancel</button>
                        {!! csrf_field() !!}
                      </form>
                    @endif
                  </td>
                  <td><a href="{{ route('offers.brand',['id' => $brand->id]) }}" class="btn btn-secondary">See {{ count($brand->offers) }} offers</a></td>
                  <td>{{ $brand->created_at->toFormattedDateString() }}</td>
                  <td><a href="{{ route('edit.brand', ['id' => $brand->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  <td><a href="{{ route('delete.brand', ['id' => $brand->id]) }}"><i class="fa fa-trash"></i></a></td>
                  <td><a href="{{ route('brand.seo.edit', ['id' => $brand->id]) }}"><i class="fa fa-cog"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop

@section('js')
<script type="text/javascript">
  $('.add-fp-position').click(function(){
    $(this).hide();
    $(this).next().show();
  });
  $('.edit-fp-position').click(function(){
    $(this).parent().hide();
    $(this).parent().next().show();
  });
  $('.cancel-btn').click(function(){
    $(this).parent().hide();
    $(this).parent().prev().show();
  });
</script>
@stop