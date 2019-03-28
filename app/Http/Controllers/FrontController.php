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

class FrontController extends Controller
{
    
   public function index(Request $request)
    {
        $slides = Slider::where('active',1)->orderBy('position')->get();
        $categories = [];
        $title = MetaTag::where('link','/')->pluck('title')->first();
        if(!$title)
        {
            $title = 'BeforeTheShop';
        }
        $parentCategories = Category::where('parent_id',null)->where('display', true)->orderBy('position')->get();
        
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->where('display', true)->with('offers')->orderBy('position')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $allNewestOffers = Offer::orderBy('created_at','DESC')->where('display', true)->get();
        $allMostPopularOffers = Offer::orderBy('click','DESC')->where('display', true)->get();
        $off = new Offer();
        $newestOffers = $off->filterOffers($allNewestOffers);
        $mostPopularOffers = $off->filterOffers($allMostPopularOffers);
        $newestOffers = (new Collection($newestOffers))->paginate(10);
        $mostPopularOffers = (new Collection($mostPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.indexNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.indexPopularLazyLoad')->with(compact('mostPopularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        return view('front.index',compact('categories','slides','newestOffers','mostPopularOffers','title', 'customPages'));
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
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->where('display', true)->orderBy('position')->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->where('display', true)->with('offers')->orderBy('position')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        $allNewestOffers = $category->getFilteredLiveOffersByCategory($category->id,'created_at','DESC');
        $allPopularOffers = $category->getFilteredLiveOffersByCategory($category->id,'click','DESC');
        $newestOffers = (new Collection($allNewestOffers))->paginate(10);
        $popularOffers = (new Collection($allPopularOffers))->paginate(10);
        if($request->ajax()) {
            return [
                'newest' => view('front.categoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.categoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'next_page' => $newestOffers->nextPageUrl(),
            ];
        }
        return view('front.categoryOffers',compact('category','newestOffers','popularOffers','categories','customPages'));
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
        $mainCategory = $offer->categories()->first();
        $mainCategory = Category::where('id', $mainCategory->parent_id)->where('display', true)->first();
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
        $newestSimillarOffers = (new Collection($newestSimillarOffers))->paginate(10);
        $popularSimillarOffers = collect($popularSimillarOffers);
        $popularSimillarOffers = (new Collection($popularSimillarOffers))->paginate(10);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->where('display', true)->orderBy('position')->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->where('display', true)->orderBy('position')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        if($request->ajax()) {
            return [
                'newest' => view('front.offerNewestLazyLoad')->with(compact('newestSimillarOffers'))->render(),
                'popular' => view('front.offerPopularLazyLoad')->with(compact('popularSimillarOffers'))->render(),
                'next_page' => $newestSimillarOffers->nextPageUrl()
            ];
        }
        return view('front.offer',compact('offer','newestSimillarOffers','popularSimillarOffers','categories','mainCategory','customPages'));
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
        
        $offers = Offer::where('name','LIKE', '%' . $request->search . '%')->orWhere('detail', 'LIKE' , '%' . $request->search . '%')->get();
        foreach($offers as $key=>$value)
        {
            if($value->display==0) $offers->forget($key);
        }
        $off = new Offer();
        $offers = $off->filterOffers($offers);
        $offers = (new Collection($offers))->paginate(10);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->where('display', true)->orderBy('position')->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->where('display', true)->orderBy('position')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        $search = $request->search;
        if($request->ajax()) {
            return [
                'offers' => view('front.categoryLazyLoadRaw')->with(compact('offers'))->render(),
                'next_page' => $offers->nextPageUrl()
            ];
        }
        return view('front.search', compact('offers', 'categories', 'search','customPages'));

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
        return Redirect::away($offer->link);
    }

    public function parentCategoryOffers(Request $request)
    {
        $category = Category::where('name',$request->name)->where('display', true)->with('subcategories')->first();
        
        $allNewestOffers = [];
        $allPopularOffers = [];
        foreach($category->subcategories as $cat)
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
        $newestOffers = (new Collection($newestOffers))->paginate(10)->appends('name',$request->name);
        $popularOffers = (new Collection($popularOffers))->paginate(10);
        //dd($newestOffers);
        //dd($popularOffers);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->where('display', true)->orderBy('position')->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->where('display', true)->orderBy('position')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $customPages = CustomPage::where('active', 1)->orderBy('position')->get();
        if($request->ajax()) {
            return [
                'newest' => view('front.parentCategoryNewestLazyLoad')->with(compact('newestOffers'))->render(),
                'popular' => view('front.parentCategoryPopularLazyLoad')->with(compact('popularOffers'))->render(),
                'name' => $category->name,
                'next_page' => $newestOffers->nextPageUrl()
            ];
        }
        //dd($category);
        return view('front.parentCategoryOffers',compact('newestOffers','popularOffers','categories','customPages','category'));
    }


}
