<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomPage;

class CustomPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customPages = CustomPage::all();
        return view('customPage.index',compact('customPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customPage.create');
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
            'text' => 'required',
            'position' => 'required',
        ]);
        $slug = $this->createSlug($request->name);
        $customPage = CustomPage::create([
            'name' => $request->name,
            'text' => $request->text,
            'slug' => $slug,
            'position' => $request->position,
            'active' => 1,
        ]);
        return redirect()->back()->with('success', 'Successfully created new custom page '.$customPage->name);
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
        $customPage = CustomPage::find($id);
        return view('customPage.edit',compact('customPage'));
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
            'text' => 'required',
            'position' => 'required',
        ]);
        $customPage = CustomPage::find($id);
        $slug = $this->createSlug($request->name);
        $customPage::update([
            'name' => $request->name,
            'text' => $request->text,
            'slug' => $slug,
            'position' => $request->position,
        ]);
        return redirect()->back()->with('success', 'Successfully updated custom page '.$customPage->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customPage = CustomPage::find($id);
        $name = $customPage->name;
        $customPage->delete();
        return redirect()->back()->with('success', 'Successfully deleted custom page '.$name);
    }
}
