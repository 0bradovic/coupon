@extends('front.master')

@section('content')
<div class="container">
<div class="search_page">
        <div class="category_blade_row ">
          
       
        <div class="no-result-holder">
            <a>No offers currently for {{ $search }}</a>
        </div>
        
        
    <div class="ad_sense_holder_search_page">
        <div class="ad_sense"></div>
        <div class="ad_sense"></div>
    </div>
</div>
</div>

@endsection

