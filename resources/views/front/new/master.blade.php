<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>BeforeTheShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700,700i|Exo:400,400i,700,700i|Kodchasan:400,400i,700,700i|Lato:400,400i,700,700i|Montserrat:400,400i,700,700i|Muli:400,400i,700,700i|Open+Sans:400,400i,700,700i|Poppins:400,400i,700,700i|Roboto:400,400i,700,700i|Titillium+Web:400,400i,700,700i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/style.css') }}" />
    @if(Helpers::getFavicon() == null)
    <link rel="shortcut icon" href="/front/image/favicon.png">
    @else
    <link rel="shortcut icon" href="{{Helpers::getFavicon()}}">
    @endif
    {!! Helpers::getMetaTags() !!} 
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129562058-1"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    
     gtag('config', 'UA-129562058-1');
    </script>
    
</head>

<body>
    @include('front.new.header')

    @include('layouts.errors')
    @include('layouts.messages')

    @include('front.new.slider')
    
    @yield('content')

    @include('front.new.footer')

</body>
<script> 
var SITE_URL = '<?php echo env("APP_URL")?>/';
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('front/js/main.js') }}"></script>

</html>