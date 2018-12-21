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

// Category routes
Route::get('/categories', 'CategoryController@index');
Route::get('/create/category', 'CategoryController@create')->name('create.category');
Route::post('/store/category', 'CategoryController@store')->name('store.category');
Route::get('/edit/category/{id}', 'CategoryController@edit')->name('edit.category');
Route::post('/update/category/{id}', 'CategoryController@update')->name('update.category');
Route::get('/delete/category/{id}', 'CategoryController@destroy')->name('delete.category');

// Offer type routes
Route::get('/offer-types', 'OfferTypeController@index');
Route::get('/create/offer-type', 'OfferTypeController@create')->name('create.offer-type');
Route::post('/store/offer-type', 'OfferTypeController@store')->name('store.offer-type');
Route::get('/edit/offer-type/{id}', 'OfferTypeController@edit')->name('edit.offer-type');
Route::post('/update/offer-type/{id}', 'OfferTypeController@update')->name('update.offer-type');
Route::get('/delete/offer-type/{id}', 'OfferTypeController@destroy')->name('delete.offer-type');

// Offer routes
Route::get('/offes', 'OfferController@index');
Route::get('/create/offer', 'OfferController@create')->name('create.offer');
Route::post('/store/offer', 'OfferController@store')->name('store.offer');
Route::get('/edit/offer/{id}', 'OfferController@edit')->name('edit.offer');
Route::post('/update/offer/{id}', 'OfferController@update')->name('update.offer');
Route::get('/delete/offer/{id}', 'OfferController@destroy')->name('delete.offer');

// Tag routes
Route::get('/tags', 'TagController@index');
Route::get('/create/tag', 'TagController@create')->name('create.tag');
Route::post('/store/tag', 'TagController@store')->name('store.tag');
Route::get('/edit/tag/{id}', 'TagController@edit')->name('edit.tag');
Route::post('/update/tag/{id}', 'TagController@update')->name('update.tag');
Route::get('/delete/tag/{id}', 'TagController@destroy')->name('delete.tag');
