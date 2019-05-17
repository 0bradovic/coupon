<?php

namespace App\Helpers;


use Request;
use App\MetaTag;
use App\Tagline;
use Carbon\Carbon;
use App\SiteSetings;

class Helpers
{
public static function getMetaTags()
    {
        $path = Request::path();

        $tag = MetaTag::where('link', $path)->orWhere('is_default', 1)->orderBy('is_default', 'asc')->first();
        if($tag)
        {

            $tag = $tag->toArray();
            return '
                    <meta name="keywords" content="'.$tag['keywords'].'"/>
                    <meta name="description" content="'.$tag['description'].'"/>
                    <meta property="og:title" content="'.$tag['og_title'].'"/>
                    <meta property="og:image" content="'.$tag['og_image'].'"/>
                    <meta property="og:description" content="'.$tag['og_description'].'"/>';

        }
        
    }



    public static function getMetaTagsCategory($id)
    {
        $tag = MetaTag::where('category_id', $id)->orWhere('is_default', true)->orderBy('is_default', 'asc')->first();
        if($tag)
        {

            $tag = $tag->toArray();
            return '
                    <meta name="keywords" content="'.$tag['keywords'].'"/>
                    <meta name="description" content="'.$tag['description'].'"/>
                    <meta property="og:title" content="'.$tag['og_title'].'"/>
                    <meta property="og:image" content="'.$tag['og_image'].'"/>
                    <meta property="og:description" content="'.$tag['og_description'].'"/>';

        }
    }

    public static function getTagline()
    {
        return Tagline::first();
    }

    public static function expireSoon()
    {
        return Carbon::now()->addHours(48);
    }

    public static function getLogo()
    {
        $siteSetings = SiteSetings::first();
        if($siteSetings)
        {
            return $siteSetings->logo;
        }
        else
        {
            return null;
        }
    }

    public static function getFavicon()
    {
        $siteSetings = SiteSetings::first();
        if($siteSetings)
        {
            return $siteSetings->favicon;
        }
        else
        {
            return null;
        }
    }

}