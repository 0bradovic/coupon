@extends('adminlte::page')

@section('title', 'Edit Offer')

@section('content_header')
@section('css')
  <link rel="stylesheet" href="/css/texteditor.css">
  <link rel="stylesheet" href="/css/displayNone.css">
@stop
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Offer</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('update.offer',['id' => $offer->id]) }}" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" value="{{ $offer->name }}">
            </div>
            <div class="form-group" style="display:none">
              <label for="highlight">Highlight</label>
              <input type="text" class="form-control" name="highlight" value="{{ $offer->highlight }}">
            </div>
            <div class="form-group" style="display:none">
              <label for="summary">Summary</label>
              <textarea class="form-control" name="summary">{{ $offer->summary }}</textarea>
            </div>
            <div class="form-group">
              <label for="detail">Detail</label>
              <div>
                  <textarea name="detail" class="textarea" placeholder="Place some text here"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $offer->detail }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="link">Link</label>
              <input type="text" class="form-control" name="link" value="{{ $offer->link }}">
            </div>
            <div class="form-group">
              <label for="startDate">Start Date</label>
              <input type="date" class="form-control" name="startDate" value="{{ $offer->dateFormat($offer->startDate)->toDateString() }}">
            </div>
            <div class="form-group">
              <label for="endDate">End Date</label>
              <input type="date" class="form-control" name="endDate" @if($offer->endDate) value="{{ $offer->dateFormat($offer->endDate)->toDateString() }}"@endif>
            </div>
            <div class="form-group">
              <label for="position">Position</label>
              <input type="number" class="form-control" name="position" value="{{ $offer->position }}">
            </div>
            <div class="form-group">
              <label>Offer Type</label>
              <select class="form-control select2 " name="offer_type_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option value="">Select offer type</option>
              @foreach($offerTypes as $t)
                @if($t->id == $offer->offer_type_id)
                <option value="{{$t->id}}" selected="selected">{{$t->name}}</option>
                @else
                <option value="{{$t->id}}">{{$t->name}}</option>
                @endif
              @endforeach
              
              </select>
            </div>
            <div class="form-group">
            <label>Select categories</label>
              <select class="form-control select2" multiple="multiple" name="categories[]" data-placeholder="Select a Category"
                        style="width: 100%;">
                  @foreach($categories as $category)
                    @foreach($offer->categories as $cat)
                        @if($category->id == $cat->id)
                            <option value="{{ $category->id }}" selected="selected">{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endif
                    @endforeach
                  @endforeach
                </select>
            </div>

            <div class="form-group">
            <label>Select tags</label>
              <select class="form-control select2" multiple="multiple" name="tags[]" data-placeholder="Select a Tag"
                        style="width: 100%;">
                  @foreach($tags as $tag)
                    @foreach($offer->tags as $t)
                        @if($tag->id == $t->id)
                            <option value="{{ $tag->id }}" selected="selected">{{ $tag->name }}</option>
                        @else
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endif
                    @endforeach
                  @endforeach
                </select>
            </div>
            
            @if($offer->img_src)
                 <div class="form-group">
                    <img src="{{$offer->img_src}}" style="width:150px;height:150px;">
                 </div>
                @endif
                <div class="form-group">
                    <label>Upload new offer image (optional)</label>
                    <input type="file" name="photo">
                </div>

          </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update Offer</button>
          </div>
        </form>
      </div>
    </div>
    </div>
@stop
@section('js')
<script src="{{ asset('js/texteditor.js') }}">
    </script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })

  
</script>

@stop