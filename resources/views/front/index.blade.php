<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
    {!! Helpers::getMetaTags() !!} 
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129562058-1"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    
     gtag('config', 'UA-129562058-1');
    </script>
    
</head>

<body>
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="header-navbar-right">
                    <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                <a href="#" class="uk-etc"><em>All the best UK offers in one place to save you time & money</em></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                </div>
                
                <div class="header-form-left">
                    <div class="navbar_search_form" id="navbarSupportedContent">
                    <form autocomplete="off" class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input autocomplete="off" id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search by brand or product" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>

                        <div class="search-div disable" id="serachDiv">
                        </div>
                </div>
                <div class="social_icons">
                    <a href="https://www.facebook.com/BeforeTheShop" target="_blank">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                </div>
                
                </div>
            </nav>
        </div>
        <section id="menu">
                    <div class="container dropdowns_holder">
                        @php $i = 1; @endphp
                    @foreach($categories as $key=>$value)
                        <div class="dropdown">
                            <button class="dropbtn" data-id="{{$i}}" 
                            @foreach($value as $cat) @if(is_object($cat)) @if(Request::is($cat->slug)) style="text-decoration: underline !important;" @endif @endif @endforeach > {{ $key }}<span class="spanrr">{{end($value)}} <span class="text_offers">offers</span></span></button> 
                        </div>
                    @endforeach
                    </div>
                    @php $i = 1; @endphp
                    @foreach($categories as $key=>$value)
                    <div class="dropdown-content " id="{{$i}}">
                            <div class="dropdown-container d-none">
                            @foreach($value as $cat)
                            @if(is_object($cat))
                                <a href="{{ route('category.offers',['slug' => $cat->slug]) }}" @if(Request::is($cat->slug)) style="text-decoration: underline;" @endif >{{ $cat->name }}<span class="spanr">{{ count($cat->getLiveOffersByCategory($cat->id)) }} offers</span></a>
                            @endif
                            @endforeach
                            @php $i++; @endphp
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
    @if(count($slides) > 0)
    <section id="carousel">
            <div class="container">
                <div id="my-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($slides as $slide)
                        <div @if($slide == $slides[0]) class="carousel-item active" @else class="carousel-item" @endif>
                            
                                <img class="d-block w-100" src="{{ $slide->img_src }}" alt="First slide">
                            
                            @if($slide->center_text)
                                <p class="caroP" @if($slide->center_text_color) style="color:{{ $slide->center_text_color }}" @endif>{{ $slide->center_text }}</p>
                            @endif
                            @if($slide->left_text)
                                <p class="caroPleft" @if($slide->left_text_color) style="color:{{ $slide->left_text_color }}" @endif>{{ $slide->left_text }}</p>
                            @endif
                            @if($slide->right_text)
                                <p class="caroPright" @if($slide->right_text_color) style="color:{{ $slide->right_text_color }}" @endif>{{ $slide->right_text }}</p>
                            @endif
                        </div>
                    @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#my-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#my-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
        @endif
    <section id="row">
   
        <div id="cont" class="container  main_offers_container " >
        

        <div class="offers_list_holder endless-pagination newestOffers" data-next-page="{{ $newestOffers->nextPageUrl() }}">
        <div class="tabs_nav_holder">
            <a href="#" class="hidden-xs">Most popular
            
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
            {{--{!! $newestOffers->links() !!}--}}
        </div>
        <div class="offers_list_holder endless-pagination mostPopularOffers dNone991" data-next-page="{{ $mostPopularOffers->nextPageUrl() }}">
        <div class="tabs_nav_holder">
           
            <a href="#" class="hidden-xs">Newest offers</a>
            
        </div>   
        @foreach($mostPopularOffers as $offer)
           
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

        {{--{!! $mostPopularOffers->links() !!}--}}
        <a href="#top" class="btn btn-warning go_top"><i class="fas fa-arrow-up"></i></a>
        
</div>

    </section>
<br>
@foreach($customPages as $br)
<br>
@endforeach

    <footer>
        
        <div class="container">
            <div class="foo">
                
                <ul>
                    
					@foreach($customPages as $customPage)
						<a href="{{ route('custom.page.get', ['slug' => $customPage->slug]) }}" target="_blank" class="list-foo">{{$customPage->name}}</a>
						</br>
                    @endforeach
                    
                    
                </ul>
                <p>Copyright 2019 MadeByDigital. All rights reserved.</p>
                <a href="mailto:hi@madebydigital.com" class="list-foo">hi@madebydigital.com</a>
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
  
         var page = $('.newestOffers').data('next-page');
       
         if(page != null && page != '') {
            
             clearTimeout( $.data( this, "scrollCheck" ) );
  
             $.data( this, "scrollCheck", setTimeout(function() {
                 var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 3000;
                
                 if(scroll_position_for_posts_load >= $(document).height()) {
                    
                    if(localStorage.getItem('req') != null && localStorage.getItem('req') != undefined ){
                       
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