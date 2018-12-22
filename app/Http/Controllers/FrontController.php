<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Offer;

class FrontController extends Controller
{
    
    public function index()
    {
        
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->offers);
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        
        return view('front.index',compact('categories'));
    }

    public function categoryOffers($id)
    {
        $category = Category::find($id);
        $offers = $category->offers;
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->offers);
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        return view('front.categoryOffers',compact('category','offers','categories'));
    }

    public function offer($id)
    {
        $offer = Offer::find($id);
        $simillarOffers = [];
        foreach($offer->categories as $cat)
        {
            foreach($cat->offers as $off)
            {
                array_push($simillarOffers,$off);
            }
        }
        $simillarOffers = collect($simillarOffers);
        $categories = [];
        $parentCategories = Category::where('parent_id',null)->get();
        foreach($parentCategories as $cat)
        {
            $cs = Category::where('parent_id',$cat->id)->with('offers')->get();
            $categories[$cat->name] = array();
            $count = 0;
            foreach($cs as $c)
            {
               
                $count += count($c->offers);
                array_push($categories[$cat->name],$c);
            }
           
            $categories[$cat->name]['count'] = $count;

        }
        return view('front.offer',compact('offer','simillarOffers','categories'));
    }

    public function ajaxSearch($query)
    {
        $offers = Offer::where('name','LIKE', '%' . $query . '%')/*->orWhere('summary', 'LIKE' , '%' . $query . '%')*/->get();
        
        $category = Category::where('name', $query)->first();

        if($category)
        {
            $category_offers = $category->offers()->get();
            $merged = $offers->merge($category_offers);
        }

        return response()->json($offers);
    }

}
