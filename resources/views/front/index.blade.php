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
    <link rel="shortcut icon" href="/front/image/favicon.png">
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
                    <i id="mob_menu" class="fa fa-bars" aria-hidden="true"></i>
                    
                    <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                <a href="#" class="uk-etc" style="color:{{ Helpers::getTagline()->color }}"><em>{{ Helpers::getTagline()->text }}</em></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                </div>
                
                <div class="header-form-left">
                    <div class="navbar_search_form" id="navbarSupportedContent">
                    <form autocomplete="off" class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input autocomplete="off" id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search for a brand or retailer" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>

                        <div class="search-div disable" id="serachDiv">
                        </div>
                </div>
                <div class="social_icons">
                    <a href="#" class="social_icons_like">Like us?<br>Tell a freind...</a>
                    <div class="social_icons_all">
                    <div class="social_icons_div">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.beforetheshop.com&title=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! www.beforetheshop.com&summary=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! www.beforetheshop.com" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/intent/tweet?url=http://www.beforetheshop.com&text=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too!" target="_blank">
                    <i class="fab fa-twitter"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div">
                    <a href="http://pinterest.com/pin/create/button/?url=http://www.beforetheshop.com&description=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com" target="_blank">
                    <i class="fab fa-pinterest-p"></i>
                    
                    </a>
                    </div>
                    <div id='email_form' class="social_icons_div">
                    <a id="mailto" href="#">
                    <i class="far fa-envelope"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div_absolute" style="display:none;">
                        <input id="emailinput" type="text" placeholder="Enter Email" />
                        <button id="mailto_button"><a href="" id="send_mail">Share</a></button>
                        
                    </div>
                   
                    <div class="social_icons_div">
                    <a href="https://wa.me/?text=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com" target="_blank">
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
                        <div class="mobile-menu-paragraph">
                            <p>CATEGORIES (click down icon to see more)</p>
                        </div>
                    @foreach($categories as $category)
                        <div class="dropdown" data-id="{{ $i }}">
                        
                        <div class="dropdown_row"><a href="{{ route('parent.category.offers',['slug' => $category->slug]) }}" class="dropbtn @if($loop->first) tdu @endif" data-id="{{$i}}">{{ $category->name }}</a><i class="fas fa-caret-down open_sub"></i></div>
                        
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
                    <div class="dropdown-content" >
                        <div class="dropdown-container d-none" id="cont{{$j}}">
                            @foreach($category->liveSubcategories as $cat)
                            
                                <a href="{{ route('category.offers',['slug' => $cat->slug]) }}" @if(Request::is($cat->slug)) style="text-decoration: underline;" @endif >{{ $cat->name }}</a>
                           
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
    @include('layouts.errors')
    @include('layouts.messages')
    @if(count($slides) > 0)
    <section id="carousel">
            <div class="container">
                <div id="my-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($slides as $slide)
                        <div @if($slide == $slides[0]) class="carousel-item active" @else class="carousel-item" @endif>
                            
                                <img class="d-block w-100" src="{{ $slide->img_src }}" alt="{{ $slide->alt_tag }}">
                            
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
        
        <div class="in-feed-ad">
            
        </div>

        <div id="cont" class="container main_offers_container home_page_container" >
        

        <div class="offers_list_holder endless-pagination newestOffers" data-next-page="{{ $newestOffers->nextPageUrl() }}">
        <div class="tabs_nav_holder">
            <a href="#" class="hidden-xs">Most Popular</a>
            
        </div>    
        @php $k = 1; @endphp
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
                        <img src="{{ $offer->img_src }}"  alt="{{ $offer->alt_tag }}"
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
                    <div class="date"><a  class="dateA" @if($offer->endDate != null) @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif @endif><p>@if($offer->endDate)ends</p>  <p>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>@else Ongoing @endif</a></div>
                    </div>
                    <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This ></a></div>
                    <div class="text">
                    <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                        
                        <small>
                            {!! $offer->formatDetails($offer->detail) !!}
                            
                        </small>  
                                    
                    </a>
                        
                    <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This ></a></div>
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
                        <img src="{{ $offer->img_src }}"  alt="{{ $offer->alt_tag }}"
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
                    <div class="date"><a  class="dateA" @if($offer->endDate != null) @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif @endif><p>@if($offer->endDate)ends</p>  <p>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>@else Ongoing @endif</a></div>
                    </div>
                    <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>
                    <div class="text">
                    <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                        
                        <small>
                            {!! $offer->formatDetails($offer->detail) !!}
                        </small>  
                                    
                    </a>
                    
                    <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>
                    </div>
                    
                   
                    
                </div>
            @endforeach
        </div>

        {{--{!! $mostPopularOffers->links() !!}--}}
        <a href="#top" class="btn btn-warning go_top">TOP<i class="fas fa-arrow-up"></i></a>
            <div class="fixed_btn_form" style="display:none;">
                <span class="close_popUp"><i class="fas fa-times"></i></span>
                    <div class="fixed_btn_in_form">
                        <div class="fixed_btn_in_form_title">
                            <h2>{{ $popup->title }}</h2>
                            <h3>{{ $popup->second_title }}</h3>
                        </div>
                        <div class="fixed_btn_in_form_grey">
                            {!! $popup->first_section !!}
                        </div>
                        <div class="fixed_btn_in_form_submit">
                            <form method="POST" action="{{ route('subscribe') }}" id="newsletter_form">
                            <div class="fixedMy">
                            @csrf
                            <input type="email" name="email">
                            <button type="submit" id="newsletter_submit">{{ $popup->button }}</button>
                            </div>
                            </form>
                            <!-- <p>You can change your email preferences at any time</p> -->
                        </div>
                        <!-- <p class="fixed_btn_in_form_text_first">Yes, I want to save money by receiving personailsed Groupon emails with awesome deals. By subscribing I agree to the <span>Terms of Use</span> and have read the <span>Privacy Statement.</span></p> -->
                        <div class="fixed_btn_in_form_text">
                            {!! $popup->second_section !!}
                        </div>
                        <button class="btn close-modal">No thanks</button>
                    </div>
            </div>
</div>

    </section>
<br>
@foreach($customPages as $br)
<br>
@endforeach

    <footer>
        
        <div class="container">
            <div class="foo">
                <div class="footer_top">
                    <a href="mailto:hi@madebydigital.com">Contact us</a>
                    <a href="/front/Privacy Policy.pdf" target="_blank">Cookie Policy</a>
                    @foreach($customPages as $customPage)
                         <a href="{{ route('custom.page.get', ['slug' => $customPage->slug]) }}" target="_blank">{{$customPage->name}}</a>
                    @endforeach
                    <!-- <a href="#">Privacy Notice</a>
                    <a href="#">Contact Us</a> -->
                </div>
                <div class="footer_share">
                    <a href="https://www.facebook.com/BeforeTheShop" target="_blank">Facebook</a>
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">Twitter</a>
                    <a href="#"><span id="open_popup">Sign up!</span></a>
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