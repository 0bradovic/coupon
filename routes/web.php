<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoryController@index');
Route::get('/create/category', 'CategoryController@create')->name('create.category');
Route::post('/store/category', 'CategoryController@store')->name('store.category');
Route::get('/edit/category/{id}', 'CategoryController@edit')->name('edit.category');
Route::post('/update/category/{id}', 'CategoryController@update')->name('update.category');
Route::get('/delete/category/{id}', 'CategoryController@destroy')->name('delete.category');

Route::get('/offers/index', 'OfferController@createOffer')->name('offer.create');
Route::post('/offers/store', 'OfferController@storeOffer')->name('offer.store');