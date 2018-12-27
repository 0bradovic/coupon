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
        
        <div class="fiksirano">
        @if(count($offer->comments) > 0)
            <section id="titlee">
                <h6>1 Comment</h6>
            </section>
            <div class="sekcija">
                <section id="users">
                    <div class="user">
                        <img src="./assets/image/user.png">
                        <div class="gore">
                            <a href="#" class="ime">Sharpie</a>
                            <a href="#" class="date">August 21, 2018 at 10:32 am</a>
                            <a href="#" class="link">Replay</a>
                        </div>
                    </div>
                </section>
                <section id="users-com">
                    <div class="com">
                        <p>This is a great offer</p>
                    </div>
                </section>
            </div>
            <div class="sekcija aaa">
                <section id="userss">
                    <div class="user">
                        <img src="./assets/image/user.png">
                        <div class="gore">
                            <a href="#" class="ime">Sharpie</a>
                            <a href="#" class="date">August 21, 2018 at 10:32 am</a>
                        </div>
                    </div>
                </section>
                <section id="users-comm">
                    <div class="com">
                        <p>This is a great offer</p>
                    </div>
                </section>
            </div>
            @endif
            <section id="forma">
                <div class="form">
                    <h5>ADD YOUR COMMENT</h5>
                    <form action="">
                        <textarea name="commentar" id="textArea" cols="30" rows="10"></textarea>
                        <div class="name-box">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Name" class="name">
                        </div>
                        <div class="name-box">
                            <i class="fas fa-envelope-square"></i>
                            <input type="text" placeholder="E-mail" class="name">
                        </div>
                        <a href="#" class="submit">Submit</a>
                    </form>
                </div>
            </section>
        </div>
        <section id="cont">
            <div class="sve">
                <div class="container">
                    <h3 class="h3-prvi">{{ $mainCategory->name }}</h3>
                </div>
                <div class="container">
                    <div class="fiXXX sirina">
                        <div class="fix">
                            <div class="fix-img">
                                <img class="imag" src="{{ $offer->img_src }}" width="170px" height="140px">
                            </div>
                            <div class="fix-text">
                                <a  class="fix-a">{{ $offer->name }}</a>
                                @if($offer->detail)
                                <a  class="fix-a">{!! $offer->detail !!}</a>
                                @endif
                            </div>
                            <div class="dugmici">
                                <p class="datum">@if($offer->endDate){{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                                <a href="{{$offer->link}}" class="dugme">Get offer</a>
                                <a class="dugme">@if(count($offer->comments) > 0){{ count($offer->comments) }} comments @else No comments @endif</a>
                            </div>
                        </div>
                    </div>
                    <div class="container coN">
                        <h3>More offers you might like</h3>
                    </div>
                    <div class="fiXXX sirina">
                        @foreach($simillarOffers as $off)
                        <div class="fix">
                            <div class="fix-img">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <img class="imag" src="{{ $off->img_src }}" width="170px" height="140px">
                            </a>
                            </div>
                            <div class="fix-text">
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{{ $off->name }}</a>
                                @if($off->detail)
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{!! $off->detail !!}</a>
                                @endif
                            </div>
                            <div class="dugmici">
                                <p class="datum">@if($off->endDate){{ $off->dateFormat( $off->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                                <a href="{{ $off->link }}" class="dugme">Get offer</a>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" class="dugme">@if(count($off->comments) > 0){{ count($off->comments) }} comments @else No comments @endif</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
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