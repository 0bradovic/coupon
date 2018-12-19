<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    protected $fillable = [
        'sku', 'brand_id', 'highlight', 
        'summary', 'detail', 'link',
        'start', 'end', 'offer_type_id',
        'position'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'offer_to_category','offer_id','category_id');
    }

    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }

}
