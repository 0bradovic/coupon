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

class NewFrontController extends Controller
{
    
    public function index()
    {
        $slides = Slider::where('active',1)->orderBy('position')->get();
        $fpCategories = Category::where('parent_id',null)->where('display', true)->where('fp_position','<>',0)->with('liveSubcategories')->orderBy('fp_position')->get();
        
        $i = 0;
        foreach($fpCategories as $category)
        {
            // if($i == 2)
            // {
            //     dd($category->liveSubcategories);
            // }
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
            
            $i++;
        }
        //dd($fpCategories);
       return view('front.new.index',compact('fpCategories','slides'));
    }

}
