@extends('front.master')

@section('content')
<div class="container">
<div class="search_page">
        <div class="category_blade_row ">
          
       
        <div class="no-result-holder">
            <a>No offers currently for {{ $search }}</a>
        </div>
        
        
        
    
        <div class="newHolder">
        <div class="category_blade_row most_popular endless-pagination mostPopularOffers" data-next-page="{{ $popularOffers->nextPageUrl() }}">
            <div class="category_blade_title">
                <span>Here's more you might like</span>
            </div>
            @foreach($popularOffers as $offer)
            @if($offer->brand)
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        @if($offer->brand->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                            ?>
                             <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                            </a>
                            <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" class="redirect-btn get_this_btn">Get This <i class="fas fa-chevron-right"></i></a>
                        @elseif($offer->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                            ?>
                             <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                                
                            </a>
                            <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" class="redirect-btn get_this_btn">Get This <i class="fas fa-chevron-right"></i></a>
                        @endif
                    </div>
                    <div class="category_blade_box_date">
                        @if($offer->offerType)
                            <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
                        @endif
                        <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                            <div class="category_blade_box_date_top">
                                {{ $offer->name }}
                            </div>
                        </a>
                        <div class="category_blade_box_date_bottom">
                            @if($offer->endDate)
                                <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                                <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>
                            @else
                                <p>Ongoing</p>
                            @endif
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                            <div class="category_blade_box_text_top">
                                {!! $offer->formatDetails($offer->detail) !!}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="ad_sense_holder_search_page">
            <div class="ad_sense"></div>
            <div class="ad_sense"></div>
        </div>
</div>
        {{--{!! $popularOffers->links() !!}--}}
    
</div>
</div>

@endsection

@section('scripts')
<script>
$(window).load(function(){
    localStorage.removeItem('req');
});
$(document).ready(function() {
  
     $(window).scroll(fetchPosts);
  
     function fetchPosts() {
  
         var page = $('.endless-pagination').data('next-page');
       
         if(page !== null && page !== '') {
  
             clearTimeout( $.data( this, "scrollCheck" ) );
  
             $.data( this, "scrollCheck", setTimeout(function() {
                 var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 30;
  
                 if(scroll_position_for_posts_load <= $(document).height()) {
                    if(localStorage.getItem('req') != null && localStorage.getItem('req') != undefined){
                        if( localStorage.getItem('req') != page){
                            localStorage.setItem('req',page);
                            $.get(page, function(data){
                                $('.mostPopularOffers').append(data.popular);
                                $('.mostPopularOffers').data('next-page', data.next_page);
                            });
                        }
                    }else{
                        localStorage.setItem('req',page);
                        $.get(page, function(data){
                                $('.mostPopularOffers').append(data.popular);
                                $('.mostPopularOffers').data('next-page', data.next_page);
                            });
                        }
                    }
                 
             }, 50))
  
         }
     }
  
  
 })

</script>
@endsection

