<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Web</title>
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
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                </form>
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
        <section id="naslov">
            <h2>Search results for {{ $search }}</h2>
        </section>
        <section id="work">
            @foreach($offers as $offer)
            <div class="container">
                <div class="row">
                    <div class="box">
                        <div class="box1">
                            <img class="imag" src="{{ $offer->img_src }}" width="150px" height="150px">
                        </div>
                        <div class="box2">
                            <a href="" class="naslov">{{ $offer->name }}</a><br>
                            <a href="" class="text">{{ $offer->highligth }}</a><br>
                            <a href="" class="text">{{ $offer->summary }}</a>
                        </div>
                        <div class="box3">
                            <p style="text-align: end; text-align: center;">{{ $offer->created_at->toFormattedDateString() }}</p>
                            <button class="btn"><a class="text-white" href="#">Get offer</a></button>
                            <button class="btn"><a class="text-white" href="#">No comments</a></button>
                        </div>
                    </div>
                </div>
            </div>
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
<script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js "></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
</html>