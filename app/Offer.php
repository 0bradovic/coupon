<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Offer extends Model
{
    //

    protected $fillable = [
        'name', 'sku', 'brand_id', 'highlight', 
        'summary', 'detail', 'link',
        'startDate', 'endDate', 'offer_type_id',
        'position', 'user_id','img_src','endDateNull','slug',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'offer_to_category','offer_id','category_id');
    }

    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'offer_to_tag', 'offer_id', 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function dateFormat($date)
    {
        return Carbon::parse($date);
    }

    public function metaTag()
    {
        return $this->hasOne(MetaTag::class);
    }

    public function undoOffer()
    {
        return $this->hasOne(UndoOffer::class);
    }

    public function filterOffers($allOffers)
    {
        $offers = [];
        foreach($allOffers as $offer)
        {
            if($offer->startDate <= Carbon::now())
            {
                if($offer->endDate > Carbon::now() || $offer->endDate==null)
                {
                    array_push($offers,$offer);
                }
            }
        }
        $offers = collect($offers);
        return $offers;
    }

}
