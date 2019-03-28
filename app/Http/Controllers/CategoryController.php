<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\MetaTag;
use Illuminate\Routing\UrlGenerator;
use App\UndoCategory;



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
            'position' => 'required',
        ]);
        $slug = $this->createSlug($request->name);
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
            'slug' => $slug,
            'img_src' => $img_src,
            'parent_id' => $parent_id,
            'position' => $request->position,
            'display' => $request->display,
        ]);

        // $newCategoryMetaTag = MetaTag::create([
        //     'category_id' => $category->id
        // ]);
        
        //$url = env("APP_URL");
        // $newCategoryMetaTag->link = 'category/'.$category->slug;
        // $newCategoryMetaTag->save();

        // $metaTag = MetaTag::where('category_id', $category->id)->first();
        // return redirect()->route('category.seo.edit', ['id' => $category->id])->with('success', 'Successfully added category '.$category->name);
        return redirect()->back()->with('success', 'Successfully added category '.$category->name);
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
            'name' => 'required',
            'position' => 'required'
        ]);
        $category = Category::find($id);
        $undoCategory = UndoCategory::first();
        $undoCategory->update([
            'name' => $category->name,
            'sku' => $category->sku,
            'img_src' => $category->img_src,
            'parent_id' => $category->parent_id,
            'summary' => $category->summary,
            'slug' => $category->slug,
            'display' => $category->display,
            'category_id' => $category->id,
            'position' => $category->position,
        ]);
        $slug = $this->createSlug($request->name);
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
            'slug' => $slug,
            'parent_id' => $parent_id,
            'position' => $request->position
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
        $subCategories = Category::where('parent_id', $category->id)->get();
        if(count($subCategories) > 0)
        {
            return redirect()->back()->withErrors(['Cannot delete this category because other categories are attached.']);
        }
        else
        {
            if($category->img_src)
            {
                unlink(public_path().$category->img_src);
            }
            $name = $category->name;
            // if($category->metaTag)
            // {
            //     $metaTag = MetaTag::where('category_id', $id)->first();
            //     $metaTag->delete();
            // }
            
            $category->delete();
            return redirect()->back()->with('success','Successfully deleted category '.$name);
        }
        
    }

    public function display($id)
    {
        $category = Category::find($id);
        $category->display = !$category->display;
        $category->save();

        return redirect()->back()->with('success', 'Successfully changed visibility of category '.$category->name);
    }


    public function undoEdit()
    {
        $undo = UndoCategory::first();
        $category = Category::find($undo->category_id);
        $category->update([
            'name' => $undo->name,
            'sku' => $undo->sku,
            'img_src' => $undo->img_src,
            'parent_id' => $undo->parent_id,
            'summary' => $undo->summary,
            'slug' => $undo->slug,
            'display' => $undo->display,
            'position' => $undo->position,
        ]);
        return redirect()->back();
    }
}
