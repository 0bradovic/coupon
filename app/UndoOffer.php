<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndoOffer extends Model
{
    
    protected $fillable = [
        'name', 'sku', 'brand_id', 'highlight', 
        'summary', 'detail', 'link',
        'startDate', 'endDate', 'offer_type_id',
        'position', 'user_id','img_src','endDateNull','slug','offer_id', 'display'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

}
