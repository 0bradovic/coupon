<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    //
    protected $fillable = [
        'keywords', 'description', 'og_title', 'og_image', 'og_description', 
        'is_default', 'link', 'title', 'offer_id', 'category_id','brand_id',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }



}
