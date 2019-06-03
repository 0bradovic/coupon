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
Route::get('/get-offer/{slug}','FrontController@getOffer')->name('get.offer');
Route::get('/category/{slug}', 'FrontController@categoryOffers')->name('category.offers');
Route::get('/offer/{slug}', 'FrontController@offer')->name('offer');
Route::get('/search/{id}', 'FrontController@ajaxSearch')->name('ajax.search');
Route::post('/comment/send', 'FrontController@sendComment')->name('comment.send');
Route::get('/search', 'FrontController@renderSearch')->name('search.blade');
Route::get('/seo/meta', 'SeoController@getMetaTags')->name('seo.meta.tag');
Route::get('/page/{slug}', 'FrontController@getCustomPage')->name('custom.page.get');
Route::get('/pinterest', 'FrontController@pinterest')->name('pinterest');

Route::post('/subscribe', 'MailChimpController@subscribe')->name('subscribe');

Route::get('/parent-category/{slug}', 'FrontController@parentCategoryOffers')->name('parent.category.offers');

Auth::routes();
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
 });
Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/search-queries', 'SearchQueryController@index')->name('get.search-queries');

    Route::group(['middleware' => ['permission:manage tagline']], function () {
        Route::get('/tagline', 'TaglineController@index');
        Route::post('/update/tagline', 'TaglineController@update')->name('update.tagline');
    });

    Route::group(['middleware' => ['permission:manage categories']], function () {
        // Category routes
        Route::get('/categories', 'CategoryController@index')->name('category.index');
        Route::get('/create/category', 'CategoryController@create')->name('create.category');
        Route::post('/store/category', 'CategoryController@store')->name('store.category');
        Route::get('/edit/category/{id}', 'CategoryController@edit')->name('edit.category');
        Route::post('/update/category/{id}', 'CategoryController@update')->name('update.category');
        Route::get('/delete/category/{id}', 'CategoryController@destroy')->name('delete.category');

        Route::get('/display/category/{id}', 'CategoryController@display')->name('display.category');

        //Route::get('/undo/category', 'CategoryController@undoEdit')->name('undoCategory');

        Route::get('/undo/deleted/category', 'CategoryController@undoDeleted')->name('undo.deleted.category');
        Route::get('/undo/edited/category/{id}', 'CategoryController@undoEdited')->name('undo.edited.category');

        Route::get('/exclude-keywords', 'CategoryController@getKeywords')->name('get.exclude-keywords');
        Route::post('/update/exclude-keywords', 'CategoryController@updateKeywords')->name('update.exclude-keywords');

        Route::get('/front-page/categories', 'CategoryController@frontPageCategories')->name('front-page.categories');
        Route::post('/update/front-page/category/{id}', 'CategoryController@updateFrontPagePosition')->name('update.front-page.category');
    });

    Route::group(['middleware' => ['permission:manage offer types']], function () {
        // Offer type routes
        Route::get('/offer-types', 'OfferTypeController@index');
        Route::get('/create/offer-type', 'OfferTypeController@create')->name('create.offer-type');
        Route::post('/store/offer-type', 'OfferTypeController@store')->name('store.offer-type');
        Route::get('/edit/offer-type/{id}', 'OfferTypeController@edit')->name('edit.offer-type');
        Route::post('/update/offer-type/{id}', 'OfferTypeController@update')->name('update.offer-type');
        Route::get('/delete/offer-type/{id}', 'OfferTypeController@destroy')->name('delete.offer-type');

        Route::get('/undo/deleted/offer-type', 'OfferTypeController@undoDeleted')->name('undo.deleted.offer-type');
        Route::get('/undo/edited/offer-type/{id}', 'OfferTypeController@undoEdited')->name('undo.edited.offer-type');
    });

    Route::group(['middleware' => ['permission:manage brands']], function () {
        // Brand routes
        Route::get('/brands', 'BrandController@index');
        Route::get('/create/brand', 'BrandController@create')->name('create.brand');
        Route::post('/store/brand', 'BrandController@store')->name('store.brand');
        Route::get('/edit/brand/{id}', 'BrandController@edit')->name('edit.brand');
        Route::post('/update/brand/{id}', 'BrandController@update')->name('update.brand');
        Route::get('/delete/brand/{id}', 'BrandController@destroy')->name('delete.brand');
    });

    Route::group(['middleware' => ['permission:manage offers']], function () {
        // Offer routes
        Route::get('/offers', 'OfferController@index')->name('offers.index');
        Route::get('/offers/search', 'OfferController@searchOffers')->name('search.offers');
        Route::get('/create/offer', 'OfferController@create')->name('create.offer');
        Route::post('/store/offer', 'OfferController@store')->name('store.offer');
        Route::get('/edit/offer/{id}', 'OfferController@edit')->name('edit.offer');
        Route::post('/update/offer/{id}', 'OfferController@update')->name('update.offer');
        Route::get('/delete/offer/{id}', 'OfferController@destroy')->name('delete.offer');
        Route::get('/undo/offer', 'OfferController@undo')->name('undo');

        Route::get('/undo/deleted/offer', 'OfferController@undoDeleted')->name('undo.deleted.offer');
        Route::get('/undo/edited/offer/{id}', 'OfferController@undoEdited')->name('undo.edited.offer');

        Route::get('/display/offer/{id}', 'OfferController@display')->name('display.offer');

        Route::get('/copy/offer/{id}', 'OfferController@copy')->name('copy.offer');

        Route::get('/upload/csv', 'OfferController@uploadCsv');
        Route::post('/upload/offer', 'OfferController@uploadOffer')->name('upload.offer');

        Route::get('/download/csv', 'OfferController@downloadCsv');
        Route::post('/download/offer', 'OfferController@downloadOffer')->name('download.offer');
        Route::get('/download/offer/search', 'OfferController@downloadOfferSearch')->name('search.offers.download');

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

        Route::get('/undo/deleted/role', 'RoleController@undoDeleted')->name('undo.deleted.role');
        Route::get('/undo/edited/role/{id}', 'RoleController@undoEdited')->name('undo.edited.role');
    });

    Route::group(['middleware' => ['permission:manage users']], function () {
        // User rooutes
        Route::get('/users', 'UserController@index');
        Route::get('/create/user', 'UserController@create')->name('create.user');
        Route::post('/store/user', 'UserController@store')->name('store.user');
        Route::get('/edit/user/{id}', 'UserController@edit')->name('edit.user');
        Route::post('/update/user/{id}', 'UserController@update')->name('update.user');
        Route::get('/delete/user/{id}', 'UserController@destroy')->name('delete.user');

        Route::get('/undo/deleted/user', 'UserController@undoDeleted')->name('undo.deleted.user');
        Route::get('/undo/edited/user/{id}', 'UserController@undoEdited')->name('undo.edited.user');
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

        Route::get('/undo/deleted/slide', 'SliderController@undoDeleted')->name('undo.deleted.slide');
        Route::get('/undo/edited/slide/{id}', 'SliderController@undoEdited')->name('undo.edited.slide');
    });

    Route::group(['middleware' => ['permission:manage custom pages']], function () {
        // Custom page routes
        Route::get('/customPages', 'CustomPageController@index')->name('customPage.index');
        Route::get('/create/customPage', 'CustomPageController@create')->name('create.customPage');
        Route::post('/store/customPage', 'CustomPageController@store')->name('store.customPage');
        Route::get('/edit/customPage/{id}', 'CustomPageController@edit')->name('edit.customPage');
        Route::post('/update/customPage/{id}', 'CustomPageController@update')->name('update.customPage');
        Route::get('/delete/customPage/{id}', 'CustomPageController@destroy')->name('delete.customPage');
        Route::get('/show/CustomPage/{id}', 'CustomPageController@show')->name('show.customPage');
        Route::get('/update/customPage/activity', 'CustomPageController@updateActivity');

        Route::get('/undo/deleted/custom-page', 'CustomPageController@undoDeleted')->name('undo.deleted.custom-page');
        Route::get('/undo/edited/custom-page/{id}', 'CustomPageController@undoEdited')->name('undo.edited.custom-page');
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
        Route::get('/edit/meta/custom/{id}', 'SeoController@editCustom')->name('custom.seo.edit');
        Route::post('/update/meta/custom/{id}', 'SeoController@updateCustom')->name('custom.seo.update');
        //Route::get('/delete/meta/custom/{id}', 'SeoController@destroy')->name('custom.seo.delete');
    });

    Route::group(['middleware' => ['permission:manage popup']], function () {
        Route::get('/subscribe/popup', 'PopupController@index');
        Route::post('/update/popup', 'PopupController@update')->name('update.popup');
    });

    Route::group(['middleware' => ['permission:manage site setings']], function () {
        //Logo
        Route::get('/site-setings/logo', 'SiteController@indexLogo');
        Route::post('/site-setings/upload/logo', 'SiteController@storeLogo')->name('store.logo');
        Route::post('/site-setings/update/logo', 'SiteController@updateLogo')->name('update.logo');
        //Favicon
        Route::get('/site-setings/favicon', 'SiteController@indexFavicon');
        Route::post('/site-setings/upload/favicon', 'SiteController@storeFavicon')->name('store.favicon');
        Route::post('/site-setings/update/favicon', 'SiteController@updateFavicon')->name('update.favicon');
    });

});
// use Spatie\Permission\Models\Permission;
// Route::get('/perm', function(){
//     Permission::create(['name' => 'manage brands']);
// });
// use App\Category;
// Route::get('/clear', function(){
//     $cats = Category::all();
//     foreach($cats as $cat)
//     {
//         $cat->default_words_exclude = null;
//         $cat->save();
//     }
// });

// Testing new layouts
use App\Category;
use App\CustomPage;
use App\SubscribePopup;

Route::get('/new', 'NewFrontController@index')->name('welcome');

Route::get('/new-category', 'NewFrontController@categoryOffers');

Route::get('/new-search', function(){
    return view('front.new.search');
});

Route::get('/new-brand', function(){
    return view('front.new.brand');
});

// End testing
