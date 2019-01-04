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
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('public/front/style.css') }}" />
    {!! Helpers::getMetaTags() !!} 
</head>

<body>
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>
                    <div class="search-div disable" id="serachDiv">
                </div>
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
    <section id="carousel">
            <div class="container">
                <div id="my-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($slides as $slide)
                        <div @if($slide == $slides[0]) class="carousel-item active" @else class="carousel-item" @endif>
                            <a href="{{ $slide->link }}" target="_blank">
                                <img class="d-block w-100" src="{{ '/public/'.$slide->img_src }}" alt="First slide">
                            </a>
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
    <section id="row">
   
        <div id="cont" class="container offers endless-pagination" data-next-page="{{ $offers->nextPageUrl() }}">
        @foreach($offers as $offer)
            <div class="red">
                <div class="image">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <img src="{{ '/public/'.$offer->img_src }}">
                </a>
                </div>
                <div class="title">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <h6>{{ $offer->name }}</h6>
                </a>
                </div>
                <div class="text">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
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
                <div class="date"><a  class="dateA">@if($offer->endDate)Ends <br> {{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</a></div>
                <div class="btn"><a href="{{ $offer->link }}" target="_blank" class="butt">Get offer</a></div>
            </div>
        @endforeach
        {{--{!! $offers->links() !!}--}}
        <a href="#top" class="btn btn-warning" style="position:fixed;bottom:100px;right:100px;"><i class="fas fa-arrow-up"></i></a>
</div>
    </section>
    <footer>
        <div class="container">
            <div class="foo">
                <p>2018 MadeByDigital. All rights reserved.</p>
                <ul>

                    @foreach($customPages as $customPage)
                    
                    <a href="#" class="list-foo">{{$customPage->name}}</a>

                    @endforeach
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
<script src="{{ asset('public/front/js/main.js') }}"></script>
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
                         $('.offers').append(data.offers);
                         $('.endless-pagination').data('next-page', data.next_page);
                     });
                 }
             }, 350))
  
         }
     }
  
  
 })

</script>

</html>