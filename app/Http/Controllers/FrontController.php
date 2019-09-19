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
use App\SearchQuery;
use App\Brand;
use App\BrandClick;

class FrontController extends Controller
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
            $offers = $offers->unique('id');
            $offers = (new Collection($offers))->sortBy('click',SORT_REGULAR, true);
            $category->topOffers = $offers->unique('brand_id')->take(5);
        }
        $topBrands = Brand::where('fp_position','<>',null)->orderBy('fp_position')->limit(10)->get();
       return view('front.index',compact('fpCategories','slides','title','topBrands'));
    }
    
    public function getCustomPage($slug)
    {
        $customPage = CustomPage::where('slug', $slug)->first();
        return view('front.customPage', compact('customPage'));
    }

    public function sendComment(Request $request)
    {
        $offer = Offer::find($request->client_id);

        $this->validate($request, [
            'text' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $newComment = Comment::create([
            'text' => $request->text,
            'email' => $request->email,
            'name' => $request->name
        ]);

        $newComment->offer()->attach($offer->id);

        return redirect()->back()->with('success');
    }

    public function sendCommentReplay(Request $request)
    {
        $commentToBeAppliedTo = Comment::find($request->comment_id);

        $this->validate($request, [
            'text' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $newCommentReplay = CommentReply::create([
            'text' => $request->text,
            'email' => $request->email,
            'name' => $request->name
        ]);

        $newCommentReplay->offer()->attach($offer->id);

        return redirect()->back()->with('success');

    }

    public function categoryOffers(Request $request,$slug)
    {
        $category = Category::where('slug',$slug)->where('display', true)->first();
        $topBrands = $category->orderedBrands()->limit(10)->get();
        $tag = $category->metaTag;
        if($tag != null)
        {
            if($tag->title != '' && $tag->title != null)
            {
                $title = $tag->title;
            }
            else
            {
                $title = 'BeforeTheShop';
            }

        }
        else
        {
            $title = 'BeforeTheShop';
        }
        $allPopularOffers = $category->getFilteredLiveOffersByCategory($category->id,'click','DESC');
        $total = floor(count($allPopularOffers)/6);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $popularOffers->nextPageUrl(),
            ];
        }
        return view('front.categoryOffers',compact('total','category','popularOffers','title','topBrands'));
    }

    public function offer(Request $request,$brandSlug,$offerSlug)
    {
        $offer = Offer::where('slug', $offerSlug)->where('display', true)->first();
        if($offer->endDate != null)
        {
            if($offer->dateFormat($offer->endDate) < Carbon::now())
            {
            return redirect('/')->withErrors('Offer has expired');
            }
        }
        $tag = $offer->metaTag;
        if($tag != null)
        {
            if($tag->title != '' && $tag->title != null)
            {
                if($offer->brand)
                {
                    $title = $offer->brand->name." | ".$tag->title;
                }
                else
                {
                    $title = $tag->title;
                }
                
            }
            else
            {
                $title = 'BeforeTheShop';
            }

        }
        else
        {
            $title = 'BeforeTheShop';
        }
        $popularSimillarOffers = [];
        foreach($offer->categories as $cat)
        {
            if($cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC'))
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
        }
    
        $popularSimillarOffers = collect($popularSimillarOffers);
        $total = floor(count($popularSimillarOffers)/6);
        $popularSimillarOffers = (new Collection($popularSimillarOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'popular' => view('front.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $popularSimillarOffers->nextPageUrl()
            ];
        }
        return view('front.offer',compact('total','offer','popularSimillarOffers','title'));
    }

    public function ajaxSearch($query)
    {
        $brands = Brand::where('name','LIKE','%' . $query . '%')->get();
        return response()->json($brands);
    }


    public function renderSearch(Request $request)
    {
        if($request->search != null && $request->search != '')
        {
            SearchQuery::create([
                'query' => $request->search,
            ]);
        }
        $brand = Brand::where('name','LIKE','%'. $request->search . '%')->first();
        if($brand != null)
        {
            $offers = $brand->getFilteredLiveOffersByBrand($brand->id,'click','DESC');
            if(count($offers) > 0)
            {
                return redirect()->route('brand.offers', [$brand->slug]);
            }
            else
            {
                $allOffers = Offer::where('display',true)->orderBy('click','DESC')->get();
                $off = new Offer();
                $popularOffers = $off->filterOffers($allOffers);
                $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
                $search = $request->search;
                if($request->ajax()) {
                    return [
                        'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                        'next_page' => $popularOffers->nextPageUrl()
                    ];
                }
                return view('front.search',compact('search','popularOffers'));
                }     
        }
        else
        {
            $allOffers = Offer::where('display',true)->orderBy('click','DESC')->get();
            $off = new Offer();
            $popularOffers = $off->filterOffers($allOffers);
            $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
            $search = $request->search;
            if($request->ajax()) {
                return [
                    'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                    'next_page' => $popularOffers->nextPageUrl()
                ];
            }
            return view('front.search',compact('search','popularOffers'));
        }
    }
    
    public function getOffer($slug)
    {
        $offer = Offer::where('slug', $slug)->where('display', true)->first();
        if($offer->endDate != null)
        {
            if($offer->dateFormat($offer->endDate) < Carbon::now())
            {
            return redirect('/')->withErrors('Offer has expired');
            }
        }
        $offer->click += 1;
        $offer->timestamps = false;
        $offer->save();
        OfferClick::create(['offer_id'=>$offer->id]);
        if($offer->brand)
        {
            $brand = $offer->brand;
            $brand->click += 1;
            $brand->save();
            BrandClick::create(['brand_id' => $brand->id]);
        }
        return Redirect::away($offer->link);
    }

    public function parentCategoryOffers(Request $request,$slug)
    {
        $category = Category::where('slug',$slug)->where('display', true)->with('liveSubcategories')->first();
        $tag = $category->metaTag;
        if($tag != null)
        {
            if($tag->title != '' && $tag->title != null)
            {
                $title = $tag->title;
            }
            else
            {
                $title = 'BeforeTheShop';
            }

        }
        else
        {
            $title = 'BeforeTheShop';
        }
        $allPopularOffers = [];
        foreach($category->liveSubcategories as $cat)
        {
            $allPopularOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC');
        }
        $popularOffers = new Collection();
        foreach($allPopularOffers as $off)
        {   
            $popularOffers = $popularOffers->merge($off);
        }
        $popularOffers = $popularOffers->unique('id');
        $total = floor(count($popularOffers)/6);
        $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
        
        if($request->ajax()) {
            return [
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $popularOffers->nextPageUrl()
            ];
        }
        return view('front.parentCategoryOffers',compact('total','popularOffers','category','title'));
    }

    public function brandOffers(Request $request,$slug)
    {
        $brand = Brand::where('slug',$slug)->first();
        $title = $brand->name." | every ".$brand->name." voucher code, coupon, offer and deal";
        $tag = $brand->metaTag;
        if($tag != null)
        {
            if($tag->title != '' && $tag->title != null)
            {
                $title = $tag->title;
            }
            else
            {
                $title = $brand->name." | every ".$brand->name." voucher code, coupon, offer and deal";
            }

        }
        $popularOffers = $brand->getFilteredLiveOffersByBrand($brand->id,'click','DESC');
        if(count($popularOffers) > 0)
        {
            $total = floor(count($popularOffers)/6);
            $allCategories = [];
            foreach($popularOffers as $offer)
            {
                $allCategories[] = $offer->categories;
            }
            $categories = new Collection();
            foreach($allCategories as $cat)
            {
                $categories = $categories->merge($cat);
            }
            $categories = $categories->unique('id');
            $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
            
            if($request->ajax()) {
                return [
                    'popular' => view('front.offerPopularLazyLoad')->with(compact('popularOffers'))->render(),
                    'next_page' => $popularOffers->nextPageUrl(),
                ];
            }
            return view('front.brandOffers',compact('total','popularOffers','brand','title'));
        }
        else
        {
            $allOffers = Offer::where('display',true)->orderBy('click','DESC')->get();
            $off = new Offer();
            $popularOffers = $off->filterOffers($allOffers);
            $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
            $search = $brand->name;
            if($request->ajax()) {
                return [
                    'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                    'next_page' => $popularOffers->nextPageUrl()
                ];
            }
            return view('front.search',compact('search','popularOffers'));
        }
        
    }


}
