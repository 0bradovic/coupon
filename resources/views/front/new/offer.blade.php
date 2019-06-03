@extends('front.new.master')

@section('content')
<div class="offer_page">
    <div class="container">
    <div class="single_offer">
        <div class="single_offer_img">
            @if($offer->brand)
                <?php
                list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                ?>
                    <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                    @else style="height:auto;width:100%"; 
                    @endif>
                        <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif/>
                    </a>
            @elseif($offer->img_src)
                <?php
                list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                ?>
                    <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                    @else style="height:auto;width:100%"; 
                    @endif>
                        <img src="{{ $offer->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif/>
                    </a>
            @endif
        </div>
        <div class="single_offer_date">
            @if($offer->offerType)
                <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
            @endif
            <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                <div class="single_offer_date_top">
                    {{ $offer->name }}
                </div>
            </a>
            <div class="single_offer_date_bottom">
                @if($offer->endDate)
                    <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                    <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>
                @else
                    <p>Ongoing</p>
                @endif
            </div>
        </div>
        <div class="single_offer_text">
            <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                <div class="single_offer_text_top">
                    {!! $offer->detail !!}
                </div>
            </a>
            <div class="single_offer_text_bottom">
                <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="share_me">
            <p>Share Me!</p>
            <div class="share_me_item facebook">
                <a target="_blank" href="https://www.facebook.com/login.php?skip_api_login=1&api_key=966242223397117&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fsharer%2Fsharer.php%3Fu%3Dhttps%253A%252F%252Fwww.beforetheshop.com%252Foffer%252Ffree84%26title%3DBeforeTheShop%26summary%3DI%2527m%2Bloving%2Bthis%2Boffer%2Bof%2BFREE%2BAny%2BYaar%2BBar%2B40g...%2BI%2Bthought%2Byou%2527d%2Blove%2Bit%2Btoo%2521&cancel_url=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Fclose_window%2F%3Fapp_id%3D966242223397117%26connect%3D0%23_%3D_&display=popup&locale=en_US"><i class="fab fa-facebook-f"></i></a>
            </div>
            <div class="share_me_item twitter">
                <a target="_blank" href="https://twitter.com/intent/tweet?url=https://www.beforetheshop.com/offer/free84&text=I%27m%20loving%20this%20offer%20of%20FREE%20Any%20Yaar%20Bar%2040g...%20I%20thought%20you%27d%20love%20it%20too!"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="share_me_item pinterest">
                <a target="_blank" href="https://www.pinterest.com/login/?next=/pin/create/button/%3Furl%3Dhttps%3A//www.beforetheshop.com/offer/free84%26description%3DI%2527m%2520loving%2520this%2520offer%2520of%2520FREE%2520Any%2520Yaar%2520Bar%252040g...%2520I%2520thought%2520you%2527d%2520love%2520it%2520too!%2520https%3A//www.beforetheshop.com/offer/free84"><i class="fab fa-pinterest-p"></i></a>
            </div>
            <div class="share_me_item envelope">
                <a href="#"><i class="far fa-envelope" id="email_popup"></i></a>
                <div class="email_popup hidden">
                    <input type="text" placeholder="Enter Email" />
                    <button>Share</button>
                </div>
            </div>
            <div class="share_me_item whatsapp">
                <a target="_blank" href="https://api.whatsapp.com/send?phone=&text=I%27m%20loving%20this%20offer%20of%20FREE%20Any%20Yaar%20Bar%2040g...%20I%20thought%20you%27d%20love%20it%20too%21%20https%3a%2f%2fwww.beforetheshop.com%2foffer%2ffree84&source=&data="><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    <div class="offer_page_title">
        <span>Here's more you might like...</span>
    </div>
    <div class="offer_content">
    <div class="category_blade_row most_popular endless-pagination mostPopularOffers" @if($popularSimillarOffers) data-next-page="{{ $popularSimillarOffers->nextPageUrl() }}" @endif>
            <div class="category_blade_title">
                <span>Most Popular</span>
            </div>
            @if($popularSimillarOffers)
                @foreach($popularSimillarOffers as $off)
                <div class="category_blade_content">
                    <div class="category_blade_box">
                        <div class="category_blade_box_img">
                            @if($off->brand)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->brand->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->brand->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                </a>
                            
                            @elseif($off->img_src)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                    
                                </a>
                            @endif
                        </div>
                        <div class="category_blade_box_date">
                            @if($off->offerType)
                                <span class="coupon" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</span>
                            @endif
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_date_top">
                                    {{ $off->name }}
                                </div>
                            </a>
                            <div class="category_blade_box_date_bottom">
                                @if($off->endDate)
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $off->frontDateFormat( $off->endDate ) }}</p>
                                @else
                                    <p>Ongoing</p>
                                @endif
                            </div>
                        </div>
                        <div class="category_blade_box_text">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_text_top">
                                    {{ $off->formatDetails($off->detail) }}
                                </div>
                            </a>
                            <div class="category_blade_box_text_bottom">
                                <a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
    </div>
    {{--{!! $popularSimillarOffers->links() !!}--}}
        <div class="category_blade_row newest_offers hidden800 endless-pagination newestOffers" @if($newestSimillarOffers) data-next-page="{{ $newestSimillarOffers->nextPageUrl() }}" @endif>
            <div class="category_blade_title">
                <span>Newest offers</span>
            </div>
            @if($newestSimillarOffers)
                @foreach($newestSimillarOffers as $off)
                <div class="category_blade_content">
                    <div class="category_blade_box">
                        <div class="category_blade_box_img">
                            @if($off->brand)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->brand->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->brand->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                </a>
                            
                            @elseif($off->img_src)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                    
                                </a>
                            @endif
                        </div>
                        <div class="category_blade_box_date">
                            @if($off->offerType)
                                <span class="coupon" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</span>
                            @endif
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_date_top">
                                    {{ $off->name }}
                                </div>
                            </a>
                            <div class="category_blade_box_date_bottom">
                                @if($off->endDate)
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $off->frontDateFormat( $off->endDate ) }}</p>
                                @else
                                    <p>Ongoing</p>
                                @endif
                            </div>
                        </div>
                        <div class="category_blade_box_text">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_text_top">
                                    {{ $off->formatDetails($off->detail) }}
                                </div>
                            </a>
                            <div class="category_blade_box_text_bottom">
                                <a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>    
        {{--{!! $newestSimillarOffers->links() !!}--}}
    <div>
    <div class="ad_sense"></div>
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