<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagline extends Model
{
    
    protected $fillable = [
        'text', 'color',
    ];

}
