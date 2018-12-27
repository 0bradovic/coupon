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

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::orderBy('position')->get();
        return view('offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        return view('offers.create',compact('categories','tags','offerTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request,[
            'name' => 'required|string',
            'highlight' => 'max:20',
            'summary' => 'max:50',
            'detail' => 'max:300',
            'link' => 'required|string',
            'startDate' => 'required|date',
            'categories' => 'required'
        ]);
        $slug = $this->createSlug($request->name);
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
            'startDate' => $startDate,
            'endDate' => $endDate,
            'endDateNull' => $endDateNull,
            'offer_type_id' => $offer_type_id,
            'user_id' => Auth::user()->id,
            'position' => $request->position,
            'img_src' => $img_src,
        ]);
        foreach($request->categories as $category)
        {
            $offer->categories()->attach($category);
        }
        if($request->tags)
        {
            foreach($request->tags as $tag)
            {
                $offer->tags()->attach($tag);
            }
        }

        $newOfferMetaTag = MetaTag::create([
            'offer_id' => $offer->id
        ]);

        $metaTag = MetaTag::where('offer_id', $offer->id)->first();
        return redirect()->route('offer.seo.edit', ['id' => $offer->id])->with('success', 'Successfully added offer '.$offer->name);
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
        $tags = Tag::all();
        $offerTypes = OfferType::all();
        $categories = Category::all();
        return view('offers.edit',compact('offer','tags','offerTypes','categories'));
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
            'offer_type_id' => 'required|numeric',
            'categories' => 'required'
        ]);
        $offer = Offer::find($id);
        $slug = $this->createSlug($request->name);
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
            'link' => $request->link,
            'startDate' => $request->startDate,
            'endDate' => $endDate,
            'endDateNull' => $endDateNull,
            'offer_type_id' => $request->offer_type_id,
            'user_id' => Auth::user()->id,
            'position' => $request->position,
        ]);
        $offer->categories()->detach();
        foreach($request->categories as $category)
        {
            $offer->categories()->attach($category);
        }
        $offer->tags()->detach();
        if($request->tags)
        {
            foreach($request->tags as $tag)
            {
                $offer->tags()->attach($tag);
            }
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
        $offer->categories()->detach();
        $offer->tags()->detach();
        $name = $offer->name;
        $offer->delete();
        return redirect()->back()->with('success', 'Successfully deleted offer '.$name);
    }
}
