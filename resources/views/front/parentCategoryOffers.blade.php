<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> @if($category->metaTag) @if($category->metaTag->title) {{$category->metaTag->title}} @else BeforeTheShop @endif @else BeforeTheShop @endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
    @if($category->metaTag)
    {!! Helpers::getMetaTagsCategory($category->id) !!}
    @else
    {!! Helpers::getMetaTags() !!} 
    @endif
</head>

<body>
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="header-navbar-right">
                <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                 <a href="#" class="uk-etc">Every	offer	in	the	UK	here	–	and	personalised	suggestions	for you!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                </div>
                <div class="header-form-left">
                <div class="navbar_search_form" id="navbarSupportedContent">
                    <form autocomplete="off" class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input autocomplete="off" id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search by brand of product" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>

                        <div class="search-div disable" id="serachDiv">
                        </div>
                </div>
                <div class="social_icons">
                    <a href="#" class="social_icons_like">Like us?<br>Tell a freind..</a>
                    <div class="social_icons_all">
                    <div class="social_icons_div">
                    <a href="https://www.facebook.com/BeforeTheShop" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                    Facebook
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">
                    <i class="fab fa-twitter"></i>
                    </a>
                    Twitter
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">
                    <i class="fab fa-pinterest-p"></i>
                    </a>
                    wApp
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">
                    <i class="far fa-envelope"></i>
                    </a>
                    E-mail
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    </a>
                    Share
                    </div>
                    </div>
                </div>
                
                </div>
            </nav>
        </div>
        <section id="menu">
                    <div class="container dropdowns_holder">
                        @php $i = 1; @endphp
                    @foreach($categories as $key=>$value)
                        <div class="dropdown">
                        <form method="GET" action="{{ route('parent.category.offers') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $key }}">
                            <button class="dropbtn" data-id="{{$i}}">{{ $key }}<span class="spanrr">{{end($value)}} <span class="text_offers">offers</span></span></button>
                        </form>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                    </div>
                    @php $j = 1; @endphp
                    @foreach($categories as $key=>$value)
                    <div class="dropdown-content " id="{{$j}}">
                            <div class="dropdown-container @if(!$loop->first) d-none @endif">
                            @foreach($value as $cat)
                            @if(is_object($cat))
                                <a href="{{ route('category.offers',['slug' => $cat->slug]) }}" @if(Request::is($cat->slug)) style="text-decoration: underline;" @endif >{{ $cat->name }}<span class="spanr">{{ count($cat->getLiveOffersByCategory($cat->id)) }} offers</span></a>
                            @endif
                            @endforeach
                            @php $j++; @endphp
                            </div>
                        </div>
                    
                    @endforeach
                </section>
    </header>

  <section id="row">
    <div class="container dropdowns_holder">
      <h2 class="title2">{{ $category->name }}</h2>
      
    </div>
        <div id="cont" class="container main_offers_container">
            
        <div class="offers_list_holder endless-pagination newestOffers" data-name="{{ $category->name }}" data-next-page="{{ $newestOffers->nextPageUrl() }}">
        <div class="tabs_nav_holder" style="margin-top:0!important">
            <a href="#" class="suggestions">Suggestions for you</a>
            <!-- <a href="#">Most Popular</a> -->
            <!-- <a href="#">Ends soon</a> -->
        </div>
                @foreach($newestOffers as $offer)
                    <div class="red">
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
                        <div class="date"><a  class="dateA">@if($offer->endDate)ends <br> {{ $offer->frontDateFormat( $offer->endDate ) }}@else Ongoing @endif</a></div>
                        </div>
                        <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>
                        <div class="text">
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            
                            <small>
                                {!! $offer->formatDetails($offer->detail) !!}
                            </small> 
                                        
                        </a>
                            
                        <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>
                        </div>
                       
                        
                        
                    </div>
                @endforeach
        </div>

        {{--{!! $newestOffers->links() !!}--}}
        <div class="offers_list_holder endless-pagination mostPopularOffers dNone991" data-next-page="{{ $popularOffers->nextPageUrl() }}">
               <div class="tabs_nav_holder" style="margin-top:0!important">
            <!-- <a href="#">Newest</a> -->
            <a href="#" class="suggestions">Newest offers</a>
            <!-- <a href="#">Ends soon</a> -->
        </div>
                @foreach($popularOffers as $offer)
                    <div class="red">
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
                        <div class="date"><a  class="dateA">@if($offer->endDate)ends <br> {{ $offer->frontDateFormat( $offer->endDate ) }}@else Ongoing @endif</a></div>
                        </div>
                        <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>
                        <div class="text">
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            
                            <small>
                                {!! $offer->formatDetailsSearch($offer->detail) !!}
                            </small> 
                                        
                        </a>
                        <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>   
                        
                        </div>
                       
                        
                        
                    </div>
                @endforeach
        </div>

        {{--{!! $popularOffers->links() !!}--}}
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
console.log(SITE_URL);
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('front/js/parent.js') }}"></script>
<script>
$(window).load(function(){
    localStorage.clear();
});
$(document).ready(function() {
  
     $(window).scroll(fetchPosts);
  
     function fetchPosts() {
  
         var page = $('.newestOffers').data('next-page');
       
         if(page !== null && page !== '') {
            console.log(page);
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
                                $('.newestOffers').data('name',data.name);
                                $('.newestOffers').data('next-page', data.next_page);
                            });
                        }
                    }else{
                        localStorage.setItem('req',page);
                        $.get(page, function(data){
                                $('.newestOffers').append(data.newest);
                                $('.mostPopularOffers').append(data.popular);
                                $('.newestOffers').data('name',data.name);
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