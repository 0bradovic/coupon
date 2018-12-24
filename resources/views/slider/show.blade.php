<head>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/animate.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/font/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/font/climacon-font/styles.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('front/css/style.css') }}" />
</head>
<body>
<div class="row">
        <div class="col-xs-12">
            <div class="box">
            <article>
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
        </article>
            </div>
        </div>
    </div>
    <script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js "></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
</body>
