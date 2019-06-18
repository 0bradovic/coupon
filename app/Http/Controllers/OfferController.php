<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\OfferType;
use App\Category;
use App\Tag;
use Auth;
use App\MetaTag;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use App\Support\Collection;
use Response;
use App\Undo;
use App\ExcludeKeywords;
use App\Brand;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::orderBy('position')->paginate(15);
        $categories = Category::where('parent_id',null)->get();
        $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
        return view('offers.index',compact('offers','categories','undoDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$tags = Tag::all();
        $brands = Brand::all();
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        return view('offers.create',compact('categories','offerTypes','brands'));
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
            'name' => 'required|string',
            'highlight' => 'max:20',
            'summary' => 'max:50',
            'detail' => 'max:300',
            'link' => 'required|string',
            'startDate' => 'required|date',
            'categories' => 'required',
            'brand' => 'required',
        ]);
        $slug = $this->createSlug($request->name);
         $i = 1;
        if(count(Offer::where('slug', $slug)->get()) > 0)
        {
            do{
            $x=Offer::where('slug', $slug)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Offer::where('slug', $newSlug)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
        $img_src = null;
        $offer_type_id = null;
        $startDate = Carbon::parse($request->startDate);
        $endDate = null;
        $endDateNull = 1;
        if($request->endDate)
        {
            $endDate = Carbon::parse($request->endDate);
            $endDateNull = 0;
        }
        if($request->offer_type_id)
        {
            $offer_type_id = $request->offer_type_id;
        }
        $fullOfferLink = $request->link;
        $url = "http://tinyurl.com/api-create.php?url=".$request->link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
 
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
 
        $offerLink = $output;
        
        $lastOfferSku = Offer::all()->pluck('sku')->last();
        if($lastOfferSku)
        {
            $sku = intval($lastOfferSku) + 1;
        }
        else
        {
            $sku = 10000000;
        }
        if($request->photo)
        {
            $file = $request->photo;
            $name = time().$file->getClientOriginalName();
            $image = Image::make($file->getRealPath());
            $image->resize(788,null,function($constraint){
                $constraint->aspectRatio();
            });
            $image->save(public_path('images/offer/' .$name));
            $img_src = '/images/offer/'.$name;
        }
        $offer = Offer::create([
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $sku,
            'highlight' => $request->highlight,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'link' => $offerLink,
            'full_link' => $fullOfferLink,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'endDateNull' => $endDateNull,
            'offer_type_id' => $offer_type_id,
            'user_id' => Auth::user()->id,
            'position' => $request->position,
            'img_src' => $img_src,
            'display' => $request->display,
            'brand_id' => $request->brand,
        ]);
        foreach($request->categories as $category)
        {
            $offer->categories()->attach($category);
        }
        // if($request->tags)
        // {
        //     foreach($request->tags as $tag)
        //     {
        //         $offer->tags()->attach($tag);
        //     }
        // }

        $newOfferMetaTag = MetaTag::create([
            'offer_id' => $offer->id
        ]);

        //$url = env("APP_URL");
        $newOfferMetaTag->link = 'offer/'.$offer->slug;
        $newOfferMetaTag->save();

        //image alt tag populate
        $excludeKeywords = ExcludeKeywords::first();
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

        //end image alt tag populate

        $metaTag = MetaTag::where('offer_id', $offer->id)->first();
        return redirect()->route('offer.seo.edit', ['id' => $offer->id])->with('success', 'Successfully added offer '.$offer->name);
        //return redirect()->back()->with('success', 'Successfully added offer '.$offer->name);
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
        $offer = Offer::find($id);
        //$tags = Tag::all();
        $brands = Brand::all();
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        $undoEdited = Undo::where('offer_id',$id)->where('type','Edited')->first();
        return view('offers.edit',compact('offer','offerTypes','categories','undoEdited','brands'));
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
            'name' => 'required|string',
            'highlight' => 'max:20',
            'summary' => 'max:50',
            'detail' => 'max:300',
            'link' => 'required|string',
            'startDate' => 'required|date',
            'categories' => 'required',
            'brand' => 'required',
        ]);
        $offer = Offer::find($id);
        $hasUndo = Undo::where('offer_id','<>',null)->where('type','Edited')->first();
        $properties = $offer->toJson();
        $categoryIds = $offer->categories()->pluck('id');
        $properties = json_decode($properties);
        $properties->categories = $categoryIds;
        $properties->img_changed = 0;
        $img_src = $offer->img_src;
        if($request->photo)
        {
            $img_url = public_path().$offer->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $offer_img_src = '/images/undo/offer/'.$name;
            file_put_contents(public_path().$offer_img_src, $contents);
            $properties->img_src = $offer_img_src;
            $properties->img_changed = 1;
        }
        $properties = json_encode($properties);
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Edited',
                'offer_id' => $offer->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Edited',
                'offer_id' => $offer->id,
            ]);
        }
        $slug = $this->createSlug($request->name);
        $i = 1;
        if(count(Offer::where('slug', $slug)->where('id','!=',$offer->id)->get()) > 0)
        {
            do{
            $x=Offer::where('slug', $slug)->where('id','!=',$offer->id)->get();
            if($x) $newSlug = $slug.$i;
            //$slug = $slug.$i;
            $i++;
            }while(count(Offer::where('slug', $newSlug)->where('id','!=',$offer->id)->get())>0);
            
            if($newSlug)
            {
                $slug = $newSlug;
            }
        }
        $fullOfferLink = $offer->full_link;
        if(strpos($request->link,'tinyurl.com') == false)
        {
            $fullOfferLink = $request->link;
            $url = "http://tinyurl.com/api-create.php?url=".$request->link;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
    
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
    
            $offerLink = $output;
        }
        else
        {
            $offerLink = $request->link;
        }
        
        $endDate = null;
        $endDateNull = 1;
        if($request->endDate)
        {
            $endDate = Carbon::parse($request->endDate);
            $endDateNull = 0;
        }
        
        $offer->update([
            'name' => $request->name,
            'slug' => $slug,
            'highlight' => $request->highlight,
            'summary' => $request->summary,
            'detail' => $request->detail,
            'link' => $offerLink,
            'full_link' => $fullOfferLink,
            'startDate' => $request->startDate,
            'endDate' => $endDate,
            'endDateNull' => $endDateNull,
            'offer_type_id' => $request->offer_type_id,
            'user_id' => Auth::user()->id,
            'position' => $request->position,
            'alt_tag' => $request->alt_tag,
            'brand_id' => $request->brand,
        ]);
        $offer->categories()->detach();
        foreach($request->categories as $category)
        {
            $offer->categories()->attach($category);
        }
        // $offer->tags()->detach();
        // if($request->tags)
        // {
        //     foreach($request->tags as $tag)
        //     {
        //         $offer->tags()->attach($tag);
        //     }
        // }
        if($request->photo)
        {
            if($offer->img_src)
            {
                unlink(public_path().$offer->img_src);
            }
            $file = $request->photo;
            $name = time().$file->getClientOriginalName();
            $image = Image::make($file->getRealPath());
            $image->resize(788,null,function($constraint){
                $constraint->aspectRatio();
            });
            $image->save(public_path('images/offer/' .$name));
            $img_src = '/images/offer/'.$name;
            $offer->update(['img_src' => $img_src]);
        }
        return redirect()->back()->with('success', 'Successfully updated offer '.$offer->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        $img_src = null;
        if($offer->img_src)
        {
            $img_url = public_path().$offer->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $img_src = '/images/undo/offer/'.$name;
            file_put_contents(public_path().$img_src, $contents);
        }
        $categoryIds = $offer->categories()->pluck('id');
        $properties = $offer->toJson();
        $properties = json_decode($properties);
        $properties->img_src = $img_src;
        $properties->categories = $categoryIds;
        $properties = json_encode($properties);
        $hasUndo = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
        if($hasUndo == null)
        {
            $undo = Undo::create([
                'properties' => $properties,
                'type' => 'Deleted',
                'offer_id' => $offer->id,
            ]);
        }
        else
        {
            $hasUndo->update([
                'properties' => $properties,
                'type' => 'Deleted',
                'offer_id' => $offer->id,
            ]);
        }
        $offer->categories()->detach();
        //$offer->tags()->detach();
        $name = $offer->name;
        if($offer->metaTag)
        {
            $metaTag = MetaTag::where('offer_id', $id)->first();
            $metaTag->delete();
        }
        if($offer->img_src)
        {
            unlink(public_path().$offer->img_src);
        }
        $offer->delete();
        return redirect()->back()->with('success', 'Successfully deleted offer '.$name);
    }

    public function undoDeleted()
    {
        $undo = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            $slug = $this->createSlug($props->name);
            $i = 1;
            if(count(Offer::where('slug', $slug)->get()) > 0)
            {
                do{
                $x=Offer::where('slug', $slug)->get();
                if($x) $newSlug = $slug.$i;
                //$slug = $slug.$i;
                $i++;
                }while(count(Offer::where('slug', $newSlug)->get())>0);
                
                if($newSlug)
                {
                    $slug = $newSlug;
                }
            }
            $lastOfferSku = Offer::all()->pluck('sku')->last();
            if($lastOfferSku)
            {
                $sku = intval($lastOfferSku) + 1;
            }
            else
            {
                $sku = 10000000;
            }
            $img_url = public_path().$props->img_src;
            $info = pathinfo($img_url);
            $contents = file_get_contents($img_url);
            $name = $info['basename'];
            $img_src = '/images/offer/'.$name;
            file_put_contents(public_path().$img_src, $contents);
            $offerType = OfferType::find($props->offer_type_id);
            if($offerType == null)
            {
                $offer_type_id = null;
            }
            else
            {
                $offer_type_id = $offerType->id;
            }
            $offer = Offer::create([
                'name' => $props->name,
                'slug' => $slug,
                'sku' => $sku,
                'detail' => $props->detail,
                'link' => $props->link,
                'startDate' => $props->startDate,
                'endDate' => $props->endDate,
                'endDateNull' => $props->endDateNull,
                'img_src' => $img_src,
                'alt_tag' => $props->alt_tag,
                'offer_type_id' => $offer_type_id,
                'user_id' => $props->user_id,
                'position' => $props->position,
                'display' => $props->display,
                'click' => $props->click,
            ]);
            $categories = Category::find($props->categories);
            foreach($categories as $category)
            {
                $offer->categories()->attach($category->id);
            }
            $newOfferMetaTag = MetaTag::create([
                'offer_id' => $offer->id
            ]);
    
            //$url = env("APP_URL");
            $newOfferMetaTag->link = 'offer/'.$offer->slug;
            $newOfferMetaTag->save();
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully restore last deleted offer.');
        }
    }

    public function undoEdited($id)
    {
        $offer = Offer::find($id);
        $undo = Undo::where('offer_id',$id)->where('type','Edited')->first();
        if($undo == null)
        {
            return redirect()->back()->withErrors(['Something went wrong.']);
        }
        else
        {
            $props = json_decode($undo->properties);
            if($props->img_changed == 0)
            {
                $offer->update([
                    'name' => $props->name,
                    'slug' => $props->slug,
                    'sku' => $props->sku,
                    'detail' => $props->detail,
                    'link' => $props->link,
                    'startDate' => $props->startDate,
                    'endDate' => $props->endDate,
                    'endDateNull' => $props->endDateNull,
                    'img_src' => $props->img_src,
                    'alt_tag' => $props->alt_tag,
                    'offer_type_id' => $props->offer_type_id,
                    'user_id' => $props->user_id,
                    'position' => $props->position,
                    'display' => $props->display,
                    'click' => $props->click,
                ]);
                $offer->categories()->detach();
                $categories = Category::find($props->categories);
                foreach($categories as $category)
                {
                    $offer->categories()->attach($category->id);
                }
            }
            else
            {
                $img_url = public_path().$props->img_src;
                $info = pathinfo($img_url);
                $contents = file_get_contents($img_url);
                $name = $info['basename'];
                $img_src = '/images/offer/'.$name;
                file_put_contents(public_path().$img_src, $contents);
                unlink(public_path().$offer->img_src);
                $offer->update([
                    'name' => $props->name,
                    'slug' => $props->slug,
                    'sku' => $props->sku,
                    'detail' => $props->detail,
                    'link' => $props->link,
                    'startDate' => $props->startDate,
                    'endDate' => $props->endDate,
                    'endDateNull' => $props->endDateNull,
                    'img_src' => $img_src,
                    'alt_tag' => $props->alt_tag,
                    'offer_type_id' => $props->offer_type_id,
                    'user_id' => $props->user_id,
                    'position' => $props->position,
                    'display' => $props->display,
                    'click' => $props->click,
                ]);
                $offer->categories()->detach();
                $categories = Category::find($props->categories);
                foreach($categories as $category)
                {
                    $offer->categories()->attach($category->id);
                }
            }
            $undo->delete();
            return redirect()->back()->with('success', 'Successfully undo offer.');
        }
    }

    
    public function display($id)
    {
        $offer = Offer::find($id);
        $offer->display = !$offer->display;
        $offer->save();

        return redirect()->back()->with('success', 'Successfully changed visibility of offer '.$offer->name);
    }

    public function copy($id)
    {
        $offer = Offer::find($id);
        $brands = Brand::all();
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        return view('offers.copy',compact('offer','offerTypes','categories','brands'));
    }

    public function uploadCsv()
    {
        return view('offers.upload');
    }

    public function uploadOffer(Request $request)
    {
        $this->validate($request,[
            'csv' => 'required|file',
        ]);
        $file = $request->csv;
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();

        // Valid File Extensions
        $valid_extension = array("csv");
        
         // Check file extension
        if(in_array(strtolower($extension),$valid_extension)){
            // File upload location
            $location = 'uploads';
            // Upload file
            $file->move($location,$filename);
            // Import CSV to Database
            $filepath = public_path($location."/".$filename);
            // Reading file
            $file = fopen($filepath,"r");
            
            $importData_arr = array();
            $i = 0;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                
                $num = count($filedata );
                //dd($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                   $i++;
                   continue; 
                }
                
                for ($c=0; $c < $num; $c++) {
                    
                    // if($filedata [$c] != '')
                    // {
                    //     $importData_arr[$i][] = $filedata [$c];
                    // }
                    // else
                    // {
                    //     continue;
                    // }
                    $importData_arr[$i][] = $filedata [$c];
                   
                }
                $i++;
             }
             fclose($file);
             
             foreach($importData_arr as $data)
             {
                 //dd(Carbon::parse($data[4]));
                 if(Offer::where('name',$data[0])->where('detail',$data[1])->first() != null)
                 {
                    $offer = Offer::where('name',$data[0])->where('detail',$data[1])->first();
                    $offerType = OfferType::where('name',$data[6])->first();
                    if($offerType == null)
                    {
                        $offer->offer_type_id = null;
                        $offer->save();
                    }
                    else
                    {
                        $offer->offer_type_id = $offerType->id;
                        $offer->save();
                    }
                    $brand_id = null;
                    $brand = Brand::where('slug',$data[8])->first();
                    if($brand != null)
                    {
                        $brand_id = $brand->id;
                    }
                    $offer->brand_id = $brand_id;
                    $offer->save();
                    $offer->categories()->detach();
                    $categorySlugs = explode(',',$data[7]);
                    foreach($categorySlugs as $categorySlug)
                    {
                        $category = Category::where('slug',$categorySlug)->first();
                        if($category != null)
                        {
                            $offer->categories()->attach($category->id);
                        }
                    }
                    if($offer->link != $data[2])
                    {
                        $fullOfferLink = $data[2];
                        $url = "http://tinyurl.com/api-create.php?url=".$data[2];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
                
                        $output = curl_exec($ch);
                        $info = curl_getinfo($ch);
                        curl_close($ch);
                
                        $offerLink = $output;
                        $offer->link = $offerLink;
                        $offer->full_link = $fullOfferLink;
                        $offer->save();
                    }
                    if($offer->startDate != Carbon::parse($data[3]))
                    {
                        $offer->startDate = Carbon::parse($data[3]);
                        $offer->save();
                    }
                    if(public_path().$offer->img_src != $data[5])
                    {
                        if($offer->img_src)
                        {
                            unlink(public_path().$offer->img_src);
                        }
                        if(file_exists($data[5]))
                        {
                            $img_url = $data[5];
                            $info = pathinfo($img_url);
                            $contents = file_get_contents($img_url);
                            $name = time().$info['basename'];
                            $img_src = '/images/offer/'.$name;
                            file_put_contents(public_path().$img_src, $contents);
                        }
                        else
                        {
                            $img_src = null;
                        }
                        $offer->img_src = $img_src;
                        $offer->save();
                    }
                     if($offer->endDate != null)
                     {
                        if($data[4] == 'Ongoing')
                        {
                            $offer->endDate = null;
                            $offer->endDateNull = 1;
                            $offer->save();
                            continue;
                        }
                        elseif(Carbon::parse($data[4]) > $offer->endDate)
                        {
                            $offer->endDate = Carbon::parse($data[4]);
                            $offer->endDateNull = 0;
                            $offer->save();
                            continue;
                        }
                        else
                        {
                            continue;
                        }
                     }
                     else
                     {
                        continue;
                     }
                    
                 }
                 else
                 {

                 
                    $slug = $this->createSlug($data[0]);
                    $i = 1;
                    if(count(Offer::where('slug', $slug)->get()) > 0)
                    {
                        do{
                        $x=Offer::where('slug', $slug)->get();
                        if($x) $newSlug = $slug.$i;
                        //$slug = $slug.$i;
                        $i++;
                        }while(count(Offer::where('slug', $newSlug)->get())>0);
                        
                        if($newSlug)
                        {
                            $slug = $newSlug;
                        }
                    }
                    $fullOfferLink = $data[2];
                    $url = "http://tinyurl.com/api-create.php?url=".$data[2];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
                
                        $output = curl_exec($ch);
                        $info = curl_getinfo($ch);
                        curl_close($ch);
                
                        $offerLink = $output;

                        $lastOfferSku = Offer::all()->pluck('sku')->last();
                        if($lastOfferSku)
                        {
                            $sku = intval($lastOfferSku) + 1;
                        }
                        else
                        {
                            $sku = 10000000;
                        }
                        $startDate = Carbon::parse($data[3]);
                        $endDate = $data[4];
                        
                        if($endDate == 'Ongoing')
                        {
                            $endDate = null;
                            $endDateNull = 1;
                        }
                        else
                        {
                            $endDate = Carbon::parse($endDate);
                            $endDateNull = 0;
                        }
                    if(file_exists($data[5]))
                    {
                        $img_url = $data[5];
                        $info = pathinfo($img_url);
                        $contents = file_get_contents($img_url);
                        $name = time().$info['basename'];
                        $img_src = '/images/offer/'.$name;
                        file_put_contents(public_path().$img_src, $contents);
                    }
                    else
                    {
                        $img_src = null;
                    }
                    $offerType = OfferType::where('name',$data[6])->first();
                    if($offerType == null)
                    {
                        $offer_type_id = null;
                    }
                    else
                    {
                        $offer_type_id = $offerType->id;
                    }
                    $brand_id = null;
                    $brand = Brand::where('slug',$data[8])->first();
                    if($brand != null)
                    {
                        $brand_id = $brand->id;
                    }
                    $insertData = array(
                    'name' => $data[0],
                    'slug' => $slug,
                    'detail' => $data[1],
                    'link' => $offerLink,
                    'full_link' => $fullOfferLink,
                    'sku' => $sku,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'endDateNull' => $endDateNull,
                    'img_src' => $img_src,
                    'user_id' => Auth::user()->id,
                    'offer_type_id' => $offer_type_id,
                    'brand_id' => $brand_id,
                    );
                    $offer = Offer::create($insertData);
                    $categorySlugs = explode(',',$data[7]);
                    foreach($categorySlugs as $categorySlug)
                    {
                        $category = Category::where('slug',$categorySlug)->first();
                        if($category != null)
                        {
                            $offer->categories()->attach($category->id);
                        }
                    }
                    $newOfferMetaTag = MetaTag::create([
                        'offer_id' => $offer->id
                    ]);
            
                    //$url = env("APP_URL");
                    $newOfferMetaTag->link = 'offer/'.$offer->slug;
                    $newOfferMetaTag->save();

                    $excludeKeywords = ExcludeKeywords::first();
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
        }else{
            return redirect()->back()->withErrors('Invalid File Extension.');
         }
         return redirect()->back()->with('success', 'Import Successful.');
    }

    public function downloadCsv()
    {
        $offers = Offer::orderBy('position')->get();
        return view('offers.download',compact('offers'));
    }

    public function downloadOffer(Request $request)
    {
        $this->validate($request,[
            'offers' => 'required',
        ]);
        if($request->offers == 'all')
        {
            $offers = Offer::all();
        }
        else
        {
            $offers = Offer::find($request->offers);
        }
        
        $filename = 'offers.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Name', 'Detail1', 'Link', 'Todays Date', 'End Date', 'Image','Offer Type','Categories','Brand'));
        foreach($offers as $offer)
        {
            $categories = $offer->categories()->pluck('slug')->toArray();
            $categories = implode(',',$categories);
            $offerType = '';
            if($offer->offerType != null)
            {
                $offerType = $offer->offerType->name;
            }
            $brand = null;
            if($offer->brand)
            {
                $brand = $offer->brand->slug;
            }
            if($offer['endDate'] == null)
            {
                fputcsv($handle, array($offer['name'], $offer['detail'], $offer['link'], $offer['startDate'],'Ongoing',public_path().$offer['img_src'],$offerType,$categories,$brand));
            }
            else
            {
                fputcsv($handle, array($offer['name'], $offer['detail'], $offer['link'], $offer['startDate'],$offer['endDate'],public_path().$offer['img_src'],$offerType,$categories,$brand));
            }
                
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'offers.csv', $headers);
    }

    public function downloadOfferSearch(Request $request)
    {
        $offers = Offer::where('name', 'LIKE', '%'.$request->term.'%')->orWhere('sku', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('position')->get();
        return view('offers.download',compact('offers'));
    }

    public function searchOffers(Request $request)
    {
        if($request->category == 'all')
        {
            if($request->offers == 'all')
            {
                if($request->term == null)
                {
                    $offers = Offer::orderBy('position')->paginate(15);
                }
                else
                {
                    $offers = Offer::where('name', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('position')->paginate(15);
                }
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'most-popular')
            {
                if($request->term == null)
                {
                    $offers = Offer::orderBy('click','DESC')->paginate(15);
                }
                else
                {
                    $offers = Offer::where('name', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('click','DESC')->paginate(15);
                }
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'live')
            {
                if($request->term == null)
                {
                    $offers = Offer::orderBy('position')->get();
                }
                else
                {
                    $offers = Offer::where('name', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('position')->paginate(15);
                }
                $offer = new Offer();
                $offers = $offer->filterOffers($offers);
                $offers = (new Collection($offers))->paginate(15);
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'expired')
            {
                if($request->term == null)
                {
                    $offers = Offer::where('endDate', '<', Carbon::now())->orderBy('position')->paginate(15);
                }
                else
                {
                    $offers = Offer::where('endDate', '<', Carbon::now())->where('name', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('position')->paginate(15);
                }
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
        }
        else
        {
            $parentCategory = Category::find($request->category);
            if($request->offers == 'all')
            {
                $collections = [];
                if($request->term == null)
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers;
                    }
                }
                else
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers()->where('detail', 'LIKE', '%'.$request->term.'%')->get();
                        $collections[] = $cat->offers()->where('name', 'LIKE', '%'.$request->term.'%')->get();
                    }
                }
                $offers = new Collection();
                foreach($collections as $item)
                {
                    $offers = $offers->merge($item);
                }
                $offers = $offers->unique();
                $offers = (new Collection($offers))->sortBy('position',SORT_REGULAR, false)->paginate(15);
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'most-popular')
            {
                $collections = [];
                //dd($parentCategory->subcategories);
                if($request->term == null)
                {
                   
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers;
                    }
                }
                else
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers()->where('name', 'LIKE', '%'.$request->term.'%')->get();
                        $collections[] = $cat->offers()->where('detail', 'LIKE', '%'.$request->term.'%')->get();
                    }
                }
                
                $offers = new Collection();
                foreach($collections as $item)
                {
                    $offers = $offers->merge($item);
                }
                $offers = $offers->unique();
                $offers = (new Collection($offers))->sortBy('click',SORT_REGULAR, true)->paginate(15);
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'live')
            {
                $collections = [];
                if($request->term == null)
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers;
                    }
                }
                else
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers()->where('name', 'LIKE', '%'.$request->term.'%')->get();
                        $collections[] = $cat->offers()->where('detail', 'LIKE', '%'.$request->term.'%')->get();
                    }
                }
                
                $offers = new Collection();
                foreach($collections as $item)
                {
                    $offers = $offers->merge($item);
                }
                $offers = $offers->unique();
                $offers = (new Collection($offers))->sortBy('position',SORT_REGULAR, false);
                $offer = new Offer();
                $offers = $offer->filterOffers($offers);
                $offers = (new Collection($offers))->paginate(15);
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
            elseif($request->offers == 'expired')
            {
                $collections = [];
                if($request->term == null)
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers;
                    }
                }
                else
                {
                    foreach($parentCategory->subcategories as $cat)
                    {
                        $collections[] = $cat->offers()->where('name', 'LIKE', '%'.$request->term.'%')->get();
                        $collections[] = $cat->offers()->where('detail', 'LIKE', '%'.$request->term.'%')->get();
                    }
                }
                
                $offers = new Collection();
                foreach($collections as $item)
                {
                    $offers = $offers->merge($item);
                }
                $offers = $offers->unique();
                $offers = (new Collection($offers))->where('endDate', '<', Carbon::now())->sortBy('position',SORT_REGULAR, false)->paginate(15);
                $categories = Category::where('parent_id',null)->get();
                $undoDeleted = Undo::where('offer_id','<>',null)->where('type','Deleted')->first();
                return view('offers.index',compact('offers','categories','undoDeleted'));
            }
        }
    }

}
