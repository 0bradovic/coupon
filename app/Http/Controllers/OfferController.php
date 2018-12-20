<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\OfferType;

class OfferController extends Controller
{
    //

    public function allOffersIndex()
    {
        return view();
    }

    public function newOfferIndex()
    {
        return view();
    }

    public function createOffer(Request $request)
    {
        $allOfferTypes = OfferType::all();

        return view('offers.offers', compact('allOfferTypes'));
    }

    public function storeOffer(Request $reuqest)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'highlight' => 'required|string',
            'summary' => 'required|string',
            'detail' => 'required|string',
            'link' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
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
            'highlight' => $request->hightlight,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'link' => $request->link,
            'start' => $request->start,
            'end' => $request->end,
            'offer_type_id' => $request->offer_type_id,
            'user_id' => $request->user_id,
            'position' => $request->position
        ]);

        return redirect()->back()->with('success', 'Successfully created new '.$newOffer->name.' offer');
    }




}
