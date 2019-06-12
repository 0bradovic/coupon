<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscribePopup extends Model
{
    
    protected $fillable = [
        'title', 'second_title', 'button', 'first_section', 'second_section', 'success_message',
    ];

}
