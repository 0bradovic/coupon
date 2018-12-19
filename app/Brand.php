<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $fillable = [
        'name', 'sku', 'img_src', 'url', 'description'
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);

    }

}
