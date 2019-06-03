<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Offer;
use App\Slider;
use Carbon\Carbon;
use App\Support\Collection;
use App\MetaTag;
use App\CustomPage;
use App\OfferClick;
use Illuminate\Support\Facades\Redirect;
use App\SubscribePopup;
use App\Brand;

class NewFrontController extends Controller
{
    
    public function index()
    {
        $slides = Slider::where('active',1)->orderBy('position')->get();
        $title = MetaTag::where('link','/')->pluck('title')->first();
        if(!$title)
        {
            $title = 'BeforeTheShop';
        }
        $fpCategories = Category::where('parent_id',null)->where('display', true)->where('fp_position','<>',0)->with('liveSubcategories')->orderBy('fp_position')->get();
        foreach($fpCategories as $category)
        {
            $collections = [];
            foreach($category->liveSubcategories as $cat)
            {
                $collections[] = $cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC');
            }
            $offers = new Collection();
            
            foreach($collections as $item)
            {
                $offers = $offers->merge($item);
            }
            
            $offers = (new Collection($offers))->sortBy('click',SORT_REGULAR, true);
            $category->topOffers = $offers->take(3);
        }
       return view('front.new.index',compact('fpCategories','slides','title'));
    }

    public function categoryOffers(Request $request)
    {
        //$category = Category::where('slug',$slug)->where('display', true)->first();
        //$categories = Category::where('parent_id',null)->where('display', true)->with('liveSubcategories')->orderBy('position')->get();
        $category = Category::where('parent_id','<>',null)->where('display', true)->first();
       // $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        $brands = Brand::orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        $allNewestOffers = $category->getFilteredLiveOffersByCategory($category->id,'created_at','DESC');
        $allPopularOffers = $category->getFilteredLiveOffersByCategory($category->id,'click','DESC');
        $total = floor(count($allNewestOffers)/6);
        $newestOffers = (new Collection($allNewestOffers))->paginate(10);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.new.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.new.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        //$popup = SubscribePopup::first();
        return view('front.new.category',compact('total','category','newestOffers','popularOffers','brands'));
    }

    public function offer(Request $request)
    {
        $offer = Offer::where('display', true)->where('endDate',null)->first();
        if($offer->endDate != null)
        {
            if($offer->dateFormat($offer->endDate) < Carbon::now())
            {
            return redirect('/')->withErrors('Offer has expired');
            }
        }
        
        // $mainCategory = $offer->categories()->first();
        // $mainCategory = Category::where('id', $mainCategory->parent_id)->where('display', true)->first();
        $newestSimillarOffers = [];
        $popularSimillarOffers = [];
        foreach($offer->categories as $cat)
        {
            foreach($cat->getFilteredLiveOffersByCategory($cat->id,'created_at','DESC') as $off)
            {
                if($offer->id != $off->id)
                {
                    array_push($newestSimillarOffers,$off);
                }
                else
                {
                    continue;
                }
            }
        }
        foreach($offer->categories as $cat)
        {
            foreach($cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC') as $off)
            {
                if($offer->id != $off->id)
                {
                    array_push($popularSimillarOffers,$off);
                }
                else
                {
                    continue;
                }
            }
        }
        $newestSimillarOffers = collect($newestSimillarOffers);

        $total = floor(count($newestSimillarOffers)/6);
    
        $newestSimillarOffers = (new Collection($newestSimillarOffers))->paginate(10);
        $popularSimillarOffers = collect($popularSimillarOffers);
        $popularSimillarOffers = (new Collection($popularSimillarOffers))->paginate(10);
        //$categories = Category::where('parent_id',null)->where('display', true)->with('liveSubcategories')->orderBy('position')->get();
        //$customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        if($request->ajax()) {
            return [
                'newest' => view('front.new.offerNewestLazyLoad')->with(compact('newestSimillarOffers'))->render(),
                'popular' => view('front.new.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $newestSimillarOffers->nextPageUrl()
            ];
        }
        //$popup = SubscribePopup::first();
        return view('front.new.offer',compact('total','offer','newestSimillarOffers','popularSimillarOffers'));
    }

}
