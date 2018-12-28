<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Offer;
use App\Slider;
use Carbon\Carbon;
use App\Support\Collection;

class FrontController extends Controller
{
    
    public function index(Request $request)
    {
        $slides = Slider::where('active',1)->orderBy('position')->get();
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $allOffers = Offer::orderBy('position')->get();
        $off = new Offer();
        $offers = $off->filterOffers($allOffers);
        $offers = (new Collection($offers))->paginate(10);
        if($request->ajax()) {
            return [
                'offers' => view('front.indexLazyLoad')->with(compact('offers'))->render(),
                'next_page' => $offers->nextPageUrl()
            ];
        }
        return view('front.index',compact('categories','slides','offers'));
    }

    public function indexByCategory()
    {
        $now = Carbon::now();
        $slides = Slider::where('active',1)->orderBy('position')->get();
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        
        return view('front.index-old',compact('categories','slides','now'));
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
        $category = Category::where('slug',$slug)->first();
        $offers = $category->getLiveOffersByCategory($category->id);
        $offers = (new Collection($offers))->paginate(3);
        
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        if($request->ajax()) {
            return [
                'offers' => view('front.categoryLazyLoadRaw')->with(compact('offers'))->render(),
                'next_page' => $offers->nextPageUrl()
            ];
        }
        return view('front.categoryOffers',compact('category','offers','categories'));
    }

    public function offer(Request $request,$slug)
    {
        $offer = Offer::where('slug', $slug)->first();
        $mainCategory = $offer->categories()->first();
        $mainCategory = Category::find($mainCategory->parent_id);
        $comments = $offer->comments()->with('commentReplies')->get();
        $simillarOffers = [];
        foreach($offer->categories as $cat)
        {
            foreach($cat->getLiveOffersByCategory($cat->id) as $off)
            {
                if($offer->id != $off->id)
                {
                    array_push($simillarOffers,$off);
                }
                else
                {
                    continue;
                }
            }
        }
        $simillarOffers = collect($simillarOffers);
        $simillarOffers = (new Collection($simillarOffers))->paginate(10);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        if($request->ajax()) {
            return [
                'simillarOffers' => view('front.offerLazyLoadRaw')->with(compact('simillarOffers'))->render(),
                'next_page' => $simillarOffers->nextPageUrl()
            ];
        }

        //dd($comments);

        return view('front.offer',compact('offer','simillarOffers','categories', 'comments','mainCategory'));
    }

    public function ajaxSearch($query)
    {
        $offers = Offer::where('name','LIKE', '%' . $query . '%')/*->orWhere('summary', 'LIKE' , '%' . $query . '%')*/->get();
        $off = new Offer();
        $offers = $off->filterOffers($offers);
        $category = Category::where('name', $query)->first();

        if($category)
        {
            $category_offers = $category->getLiveOffersByCategory($category->id);
            $merged = $offers->merge($category_offers);
        }

        return response()->json($offers);
    }


    public function renderSearch(Request $request)
    {
        
        $offers = Offer::where('name','LIKE', '%' . $request->search . '%')->get();
        $off = new Offer();
        $offers = $off->filterOffers($offers);
        $offers = (new Collection($offers))->paginate(10);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->getLiveOffersByCategory($c->id));
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        $search = $request->search;
        if($request->ajax()) {
            return [
                'offers' => view('front.categoryLazyLoadRaw')->with(compact('offers'))->render(),
                'next_page' => $offers->nextPageUrl()
            ];
        }
        return view('front.search', compact('offers', 'categories', 'search'));

    }

}
