<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferClick extends Model
{

    protected $fillable = [
        'offer_id',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

}
