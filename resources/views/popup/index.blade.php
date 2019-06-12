@extends('adminlte::page')

@section('title','Subscription Popup')

@section('content_header')
@stop

@section('css')
    <link rel="stylesheet" href="/css/texteditor.css">
@stop

@section('content')
    <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Subscription Popup</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @include('layouts.messages')
            @include('layouts.errors')
              <form role="form" action="{{ route('update.popup') }}" method="POST">
                <!-- text input -->
                <div class="form-group">
                  <label>Popup title</label>
                  <input type="text" class="form-control" name="title" value="{{ $popup->title }}">
                </div>

                <div class="form-group">
                    <label>Second title</label>
                    <input type="text" name="second_title" value="{{ $popup->second_title }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="detail">First section (this is text before email input)</label>
                    <div>
                        <textarea name="first_section" class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $popup->first_section }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="detail">Second section (this is text after email input)</label>
                    <div>
                        <textarea name="second_section" class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $popup->second_section }}</textarea>
                    </div>
                </div>
    
                <div class="form-group">
                    <label>Button text</label>
                    <input type="text" name="button" value="{{ $popup->button }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Success Message</label>
                    <input type="text" name="success_message" value="{{ $popup->success_message }}" class="form-control">
                </div>

              <div class="form-group">
                    <button id="submit" class="btn btn-primary">Update popup</button>
              </div>

                {!! csrf_field() !!}
              </form>
            </div>
            <!-- /.box-body -->
          </div>
@stop
@section('js')
    <script src="{{ asset('/js/texteditor.js') }}"></script>
    <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
@stop

