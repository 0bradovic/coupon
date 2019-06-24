<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubscribePopup;
use App\RedirectPopup;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popup = SubscribePopup::first();
        return view('popup.index',compact('popup'));
    }

   public function indexRedirectPopup()
   {
        $popup = RedirectPopup::first();
        return view('popup.index-redirect',compact('popup'));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'second_title' => 'required',
            'first_section' => 'required',
            'second_section' => 'required',
            'button' => 'required',
            'success_message' => 'required',
            'active' => 'required',
            'present_on_session' => 'required',
        ]);
        $popup = SubscribePopup::first();
        $popup->update([
            'title' => $request->title,
            'second_title' => $request->second_title,
            'first_section' => $request->first_section,
            'second_section' => $request->second_section,
            'button' => $request->button,
            'success_message' => $request->success_message,
            'active' => $request->active,
            'present_on_session' => $request->present_on_session,
        ]);
        return redirect()->back()->with('success', 'Successfully updated subscription popup.');
    }

    public function updateRedirectPopup(Request $request)
    {
        $this->validate($request,[
            'text' => 'required',
            'button_text' => 'required',
        ]);
        $popup = RedirectPopup::first();
        $popup->update([
            'text' => $request->text,
            'button_text' => $request->button_text,
        ]);
        return redirect()->back()->with('success', 'Successfully updated redirect popup.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
