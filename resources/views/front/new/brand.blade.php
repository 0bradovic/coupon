@extends('front.new.master')

@section('content')
<div class="category_page">
    <div class="popular_brands_row">
        <div class="popular_brands_row_left">
        <div class="popular_brands_text">Farmfoods</div>
        <div class="popular_brands_text">
            <h5>Popular Brands:</h5>
            <a href="#">Ariel,</a>
            <a href="#">Bold,</a>
            <a href="#">Coca-Cola,</a>
            <a href="#">Heinz,</a>
            <a href="#">Krispy,</a>
            <a href="#">Loctite,</a>
            <a href="#">Peperami,</a>
            <a href="#">Walkers</a>
        </div>
        </div>
        <div class="popular_brands_row_right">
        <form action="{{route('search.blade')}}" method="GET">
                        <label for="search"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a><input id="search"
                                type="text" placeholder="Search for a brand or retailer"></label>
                        <div class="search_result hidden">
                            
                        </div>
                        {!! csrf_field() !!}
                    </form>
        </div>
    </div>
<div class="category_page_holder">
    <div class="category_blade">
        <div class="category_blade_row most_popular">
            <div class="category_blade_title">
                <span>Most Popular</span>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="category_blade_row newest_offers hidden800">
            <div class="category_blade_title">
                <span>Newest offers</span>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        <img src="../../../front/image/k1.jpg" />
                    </div>
                    <div class="category_blade_box_date">
                        <span class="coupon">Coupon</span>
                        <div class="category_blade_box_date_top">
                            FREE welcome gift
                        </div>
                        <div class="category_blade_box_date_bottom">
                            <p>ends</p>
                            <p>Jul 10</p>
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <div class="category_blade_box_text_top">
                            Every 10th drink is free.Instore. Boost.Download the Boost app register. 
                        </div>
                        <div class="category_blade_box_text_bottom">
                            <button>Get This <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ad_sense">
        
    </div>
</div>
</div>
@endsection