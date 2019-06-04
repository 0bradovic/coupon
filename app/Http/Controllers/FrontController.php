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
            
            $offers = (new Collection($offers))->sortBy('click',SORT_REGULAR, true);
            $category->topOffers = $offers->take(3);
        }
       return view('front.index',compact('fpCategories','slides','title'));
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
        $brands = Brand::orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        $allNewestOffers = $category->getFilteredLiveOffersByCategory($category->id,'created_at','DESC');
        $allPopularOffers = $category->getFilteredLiveOffersByCategory($category->id,'click','DESC');
        $total = floor(count($allNewestOffers)/6);
        $newestOffers = (new Collection($allNewestOffers))->paginate(10);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        return view('front.categoryOffers',compact('total','category','newestOffers','popularOffers','brands'));
    }

    public function offer(Request $request,$slug)
    {
        $offer = Offer::where('slug', $slug)->where('display', true)->first();
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
        if($request->ajax()) {
            return [
                'newest' => view('front.offerNewestLazyLoad')->with(compact('newestSimillarOffers'))->render(),
                'popular' => view('front.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $newestSimillarOffers->nextPageUrl()
            ];
        }
        return view('front.offer',compact('total','offer','newestSimillarOffers','popularSimillarOffers'));
    }

    public function ajaxSearch($query)
    {
        $offers = Offer::where('name','LIKE', '%' . $query . '%')->orWhere('detail', 'LIKE' , '%' . $query . '%')->where('display', true)->get();
        $off = new Offer();
        $offers = $off->filterOffers($offers);
        $category = Category::where('name', $query)->where('display', true)->first();

        if($category)
        {
            $category_offers = $category->getLiveOffersByCategory($category->id);
            $merged = $offers->merge($category_offers);
        }

        return response()->json($offers);
    }


    public function renderSearch(Request $request)
    {
        if($request->search != null && $request->search != '')
        {
            SearchQuery::create([
                'query' => $request->search,
            ]);
        }
        $offers = Offer::where('name','LIKE', '%' . $request->search . '%')->orWhere('detail', 'LIKE' , '%' . $request->search . '%')->get();
        foreach($offers as $key=>$value)
        {
            if($value->display==0) $offers->forget($key);
        }
        $off = new Offer();
        $offers = $off->filterOffers($offers);
        $offers = (new Collection($offers))->paginate(10);

        $newestSimillarOffers = Offer::orderBy('created_at','DESC')->get();
        $newestSimillarOffers = $off->filterOffers($newestSimillarOffers);
        $newestSimillarOffers = (new Collection($newestSimillarOffers))->paginate(10);

        $popularSimillarOffers = Offer::orderBy('click','DESC')->get();
        $popularSimillarOffers = $off->filterOffers($popularSimillarOffers);
        $popularSimillarOffers = (new Collection($popularSimillarOffers))->paginate(10);
        
        $categories = Category::where('parent_id',null)->where('display', true)->with('liveSubcategories')->orderBy('position')->get();
        //$customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        //$popup = SubscribePopup::first();
        $search = $request->search;
        
        if($request->ajax()) {
            return [
                'newest' => view('front.offerNewestLazyLoad')->with(compact('newestSimillarOffers'))->render(),
                'popular' => view('front.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $newestSimillarOffers->nextPageUrl()
            ];
        }
        return view('front.search', compact('offers', 'newestSimillarOffers', 'popularSimillarOffers', 'search'));

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

        $allNewestOffers = [];
        $allPopularOffers = [];
        foreach($category->liveSubcategories as $cat)
        {
            $allNewestOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'created_at','DESC');
            $allPopularOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC');
        }
        $newestOffers = new Collection();
        $popularOffers = new Collection();
        foreach($allNewestOffers as $off)
        {   
            $newestOffers = $newestOffers->merge($off);
        }
        foreach($allPopularOffers as $off)
        {   
            $popularOffers = $popularOffers->merge($off);
        }
        $newestOffers = $newestOffers->unique();
        $popularOffers = $popularOffers->unique();
        $total = floor(count($newestOffers)/6);
        $newestOffers = (new Collection($newestOffers))->sortBy('created_at',SORT_REGULAR, true)->paginate(10);
        $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
        $brands = Brand::orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl()
            ];
        }
        
        return view('front.parentCategoryOffers',compact('total','newestOffers','popularOffers','category','brands'));
    }

    public function brandOffers(Request $request,$slug)
    {
        $brand = Brand::where('slug',$slug)->first();
        $brands = Brand::where('id','<>',$brand->id)->orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        $allNewestOffers = $brand->getFilteredLiveOffersByBrand($brand->id,'created_at','DESC');
        $allPopularOffers = $brand->getFilteredLiveOffersByBrand($brand->id,'click','DESC');
        $total = floor(count($allNewestOffers)/6);
        $newestOffers = (new Collection($allNewestOffers))->paginate(10);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        return view('front.brandOffers',compact('total','newestOffers','popularOffers','brand','brands'));
    }


}
