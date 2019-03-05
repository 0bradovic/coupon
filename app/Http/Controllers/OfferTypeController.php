<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfferType;

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
        return view('offer-types.index',compact('offerTypes'));
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
        return view('offer-types.edit',compact('offerType'));
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
        $name = $offerType->name;
        $offerType->delete();
        return redirect()->back()->with('success', 'Successfully deleted offer type '.$name);
    }
}
