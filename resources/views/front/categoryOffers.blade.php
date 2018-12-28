<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BeforeTheShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
    {!! Helpers::getMetaTags() !!} 
</head>

<body>
    <header>
        <div class="container">
            <a href="/public/" class="logo">BeforeTheShop</a>
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
        <section id="cont">
            <div class="container">
                <h2>{{ $category->name }}</h2>
            </div>
            <div class="container">
            @foreach($offers as $offer)
                <div class="fiXXX">
                    <div class="fix">
                        <div class="fix-img">
                        <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                        <img class="imag" src="{{ '/public/'.$offer->img_src }}" width="170px" height="140px">
                        </a>
                        </div>
                        <div class="fix-text">
                            <a href="{{ route('offer',['slug' => $offer->slug]) }}" class="fix-a">{{ $offer->name }}</a>
                            @if($offer->detail)
                            <a href="{{ route('offer',['slug' => $offer->slug]) }}" class="fix-a">{!! $offer->detail !!}</a>
                            @endif
                        </div>
                        <div class="dugmici">
                            <p class="datum">@if($offer->endDate)Ends {{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                            <a href="{{ $offer->link }}" class="dugme">Get offer</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
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