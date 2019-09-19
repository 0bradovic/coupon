@extends('adminlte::page')

@section('title','Category Top Brands');

@section('css')
<link href="https://cdn.jsdelivr.net/npm/dual-listbox/dist/dual-listbox.css" type="text/css" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit {{ $category->name }} top brands</h3>
    </div>
    <div class="box-body">
        @include('layouts.messages')
        @include('layouts.errors')
        <input type="hidden" name="category_id" id="category-id" value="{{ $category->id }}">
        <form role="form" action="{{ route('top-brands.category.update',['id' => $category->id]) }}" method="POST">
            <div class="form-group">
                <div style="background-color:#FFFFFF;width:100%;">
                    <select class="select1" multiple>
                        @foreach($brands as $brand)
                        @if(!$category->brands->contains($brand->id))
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            {!! csrf_field() !!}
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/dual-listbox/dist/dual-listbox.min.js"></script>
<script type="text/javascript">
    function fetchCategoryBrands(){
        var catId = $('#category-id').val();
        var brands = [];
        $.ajax({
            method:"GET",
            async: false,
            url:"/category-brands/"+catId,
        }).done (function(res){
            $.each(res.brands,function(k,v){
                brands.push(v);
            });
            console.log(res);
        });
        return brands;
    } 
    var brandsArray = fetchCategoryBrands();
    var optionsArray = [];
    $.each(brandsArray,function(k,v){
        var obj = {
            text:v.name,
            value:v.id,
            selected:true,
        }
        optionsArray.push(obj);
    });
    let dualListbox = new DualListbox('.select1', {
    addEvent: function(value) { // Should use the event listeners
       var selected = $('.dual-listbox__item[data-id='+value+']');
       var name = selected.text();
       selected.append('<div id='+value+'><input style="max-width:70px;" placeholder="Position" type="number" name="brands['+name+'][position]"><input type="hidden" value="'+value+'" name="brands['+name+'][id]"></div>')
    },
    removeEvent: function(value) { // Should use the event listeners
        $('#'+value).remove();
    },
    availableTitle: 'Select Brands',
    selectedTitle: 'Selected Brands',
    addButtonText: 'Add',
    removeButtonText: 'Remove',
    addAllButtonText: 'Add All',
    removeAllButtonText: 'Remove All',

    options:optionsArray
});

$('.dual-listbox__selected').children('li').each(function(){
    var brand = brandsArray.find(x => x.id == $(this).data('id'));
    $(this).append('<div id='+brand.id+'><input style="max-width:70px;" placeholder="Position" type="number" value="'+brand.pivot.position+'" name="brands['+brand.name+'][position]"><input type="hidden" value="'+brand.id+'" name="brands['+brand.name+'][id]"></div>')
});

</script>
@stop