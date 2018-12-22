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
Route::get('/category/{id}', 'FrontController@categoryOffers')->name('category.offers');
Route::get('/offer/{id}', 'FrontController@offer')->name('offer');

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
});
