<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'img_src', 'parent_id','slug',
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

    public function getLiveOffersByCategory($id)
    {
        $cat = Category::find($id);
        $allOffers = $cat->offers()->orderBy('updated_at','DESC')->orderBy('position')->get();
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
