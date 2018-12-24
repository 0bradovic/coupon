<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Intervention\Image\ImageManagerStatic as Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = Slider::orderBy('position')->get();
        return view('slider.index',compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.create');
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
            'photo' => 'required',
            'position' => 'required',
        ]);
        $file = $request->photo;
        $name = time().$file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        $image->resize(1200,null,function($constraint){
                $constraint->aspectRatio();
            });
        $image->save(public_path('images/slider/' .$name));
        $img_src = '/images/slider/'.$name;

        $slide = Slider::create([
            'img_src' => $img_src,
            'up_text' => $request->up_text,
            'down_text' => $request->down_text,
            'center_text' => $request->center_text,
            'left_text' => $request->left_text,
            'right_text' => $request->right_text,
            'link' => $request->link,
            'position' => $request->position,
            'active' => 1
        ]);
        return redirect()->back()->with('success', 'Successfully created new slide.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $slides = Slider::where('active',1)->orderBy('position')->get();
        return view('slider.show',compact('slides'));
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
    public function update(Request $request, $id)
    {
        //
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
