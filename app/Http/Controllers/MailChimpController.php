<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NZTim\Mailchimp\Mailchimp;

class MailChimpController extends Controller
{
    
    private $listId = '15d2929c6a';

    public function subscribe()
    {
        $mc = new Mailchimp(env('MC_KEY'));
        $emailAddress = 'ilic90nis@gmail.com';
        $mc->subscribe($this->listId, $emailAddress, $merge = [], $confirm = true);
        return 'Success!';
    }

}
