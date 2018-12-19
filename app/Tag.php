<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //

    protected $fillable = [
        'name'
    ];

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_to_tag', 'tag_id', 'offer_id');
    }
}
