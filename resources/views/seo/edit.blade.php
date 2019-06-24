@extends('adminlte::page')

@section('title', 'Edit Meta Tag')

@section('content_header')
@section('css')
  <link rel="stylesheet" href="/public/css/texteditor.css">
  <link rel="stylesheet" href="/public/css/displayNone.css">
@stop
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Meta Tag</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        @if(Request::is('*/custom/*'))
        <form role="form"  action="{{ route('custom.seo.update',['id' => $metaTag->id]) }}') }}" method="POST">
        @elseif(Request::is('*/category/*'))
        <form role="form"  action="{{ route('category.seo.update',['id' => $metaTag->id]) }}') }}" method="POST">
        @elseif(Request::is('*/brand/*'))
        <form role="form"  action="{{ route('brand.seo.update',['id' => $metaTag->id]) }}') }}" method="POST">
        @else
        <form role="form"  action="{{ route('offer.seo.update',['id' => $metaTag->id]) }}') }}" method="POST">
        @endif
        <div class="box-body">
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" name="keywords" value="{{ $metaTag->keywords }}">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" name="description" value="{{ $metaTag->description }}">
            </div>
            <div class="form-group">
              <label for="og_title">Og-Title</label>
              <input type="text" class="form-control" name="og_title" value="{{ $metaTag->og_title }}">
            </div>
            <div class="form-group">
              <label for="og_image">Og-Image</label>
              <input type="text" class="form-control" name="og_image" value="{{ $metaTag->og_image }}">
            </div>
            <div class="form-group">
              <label for="og_description">Og-Description</label>
              <input type="text" class="form-control" name="og_description" value="{{ $metaTag->og_description }}">
            </div>
            <div class="form-group">
            @if($metaTag->is_default == true)
            <input type="checkbox" name="is_default" checked="checked"> &nbsp;  <label for="is_default">Is Default</label>
            @else
              <input type="checkbox" name="is_default" > &nbsp;  <label for="is_default">Is Default</label>
            @endif
            </div>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" name="title" value="{{ $metaTag->title }}">
            </div>
            

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update Meta Tag</button>
            @if(Request::is('*/offer/*'))
            <a href="{{ route('offer.seo.index')}}" class="btn btn-xs btn-info pull-right">Skip</a>
            @elseif(Request::is('*/category/*'))
            <a href="{{ route('category.seo.index')}}" class="btn btn-xs btn-info pull-right">Skip</a>
            @elseif(Request::is('*/brand/*'))
            <a href="{{ route('brand.seo.index')}}" class="btn btn-xs btn-info pull-right">Skip</a>
            @endif
          </div>
        </form>
      </div>
    </div>
    </div>
@stop
@section('js')
<script src="{{ asset('public/js/texteditor.js') }}">
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