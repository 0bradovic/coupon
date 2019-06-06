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
        $allNewestOffers = $category->getFilteredLiveOffersByCategory($category->id,'updated_at','DESC');
        $allPopularOffers = $category->getFilteredLiveOffersByCategory($category->id,'click','DESC');
        $total = floor(count($allNewestOffers)/6);
        $brandIds = [];
        foreach($allNewestOffers as $offer)
        {
            if($offer->brand)
            {
                $brandIds[] = $offer->brand->id;
            }
        }
        $brandIds = array_unique($brandIds);
        $brands = Brand::whereIn('id',$brandIds)->orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        $newestOffers = (new Collection($allNewestOffers))->paginate(10);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        return view('front.categoryOffers',compact('total','category','newestOffers','popularOffers','brands','title'));
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
        $tag = $offer->metaTag;
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
        // $mainCategory = $offer->categories()->first();
        // $mainCategory = Category::where('id', $mainCategory->parent_id)->where('display', true)->first();
        $newestSimillarOffers = [];
        $popularSimillarOffers = [];
        foreach($offer->categories as $cat)
        {
            foreach($cat->getFilteredLiveOffersByCategory($cat->id,'updated_at','DESC') as $off)
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
        return view('front.offer',compact('total','offer','newestSimillarOffers','popularSimillarOffers','title'));
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
            return redirect()->route('brand.offers', [$brand->slug]);
        }
        else
        {
            $search = $request->search;
            return view('front.search',compact('search'));
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
        $allNewestOffers = [];
        $allPopularOffers = [];
        foreach($category->liveSubcategories as $cat)
        {
            $allNewestOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'updated_at','DESC');
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
        $brandIds = [];
        foreach($newestOffers as $offer)
        {
            if($offer->brand)
            {
                $brandIds[] = $offer->brand->id;
            }
        }
        $brandIds = array_unique($brandIds);
        $brands = Brand::whereIn('id',$brandIds)->orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);
        $newestOffers = (new Collection($newestOffers))->sortBy('updated_at',SORT_REGULAR, true)->paginate(10);
        $popularOffers = (new Collection($popularOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
        
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl()
            ];
        }
        
        return view('front.parentCategoryOffers',compact('total','newestOffers','popularOffers','category','brands','title'));
    }

    public function brandOffers(Request $request,$slug)
    {
        $brand = Brand::where('slug',$slug)->first();
        $newestOffers = $brand->getFilteredLiveOffersByBrand($brand->id,'updated_at','DESC');
        $popularOffers = $brand->getFilteredLiveOffersByBrand($brand->id,'click','DESC');
        $total = floor(count($newestOffers)/6);
        $allCategories = [];
        foreach($newestOffers as $offer)
        {
            $allCategories[] = $offer->categories;
        }
        $categories = new Collection();
        foreach($allCategories as $cat)
        {
            $categories = $categories->merge($cat);
        }
        $categories = $categories->unique('id');
        
        $allSimilarNewestOffers = [];
        $allSimilarPopularOffers = [];
        foreach($categories as $cat)
        {
            $allSimilarNewestOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'updated_at','DESC');
            $allSimilarPopularOffers[] = $cat->getFilteredLiveOffersByCategory($cat->id,'click','DESC');
        }
        $newestSimillarOffers = new Collection();
        $popularSimillarOffers = new Collection();
        foreach($allSimilarNewestOffers as $off)
        {   
            $newestSimillarOffers = $newestSimillarOffers->merge($off);
        }
        foreach($allSimilarPopularOffers as $off)
        {   
            $popularSimillarOffers = $popularSimillarOffers->merge($off);
        }
        $newestSimillarOffers = $newestSimillarOffers->unique('id');
        $popularSimillarOffers = $popularSimillarOffers->unique('id');
        $brandIds = [];
        foreach($newestSimillarOffers as $offer)
        {
            if($offer->brand)
            {
                $brandIds[] = $offer->brand->id;
            }
        }
        $brandIds = array_unique($brandIds);
        $brands = Brand::whereIn('id',$brandIds)->orderBy('click','DESC')->limit(8)->get();
        $brands = $brands->sortBy('name',SORT_REGULAR, false);

        $newestSimillarOffers = (new Collection($newestSimillarOffers))->sortBy('updated_at',SORT_REGULAR, true)->paginate(10);
        $popularSimillarOffers = (new Collection($popularSimillarOffers))->sortBy('click',SORT_REGULAR, true)->paginate(10);
        
        if($request->ajax()) {
            return [
                'newest' => view('front.offerNewestLazyLoad')->with(compact('newestSimillarOffers'))->render(),
                'popular' => view('front.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $newestSimillarOffers->nextPageUrl(),
            ];
        }
        return view('front.brandOffers',compact('total','newestOffers','popularOffers','brand','brands','newestSimillarOffers','popularSimillarOffers'));
    }


}
