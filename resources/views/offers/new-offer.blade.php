@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
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
            
        </div>

             <div class="publish_offer">
                <button class="">Publish Offer</button>
        </div>
    </div>
@stop