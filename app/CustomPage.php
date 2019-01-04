<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    
    protected $fillable = [
        'name', 'text', 'slug', 'position', 'active',
    ];

}
