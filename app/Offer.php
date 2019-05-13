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
        'position', 'user_id','img_src', 'alt_tag', 'endDateNull','slug','click', 'display'
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
    
    public function offerClicks()
    {
        return $this->hasMany(OfferClick::class);
    }

    public function frontDateFormat($date)
    {
        $newDate = Carbon::parse($date);
        $newDate = $newDate->toFormattedDateString();
        $newDate = substr( $newDate, 0, -6 );
        return $newDate;
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

    public function formatDetailsDescription($string)
    {
        $findbr = ["<br>","</br>"];
        $replacebr = "";
        $string = str_replace($findbr,$replacebr,$string);
        $search = ["</p>","</div>"]; 
        $replace = ". ";  
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
        $newString = strip_tags(str_replace($search,$replace,preg_replace($pattern, '',$string)));
        return $newString;
    }

    public function firstSentence($string)
    {
        $newString = $this->formatDetailsDescription($string);
        $sentenceArray = explode('.',$newString);
        $firstSentence = trim($sentenceArray[0]);
        return $firstSentence;
    }
    
    public function formatDetails($string)
    {
        $findbr = ["<br>","</br>"];
        $replacebr = "";
        $string = str_replace($findbr,$replacebr,$string);
        $search = ["</p>","</div>"]; 
        $replace = ". ";  
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
        $newString = str_limit(strip_tags(str_replace($search,$replace,preg_replace($pattern, '',$string))),'95','...');
        return $newString;
    }

    public function formatDetailsSearch($string)
    {
        $findbr = ["<br>","</br>"];
        $replacebr = "";
        $string = str_replace($findbr,$replacebr,$string);
        $search = ["</p>","</div>"]; 
        $replace = ". ";  
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
        $newString = str_limit(strip_tags(str_replace($search,$replace,preg_replace($pattern, '',$string))),'300','...');
        return $newString;
    }

    public function urlOfferName($string)
    {
        $string = preg_replace("/%/", " percent", $string);
        //$string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
        return $string;
    }

    public function urlOfferDetails($string)
    {
        $findbr = ["<br>","</br>"];
        $replacebr = "";
        $string = str_replace($findbr,$replacebr,$string);
        $findSpace = ["&nbsp;"];
        $replaceSpace = " ";
        $string = str_replace($findSpace,$replaceSpace,$string);
        $search = ["</p>","</div>"]; 
        $replace = ". ";  
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
        $newString = str_limit(strip_tags(str_replace($search,$replace,preg_replace($pattern, '',$string))),'30','...');
        return $newString;
    }

    public function formatUrlDetails($string)
    {
        $findbr = ["<br>","</br>"];
        $replacebr = "";
        $string = str_replace($findbr,$replacebr,$string);
        $search = ["</p>","</div>"]; 
        $replace = ". ";  
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
        $newString = str_limit(strip_tags(str_replace($search,$replace,preg_replace($pattern, '',$string))),'120','...');
        $string = explode('.',$newString);
        return $string[0];
    }

}
