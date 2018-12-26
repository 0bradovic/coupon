@extends('adminlte::page')

@section('title', 'Add Meta Tag')

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
          <h3 class="box-title">Add New Meta Tag</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        @if(Request::is('*/custom'))
        <form role="form"  action="{{ route('custom.seo.store') }}" method="POST">
        @elseif(Request::is('*/category'))
        <form role="form"  action="{{ route('category.seo.store') }}" method="POST">
        @else
        <form role="form"  action="{{ route('offer.seo.store') }}" method="POST">
        @endif
          <div class="box-body">
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" name="keywords" placeholder="Provide keywords">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" name="description" placeholder="Provide description">
            </div>
            <div class="form-group">
              <label for="og_title">Og-Title</label>
              <input type="text" class="form-control" name="og_title" placeholder="Provide og-title">
            </div>
            <div class="form-group">
              <label for="og_image">Og-Image</label>
              <input type="text" class="form-control" name="og_image" placeholder="Provide og-image">
            </div>
            <div class="form-group">
              <label for="og_description">Og-Description</label>
              <input type="text" class="form-control" name="og_description" placeholder="Provide og-description">
            </div>
            <div class="form-group">
            <input type="checkbox" name="is_default"> &nbsp;  <label for="is_default">Is Default</label>
              
            </div>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" name="title" placeholder="Provide title">
            </div>

            <!--Custom Meta Tag-->
            @if(Request::is('*/custom'))
            <div class="form-group">
              <label for="link">Link</label>
              <input type="text" class="form-control" name="link" placeholder="Provide link">
            </div>
            @elseif(Request::is('*/category'))
            <!--Category Meta Tag-->
            <div class="form-group">
              <label>Category</label>
              <select class="form-control select2 " name="category_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option value="">Select category</option>
              @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
              </select>
            </div>
            @else
            <!--Offer Meta Tag-->
            <div class="form-group">
              <label>Offer</label>
              <select class="form-control select2 " name="offer_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option value="">Select offer</option>
              @foreach($offers as $offer)
                    <option value="{{ $offer->id }}">{{ $offer->name }}</option>
              @endforeach
              </select>
            </div>
          </div>
          @endif
          {!! csrf_field() !!}

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Add Meta Tag</button>
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