<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomPage;
use App\Undo;

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
        $undoDeleted = Undo::where('custom_page_id','<>',null)->where('type','Deleted')->first();
        return view('customPage.index',compact('customPages','undoDeleted'));
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
        $customPage = CustomPage::find($id);
        
        return view('front.customPage',compact('customPage'));
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
        $undoEdited = Undo::where('type','Edited')->where('custom_page_id',$customPage->id)->first();
        return view('customPage.edit',compact('customPage','undoEdited'));
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
        $properties = $customPage->toJson();
        $hasUndo = Undo::where('custom_page_id','<>',null)->where('type','Edited')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'custom_page_id' => $customPage->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'custom_page_id' => $customPage->id,
            ]);
        }
        $slug = $this->createSlug($request->name);
        $customPage->update([
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
        $properties = $customPage->toJson();
        $hasUndo = Undo::where('custom_page_id','<>',null)->where('type','Deleted')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'custom_page_id' => $customPage->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'custom_page_id' => $customPage->id,
            ]);
        }
        $name = $customPage->name;
        $customPage->delete();
        return redirect()->back()->with('success', 'Successfully deleted custom page '.$name);
    }

    public function updateActivity(Request $request)
    {
        $customPage = CustomPage::find($request->id);
        $customPage->update([
            'active' => $request->active,
        ]);
    }

    public function undoDeleted()
    {
        $undo = Undo::where('custom_page_id','<>',null)->where('type','Deleted')->first();
        $props = json_decode($undo->properties);
        $customPage = CustomPage::create([
            'name' => $props->name,
            'text' => $props->text,
            'slug' => $props->slug,
            'position' => $props->position,
            'active' => $props->active,
        ]);
        $undo->delete();
        return redirect()->back()->with('success', 'Successfully restore last deleted custom page.');
    }

    public function undoEdited($id)
    {
        $customPage = CustomPage::find($id);
        $undo = Undo::where('type','Edited')->where('custom_page_id',$customPage->id)->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $customPage->update([
                'name' => $props->name,
                'text' => $props->text,
                'slug' => $props->slug,
                'position' => $props->position,
                'active' => $props->active,
            ]);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo custom page.');
        }
    }

}
