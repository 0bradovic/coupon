<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    
    protected $fillable = [
        'text', 'comment_id', 'user_id',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
