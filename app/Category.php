<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\UndoCategory;

class Category extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'img_src', 'parent_id','slug', 'position', 'display'
    ];


    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_to_category','category_id','offer_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_to_category', 'category_id', 'brand_id');
    }

    public function metaTag()
    {
        return $this->hasOne(MetaTag::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function undoCategories()
    {
        return $this->hasMany(UndoCategory::class);
    }

    public function getLiveOffersByCategory($id)
    {
        $cat = Category::where('id', $id)->where('display', true)->first();
        $allOffers = $cat->offers()->orderBy('updated_at','DESC')->where('display', true)->orderBy('position')->get();
        $offers = [];
        foreach($allOffers as $offer)
        {
            if($offer->startDate <= Carbon::now())
            {
                if($offer->endDate > Carbon::now() || $offer->endDate==null)
                {
                    array_push($offers,$offer);
                }
            }
        }
        $offers = collect($offers);
        return $offers;
    }
    
     public function getFilteredLiveOffersByCategory($id,$order,$oredrType)
    {
        $cat = Category::where('id', $id)->where('display', true)->first();
        if($order == 'endDate')
        {
            $allOffers = $cat->offers()->where('endDate','<>',null)->where('display', true)->orderBy($order,$oredrType)->get();
        }
        else
        {
            $allOffers = $cat->offers()->orderBy($order,$oredrType)->where('display', true)->get();
        }
        
        $offers = [];
        foreach($allOffers as $offer)
        {
            if($offer->startDate <= Carbon::now())
            {
                if($offer->endDate > Carbon::now() || $offer->endDate==null)
                {
                    array_push($offers,$offer);
                }
            }
        }
        $offers = collect($offers);
        return $offers;
    }

}
