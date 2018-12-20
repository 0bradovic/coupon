<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\OfferType;
use App\User;

class OfferController extends Controller
{
    //

    public function allOffersIndex()
    {
        $offers = Offer::with('user')->with('offerType')->get();

        return view('offers.index', compact('offers'));
    }

    public function createOffer(Request $request)
    {
        $offerTypes = OfferType::all();

        $users = User::all();

        return view('offers.create', compact('offerTypes', 'users'));
    }

    public function storeOffer(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'highlight' => 'required|string',
            'summary' => 'required|string',
            'detail' => 'required|string',
            'link' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'offer_type_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'position' => 'required|numeric'
        ]); 

        $lastOfferSku = Offer::all()->pluck('sku')->last();
        if($lastOfferSku)
        {
            $sku = intval($lastOfferSku) + 1;
        }
        else
        {
            $sku = 10000000;
        }

        $newOffer = Offer::create([
            'name' => $request->name,
            'sku' => $sku,
            'highlight' => $request->highlight,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'link' => $request->link,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'offer_type_id' => $request->offer_type_id,
            'user_id' => $request->user_id,
            'position' => $request->position
        ]);

        return redirect()->back()->with('success', 'Successfully created new '.$newOffer->name.' offer');
    }




}
