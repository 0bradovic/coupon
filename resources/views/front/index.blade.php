<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TEstttt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/animate.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/font/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/font/climacon-font/styles.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/style.css') }}" />
</head>

<body>  
    <header id="header">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.html"><b>BeforeTheShop</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0">
                    <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                    <input class="form-control mr-sm-2" id="search" type="search" placeholder="Search" aria-label="Search">
                </form>
                <div class="searchdiv"></div>
            </div>
        </nav>
    </header>
    <article>
        <section id="menu">
        @foreach($categories as $key=>$value)
            <div class="dropdown">
               
                <button class="dropbtn">{{ $key }}<span class="spanrr">{{end($value)}} offers</span><i class="fas fa-chevron-down"
                        style="margin-left: 20px;"></i></button>
               
                <div class="dropdown-content">
                @foreach($value as $cat)
                @if(is_object($cat))
                    <a href="#">{{ $cat->name }}<span class="spanr">{{ count($cat->offers) }} offers</span></a>
                @endif
                @endforeach
                </div>
             
            </div>
            @endforeach
        </section>
        <section id="carousel">
            <div class="container">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($slides as $slide)
                        <div @if($slide == $slides[0]) class="carousel-item active" @else class="carousel-item" @endif>
                            <img class="d-block w-100" src="{{ $slide->img_src }}" alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $slide->down_text }}</h5>
                            </div>
                        </div>
                        @endforeach
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="box">
            @foreach($categories as $key=>$value)
                @foreach($value as $cat)
                @if(is_object($cat) && count($cat->offers) > 0)
                
            <div class="container-fluid">
                <div class="row glavni">
                    <div class="col-auto col-12 col-md-12 col-sm-12 col-lg-2 col-xl-2 boxx">
                        <h3><b>{{ $cat->name }}</b></h3>
                    </div>
                    @foreach($cat->offers()->limit(3)->orderBy('position')->get() as $offer)
                    <div class="col-auto col-12 col-md-12 col-sm-12 col-lg-2 col-xl-2 boxx hov">
                    <div class="popust" style="background-color:{{ $offer->offerType->color }}"><p class="popustText">{{ $offer->offerType->name }}</p></div>
                        <div class="in-box">
                        <a href="{{ route('offer',['id' => $offer->id]) }}" class="boxxx">
                            <img src="{{ $offer->img_src }}" alt="">
                            <p class="boxP">{{ $offer->name }}</p>
                        </a>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="col-auto col-12 col-md-12 col-sm-12 col-lg-2 col-xl-2 boxx">
                        <a href="{{ route('category.offers',['id' => $cat->id]) }}" class="btn-see">@if(count($cat->offers) > 3)See {{ count($cat->offers)-3 }} more...@else No more offers... @endif</a>
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
            © 2014 Copyright Text
            <a class="right" href="#" style="float:right;">Mail Us</a>
            <a class="right" href="#" style="float:right;">Privacy Policy</a>
        </div>
        </div>
    </footer>
</body>
<script> 
var SITE_URL = '<?php echo env("APP_URL")?>/';
</script>
<script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js "></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>

</html>