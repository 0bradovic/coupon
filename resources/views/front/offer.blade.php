<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>BeforeTheShop 2</title>
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
                <a class="navbar-brand" href="/public/"><b>BeforeTheShop</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>
                </div>
            </nav>
        </div>
    </header>
    <section id="menu">
        <div class="container">
        @foreach($categories as $key=>$value)
            <div class="dropdown">
                <button class="dropbtn">{{ $key }}<span class="spanrr">{{end($value)}} offers</span><i class="fas fa-chevron-down"
                        style="margin-left: 20px;"></i></button>
                <div class="dropdown-content">
                @foreach($value as $cat)
                @if(is_object($cat))
                    <a href="{{ route('category.offers',['slug' => $cat->slug]) }}">{{ $cat->name }}<span class="spanr">{{ count($cat->getLiveOffersByCategory($cat->id)) }} offers</span></a>
                @endif
                @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </section>
    <section id="boxes">
        <div class="container">
            <h2>{{ $mainCategory->name }}</h2>
        </div>
        <div class="container">
            <div class="box">
                <div class="fix">
                    <div class="slika">
                        <div class="fix-img">
                            <img src="{{ '/public/'.$offer->img_src }}">
                        </div>
                    </div>
                    <div class="fix-text">
                        <a class="fix-a">{{ $offer->name }}</a>
                        @if($offer->detail)
                        <a class="fix-a">{!! $offer->detail !!}</a>
                        @endif
                    </div>
                    <div class="dugmici">
                        <p class="datum">@if($offer->endDate){{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                        <a href="{{$offer->link}}" class="dugme first-btn">Get offers</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h2 class="title2">More offers you might like</h2>
        </div>
        <div class="container offers endless-pagination" data-next-page="{{ $simillarOffers->nextPageUrl() }}">
        @foreach($simillarOffers as $off)
            <div class="dva">
                <div class="box">
                    <div class="fix">
                        <div class="slika">
                            <div class="fix-img">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <img src="{{ '/public/'.$off->img_src }}">
                            </a>
                            </div>
                        </div>
                        <div class="fix-text">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{{ $off->name }}</a>
                            <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">
                                @php chop($offer->detail,'<p></p>') @endphp
                                @if(strpos($offer->detail,'<br><p></p>') !== false)
                                    <p> {!! chop($offer->detail, '<br><p></p>')!!} </p>
                                @elseif(strpos($offer->detail,'<br></p>') !== false)
                                    <p> {!! chop($offer->detail, '<br></p>')!!} </p>
                                @else
                                    <p>{!! $offer->detail !!}</p>
                                @endif
                            </a>
                        </div>
                        <div class="dugmici">
                            <p class="datum">@if($off->endDate){{ $off->dateFormat( $off->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                            <a href="{{ $off->link }}" class="dugme">Get offers</a>
                        </div>
                    </div>
                </div>
                
            </div>
        @endforeach
        {{--{!! $simillarOffers->links() !!}--}}
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="foo">
                <p>2018 MadeByDigital. All rights reserved.</p>
                <ul>
                    <a href="#" class="list-foo">Privacy Policy</a>
                    <a href="#" class="list-foo">Mail Us</a>
                </ul>
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
 
 
 
 /*    $('body').on('click', '.pagination a', function(e){
  
         e.preventDefault();
         var url = $(this).attr('href');
  
         $.get(url, function(data){
             $('.posts').html(data);
         });
  
     });*/
  
     $(window).scroll(fetchPosts);
  
     function fetchPosts() {
  
         var page = $('.endless-pagination').data('next-page');
        console.log(page);
         if(page !== null && page !== '') {
  
             clearTimeout( $.data( this, "scrollCheck" ) );
  
             $.data( this, "scrollCheck", setTimeout(function() {
                 var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 100;
  
                 if(scroll_position_for_posts_load >= $(document).height()) {
                     $.get(page, function(data){
                         $('.offers').append(data.simillarOffers);
                         $('.endless-pagination').data('next-page', data.next_page);
                     });
                 }
             }, 350))
  
         }
     }
  
  
 })

</script>
</html>