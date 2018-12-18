@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="offers_holder">
        <h2>List of Offers</h2>
        <div class="offers_head">
            <div class="offer_title">
                <p>Title</p>
            </div>
            <div class="offer_author">
                <p>Authors name</p>
            </div>
            <div class="offer_categories">
            <p>Categories</p>
            </div>
            <div class="offer_tags">
            <p>Tags</p>
            </div>
            <div class="offer_publish_date">
            <p>Date</p>
            </div>
            <div class="offer_expire_date">
            <p>Expiration Date</p>
            </div>
        </div>

        <div class="offer_item">
            <div class="offer_title">
                <p>
                    <a href="">Free sample of Little Chompers Pet Food</a>
                </p>
            </div>
            <div class="offer_author">
                <p>Sarah Greenwood</p>
            </div>
            <div class="offer_categories">
                <p>
                    <a href="">Coupons,</a> 
                    <a href="">Fresh & Chilled Food</a> 
                </p>
            </div>
            <div class="offer_tags">
                <p>
                    <a href="">Bonne Mamam, </a>
                    <a href="">Dessert, </a>
                    <a href="">chocolate fondant, </a>
                    <a href="">baba au rhum, </a>
                    <a href="">tarte tatin, </a>
                    <a href="">creme caramel, </a>
                    <a href="">creme brulee, </a>
                    <a href="">desserts</a>
                </p>
            </div>
            <div class="offer_publish_date">
                <p>Published: <span>2018/11/21</span></p>
            </div>
            <div class="offer_expire_date">
                <p>Novemver 23, 2018</p>
            </div>

             <div class="offer_crud">
                <a href="">Edit</a>
                <a href="">Delete</a>
                <a href="">New</a>
            </div>
        </div>

        <div class="offer_item">
            <div class="offer_title">
                <p>
                    <a href="">Free sample of Little Chompers Pet Food</a>
                </p>
            </div>
            <div class="offer_author">
                <p>Sarah Greenwood</p>
            </div>
            <div class="offer_categories">
                <p>
                    <a href="">Coupons,</a> 
                    <a href="">Fresh & Chilled Food</a> 
                </p>
            </div>
            <div class="offer_tags">
                <p>
                    <a href="">Bonne Mamam, </a>
                    <a href="">Dessert, </a>
                    <a href="">chocolate fondant, </a>
                    <a href="">baba au rhum, </a>
                    <a href="">tarte tatin, </a>
                    <a href="">creme caramel, </a>
                    <a href="">creme brulee, </a>
                    <a href="">desserts</a>
                </p>
            </div>
            <div class="offer_publish_date">
                <p>Published: <span>2018/11/21</span></p>
            </div>
            <div class="offer_expire_date">
                <p>Novemver 23, 2018</p>
            </div>

            <div class="offer_crud">
                <a href="">Edit</a>
                <a href="">Delete</a>
                <a href="">New</a>
            </div>
        </div>
    </div>

    <div class="new_offer">
        <div class="offer_title">
            <h3>Offer Title</h3>
            <input type="text" placeholder="Enter Title Here">
        </div>

        <div class="offer_text">
            <h3>Offer Text</h3>
            <div class="offer_text_item">
                <input type="text" placeholder="Enter Text Here">
            </div>
            <div class="offer_text_item">
                <input type="text" placeholder="Enter Text Here">
            </div>
            <div class="offer_text_item">
                <input type="text" placeholder="Enter Text Here">
            </div>
            <div class="offer_text_add_new_item">
                <button>Add New Text Item</button>
            </div>
        </div>

        <div class="offer_categories">
            <h3>Offer Categories</h3>
            <ul>
                <li>
                    <input type="checkbox"> Category Parent 
                    <ul>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                    </ul>
                </li>

                 <li>
                    <input type="checkbox"> Category Parent 
                    <ul>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                        <li>
                            <input type="checkbox"> Category Child 
                        </li>
                    </ul>
                </li>
            </ul>


            <div class="publish_offer">
                <button class="">Publish Offer</button>
            </div>
        </div>

    </div>
@stop