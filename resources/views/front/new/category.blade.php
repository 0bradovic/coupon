@extends('front.new.master')

@section('content')
<div class="category_page">
    <div class="popular_brands_row">
        <div class="popular_brands_row_left">
        <span>{{ $category->name }}</span> 
        <div class="popular_brands_text">
            <h5>Popular Brands:</h5>
            @foreach($brands as  $brand)
                @if($loop->last)
                <a href="#">{{ $brand->name }}</a>
                @else
                <a href="#">{{ $brand->name }},</a>
                @endif
            @endforeach
        </div>
        </div>
        <div class="popular_brands_row_right">
        <form action="{{route('search.blade')}}" method="GET">
                        <label for="search"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a><input id="search"
                                type="text" placeholder="Search for a brand or retailer"></label>
                        <div class="search_result hidden">
                            
                        </div>
                        {!! csrf_field() !!}
                    </form>
        </div>
    </div>
<div class="category_page_holder">
    <div class="category_blade">
        <div class="category_blade_row most_popular endless-pagination mostPopularOffers" data-next-page="{{ $popularOffers->nextPageUrl() }}">
            <div class="category_blade_title">
                <span>Most Popular</span>
            </div>
            @foreach($popularOffers as $offer)
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        @if($offer->brand)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                            ?>
                             <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                            </a>
                        
                        @elseif($offer->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                            ?>
                             <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                                
                            </a>
                        @endif
                    </div>
                    <div class="category_blade_box_date">
                        @if($offer->offerType)
                            <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
                        @endif
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
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
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            <div class="category_blade_box_text_top">
                                {!! $offer->formatDetails($offer->detail) !!}
                            </div>
                        </a>
                        <div class="category_blade_box_text_bottom">
                            <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{--{!! $popularOffers->links() !!}--}}
        <div class="category_blade_row newest_offers hidden800 endless-pagination newestOffers" data-next-page="{{ $newestOffers->nextPageUrl() }}">
            <div class="category_blade_title">
                <span>Newest offers</span>
            </div>
            @foreach($newestOffers as $offer)
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        @if($offer->brand)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                            ?>
                             <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                            </a>
                        
                        @elseif($offer->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                            ?>
                             <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%"; 
                                @endif/>
                            </a>
                        @endif
                    </div>
                    <div class="category_blade_box_date">
                        @if($offer->offerType)
                            <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
                        @endif
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
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
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            <div class="category_blade_box_text_top">
                                {!! $offer->formatDetails($offer->detail) !!}
                            </div>
                        </a>
                        <div class="category_blade_box_text_bottom">
                            <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{--{!! $newestOffers->links() !!}--}}
    </div>
    <div class="ad_sense">
        
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
$(window).load(function(){
    localStorage.clear();
});
$(document).ready(function() {
  
     $(window).scroll(fetchPosts);
  
     function fetchPosts() {
  
         var page = $('.newestOffers').data('next-page');
         if(page !== null && page !== '') {
  
             clearTimeout( $.data( this, "scrollCheck" ) );
  
             $.data( this, "scrollCheck", setTimeout(function() {
                 var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 3000;
  
                 if(scroll_position_for_posts_load >= $(document).height()) {
                    if(localStorage.getItem('req') != null && localStorage.getItem('req') != undefined){
                        if( localStorage.getItem('req') != page){
                            localStorage.setItem('req',page);
                            $.get(page, function(data){
                                $('.newestOffers').append(data.newest);
                                $('.mostPopularOffers').append(data.popular);
                                $('.newestOffers').data('next-page', data.next_page);
                            });
                        }
                    }else{
                        localStorage.setItem('req',page);
                        $.get(page, function(data){
                                $('.newestOffers').append(data.newest);
                                $('.mostPopularOffers').append(data.popular);
                                $('.newestOffers').data('next-page', data.next_page);
                            });
                    }
                 }
             }, 50))
  
         }
     }
  
  
 })

</script>
@endsection