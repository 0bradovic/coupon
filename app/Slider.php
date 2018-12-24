<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'img_src', 'up_text', 'down_text', 'center_text', 'left_text', 'right_text', 'link', 'position', 'active'
    ];
}
