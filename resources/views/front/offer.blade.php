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
            <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
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
        <section id="form">
            <form class="form-com" action="">
                <div class="form-group">
                    <div class="container">
                        <label for="area">ADD YOUR COMMENT</label>
                        <textarea class="form-control" id="area"></textarea>
                        <i class="fas fa-user"></i><input type="name" class="form-control" id="name" aria-describedby="emailHelp"
                            placeholder="Name">
                        <i class="fas fa-envelope-square"></i><input type="E-mail" class="form-control" id="E-mail"
                            aria-describedby="emailHelp" placeholder="E-mail">
                        <button class="btn btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </section>
        <section id="naslov">
            <div class="naslov">
                <h2>Coupons</h2>
            </div>
        </section>
        <section id="zadnja">
            <div class="container">
                <div class="row">
                    <div class="box col-md-10">
                        <div class="box1">
                            <img class="imag" src="{{ $offer->img_src }}" width="150px" height="150px">
                        </div>
                        <div class="box2">
                            <a href="" class="naslov" style="margin-top: 20px;">{{ $offer->name }}</a><br>
                            <a href="" class="text">{{ $offer->highligth }}</a><br>
                            <a href="" class="text">{{ $offer->summary }}</a>
                        </div>
                        <div class="box3">
                            <p style="text-align: end; margin-right: -40%;">{{ $offer->created_at->toFormattedDateString() }}</p>
                            <button class="btn btn-prvi"><a class="text-white" href="#">Get offer</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="naslov">
            <div class="naslov">
                <h2>More offers you might like</h2>
            </div>
        </section>
        <section id="zadnja">
            @foreach($simillarOffers as $off)
            <div class="container">
                <div class="row">
                    <div class="box col-md-10">
                        <div class="box1">
                            <img class="imag" src="{{ $off->img_src }}" width="150px" height="150px">
                        </div>
                        <div class="box2">
                            <a href="" class="naslov" style="margin-top: 20px;">{{ $off->name }}</a><br>
                            <a href="" class="text">{{ $off->highligth }}</a><br>
                            <a href="" class="text">{{ $off->summary }}s</a>
                        </div>
                        <div class="box3">
                            <p style="text-align: end; text-align: end;">{{ $off->created_at->toFormattedDateString() }}</p>
                            <button class="btn"><a class="text-white" href="#">Get offer</a></button>
                            <button class="btn"><a class="text-white" href="druga.html">No comments</a></button>
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
    </footer>
    <a href="#top">
        <i class="fas fa-arrow-up"></i>
    </a>
</body>
<script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js "></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>

</html>