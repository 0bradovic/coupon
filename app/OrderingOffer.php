<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderingOffer extends Model
{
    //
    protected $fillable = [
        'offer_id'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    



}
