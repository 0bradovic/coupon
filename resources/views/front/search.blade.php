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
                        <input type="text" placeholder="Enter Email" />
                        <button>Share</button>
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
                </section>
    </header>

  <section id="row">
   <div class="container">
      <h2 class="title2 search-title">Search results for {{ $search }}</h2>
    </div>
        <div id="cont" class="container main_offers_container search-page">

        <div class="offers_list_holder endless-pagination offers w100 search_page" data-next-page="{{ $offers->nextPageUrl() }}">
                @foreach($offers as $offer)
                    <div class="red">
                        <div class="search-image">
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
                        <div class="date"><a  class="dateA"><p>@if($offer->endDate)ends</p>  <p>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>@else Ongoing @endif</a></div>
                        </div>
                        <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                        <div class="text">
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            
                            <small>
                                {!! $offer->formatDetailsSearch($offer->detail) !!}
                            </small>  
                                        
                        </a>
                        <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get This <i class="fas fa-angle-right"></i></a></div>    
                        
                        </div>
                       
                        
                        
                    </div>
                @endforeach
        </div>
        <div class="sidebar_offers" style="display:none;">
            <div class="sidebar_offers_item">
                <div class="sidebar_offers_content">
                    <h3 class="sidebar_offers_title">Title</h3>
                    <p class="sidebar_offers_text">Lorem Ipsup Dupsum larane halite mada, fera harati es lastima pertun hervatino rate</p>
                </div>
                <div class="sidebar_offers_img">
                    <img src="" alt="">
                </div>

                <p class="sidebar_offers_date">ends 31.Jan</p>
            </div>

            <div class="sidebar_offers_item">
                <div class="sidebar_offers_content">
                    <h3 class="sidebar_offers_title">Title</h3>
                    <p class="sidebar_offers_text">Lorem Ipsup Dupsum larane halite mada, fera harati es lastima pertun hervatino rate</p>
                </div>
                <div class="sidebar_offers_img">
                    <img src="" alt="">
                </div>

                <p class="sidebar_offers_date">ends 31.Jan</p>
            </div>

            <div class="sidebar_offers_item">
                <div class="sidebar_offers_content">
                    <h3 class="sidebar_offers_title">Title</h3>
                    <p class="sidebar_offers_text">Lorem Ipsup Dupsum larane halite mada, fera harati es lastima pertun hervatino rate</p>
                </div>
                <div class="sidebar_offers_img">
                    <img src="" alt="">
                </div>

                <p class="sidebar_offers_date">ends 31.Jan</p>
            </div>
        </div>
        <div class="search_adSense">
        
            <div class="search_adSense_reclame">
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
            </div>
            <div class="search_adSense_reclame">
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
            </div>
            
        </div>
        {{--{!! $offers->links() !!}--}}
        <a href="#top" class="btn btn-warning go_top"><i class="fas fa-arrow-up"></i></a>
        
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
                                $('.offers').append(data.offers);
                                $('.endless-pagination').data('next-page', data.next_page);
                            });
                        }
                    }else{
                        localStorage.setItem('req',page);
                        $.get(page, function(data){
                                $('.offers').append(data.offers);
                                $('.endless-pagination').data('next-page', data.next_page);
                            });
                    }
                 }
             }, 50))
  
         }
     }
  
  
 })

</script>
</html>