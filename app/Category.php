<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'img_src'
    ];


    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

}
