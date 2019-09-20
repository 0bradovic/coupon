<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetings extends Model
{
    
    protected $fillable = [
        'logo', 'favicon', 'front_page_search_text', 'category_page_search_text', 'brand_page_search_text','top_icon',
    ];

}
