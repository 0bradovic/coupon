<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'text', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

}
