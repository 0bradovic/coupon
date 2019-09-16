<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteSetings;
use Intervention\Image\ImageManagerStatic as Image;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLogo()
    {
        $siteSetings = SiteSetings::first();
        return view('site-setings.logo',compact('siteSetings'));
    }

    public function indexFavicon()
    {
        $siteSetings = SiteSetings::first();
        return view('site-setings.favicon',compact('siteSetings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLogo(Request $request)
    {
        $this->validate($request,[
            'logo' => 'required',
        ]);
        $siteSetings = SiteSetings::first();
        $file = $request->logo;
        $name = time().$file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        $image->save(public_path('images/logo/' .$name));
        $img_src = '/images/logo/'.$name;
        $siteSetings->logo = $img_src;
        $siteSetings->save();
        return redirect()->back()->with('success', 'Successfully uploaded logo');
    }

    public function storeFavicon(Request $request)
    {
        $this->validate($request,[
            'favicon' => 'required',
        ]);
        $siteSetings = SiteSetings::first();
        $file = $request->favicon;
        $name = time().$file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        $image->save(public_path('images/favicon/' .$name));
        $img_src = '/images/favicon/'.$name;
        $siteSetings->favicon = $img_src;
        $siteSetings->save();
        return redirect()->back()->with('success', 'Successfully uploaded favicon');
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
    public function updateLogo(Request $request)
    {
        $this->validate($request,[
            'logo' => 'required',
        ]);
        $siteSetings = SiteSetings::first();
        unlink(public_path().$siteSetings->logo);
        $file = $request->logo;
        $name = time().$file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        $image->save(public_path('images/logo/' .$name));
        $img_src = '/images/logo/'.$name;
        $siteSetings->logo = $img_src;
        $siteSetings->save();
        return redirect()->back()->with('success', 'Successfully updated logo.');
    }

    public function updateFavicon(Request $request)
    {
        $this->validate($request,[
            'favicon' => 'required',
        ]);
        $siteSetings = SiteSetings::first();
        unlink(public_path().$siteSetings->favicon);
        $file = $request->favicon;
        $name = time().$file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        $image->save(public_path('images/favicon/' .$name));
        $img_src = '/images/favicon/'.$name;
        $siteSetings->favicon = $img_src;
        $siteSetings->save();
        return redirect()->back()->with('success', 'Successfully updated favicon.');
    }

    public function editSearchText()
    {
        $siteSetings = SiteSetings::first();
        return view('site-setings.search-text',compact('siteSetings'));
    }

    public function updateSearchText(Request $request)
    {
        $this->validate($request,[
            'front_page_search_text' => 'required',
            'category_page_search_text' => 'required',
            'brand_page_search_text' => 'required',
        ]);
        $siteSetings = SiteSetings::first();
        $siteSetings->update([
            'front_page_search_text' => $request->front_page_search_text,
            'category_page_search_text' => $request->category_page_search_text,
            'brand_page_search_text' => $request->brand_page_search_text,
        ]);
        return redirect()->back()->with('success', 'Successfully updated search text.');
    }
}
