<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    //
    protected $fillable = [
        'name' , 'color'
    ];

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }

    
}
