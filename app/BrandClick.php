<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandClick extends Model
{
    
    protected $fillable = [
        'brand_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
