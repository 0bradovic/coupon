<header>
        <div class="container">
            <div class="header_top">
                <div class="header_top_left">
                    <i class="fa fa-bars open_menu" aria-hidden="true"></i>
                    @if(Helpers::getLogo() == null)
                        <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                    @else
                        <a class="navbar-brand" href="/">
                            <img class="logo" src="{{ Helpers::getLogo() }}" alt="logo">
                        </a>
                    @endif
                    <p style="color:{{ Helpers::getTagline()->color }}; @if(Helpers::getTagline()->font_family) font-family:'{{Helpers::getTagline()->font_family}}',sans-serif; @endif @if(Helpers::getTagline()->font_size) font-size:{{Helpers::getTagline()->font_size}} @endif">
                        {!! Helpers::getTagline()->text !!}
                    </p>
                </div>
                <div class="header_search">
                    <form action="{{route('search.blade')}}" method="GET">
                        <label for="search"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a><input id="search"
                                type="text" placeholder="Search for a brand or retailer"></label>
                        <div class="search_result hidden">
                            
                        </div>
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            @php $menuCategories = Helpers::getMenuCategories(); @endphp
            <div class="header_bottom">
                <ol class="navigation">
                    @foreach($menuCategories as $menuCategory)
                    <li><a href="{{ route('parent.category.offers',['slug' => $menuCategory->slug]) }}" class="navigation_item">{{ $menuCategory->name }}</a>
                        <ul class="submenu hidden">
                            @foreach($menuCategory->liveSubcategories as $subcategory)
                            <li><a href="{{ route('category.offers',['slug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ol>
                @if(\Request::route()->getName() != 'welcome')
                <div class="header_viewOfferButtons">
                    <p class="header_viewNewest hidden800">Viewing newest offers</p>
                    <a href="#" class="header_btn_viewNewest ">View newest offers</a>
                    <p class="header_mostPopular ">Viewing most popular</p>
                    <a href="#" class="header_btn_mostPopular hidden800">View most popular</a>
                </div>
                @endif
            </div>
        </div>
    </header>
    <div id="mobile_navigation" class="show_mobile_navigation">
        <div class="header_top">
            <div class="header_top_left">
                <i class="fa fa-times close_menu" aria-hidden="true"></i>
                    @if(Helpers::getLogo() == null)
                        <a class="navbar-brand" href="/"><b>BeforeTheShop</b></a>
                    @else
                        <a class="navbar-brand" href="/">
                            <img class="logo" src="{{ Helpers::getLogo() }}" alt="logo">
                        </a>
                    @endif
                    <p style="color:{{ Helpers::getTagline()->color }}; @if(Helpers::getTagline()->font_family) font-family:'{{Helpers::getTagline()->font_family}}',sans-serif; @endif @if(Helpers::getTagline()->font_size) font-size:{{Helpers::getTagline()->font_size}} @endif">
                        {!! Helpers::getTagline()->text !!}
                    </p>
            </div>
            <div class="header_search">
                <form action="{{route('search.blade')}}" method="GET">
                    <label for="search"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a><input
                            type="text" placeholder="Search for a brand or retailer"></label>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
        <div class="mobile_menu_content">
            <div class="mobile-menu-paragraph">
                <p>CATEGORIES (click down icon to see more)</p>
            </div>
            @foreach($menuCategories as $menuCategory)
            <div class="dropdown_item">
                    <div class="dropdown_item_click">
                        <a href="{{ route('parent.category.offers',['slug' => $menuCategory->slug]) }}">{{ $menuCategory->name }}</a> <i class="fa fa-caret-down open_dropdown" aria-hidden="true"></i>
                    </div>
                <ul class="dropdown_list dropdown_list_none">
                    <li><a class="main_menu" href="#"><i class="fa fa-caret-left" aria-hidden="true"></i> Main menu</a>
                    </li>
                    @foreach($menuCategory->liveSubcategories as $subcategory)
                    <li><a href="{{ route('category.offers',['slug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>