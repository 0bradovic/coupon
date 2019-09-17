<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Brand extends Model
{
    //
    protected $fillable = [
        'name', 'slug', 'sku', 'img_src', 'url', 'description', 'click',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'brand_to_category', 'brand_id', 'category_id');
    }

    public function brandClicks()
    {
        return $this->hasMany(BrandClick::class);
    }

    public function metaTag()
    {
        return $this->hasOne(MetaTag::class);
    }

    public function getFilteredLiveOffersByBrand($id,$order,$oredrType)
    {
        $brand = Brand::where('id', $id)->first();
        if($order == 'endDate')
        {
            $allOffers = $brand->offers()->where('endDate','<>',null)->orderBy($order,$oredrType)->get();
        }
        else
        {
            $allOffers = $brand->offers()->orderBy($order,$oredrType)->get();
        }
        
        $offers = [];
        foreach($allOffers as $offer)
        {
            if($offer->startDate <= Carbon::now())
            {
                if($offer->endDate > Carbon::now() || $offer->endDate==null && $offer->display == 1)
                {
                    array_push($offers,$offer);
                }
            }
        }
        $offers = collect($offers);
        return $offers;
    }

}
