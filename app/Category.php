<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'img_src', 'parent_id'
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

}
