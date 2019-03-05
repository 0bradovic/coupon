@extends('adminlte::page')

@section('title', 'Add Offer')

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
          <h3 class="box-title">Add New Offer</h3>
        </div>
        @include('layouts.errors')
        @include('layouts.messages')
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form"  action="{{ route('store.offer') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Provide name">
            </div>
            <div class="form-group" style="display:none">
              <label for="highlight">Highlight</label>
              <input type="text" class="form-control" name="highlight" placeholder="Provide highlight,max 20 characters...">
            </div>
            <div class="form-group" style="display:none">
              <label for="summary">Summary</label>
              <textarea class="form-control" name="summary" placeholder="Provide summary,max 50 characters..."></textarea>
            </div>
            
            <div class="form-group">
              <label for="detail">Detail</label>
              <div>
                  <textarea name="detail" class="textarea" placeholder="Place some text here"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
            </div>


            <div class="form-group">
              <label for="link">Link</label>
              <input type="text" class="form-control" name="link" placeholder="Provide link">
            </div>
            <div class="form-group">
              <label for="startDate">Start Date</label>
              <input type="date" class="form-control" name="startDate" placeholder="Provide start date">
            </div>
            <div class="form-group">
              <label for="endDate">End Date</label>
              <input type="date" class="form-control" name="endDate" placeholder="Provide end date">
            </div>
            <div class="form-group">
              <label for="position">Position</label>
              <input type="number" class="form-control" name="position" placeholder="Provide position">
            </div>
            <div class="form-group">
              <label>Offer Type</label>
              <select class="form-control select2 " name="offer_type_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option value="">Select offer type</option>
              @foreach($offerTypes as $t)
                <option value="{{$t->id}}">{{$t->name}}</option>
              @endforeach
              
              </select>
            </div>
            <div class="form-group">
            <label>Select categories</label>
              <select class="form-control select2" multiple="multiple" name="categories[]" data-placeholder="Select a Category"
                        style="width: 100%;">
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
            </div>

            <div class="form-group">
            <label>Select tags</label>
              <select class="form-control select2" multiple="multiple" name="tags[]" data-placeholder="Select a Tag"
                        style="width: 100%;">
                  @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Upload offer image (optional)</label>
                <input type="file" name="photo">
            </div>
            
          </div>

          {!! csrf_field() !!}

          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Add Offer</button>
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