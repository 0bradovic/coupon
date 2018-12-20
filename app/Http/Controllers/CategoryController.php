<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id',null)->get();
        return view('categories.create',compact('categories'));
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
        $parent_id = null;
        $img_src = null;
        $lastCategorySku = Category::all()->pluck('sku')->last();
        if($lastCategorySku)
        {
            $sku = intval($lastCategorySku) + 1;
        }
        else
        {
            $sku = 1000;
        }
        
        if($request->parent_id)
        {
            $parent_id = $request->parent_id;
        }
        
        if($request->photo)
        {
            $file = $request->photo;
            $name = time().$file->getClientOriginalName();
            $file->move('images/category',$name);
            $img_src = '/images/category/'.$name;
        }
        $category = Category::create([
            'name' => $request->name,
            'sku' => $sku,
            'img_src' => $img_src,
            'parent_id' => $parent_id,
        ]);
        return redirect()->back()->with('success','Successfully added new category '.$category->name);
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
        $category = Category::find($id);
        $categories = Category::where('parent_id',null)->where('id', '!=', $id)->get();
        return view('categories.edit',compact('category','categories'));
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
            'name' => 'required'
        ]);
        $category = Category::find($id);
        $parent_id = null;
        $img_src = null;
        if($category->img_src)
        {
            $img_src = $category->img_src;
        }
        if($request->parent_id)
        {
            $parent_id = $request->parent_id;
        }
        if($request->photo)
        {
            if($category->img_src)
            {
                unlink(public_path().$category->img_src);
            }
            $file = $request->photo;
            $name = time().$file->getClientOriginalName();
            $file->move('images/category',$name);
            $img_src = '/images/category/'.$name;
        }
        $category->update([
            'name' => $request->name,
            'img_src' => $img_src,
            'parent_id' => $parent_id,
        ]);
        return redirect()->back()->with('success','Successfully updated category '.$category->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->img_src)
        {
            unlink(public_path().$category->img_src);
        }
        $name = $category->name;
        $category->delete();
        return redirect()->back()->with('success','Successfully deleted category '.$name);
    }
}
