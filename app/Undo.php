<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Undo extends Model
{
    
    protected $fillable = [
        'properties', 'type', 'user_id', 'role_id', 'slider_id', 'offer_type_id', 'offer_id', 'category_id', 'custom_page_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Spatie\Permission\Models\Role::class);
    }

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }

    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customPage()
    {
        return $this->belongsTo(CustomePage::class);
    }

}
