<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>BeforeTheShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
    {!! Helpers::getMetaTags() !!} 
</head>

<body>

    <header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="header-navbar-right">
                <i id="mob_menu" class="fa fa-bars" aria-hidden="true"></i>
                <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                 <a href="#" class="uk-etc"><em>All the best UK offers in one place</em></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                </div>
                <div class="header-form-left">
                <div class="navbar_search_form" id="navbarSupportedContent">
                    <form autocomplete="off" class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input autocomplete="off" id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search here" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>

                        <div class="search-div disable" id="serachDiv">
                        </div>
                </div>
                <div class="social_icons">
                    <a href="#" class="social_icons_like">Like us?<br>Tell a freind...</a>
                    <div class="social_icons_all">
                        <div class="social_icons_div">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.beforetheshop.com&title=BeforeTheShop" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                        </a>
                        </div>
                        <div class="social_icons_div">
                        <a href="https://twitter.com/intent/tweet?url=http://www.beforetheshop.com&text=BeforeTheShop" target="_blank">
                        <i class="fab fa-twitter"></i>
                        </a>
                        </div>
                        <div class="social_icons_div">
                        <a href="http://pinterest.com/pin/create/button/?url=http://www.beforetheshop.com&media=BeforeTheShop&description=BeforeTheShop" target="_blank">
                        <i class="fab fa-pinterest-p"></i>
                        </a>
                        </div>
                        <div id='email_form' class="social_icons_div">
                        <a href="#" target="_blank">
                        <i class="far fa-envelope"></i>
                        </a>
                        
                        </div>
                        <div class="social_icons_div_absolute">
                        <input id="emailinput" type="text" placeholder="Enter Email" />
                        <button id="mailto_button"><a href="" id="send_mail">Share</a></button>
                        
                    </div>
                        <div class="social_icons_div">
                        <a href="https://wa.me/?text=http://www.beforetheshop.com" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        </a>
                        </div>
                    </div>
                </div>
                
                </div>
            </nav>
        </div>
        <section id="menu">
                    <div class="container dropdowns_holder">
                        @php $i = 1; @endphp
                    @foreach($categories as $category)
                        
                        <div class="dropdown">
                        
                            <div class="dropdown_row"><a href="{{ route('parent.category.offers',['slug' => $category->slug]) }}" class="dropbtn @if($loop->first) tdu @endif" data-id="{{$i}}">{{ $category->name }}</a><i class="fas fa-caret-right open_sub"></i></div>

                            <div class="new_sub_menu" id="{{ $i }}">
                            <a class="back"><i class="fas fa-caret-left"></i> Main menu</a>               
                                @foreach($category->liveSubcategories as $cat)
                            
                                    <a href="{{ route('category.offers',['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                       
                                @endforeach       
                                                                                                         
                            </div>
                        
                        </div>
                        
                        @php $i++; @endphp
                    @endforeach
                    </div>
                    @php $j = 1; @endphp
                    @foreach($categories as $category)
                    <div class="dropdown-content " id="{{$j}}">
                            <div class="dropdown-container @if(!$loop->first) d-none @endif">
                            @foreach($category->liveSubcategories as $cat)
                            
                                <a href="{{ route('category.offers',['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                            
                            @endforeach
                            @php $j++; @endphp
                            </div>
                        </div>
                    
                    @endforeach
                    <div class="hidden-lg hidden-md hidden-sm navbar-buttons">
                    <p class="newest-offers">Viewing newest offers </p>
                    <a class="btn btn-default newest-offers" id="most-popular-btn">View most popular</a>
                    <p class="dNone most-popular-offers">Viewing most popular offers </p>
                    <a class="btn btn-default dNone most-popular-offers" id="newest-btn">View newest</a>
                </div> 
                </section>
    </header>

    <section id="row">
    <div class="container">
            @if($mainCategory)
            <h2 class="title2">{{ $mainCategory->name }}</h2>
            @endif
        </div>
        <div class="container singe-container offers-page">
            <div class="red single-offer offers_page">
                <div class="image">
                 @if($offer->img_src)
                <?php
                    list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                ?>
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                @else style="height:auto;width:100%"; 
                @endif>
                    <img src="{{ $offer->img_src }}"  
                    @if($height>$width) style="height:100%;width:auto;"
                    @else style="height:auto;width:100%"; 
                    @endif>
                </a>
                </div>
                @else
                
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    
                </a>
                </div>
                
                @endif
                </div>
                <div class="title">
                    @if($offer->offerType)
                <div class="sticker" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</div>
                @endif
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <h6>{{ $offer->name }}</h6>
                </a>
                 <div class="date"><a  class="dateA"><p>@if($offer->endDate)ends </p> <p>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>@else Ongoing @endif</a></div>
                </div>
                <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                <div class="text">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    
                    <p>{!! $offer->detail !!}</p>
                                
                </a>
                    
                <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>
                </div>
                
                <div class="social_icons_all_single">
                <p>Share me!</p>
                        <div class="social_icons_div_single">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&title=BeforeTheShop&summary=I'm loving this offer of {{ $offer->urlOfferName($offer->name) }} {{ $offer->formatUrlDetails($offer->detail) }}... I thought you'd love it too! " target="_blank">
                        <i class="fab fa-facebook-f"></i>
                        </a>
                        </div>
                        <div class="social_icons_div_single">
                        <a href="https://twitter.com/intent/tweet?url={{url()->current()}}&text=I'm loving this offer of {{ $offer->urlOfferName($offer->name) }} {{ $offer->formatUrlDetails($offer->detail) }}... I thought you'd love it too! " target="_blank">
                        <i class="fab fa-twitter"></i>
                        </a>
                        </div>
                        <div class="social_icons_div_single">
                        <a href="http://pinterest.com/pin/create/button/?url={{url()->current()}}&media=BeforeTheShop&description=I'm loving this offer of {{ $offer->urlOfferName($offer->name) }} {{ $offer->formatUrlDetails($offer->detail) }}... I thought you'd love it too! {{url()->current()}}" target="_blank">
                        <i class="fab fa-pinterest-p"></i>
                        </a>
                        </div>
                        <div class="social_icons_div_single" id="email_form2">
                        <a href="#" class="relative_social2">
                        <i class="far fa-envelope" id="abs2"></i>
                        <div class="social_icons_div_absolute2" style="display: flex;">
                            <input type="text" id="offer-email-input" placeholder="Enter Email" data-content="I'm loving this offer of {{ $offer->urlOfferName($offer->name) }} {{ $offer->formatUrlDetails($offer->detail) }}... I thought you'd love it too! {{url()->current()}}">
                            <button><a href="" id="offer-send-mail">Share</a></button>
                        </div>
                        </a>
                        </div>
                        <div class="social_icons_div_single">
                        <a href="https://wa.me/?text=I'm loving this offer of {{ $offer->urlOfferName($offer->name) }} {{ $offer->formatUrlDetails($offer->detail) }}... I thought you'd love it too! {{url()->current()}}" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        </a>
                        </div>
                    </div>
                
                
            </div>
            
        </div>
        
        <div class="title_holder"> <h2 class="title2 title-padding titleFix" style="margin-top:0!important">Here's more you might like</h2></div>
        <div class="container dropdowns_holder">
           
        </div>
        <div id="cont" class="container main_offers_container" >
            
        <div class="offers_list_holder endless-pagination newestOffers" @if($newestSimillarOffers) data-next-page="{{ $newestSimillarOffers->nextPageUrl() }}" @endif>
        <div class="tabs_nav_holder" style="margin-top:0!important">
            <a href="#" class="suggestions">Most Popular</a>
            <!-- <a href="#" >Most Popular</a>
            <a href="#">Ends soon</a> -->
        </div>
        @if($newestSimillarOffers)
            @foreach($newestSimillarOffers as $off)
                <div class="red">
                    <div class="image">
                    @if($off->img_src)
                    <?php
                        list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                    ?>
                    <div class="holdarevitj">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                    @else style="height:auto;width:100%"; 
                    @endif>
                        <img src="{{ $off->img_src }}"  
                        @if($height>$width) style="height:100%;width:auto;"
                        @else style="height:auto;width:100%"; 
                        @endif>
                    </a>
                    </div>
                    @else
                    
                    <div class="holdarevitj">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        
                    </a>
                    </div>
                    
                    @endif
                    </div>
                    <div class="title">
                         @if($off->offerType)
                    <div class="sticker" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</div>
                    @endif
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        <h6>{{ $off->name }}</h6>
                    </a>
                    <div class="date"><a  class="dateA"><p>@if($off->endDate)ends</p>  <p>{{ $off->frontDateFormat( $off->endDate ) }}</p>@else Ongoing @endif</a></div>
                    </div>
                    <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                    <div class="text">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        
                        <small>
                            {!! $off->formatDetails($off->detail) !!}
                        </small>  
                                    
                    </a>
                    <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>    
                    
                    </div>
                    
                    
                   
                </div>
            @endforeach
        @endif
        </div>

        {{--{!! $newestSimillarOffers->links() !!}--}}
        <div class="offers_list_holder endless-pagination mostPopularOffers dNone991" @if($popularSimillarOffers) data-next-page="{{ $popularSimillarOffers->nextPageUrl() }}" @endif>
<div class="tabs_nav_holder" style="margin-top:0!important">
            <!-- <a href="#">Newest</a> -->
            <a href="#" class="suggestions">Newest offers</a>
            <!-- <a href="#">Ends soon</a> -->
        </div>
        @if($popularSimillarOffers)
            @foreach($popularSimillarOffers as $off)
                <div class="red">
                    <div class="image">
                    @if($off->img_src)
                    <?php
                        list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                    ?>
                    <div class="holdarevitj">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                    @else style="height:auto;width:100%"; 
                    @endif>
                        <img src="{{ $off->img_src }}"  
                        @if($height>$width) style="height:100%;width:auto;"
                        @else style="height:auto;width:100%"; 
                        @endif>
                    </a>
                    </div>
                    @else
                    
                    <div class="holdarevitj">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        
                    </a>
                    </div>
                    
                    @endif
                    </div>
                    <div class="title">
                        @if($off->offerType)
                    <div class="sticker" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</div>
                    @endif
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        <h6>{{ $off->name }}</h6>
                    </a>
                    <div class="date"><a  class="dateA"><p>@if($off->endDate)ends</p>  <p>{{ $off->frontDateFormat( $off->endDate ) }}</p>@else Ongoing @endif</a></div>
                    </div>
                    <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                    <div class="text">
                    <a href="{{ route('offer',['slug' => $off->slug]) }}">
                        
                        <small>
                            {!! $off->formatDetails($off->detail) !!}
                        </small>  
                                    
                    </a>
                    <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>   
                    
                    </div>
                   
                    
                    
                </div>
            @endforeach
            @endif
        </div>
        <!-- <div class="adSense">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-5885241180759942"
                 data-ad-slot=""
                 data-ad-format="auto"></ins>
                 <script>
                    (adsbygoogle = window.adsbygoogle || []).push({
                    google_ad_client: "ca-pub-5885241180759942",
                    enable_page_level_ads: true
                    });
                </script>
        </div> -->
        {{--{!! $popularSimillarOffers->links() !!}--}}
        <a href="#top" class="btn btn-warning go_top"><i class="fas fa-arrow-up"></i></a>
        
</div>
</div>



    </section>
        
       
        
    
    <br>
  @foreach($customPages as $cp)
  <br>
  @endforeach
  <footer>
        
        <div class="container">
            <div class="foo">
                
                <ul>
                    
					@foreach($customPages as $customPage)
						<!-- <a href="{{ route('custom.page.get', ['slug' => $customPage->slug]) }}" target="_blank" class="list-foo">{{$customPage->name}}</a>
						</br> -->
                    @endforeach
                    
                    
                </ul>
                <div class="footer_top">
                    <a href="#">Cookie Policy</a>
                    <a href="#">Privacy Notice</a>
                    <a href="#">Contact Us</a>
                </div>
                <div class="footer_share">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                </div>
                <p>Copyright 2019 Made By Digital Ltd. All rights reserved.</p>
            </div>
        </div>
    </footer>
 
</body>
<script> 
var SITE_URL = '<?php echo env("APP_URL")?>/';
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
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
</html>