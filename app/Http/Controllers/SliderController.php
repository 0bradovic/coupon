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
            'up_text_color' => $request->up_text_color,
            'down_text' => $request->down_text,
            'down_text_color' => $request->down_text_color,
            'center_text' => $request->center_text,
            'center_text_color' => $request->center_text_color,
            'left_text' => $request->left_text,
            'left_text_color' => $request->left_text_color,
            'right_text' => $request->right_text,
            'right_text_color' => $request->right_text_color,
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
        $slide = Slider::find($id);
        return view('slider.edit',compact('slide'));
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
            'position' => 'required',
        ]);
        $slide = Slider::find($id);
        $img_src = $slide->img_src;
        if($request->photo)
        {
            unlink(public_path().$slide->img_src);
            $file = $request->photo;
            $name = time().$file->getClientOriginalName();
            $image = Image::make($file->getRealPath());
            $image->resize(1200,null,function($constraint){
                    $constraint->aspectRatio();
                });
            $image->save(public_path('images/slider/' .$name));
            $img_src = '/images/slider/'.$name;
        }
        $slide->update([
            'img_src' => $img_src,
            'up_text' => $request->up_text,
            'up_text_color' => $request->up_text_color,
            'down_text' => $request->down_text,
            'down_text_color' => $request->down_text_color,
            'center_text' => $request->center_text,
            'center_text_color' => $request->center_text_color,
            'left_text' => $request->left_text,
            'left_text_color' => $request->left_text_color,
            'right_text' => $request->right_text,
            'right_text_color' => $request->right_text_color,
            'link' => $request->link,
            'position' => $request->position,
        ]);
        return redirect()->back()->with('success', 'Successfully updated slide.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide = Slider::find($id);
        unlink(public_path().$slide->img_src);
        $slide->delete();
        return redirect()->back()->with('success','Successfully deleted slide.');
    }

    public function updateSlideActivity(Request $request)
    {
        $slide = Slider::find($request->id);
        $slide->update([
            'active' => $request->active,
        ]);
    }

}
