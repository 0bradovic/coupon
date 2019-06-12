<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @if(isset($title))
    <title>{{ $title }}</title>
    @else
    <title>BeforeTheShop</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700,700i|Exo:400,400i,700,700i|Kodchasan:400,400i,700,700i|Lato:400,400i,700,700i|Montserrat:400,400i,700,700i|Muli:400,400i,700,700i|Open+Sans:400,400i,700,700i|Poppins:400,400i,700,700i|Roboto:400,400i,700,700i|Titillium+Web:400,400i,700,700i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/newStyle.css') }}" />
    @if(Helpers::getFavicon() == null)
    <link rel="shortcut icon" href="/front/image/favicon.png">
    @else
    <link rel="shortcut icon" href="{{Helpers::getFavicon()}}">
    @endif
    @if(\Request::route()->getName() == 'category.offers' || \Request::route()->getName() == 'parent.category.offers')
        @if(isset($category))
            @if($category != null)
                {!! Helpers::getMetaTagsCategory($category->id) !!}
            @endif
        @endif
    @elseif(\Request::route()->getName() == 'offer')
        @if(isset($offer))
            @if($offer != null)
                {!! Helpers::getMetaTagsOffer($offer->id) !!}
            @endif
        @endif
    @else
        {!! Helpers::getMetaTags() !!} 
    @endif
    
    <meta name="google-site-verification" content="SgQNy4xCCKPlSXWI5nA4Vz6mW7vWJz6ghcyyH2xitIE" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129562058-1"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    
     gtag('config', 'UA-129562058-1');
    </script>
    <!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3613410372125024",
    enable_page_level_ads: true
    });
    </script>-->
</head>

<body>
    @include('front.header')

    @include('layouts.errors')
    @include('layouts.messages')
    
    @yield('content')

    @include('front.footer')
    @php $popup = Helpers::getPopup(); @endphp
    <a href="" class="go_top hidden">TOP<i class="fas fa-arrow-up"></i></a>
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
                            <div class="popUp_miniform">
                            <input type="email" name="email">
                            <button type="submit" id="newsletter_submit">{{ $popup->button }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="fixed_btn_in_form_text">
                    {!! $popup->second_section !!}
                </div>
             <button class="btn close-modal">No thanks</button>
        </div>
    </div>
    @php $redirectPopup = Helpers::getRedirectPopup(); @endphp
    <div class="popUp_redirect hidden" id="redirect-popup">
        <div class="popUp_redirect_holder">
        <i class="fas fa-times-circle close_redirect_popUp"></i>
            <div class="popUp_redirect_text">
                {!! $redirectPopup->text !!}
            </div>
            <div class="popUp_redirect_button">
                <a href="" id="redirect-link" target="_blank">{{ $redirectPopup->button_text }}</a>
            </div>
        </div>
    </div>
</body>
<script> 
var SITE_URL = '<?php echo env("APP_URL")?>/';
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script type="text/javascript">
@if (count($errors) > 0)
    function showModal(){
        $(".fixed_btn_form").fadeToggle(300);
    }
    setTimeout(showModal, 2000);
@endif

</script>
@yield('scripts')
</html>