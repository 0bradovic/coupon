<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\MetaTag;
use Illuminate\Routing\UrlGenerator;
use App\Undo;
use App\Offer;


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
        $undoDeleted = Undo::where('category_id','<>',null)->where('type','Deleted')->first();
        return view('categories.index', compact('categories','undoDeleted'));
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
        //$slug = $this->createSlug($request->name);
        $slug = $this->createSlug($request->name);
         $i = 1;
        if(count(Category::where('slug', $slug)->get()) > 0)
        {
            do{
            $x=Category::where('slug', $slug)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Category::where('slug', $newSlug)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
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

        $newCategoryMetaTag = MetaTag::create([
            'category_id' => $category->id
        ]);
        
        $url = env("APP_URL");
        $newCategoryMetaTag->link = 'category/'.$category->slug;
        $newCategoryMetaTag->save();

        $metaTag = MetaTag::where('category_id', $category->id)->first();
        return redirect()->route('category.seo.edit', ['id' => $category->id])->with('success', 'Successfully added category '.$category->name);
        //return redirect()->back()->with('success', 'Successfully added category '.$category->name);
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
        $undoEdited = Undo::where('type','Edited')->where('category_id',$category->id)->first();
        return view('categories.edit',compact('category','categories','undoEdited'));
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
        $hasUndo = Undo::where('category_id','<>',null)->where('type','Edited')->first();
        $properties = $category->toJson();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'category_id' => $category->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'category_id' => $category->id,
            ]);
        }
        $slug = $this->createSlug($request->name);
        $i = 1;
        if(count(Category::where('slug', $slug)->get()) > 0)
        {
            do{
            $x=Category::where('slug', $slug)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Category::where('slug', $newSlug)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
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
            if($category->metaTag)
            {
                $metaTag = MetaTag::where('category_id', $id)->first();
                $metaTag->delete();
            }
            $offerIds = $category->offers()->pluck('id');
            $properties = $category->toJson();
            $properties = json_decode($properties);
            $properties->offers = $offerIds;
            $properties = json_encode($properties);
            $hasUndo = Undo::where('category_id','<>',null)->where('type','Deleted')->first();
            if($hasUndo == null)
            {
                $undo = Undo::create([
                    'properties' => $properties,
                    'type' => 'Deleted',
                    'category_id' => $category->id,
                ]);
            }
            else
            {
                $hasUndo->update([
                    'properties' => $properties,
                    'type' => 'Deleted',
                    'category_id' => $category->id,
                ]);
            }
            
            $category->delete();
            return redirect()->back()->with('success','Successfully deleted category '.$name);
        }
        
    }

    public function undoDeleted()
    {
        $undo = Undo::where('category_id','<>',null)->where('type','Deleted')->first();
        $props = json_decode($undo->properties);
        //dd($props);
        $slug = $this->createSlug($props->name);
         $i = 1;
        if(count(Category::where('slug', $slug)->get()) > 0)
        {
            do{
            $x=Category::where('slug', $slug)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Category::where('slug', $newSlug)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
        $lastCategorySku = Category::all()->pluck('sku')->last();
        if($lastCategorySku)
        {
            $sku = intval($lastCategorySku) + 1;
        }
        else
        {
            $sku = 1000;
        }
        
        $category = Category::create([
            'name' => $props->name,
            'sku' => $sku,
            'slug' => $slug,
            'img_src' => null,
            'parent_id' => $props->parent_id,
            'position' => $props->position,
            'display' => $props->display,
        ]);
        foreach($props->offers as $offer)
        {
            $category->offers()->attach($offer);
        }
        $newCategoryMetaTag = MetaTag::create([
            'category_id' => $category->id
        ]);
        
        $url = env("APP_URL");
        $newCategoryMetaTag->link = 'category/'.$category->slug;
        $newCategoryMetaTag->save();
        $undo->delete();
        return redirect()->back()->with('success', 'Successfully restore last deleted category.');
       
    }

    public function undoEdited($id)
    {
        $category = Category::find($id);
        $undo = Undo::where('type','Edited')->where('category_id',$category->id)->first();
        if($undo != null)
        {
            $props = json_decode($undo->properties);
            $category->update([
                'name' => $props->name,
                'slug' => $props->slug,
                'sku' => $props->sku,
                'img_src' => $props->img_src,
                'parent_id' => $props->parent_id,
                'position' => $props->position,
                'display' => $props->display,
            ]);
            $undo->delete();
        }
        else
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        return redirect()->back()->with('success', 'Successfully undo category.');
    }

    public function display($id)
    {
        $category = Category::find($id);
        $category->display = !$category->display;
        $category->save();

        return redirect()->back()->with('success', 'Successfully changed visibility of category '.$category->name);
    }

}
