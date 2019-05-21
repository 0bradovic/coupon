<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tagline;

class TaglineController extends Controller
{
    
    public function index()
    {
        $tagline = Tagline::first();
        $fonts = $this->fonts();
        return view('tagline.index',compact('tagline','fonts'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'text' => 'required',
            'color' => 'required',
        ]);
        $tagline = Tagline::first();
        $tagline->update([
            'text' => $request->text,
            'color' => $request->color,
            'font_family' => $request->font_family,
            'font_size' => $request->font_size,
        ]);
        return redirect()->back()->with('success', 'Successfully updated tagline.');
    }

}
