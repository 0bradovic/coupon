@extends('front.master')

@section('content')

@if(count($slides) > 0)
    @include('front.slider')
@endif
<div class="container">
<div class="big_search">
    <form action="{{route('search.blade')}}" method="GET" autocomplete="off">
    <label>
        <input placeholder="{{ Helpers::getIndexSearchText() }}" name="search" />
        <button type="submit"><i class='fa fa-search' aria-hidden='true'></i></button>
    </label>
    </form>
</div>
@if(count($topBrands) > 0)
<div class="home_top_brands">
        <p>Top Brands</p>
        <div class="home_top_brands_images">
        @foreach($topBrands as $brand)
                <a href="{{ route('brand.offers',['slug' => $brand->slug]) }}">
                    <img src="{{ $brand->img_src }}" style="height:100px;width:auto;">
                </a>      
        @endforeach
        </div>
</div>
@endif
<div class="offer_holder">
    @foreach($fpCategories as $fpCategory)
    <div class="offer_holder_row">
        <div class="offer_holder_row_title">
            <span>
                Top offers in {{ $fpCategory->name }}
            </span>
                <a href="{{ route('parent.category.offers',['slug' => $fpCategory->slug]) }}">
                    <h3>See all {{ $fpCategory->countOfParentCatLiveOffers($fpCategory->id) }} offers</h3>
                </a>
        </div>
        @foreach($fpCategory->topOffers as $offer)
        <div class="offer_holder_row_content">
            <div class="offer_box">
                <div class="offer_box_img">
                @if($offer->brand)
                    <?php
                    list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                    ?>
                    <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                    @else style="height:auto;width:100%"; 
                    @endif>
                        <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                        @else style="height:auto;width:100%"; 
                        @endif />
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
                        @else style="height:auto;width:100%"; 
                        @endif />
                    </a>
                    
                @endif
                </div>
                <div class="offer_box_date">
                @if($offer->offerType)
                    <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
                @endif
                    <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                        <div class="offer_box_date_top">
                            {{ $offer->name }}
                        </div>
                    </a>
                    <div class="offer_box_date_bottom">
                    @if($offer->endDate)
                        <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                        <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>
                    @else
                        <p>Ongoing</p>
                    @endif
                    </div>
                </div>
                <div class="offer_box_text">
                    <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                        <div class="offer_box_text_top">
                        {!! $offer->formatDetails($offer->detail) !!} 
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
</div>

@endsection