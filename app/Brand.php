<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
