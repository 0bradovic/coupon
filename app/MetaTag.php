<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    //
    protected $fillable = [
        'keywords', 'description', 'og-title', 'og-image', 'og-description', 
        'is_default', 'link', 'title', 'offer_id', 'category_id'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



}
