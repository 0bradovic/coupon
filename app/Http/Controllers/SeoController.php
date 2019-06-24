<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Category;
use App\MetaTag;
use Intervention\Image\ImageManagerStatic as Image;
use App\Brand;

class SeoController extends Controller
{
    //

    // public function index()
    // {
    //     $metaTags = MetaTag::all();
    //     return view('offers.index',compact('metaTags'));
    // }

    public function indexOffer()
    {
        $metaTags = MetaTag::where('category_id', '=', null)->where('offer_id', '<>', null)->with('offer')->with('category')->get();
        return view('seo.index',compact('metaTags'));
    }

    public function indexCategory()
    {
        $metaTags = MetaTag::where('offer_id', '=', null)->where('category_id', '<>', null)->with('offer')->with('category')->get();
        return view('seo.index',compact('metaTags'));
    }

    public function indexCustom()
    {
        $metaTags = MetaTag::where('category_id', '=', null)->where('offer_id', '=', null)->with('offer')->with('category')->get();
        return view('seo.index',compact('metaTags'));
    }

    public function indexBrand()
    {
        $metaTags = MetaTag::where('brand_id', '<>', null)->with('brand')->get();
        return view('seo.index',compact('metaTags'));
    }

    // public function create()
    // {
    //     $offers = Offer::all();
    //     $categories = Category::all();
    //     return view('seo.create',compact('categories','offers'));
    // }

    public function createOffer()
    {
        $brands = Brand::all();
        $offers = Offer::all();
        $categories = Category::all();
        return view('seo.create',compact('categories','offers','brands'));
    }

    public function createCategory()
    {
        $brands = Brand::all();
        $offers = Offer::all();
        $categories = Category::all();
        return view('seo.create',compact('categories','offers','brands'));
    }

    public function createCustom()
    {
        $brands = Brand::all();
        $offers = Offer::all();
        $categories = Category::all();
        return view('seo.create',compact('categories','offers','brands'));
    }

    public function createBrand()
    {
        $brands = Brand::all();
        $offers = Offer::all();
        $categories = Category::all();
        return view('seo.create',compact('categories','offers','brands'));
    }

    // public function store(Request $request)
    // {
    //     $newMetaTag = MetaTag::create([
    //         'keywords' => $request->keywords,
    //         'description' => $request->description,
    //         'og_title' => $request->og_title,
    //         'og_image' => $request->og_image,
    //         'og_description' => $request->og_description,
    //         'is_default' => $request->is_default,
    //         'link' => $request->link,
    //         'title' => $request->title
    //     ]);

    //     $newMetaTag->offer()->attach($request->offer_id);

    //     $newMetaTag->category()->attach($request->category_id);

    //     return redirect()->back()->with('Success', 'Successfully created new meta tag');
    // }

    public function storeOffer(Request $request)
    {
        $newMetaTag = MetaTag::create([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        
        $off=Offer::find($request->offer_id);
        $newMetaTag->link = URL::to('/').'offer/'.$off->slug;
        $newMetaTag->save();
        $newMetaTag->offer()->attach($request->offer_id);

        //$newMetaTag->category()->attach($request->category_id);

        return redirect()->back()->with('success', 'Successfully created new meta tag');
    }

    public function storeCatagory(Request $request)
    {
        $newMetaTag = MetaTag::create([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        

        // $newMetaTag->offer()->attach($request->offer_id);

        $newMetaTag->category()->attach($request->category_id);

        return redirect()->back()->with('success', 'Successfully created new meta tag');
    }

    public function storeBrand(Request $request)
    {
        $newMetaTag = MetaTag::create([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        

        // $newMetaTag->offer()->attach($request->offer_id);

        $newMetaTag->brand()->attach($request->brand_id);

        return redirect()->back()->with('success', 'Successfully created new meta tag');
    }

    public function storeCustom(Request $request)
    {
        $this->validate($request,[
            'link' => 'required'
        ]);
        $default = null;
       if($request->is_default)
       {
           $default = 1;
       }
        $newMetaTag = MetaTag::create([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $default,
            'link' => $request->link,
            'title' => $request->title
        ]);

        //$newMetaTag->offer()->attach($request->offer_id);

        //$newMetaTag->category()->attach($request->category_id);

        return redirect()->back()->with('success', 'Successfully created new meta tag');
    }

    // public function edit($id)
    // {
    //     $metaTags = MetaTag::find($id);
    //     $offers = Offer::all();
    //     $categories = Category::all();
    //     return view('seo.edit',compact('metaTags','offers','categories'));
    // }

    public function editOffer($id)
    {
        $offer = Offer::find($id);
        $metaTag = MetaTag::where('offer_id', $offer->id)->first();
        if($metaTag)
        {
            return view('seo.edit',compact('metaTag','offer'));
        }
        else
        {
            
            $metaTag = MetaTag::create([
                'offer_id' => $offer->id
            ]);
            $url = env("APP_URL");
            $metaTag->link = 'offer/'.$offer->slug;
            $metaTag->save();
            return view('seo.edit',compact('metaTag','offer'));
        }
        
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        $metaTag = MetaTag::where('category_id', $category->id)->first();
        if($metaTag)
        {
            return view('seo.edit',compact('metaTag','category'));
        }
        else
        {
            $metaTag = MetaTag::create([
                'category_id' => $category->id
            ]);
            $url = env("APP_URL");
            $metaTag->link = 'category/'.$category->slug;
            $metaTag->save();
            return view('seo.edit',compact('metaTag','category'));
        }
        
    }

    public function editBrand($id)
    {
        $brand = Brand::find($id);
        $metaTag = MetaTag::where('brand_id', $brand->id)->first();
        if($metaTag)
        {
            return view('seo.edit',compact('metaTag','brand'));
        }
        else
        {
            $metaTag = MetaTag::create([
                'brand_id' => $brand->id
            ]);
            $url = env("APP_URL");
            $metaTag->link = 'brand/'.$brand->slug;
            $metaTag->save();
            return view('seo.edit',compact('metaTag','brand'));
        }
        
    }

    public function editCustom($id)
    {
        $metaTag = MetaTag::find($id);
        return view('seo.edit',compact('metaTag'));
    }

    // public function update(Request $request, $id)
    // {
    //     $metaTag = MetaTag::find($id);
    //     $metaTag->update([
    //         'keywords' => $request->keywords,
    //         'description' => $request->description,
    //         'og_title' => $request->og_title,
    //         'og_image' => $request->og_image,
    //         'og_description' => $request->og_description,
    //         'is_default' => $request->is_default,
    //         'link' => $request->link,
    //         'title' => $request->title
    //     ]);

    //     $metaTag->category()->detach();

    //     $metaTag->offer()->detach();

    //     $metaTag->category()->attach($request->category_id);
        
    //     $metaTag->offer()->attach($request->offer_id);

    //     return redirect()->back()->with('success', 'Successfully updated meta tag');

    // }

    public function updateOffer(Request $request, $id)
    {
        $metaTag = MetaTag::find($id);
        $metaTag->update([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        //$metaTag->category()->detach();

        //$metaTag->offer()->detach();

        //$metaTag->category()->attach($request->category_id);
        
        //$metaTag->offer()->attach($request->offer_id);

        $offers = Offer::orderBy('position')->get();
        return redirect()->route('offers.index')->with('success', 'Successfully updated meta tag');

        //return redirect()->back()->with('success', 'Successfully updated meta tag');

    }

    public function updateCategory(Request $request, $id)
    {
        $metaTag = MetaTag::find($id);
        $metaTag->update([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        // $metaTag->category()->detach();

        // $metaTag->offer()->detach();

        // $metaTag->category()->attach($request->category_id);
        
        // $metaTag->offer()->attach($request->offer_id);

        $categories = Category::all();
        return redirect()->route('category.index')->with('success', 'Successfully updated meta tag');

        

        //return redirect()->back()->with('success', 'Successfully updated meta tag');

    }

    public function updateBrand(Request $request, $id)
    {
        $metaTag = MetaTag::find($id);
        $metaTag->update([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        $brands = Brand::all();
        return redirect()->route('brand.index')->with('success', 'Successfully updated meta tag');

        

        //return redirect()->back()->with('success', 'Successfully updated meta tag');

    }

    public function updateCustom(Request $request, $id)
    {
        $metaTag = MetaTag::find($id);
        $metaTag->update([
            'keywords' => $request->keywords,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_image' => $request->og_image,
            'og_description' => $request->og_description,
            'is_default' => $request->is_default,
            //'link' => $request->link,
            'title' => $request->title
        ]);

        // $metaTag->category()->detach();

        // $metaTag->offer()->detach();

        // $metaTag->category()->attach($request->category_id);
        
        // $metaTag->offer()->attach($request->offer_id);

        return redirect()->back()->with('success', 'Successfully updated meta tag');

    }


    public function destroy($id)
    {
        $metaTag = MetaTag::find($id);
        $metaTag->delete();
        return redirect()->back()->with('success', 'Successfully deleted meta tag');
    }

    // public function getMetaTags()
    // {
    //     $path = Request::path();

    //     $tag = MetaTag::where('link', $path[0] != '/' ? '/'.$path : $path)->orWhere('is_default', true)->orderBy('is_default', 'asc')->first();
    //     if($tag)
    //     {
    //         $tag = $tag->toArray();
    //         return '
    //                 <meta name="keywords" content="'.$tag['keywords'].'"/>
    //                 <meta name="description" content="'.$tag['description'].'"/>
    //                 <meta property="og:title" content="'.$tag['og_title'].'"/>
    //                 <meta property="og:image" content="'.$tag['og_image'].'"/>
    //                 <meta property="og:description" content="'.$tag['og_description'].'"/>
    //                 ';

    //     }

    // }

}
