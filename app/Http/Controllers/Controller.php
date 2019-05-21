<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createSlug(string $text)
    {
         // replace non letter or digits by -
       $text = preg_replace('~[^\pL\d]+~u', '-', $text);

       // transliterate
       $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

       // remove unwanted characters
       $text = preg_replace('~[^-\w]+~', '', $text);

       // trim
       $text = trim($text, '-');

       // remove duplicate -
       $text = preg_replace('~-+~', '-', $text);

       // lowercase
       $text = strtolower($text);

       if (empty($text)) {
           return 'n-a';
       }

       return $text;
    }

    
    public function fonts()
    {
        return [
            'Roboto', 
            'Open Sans',
            'Poppins',
            'Muli',
            'Titillium Web',
            'Cabin',
            'Exo',
            'Montserrat',
            'Lato',
            'Kodchasan',
        ];
    }

}
