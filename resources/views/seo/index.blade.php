@extends('adminlte::page')

@section('title','MetaTags')

@section('content_header')
@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <div class="box-header">
              <h3 class="box-title">All Meta Tags</h3>
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
                  <th>Keywords</th>
                  <th>Description</th>
                  <th>Og-Title</th>
                  <th>Og-Image</th>
                  <th>Og-Description</th>
                  <th>Is Default</th>
                  @if(Request::is('*/custom'))
                  <th>Link</th>
                  @elseif(Request::is('*/category'))
                  <th>Category</th>
                  @else
                  <th>Offer</th>
                  @endif
                  <th>Title</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                @foreach($metaTags as $metaTag)
                <tr>
                  <td>{{ $metaTag->id }}</td>
                  <td>{{ $metaTag->keywords }}</td>
                  <td>{{ $metaTag->description }}</td>
                  <td>{{ $metaTag->og_title }}</td>
                  <td>{{ $metaTag->og_image }}</td>
                  <td>{{ $metaTag->og_description }}</td>
                  <td>{{ $metaTag->is_default }}</td>
                  @if(Request::is('*/custom'))
                  <td>{{ $metaTag->link }}</td>
                  @elseif(Request::is('*/category'))
                  @if($metaTag->category) <td>{{ $metaTag->category->name }}</td> @else <td></td> @endif
                  @else
                  @if($metaTag->offer) <td>{{ $metaTag->offer->name }}</td>@else <td></td> @endif
                  @endif
                  <td>{{ $metaTag->title }}</td>
                  @if(Request::is('*/custom'))
                  <td><a href="{{ route('custom.seo.edit', ['id' => $metaTag->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  @elseif(Request::is('*/category'))
                  <td><a href="{{ route('category.seo.edit', ['id' => $metaTag->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  @else
                  <td><a href="{{ route('offer.seo.edit', ['id' => $metaTag->id]) }}"><i class="fa fa-pencil"></i></a></td>
                  @endif
                  <td><a href="{{ route('seo.delete', ['id' => $metaTag->id]) }}"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop