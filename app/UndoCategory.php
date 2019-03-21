<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndoCategory extends Model
{
    //
    protected $fillable = [
        'name', 'sku', 'img_src', 'parent_id','slug', 'position', 'display', 'category_id', 'type'
    ];

    //protected $table = ['undo_categories'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
