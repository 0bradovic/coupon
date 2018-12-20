<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'brand_id', 'highlight', 
        'summary', 'detail', 'link',
        'startDate', 'endDate', 'offer_type_id',
        'position', 'user_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'offer_to_category','offer_id','category_id');
    }

    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'offer_to_tag', 'offer_id', 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
