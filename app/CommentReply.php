<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    
    protected $fillable = [
        'text', 'comment_id', 'offer_id', 'comment_id', 'email' , 'name'
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

}
