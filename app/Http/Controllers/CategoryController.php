<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\MetaTag;
use Illuminate\Routing\UrlGenerator;
use App\Undo;
use App\Offer;
use App\ExcludeKeywords;
use App\Brand;


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
            'default_words_set' => $request->default_words_set,
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
        if(count(Category::where('slug', $slug)->where('id','<>',$id)->get()) > 0)
        {
            do{
            $x=Category::where('slug', $slug)->where('id','<>',$id)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Category::where('slug', $newSlug)->where('id','<>',$id)->get())>0);
            
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
            'position' => $request->position,
            'default_words_set' => $request->default_words_set,
        ]);
        $excludeKeywords = ExcludeKeywords::first();
        $offers = $category->offers;
        if(count($offers) > 0)
        {
            foreach($offers as $offer)
            {
                $s = $offer->detail;
                $search = ["</p>","</div>","<br>","</br>","</small>"]; 
                $replace = " ";
                $s = str_replace($search,$replace,$s);
                preg_match_all('([A-Z][^\s]*)', $s, $matches);
                $detailWords = $matches[0];
                foreach($detailWords as $key => $value)
                {
                    $detailWords[$key] = str_replace( ',', '', $value );
                }
                $detailWords = array_map('strtolower',$detailWords);
                $excludeWords = explode(',',$excludeKeywords->keywords);
                $excludeWords = array_map('trim', $excludeWords);
                foreach($detailWords as $key => $value)
                {
                    if(in_array($value,$excludeWords))
                    {
                        unset($detailWords[$key]);
                    }
                }
                if($category->default_words_set != null)
                {
                    $setWords = explode(',',$category->default_words_set);
                    $setWords = array_map('trim', $setWords);
                    $tag = implode(', ',$detailWords).', '.implode(', ',$setWords);
                    $tag = explode(', ',$tag);
                    $tag = array_unique($tag);
                    $tag = implode(', ',$tag);
                }
                else
                {
                    $setWords = null;
                    $tag = implode(', ',$detailWords);
                    $tag = explode(', ',$tag);
                    $tag = array_unique($tag);
                    $tag = implode(', ',$tag);
                }
                $offer->alt_tag = $tag;
                $offer->save();
                if($offer->metaTag)
                {
                    $metaTag = $offer->metaTag;
                    $metaTag->keywords = $offer->alt_tag;
                    $metaTag->description = $offer->name.". ".$offer->formatDetailsDescription($offer->detail);
                    $metaTag->title = $offer->name.". ".$offer->firstSentence($offer->detail);
                    $metaTag->save();
                }
            }
        }
        
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

    public function getKeywords()
    {
        $excludeKeywords = ExcludeKeywords::first();
        return view('categories.exclude-keywords',compact('excludeKeywords'));
    }

    public function updateKeywords(Request $request)
    {
        $this->validate($request,[
            'keywords' => 'required',
        ]);
        $excludeKeywords = ExcludeKeywords::first();
        $excludeKeywords->keywords = $request->keywords;
        $excludeKeywords->save();
        $offers = Offer::all();
        if(count($offers) > 0)
        {
            foreach($offers as $offer)
            {
                $category = $offer->categories()->first();
                $s = $offer->detail;
                $search = ["</p>","</div>","<br>","</br>","</small>"]; 
                $replace = " ";
                $s = str_replace($search,$replace,$s);
                preg_match_all('([A-Z][^\s]*)', $s, $matches);
                $detailWords = $matches[0];
                foreach($detailWords as $key => $value)
                {
                    $detailWords[$key] = str_replace( ',', '', $value );
                }
                $detailWords = array_map('strtolower',$detailWords);
                $excludeWords = explode(',',$excludeKeywords->keywords);
                $excludeWords = array_map('trim', $excludeWords);
                foreach($detailWords as $key => $value)
                {
                    if(in_array($value,$excludeWords))
                    {
                        unset($detailWords[$key]);
                    }
                }
                if($category != null)
                {
                    if($category->default_words_set != null)
                    {
                        $setWords = explode(',',$category->default_words_set);
                        $setWords = array_map('trim', $setWords);
                        $tag = implode(', ',$detailWords).', '.implode(', ',$setWords);
                        $tag = explode(', ',$tag);
                        $tag = array_unique($tag);
                        $tag = implode(', ',$tag);
                    }
                    else
                    {
                        $setWords = null;
                        $tag = implode(', ',$detailWords);
                        $tag = explode(', ',$tag);
                        $tag = array_unique($tag);
                        $tag = implode(', ',$tag);
                    }
                }
                else
                {
                    $setWords = null;
                    $tag = implode(', ',$detailWords);
                    $tag = explode(', ',$tag);
                    $tag = array_unique($tag);
                    $tag = implode(', ',$tag);
                }
               
                $offer->alt_tag = $tag;
                $offer->save();
                if($offer->metaTag)
                {
                    $metaTag = $offer->metaTag;
                    $metaTag->keywords = $offer->alt_tag;
                    $metaTag->description = $offer->name.". ".$offer->formatDetailsDescription($offer->detail);
                    $metaTag->title = $offer->name.". ".$offer->firstSentence($offer->detail);
                    $metaTag->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Successfully updated default exclude keywords.');
    }

    public function frontPageCategories()
    {
        $categories = Category::where('parent_id',null)->orderBy('fp_position')->get();
        return view('categories.front-page-categories',compact('categories'));
    }

    public function updateFrontPagePosition($id,Request $request)
    {
        $this->validate($request,[
            'fp_position' => 'required',
        ]);
        $category = Category::find($id);
        $category->fp_position = $request->fp_position;
        $category->save();
        return redirect()->back()->with('success', 'Successfully updated front page position for '.$category->name.'.');
    }

    public function topBrands($id)
    {
        $category = Category::find($id);
        $brandIds = [];
        if($category->parent_id == null)
        {
            foreach($category->subcategories as $cat)
            {
                foreach($cat->offers as $offer)
                {
                    if($offer->brand)
                    {
                        array_push($brandIds,$offer->brand_id);
                    }
                }
            }
        }
        else
        {
            foreach($category->offers as $offer)
            {
                if($offer->brand)
                {
                    array_push($brandIds,$offer->brand_id);
                }
            }
        }
        $brandIds = array_unique($brandIds);
        $brands = Brand::find($brandIds);
        return view('categories.category-brands',compact('category','brands'));
    }

    public function updateTopBrands(Request $request, $id)
    {
        $category = Category::find($id);
        if($category->brands)
        {
            $category->brands()->detach();
        }
        if($request->brands)
        {
            foreach($request->brands as $brand)
            {
                if($brand['position'] != null)
                {
                    $category->brands()->attach($brand['id'], ['position' => $brand['position']]);
                }
            
            }
        }
        
        return redirect()->back()->with('success', 'Successfully updated top brands for '.$category->name);
    }

    public function categoryBrands($id)
    {
        $category = Category::find($id);
        return response()->json([
            'brands' => $category->orderedBrands,
        ]);
    }

}
