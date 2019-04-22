<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfferType;
use App\Undo;
use App\Offer;

class OfferTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offerTypes = OfferType::all();
        $undoDeleted = Undo::where('offer_type_id','<>',null)->where('type','Deleted')->first();
        return view('offer-types.index',compact('offerTypes','undoDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'name' => 'required',
        ]);
        if($request->color)
        {
            $color = $request->color;
        }
        else
        {
            $color = '#000';
        }
        $offerType = OfferType::create([
            'name' => $request->name,
            'color' => $color,
        ]);
        return redirect()->back()->with('success', 'Successfully created new offer type '.$offerType->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offerType = OfferType::find($id);
        $undoEdited = Undo::where('type','Edited')->where('offer_type_id',$id)->first();
        return view('offer-types.edit',compact('offerType','undoEdited'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);
        if($request->color)
        {
            $color = $request->color;
        }
        else
        {
            $color = '#000';
        }
        $offerType = OfferType::find($id);
        $hasUndo = Undo::where('offer_type_id','<>',null)->where('type','Edited')->first();
        $properties = $offerType->toJson();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'offer_type_id' => $offerType->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'offer_type_id' => $offerType->id,
            ]);
        }
        $offerType->update([
            'name' => $request->name,
            'color' => $color,
        ]);
        return redirect()->back()->with('success', 'Successfully updated offer type '.$offerType->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offerType = OfferType::find($id);
        $offerIds = Offer::where('offer_type_id',$offerType->id)->pluck('id')->toArray();
        //dd($offerIds);
        $properties = $offerType->toJson();
        //dd($properties);
        $properties = json_decode($properties);
        $properties->offers = $offerIds;
        $properties = json_encode($properties);
        //dd($properties);
        $hasUndo = Undo::where('offer_type_id','<>',null)->where('type','Deleted')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'offer_type_id' => $offerType->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'offer_type_id' => $offerType->id,
            ]);
        }
        $name = $offerType->name;
        $offerType->delete();
        return redirect()->back()->with('success', 'Successfully deleted offer type '.$name);
    }

    public function undoDeleted()
    {
        $undo = Undo::where('offer_type_id','<>',null)->where('type','Deleted')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $offerType = OfferType::create([
                'name' => $props->name,
                'color' => $props->color,
            ]);
            $offers = Offer::find($props->offers);
            foreach($offers as $offer)
            {
                $offer->offer_type_id = $offerType->id;
                $offer->save();
            }
            $undo->delete();
            return redirect()->back()->with('success','Successfully restore last deleted offer type');
        }
    }

    public function undoEdited($id)
    {
        $offerType = OfferType::find($id);
        $undo = Undo::where('offer_type_id',$id)->where('type','Edited')->first();
        $props = json_decode($undo->properties);
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $offerType->update([
                'name' => $props->name,
                'color' => $props->color,
            ]);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo offer type.');
        }
    }
}
