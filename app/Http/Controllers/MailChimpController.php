<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NZTim\Mailchimp\Mailchimp;

class MailChimpController extends Controller
{
    
    private $listId = '15d2929c6a';

    public function subscribe(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
        ]);
        $mc = new Mailchimp(env('MC_KEY'));
        $emailAddress = $request->email;
        if($mc->check($this->listId,$emailAddress) == true)
        {
            return redirect()->back()->with('success', 'You are already subscribed!');
        }
        else
        {
            $mc->subscribe($this->listId, $emailAddress, $merge = [], $confirm = true);
            return redirect()->back()->with('success', 'Thanks for registering.');
        }
    }

}
