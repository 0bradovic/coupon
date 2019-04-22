<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'img_src', 'alt_tag', 'up_text', 'up_text_color', 'down_text', 'down_text_color', 'center_text', 'center_text_color', 'left_text', 'left_text_color', 'right_text', 'right_text_color', 'link', 'position', 'active'
    ];
}
