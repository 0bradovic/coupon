<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use Intervention\Image\ImageManagerStatic as Image;
use App\MetaTag;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return view('brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
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
            'image' => 'required',
        ]);
        $slug = $this->createSlug($request->name);
        $i = 1;
        if(count(Brand::where('slug', $slug)->get()) > 0)
        {
            do{
            $x=Brand::where('slug', $slug)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Brand::where('slug', $newSlug)->get()) > 0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
        $img_src = null;
        if($request->image)
        {
            $file = $request->image;
            $name = time().$file->getClientOriginalName();
            $image = Image::make($file->getRealPath());
            $image->save(public_path('images/brand/' .$name));
            $img_src = '/images/brand/'.$name;
        }
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'img_src' => $img_src,
        ]);
        $newCategoryMetaTag = MetaTag::create([
            'brand_id' => $brand->id
        ]);
        
        $newCategoryMetaTag->title = $brand->name." | every ".$brand->name." voucher code, coupon, offer and deal";
        $newCategoryMetaTag->description = "Every ".$brand->name." voucher code, coupon, offer and deal at Before The Shop";
        $newCategoryMetaTag->link = 'brand/'.$brand->slug;
        $newCategoryMetaTag->save();

        $metaTag = MetaTag::where('brand_id', $brand->id)->first();
        return redirect()->route('brand.seo.edit', ['id' => $brand->id])->with('success', 'Successfully added new brand '.$brand->name);
        //return redirect()->back()->with('success', 'Successfully added new brand '.$brand->name);
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
        $brand = Brand::find($id);
        return view('brands.edit',compact('brand'));
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
        $brand = Brand::find($id);
        $slug = $this->createSlug($request->name);
        $i = 1;
        if(count(Brand::where('slug', $slug)->where('id','!=',$brand->id)->get()) > 0)
        {
            do{
            $x=Brand::where('slug', $slug)->where('id','!=',$brand->id)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Brand::where('slug', $newSlug)->where('id','!=',$brand->id)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        if($request->image)
        {
            if($brand->img_src)
            {
                unlink(public_path().$brand->img_src);
            }
            $file = $request->image;
            $name = time().$file->getClientOriginalName();
            $image = Image::make($file->getRealPath());
            $image->save(public_path('images/brand/' .$name));
            $img_src = '/images/brand/'.$name;
            $brand->update(['img_src' => $img_src]);
        }
        return redirect()->back()->with('success', 'Successfully updated brand '.$brand->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand->img_src)
        {
            unlink(public_path().$brand->img_src);
        }
        if(count($brand->offers) > 0)
        {
            foreach($brand->offers as $offer)
            {
                $offer->brand_id = null;
                $offer->save();
            }
        }
        if($brand->metaTag)
        {
            $metaTag = $brand->metaTag;
            $metaTag->delete();
        }
        $name = $brand->name;
        $brand->delete();
        return redirect()->back()->with('success', 'Successfully deleted brand '.$name);
    }

    public function removeFromHomepage($id)
    {
        $brand = Brand::find($id);
        if($brand)
        {
            $brand->fp_position = null;
            $brand->save();
            return redirect()->back()->with('success', 'Successfully removed '.$brand->name.' from homepage.');
        }
        else
        {
            return redirect()->back()->withErrors(['Brand not found.']);
        }
    }

    public function updateHomepagePosition(Request $request,$id)
    {
        $this->validate($request,[
            'position' => 'required',
        ]);
        $brand = Brand::find($id);
        if($brand)
        {
            $brand->fp_position = $request->position;
            $brand->save();
            return redirect()->back()->with('success', 'Successfully updated '.$brand->name.' homepage position.');
        }
        else
        {
            return redirect()->back()->withErrors(['Brand not found.']);
        }
    }
}
