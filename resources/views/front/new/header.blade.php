<header id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="header-navbar-right">
                    <i id="mob_menu" class="fa fa-bars" aria-hidden="true"></i>
                    
                    @if(Helpers::getLogo() == null)
                    <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                    @else
                    <a class="navbar-brand" href="/"><img src="{{ Helpers::getLogo() }}" style="height:38px;width:auto;"></a>
                    @endif
                <a class="uk-etc" style="color:{{ Helpers::getTagline()->color }}; @if(Helpers::getTagline()->font_family) font-family:'{{Helpers::getTagline()->font_family}}',sans-serif; @endif @if(Helpers::getTagline()->font_size) font-size:{{Helpers::getTagline()->font_size}} @endif">{!! Helpers::getTagline()->text !!}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                </div>
                
                <div class="header-form-left">
                    <div class="navbar_search_form" id="navbarSupportedContent">
                    <form autocomplete="off" class="form-inline my-2 my-lg-0" action="{{route('search.blade')}}" method="GET">
                        <button class="btn btn1" type="submit"><i class="fas fa-search"></i></button>
                        <input autocomplete="off" id="search" class="form-control mr-sm-2 searchh" type="search" name="search" placeholder="Search for a brand or retailer" aria-label="Search">
                        {!! csrf_field() !!}
                    </form>

                        <div class="search-div disable" id="serachDiv">
                        </div>
                </div>
                <div class="social_icons">
                    <a href="#" class="social_icons_like">Like us?<br>Tell a freind...</a>
                    <div class="social_icons_all">
                    <div class="social_icons_div">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.beforetheshop.com&title=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! www.beforetheshop.com&summary=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! www.beforetheshop.com" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div">
                    <a href="https://twitter.com/intent/tweet?url=http://www.beforetheshop.com&text=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too!" target="_blank">
                    <i class="fab fa-twitter"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div">
                    <a href="http://pinterest.com/pin/create/button/?url=http://www.beforetheshop.com&description=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com" target="_blank">
                    <i class="fab fa-pinterest-p"></i>
                    
                    </a>
                    </div>
                    <div id='email_form' class="social_icons_div">
                    <a id="mailto" href="#">
                    <i class="far fa-envelope"></i>
                    
                    </a>
                    </div>
                    <div class="social_icons_div_absolute" style="display:none;">
                        <input id="emailinput" type="text" placeholder="Enter Email" />
                        <button id="mailto_button"><a href="" id="send_mail">Share</a></button>
                        
                    </div>
                   
                    <div class="social_icons_div">
                    <a href="https://wa.me/?text=I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                   
                    </a>
                    </div>
                    </div>
                </div>
                
                </div>
                
            </nav>
        </div>
        <section id="menu">
                    
                    <div class="container dropdowns_holder">
                        @php $i = 1; @endphp
                        <div class="mobile-menu-paragraph">
                            <p>CATEGORIES (click down icon to see more)</p>
                        </div>
                    @foreach($categories as $category)
                        <div class="dropdown" data-id="{{ $i }}">
                        
                        <div class="dropdown_row"><a href="{{ route('parent.category.offers',['slug' => $category->slug]) }}" class="dropbtn @if($loop->first) tdu @endif" data-id="{{$i}}">{{ $category->name }}</a><i class="fas fa-caret-down open_sub"></i></div>
                       
                   
                    <div class="dropdown-content" >
                        <div class="dropdown-container d-none" id="cont{{$i}}">
                            @foreach($category->liveSubcategories as $cat)
                            
                                <a href="{{ route('category.offers',['slug' => $cat->slug]) }}" @if(Request::is($cat->slug)) style="text-decoration: underline;" @endif >{{ $cat->name }}</a>
                           
                            @endforeach
                           
                        </div>
                    </div>
                    
                   
                            <div class="new_sub_menu" id="{{ $i }}">
                            <a class="back"><i class="fas fa-caret-left"></i> Main menu</a>               
                                @foreach($category->liveSubcategories as $cat)
                            
                                    <a href="{{ route('category.offers',['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                       
                                @endforeach       
                                                                                                         
                            </div>
                        
                       
                        </div>
                        @php $i++; @endphp
                    @endforeach
                    </div>
                   
                    
                    <div class="hidden-lg hidden-md hidden-sm navbar-buttons">
                    <p class="newest-offers">Viewing newest offers </p>
                    <a class="btn btn-default newest-offers" id="most-popular-btn">View most popular</a>
                    <p class="dNone most-popular-offers">Viewing most popular offers </p>
                    <a class="btn btn-default dNone most-popular-offers" id="newest-btn">View newest</a>
                </div> 
                </section>
    </header>