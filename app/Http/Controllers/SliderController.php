<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Intervention\Image\ImageManagerStatic as Image;
use App\Undo;

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
        $undoDeleted = Undo::where('slider_id','<>',null)->where('type','Deleted')->first();
        return view('slider.index',compact('slides','undoDeleted'));
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
            'alt_tag' => $request->alt_tag,
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
        $undoEdited = Undo::where('slider_id',$slide->id)->where('type','Edited')->first();
        return view('slider.edit',compact('slide','undoEdited'));
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
        $hasUndo = Undo::where('slider_id','<>',null)->where('type','Edited')->first();
        $properties = $slide->toJson();
        $img_src = $slide->img_src;
        if($request->photo)
        {
            $img_url = public_path().$slide->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $slide_img_src = '/images/undo/slider/'.$name;
            file_put_contents(public_path().$slide_img_src, $contents);
            $properties = json_decode($properties);
            $properties->img_src = $slide_img_src;
            $properties = json_encode($properties);
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
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'slider_id' => $slide->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'slider_id' => $slide->id,
            ]);
        }
        $slide->update([
            'img_src' => $img_src,
            'alt_tag' => $request->alt_tag,
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
        $img_url = public_path().$slide->img_src;
        $info = pathinfo($img_url);
        $contents = file_get_contents($img_url);
        $name = $info['basename'];
        $img_src = '/images/undo/slider/'.$name;
        file_put_contents(public_path().$img_src, $contents);
        $properties = $slide->toJson();
        $properties = json_decode($properties);
        $properties->img_src = $img_src;
        $properties = json_encode($properties);
        $hasUndo = Undo::where('slider_id','<>',null)->where('type','Deleted')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'slider_id' => $slide->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'slider_id' => $slide->id,
            ]);
        }
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

    public function undoDeleted()
    {
        $undo = Undo::where('slider_id','<>',null)->where('type','Deleted')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $img_url = public_path().$props->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $img_src = '/images/slider/'.$name;
            file_put_contents(public_path().$img_src, $contents);
            $slide = Slider::create([
                'img_src' => $img_src,
                'alt_tag' => $props->alt_tag,
                'up_text' => $props->up_text,
                'up_text_color' => $props->up_text_color,
                'down_text' => $props->down_text,
                'down_text_color' => $props->down_text_color,
                'center_text' => $props->center_text,
                'center_text_color' => $props->center_text_color,
                'left_text' => $props->left_text,
                'left_text_color' => $props->left_text_color,
                'right_text' => $props->right_text,
                'right_text_color' => $props->right_text_color,
                'link' => $props->link,
                'position' => $props->position,
                'active' => $props->active,
            ]);
            unlink(public_path().$props->img_src);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully restore last deleted slide.');
        }
    }

    public function undoEdited($id)
    {
        $slide = Slider::find($id);
        $undo = Undo::where('type','Edited')->where('slider_id',$slide->id)->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $img_url = public_path().$props->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $img_src = '/images/slider/'.$name;
            file_put_contents(public_path().$img_src, $contents);
            unlink(public_path().$slide->img_src);
            $slide->update([
                'img_src' => $img_src,
                'alt_tag' => $props->alt_tag,
                'up_text' => $props->up_text,
                'up_text_color' => $props->up_text_color,
                'down_text' => $props->down_text,
                'down_text_color' => $props->down_text_color,
                'center_text' => $props->center_text,
                'center_text_color' => $props->center_text_color,
                'left_text' => $props->left_text,
                'left_text_color' => $props->left_text_color,
                'right_text' => $props->right_text,
                'right_text_color' => $props->right_text_color,
                'link' => $props->link,
                'position' => $props->position,
                'active' => $props->active,
            ]);
            unlink(public_path().$props->img_src);
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo slide.');
        }
    }

}
