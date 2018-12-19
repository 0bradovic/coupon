<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    //
    protected $fillable = [
        'name' , 'tag_id', 'color'
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    
}
