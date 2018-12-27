<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BeforeTheShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
</head>

<body>
    <header>
        <div class="container">
            <a href="/" class="logo">BeforeTheShop</a>
            <div class="search">
            <form class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="POST">
                <input class="searchh" type="text" name="search" id="search" placeholder="Search">
                <button class="search-btn"><i class="fas fa-search"></i></button>
                {!! csrf_field() !!}
            </form>
            <div class="search-div disable" id="serachDiv">
                </div>
            </div>
        </div>
    </header>
    <article>
        <section id="menu">
            <div class="container">
            @foreach($categories as $key=>$value)
                <div class="dropdown">
                    <button class="dropbtn">{{ $key }}<span class="spanrr">{{end($value)}} offers</span><i class="fas fa-chevron-down"
                            style="margin-left: 20px;"></i></button>
                    <div class="dropdown-content">
                    @foreach($value as $cat)
                    @if(is_object($cat))
                        <a href="{{ route('category.offers',['slug' => $cat->slug]) }}">{{ $cat->name }}<span class="spanr">{{ count($cat->offers) }} offers</span></a>
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
                                <img class="d-block w-100" src="{{ $slide->img_src }}" alt="First slide">
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
        @foreach($categories as $key=>$value)
                @foreach($value as $cat)
                @if(is_object($cat) && count($cat->offers) > 0)
            <div class="container">
                <div class="boXXX">
                    <div class="boxes">
                        <div class="box">
                            <div class="box-title">
                                <a href="{{ route('category.offers',['id' => $cat->id]) }}">
                                <p class="title">{{ $cat->name }}</p>
                                </a>
                            </div>
                        </div>
                        @foreach($cat->offers()->limit(3)->orderBy('position')->get() as $offer)
                        <div class="box">
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                            <div class="box-hover">
                            @if($offer->offerType)
                                <div class="popust" style="background-color:{{ $offer->offerType->color }}">
                                    <p class="popustText" >{{ $offer->offerType->name }}</p>
                                </div>
                            @endif
                                <div class="box-image">
                                    <img src="{{ $offer->img_src }}">
                                </div>
                                <div class="box-text">
                                    <p class="text">{{ $offer->name }}</p>
                                </div>
                            </div>
                        </a>
                        </div>
                        @endforeach
                        <div class="box">
                            <div class="btn-seeMore">
                                <a href="{{ route('category.offers',['id' => $cat->id]) }}" class="btnn">@if(count($cat->offers) > 3)See {{ count($cat->offers)-3 }} more...@else No more offers... @endif</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @endif
            @endforeach
            @endforeach
                
        </section>
    </article>
    <footer id="footer">
        <div class="container">
            <div class="footer-left">
                <p>2018 MadeByDigital. All rights reserved.</p>
            </div>
            <div class="footer-right">
                <p>Privacy Policy</p>
                <p>Mail Us</p>
            </div>
        </div>
    </footer>
</body>
<script> 
var SITE_URL = '<?php echo env("APP_URL")?>/';
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
</html>