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

Route::get('/', 'FrontController@index');
Route::get('/category/{slug}', 'FrontController@categoryOffers')->name('category.offers');
Route::get('/offer/{slug}', 'FrontController@offer')->name('offer');
Route::get('/search/{id}', 'FrontController@ajaxSearch')->name('ajax.search');
Route::post('/comment/send', 'FrontController@sendComment')->name('comment.send');
Route::post('/search', 'FrontController@renderSearch')->name('search.blade');
Route::get('/seo/meta', 'SeoController@getMetaTags')->name('seo.meta.tag');

Auth::routes();
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
 });
Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => ['permission:manage categories']], function () {
        // Category routes
        Route::get('/categories', 'CategoryController@index');
        Route::get('/create/category', 'CategoryController@create')->name('create.category');
        Route::post('/store/category', 'CategoryController@store')->name('store.category');
        Route::get('/edit/category/{id}', 'CategoryController@edit')->name('edit.category');
        Route::post('/update/category/{id}', 'CategoryController@update')->name('update.category');
        Route::get('/delete/category/{id}', 'CategoryController@destroy')->name('delete.category');
    });

    Route::group(['middleware' => ['permission:manage offer types']], function () {
        // Offer type routes
        Route::get('/offer-types', 'OfferTypeController@index');
        Route::get('/create/offer-type', 'OfferTypeController@create')->name('create.offer-type');
        Route::post('/store/offer-type', 'OfferTypeController@store')->name('store.offer-type');
        Route::get('/edit/offer-type/{id}', 'OfferTypeController@edit')->name('edit.offer-type');
        Route::post('/update/offer-type/{id}', 'OfferTypeController@update')->name('update.offer-type');
        Route::get('/delete/offer-type/{id}', 'OfferTypeController@destroy')->name('delete.offer-type');
    });

    Route::group(['middleware' => ['permission:manage offers']], function () {
        // Offer routes
        Route::get('/offes', 'OfferController@index');
        Route::get('/create/offer', 'OfferController@create')->name('create.offer');
        Route::post('/store/offer', 'OfferController@store')->name('store.offer');
        Route::get('/edit/offer/{id}', 'OfferController@edit')->name('edit.offer');
        Route::post('/update/offer/{id}', 'OfferController@update')->name('update.offer');
        Route::get('/delete/offer/{id}', 'OfferController@destroy')->name('delete.offer');
    });

    Route::group(['middleware' => ['permission:manage tags']], function () {
        // Tag routes
        Route::get('/tags', 'TagController@index');
        Route::get('/create/tag', 'TagController@create')->name('create.tag');
        Route::post('/store/tag', 'TagController@store')->name('store.tag');
        Route::get('/edit/tag/{id}', 'TagController@edit')->name('edit.tag');
        Route::post('/update/tag/{id}', 'TagController@update')->name('update.tag');
        Route::get('/delete/tag/{id}', 'TagController@destroy')->name('delete.tag');
    });

    Route::group(['middleware' => ['permission:manage roles']], function () {
        // Role routes
        Route::get('/roles', 'RoleController@index');
        Route::get('/create/role', 'RoleController@create')->name('create.role');
        Route::post('/store/role', 'RoleController@store')->name('store.role');
        Route::get('/edit/role/{id}', 'RoleController@edit')->name('edit.role');
        Route::post('/update/role/{id}', 'RoleController@update')->name('update.role');
        Route::get('/delete/role/{id}', 'RoleController@destroy')->name('delete.role');
    });

    Route::group(['middleware' => ['permission:manage users']], function () {
        // User rooutes
        Route::get('/users', 'UserController@index');
        Route::get('/create/user', 'UserController@create')->name('create.user');
        Route::post('/store/user', 'UserController@store')->name('store.user');
        Route::get('/edit/user/{id}', 'UserController@edit')->name('edit.user');
        Route::post('/update/user/{id}', 'UserController@update')->name('update.user');
        Route::get('/delete/user/{id}', 'UserController@destroy')->name('delete.user');
    });

    Route::group(['middleware' => ['permission:manage slider']], function () {
        // Slider routes
        Route::get('/slides', 'SliderController@index');
        Route::get('/create/slide', 'SliderController@create')->name('create.slide');
        Route::post('/store/slide', 'SliderController@store')->name('store.slide');
        Route::get('/preview/slider', 'SliderController@show')->name('preview.slider');
        Route::get('/edit/slide/{id}', 'SliderController@edit')->name('edit.slide');
        Route::post('/update/slide/{id}', 'SliderController@update')->name('update.slide');
        Route::get('/delete/slide/{id}', 'SliderController@destroy')->name('delete.slide');
        Route::get('/update/slide/activity', 'SliderController@updateSlideActivity');
    });

    Route::group(['middleware' => ['permission:manage seo']], function () {
        // Seo Meta Tags routes
        Route::get('/delete/meta/{id}', 'SeoController@destroy')->name('seo.delete');
        //Route::get('/create/meta', 'SeoController@create')->name('seo.store');


        // Offer Meta Tags
        Route::get('/meta/offer', 'SeoController@indexOffer')->name('offer.seo.index');
        Route::get('/create/meta/offer', 'SeoController@createOffer')->name('offer.seo.create');
        Route::post('/store/meta/offer', 'SeoController@storeOffer')->name('offer.seo.store');
        Route::get('/edit/meta/offer/{id}', 'SeoController@editOffer')->name('offer.seo.edit');
        Route::post('/update/meta/offer/{id}', 'SeoController@updateOffer')->name('offer.seo.update');
        //Route::get('/delete/meta/offer/{id}', 'SeoController@destroy')->name('offer.seo.delete');

        // Category Meta Tags
        Route::get('/meta/category', 'SeoController@indexCategory')->name('category.seo.index');
        Route::get('/create/meta/category', 'SeoController@createCategory')->name('category.seo.create');
        Route::post('/store/meta/category', 'SeoController@storeCategory')->name('category.seo.store');
        Route::get('/edit/meta/category/{id}', 'SeoController@editCategory')->name('category.seo.edit');
        Route::post('/update/meta/category/{id}', 'SeoController@updateCategory')->name('category.seo.update');
        //Route::get('/delete/meta/category/{id}', 'SeoController@destroy')->name('category.seo.delete');

        //Custom Meta Tags
        Route::get('/meta/custom', 'SeoController@indexCustom')->name('custom.seo.index');
        Route::get('/create/meta/custom', 'SeoController@createCustom')->name('custom.seo.create');
        Route::post('/store/meta/custom', 'SeoController@storeCustom')->name('custom.seo.store');
        Route::get('/edit/meta/custom/{link}', 'SeoController@editCustom')->name('custom.seo.edit');
        Route::post('/update/meta/custom/{id}', 'SeoController@updateCustom')->name('custom.seo.update');
        //Route::get('/delete/meta/custom/{id}', 'SeoController@destroy')->name('custom.seo.delete');
    });

});
