<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'text', 'email', 'name', 'offer_id'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

}
