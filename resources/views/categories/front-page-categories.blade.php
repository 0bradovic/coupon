@extends('adminlte::page')

@section('title','Front Page Categories')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          <div style="position:absolute;top:0;right:0;z-index:1000;">
          </div>
          
            <div class="box-header">
              <h3 class="box-title">Front Page Categories</h3>
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
                  <th>Front Page Position</th>
                  <th>Display</th>
                </tr>
                @foreach($categories as $category)
                <tr>
                  <td>{{ $category->sku }}</td>
                  <td>{{ $category->name }}</td>
                  <td>
                    <button class="btn btn-default fp_position">{{$category->fp_position}}</button>
                    <form action="{{ route('update.front-page.category',['id' => $category->id]) }}" method="POST" class="hidden">
                        <input type="number" name="fp_position" value="{{ $category->fp_position }}" style="width:40px;">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        <button type="button" class="btn btn-default btn-sm cancle-btn">Cancle</button>
                        @csrf
                    </form>
                  </td>
                  @if($category->display == 1)
                  <td> <a href="{{ route('display.category', ['id' => $category->id]) }}" class="btn btn-success">Yes</a></td>
                  @else
                  <td> <a href="{{ route('display.category', ['id' => $category->id]) }}" class="btn btn-danger">No</a></td>
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

@section('js')
<script>
    $('.fp_position').click(function(){
        $(this).addClass('hidden');
        $(this).next().removeClass('hidden');
    })
    $('.cancle-btn').click(function(){
      $(this).parent().addClass('hidden');
      $(this).parent().prev().removeClass('hidden');
    })
</script>
@stop