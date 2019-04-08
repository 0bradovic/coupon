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
use App\UndoOffer;
use Response;


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
        return view('offers.index',compact('offers'));
    }

    public function liveOffers()
    {
        $offers = Offer::orderBy('position')->get();
        $offer = new Offer();
        $offers = $offer->filterOffers($offers);
        $offers = (new Collection($offers))->paginate(15);
        return view('offers.index',compact('offers'));
    }

    public function expiredOffers()
    {
        $offers = Offer::where('endDate', '<', Carbon::now())->orderBy('position')->paginate(15);
        return view('offers.index',compact('offers'));
    }
    
    public function mostPopularOffers()
    {
        $offers = Offer::orderBy('click','DESC')->paginate(15);
        return view('offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$tags = Tag::all();
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        return view('offers.create',compact('categories','offerTypes'));
    }

    public function searchOffers(Request $request)
    {
        $offers = Offer::where('name', 'LIKE', '%'.$request->term.'%')->orWhere('sku', 'LIKE', '%'.$request->term.'%')->orWhere('detail', 'LIKE', '%'.$request->term.'%')->orderBy('position')->paginate(15);

        return view('offers.index',compact('offers'));

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
            'categories' => 'required'
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
            'display' => $request->display,
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

        // $newOfferMetaTag = MetaTag::create([
        //     'offer_id' => $offer->id
        // ]);

        // //$url = env("APP_URL");
        // $newOfferMetaTag->link = 'offer/'.$offer->slug;
        // $newOfferMetaTag->save();

        // $metaTag = MetaTag::where('offer_id', $offer->id)->first();
        //return redirect()->route('offer.seo.edit', ['id' => $offer->id])->with('success', 'Successfully added offer '.$offer->name);
        return redirect()->back()->with('success', 'Successfully added offer '.$offer->name);
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
        $offerTypes = OfferType::all();
        $categories = Category::all();
        return view('offers.edit',compact('offer','offerTypes','categories'));
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
            'categories' => 'required'
        ]);
        $offer = Offer::find($id);
        $undoOffer = UndoOffer::first();
        $undoOffer->update([
            'name' => $offer->name,
            'sku' => $offer->sku,
            'brand_id' => $offer->brand_id,
            'highlight' => $offer->highlight,
            'summary' => $offer->summary,
            'detail' => $offer->detail,
            'link' => $offer->link,
            'startDate' => $offer->startDate,
            'endDate' => $offer->endDate,
            'offer_type_id' => $offer->offer_type_id,
            'position' => $offer->position,
            'user_id' => $offer->user_id,
            'img_src' => $offer->img_src,
            'endDateNull' => $offer->endDateNull,
            'slug' => $offer->slug,
            'offer_id' => $offer->id,
        ]);
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
        $offer->categories()->detach();
        //$offer->tags()->detach();
        $name = $offer->name;
        // if($offer->metaTag)
        // {
        //     $metaTag = MetaTag::where('offer_id', $id)->first();
        //     $metaTag->delete();
        // }
        if($offer->img_src)
        {
            unlink(public_path().$offer->img_src);
        }
        $offer->delete();
        return redirect()->back()->with('success', 'Successfully deleted offer '.$name);
    }

    public function undo()
    {
        $undo = UndoOffer::first();
        $offer = Offer::find($undo->offer_id);
        $offer->update([
            'name' => $undo->name,
            'sku' => $undo->sku,
            'brand_id' => $undo->brand_id,
            'highlight' => $undo->highlight,
            'summary' => $undo->summary,
            'detail' => $undo->detail,
            'link' => $undo->link,
            'startDate' => $undo->startDate,
            'endDate' => $undo->endDate,
            'offer_type_id' => $undo->offer_type_id,
            'position' => $undo->position,
            'user_id' => $undo->user_id,
            'img_src' => $undo->img_src,
            'endDateNull' => $undo->endDateNull,
            'slug' => $undo->slug,
        ]);
        return redirect()->back();
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
        $offerTypes = OfferType::all();
        $categories = Category::where('parent_id', '<>', null)->get();
        return view('offers.copy',compact('offer','offerTypes','categories'));
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
                
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                   $i++;
                   continue; 
                }
                for ($c=0; $c < $num; $c++) {
                    if($filedata [$c] != '')
                    {
                        $importData_arr[$i][] = $filedata [$c];
                    }
                    else
                    {
                        continue;
                    }
                   
                }
                $i++;
             }
             fclose($file);
             //dd($importData_arr);
             foreach($importData_arr as $data)
             {
                 if(count(Offer::where('name',$data[0])->where('detail',$data[1])->get()) > 0)
                 {
                    continue;
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
                    $img_url = $data[5];
                    $info = pathinfo($img_url);
                    $contents = file_get_contents($img_url);
                    $name = time().$info['basename'];
                    $img_src = '/images/offer/'.$name;
                    file_put_contents(public_path().$img_src, $contents);
                    $insertData = array(
                    'name' => $data[0],
                    'slug' => $slug,
                    'detail' => $data[1],
                    'link' => $offerLink,
                    'sku' => $sku,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'endDateNull' => $endDateNull,
                    'img_src' => $img_src,
                    'user_id' => Auth::user()->id,
                    );
                    Offer::create($insertData);
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
        $offers = Offer::find($request->offers);
        $filename = 'offers.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Name', 'Detail1', 'Link', 'Todays Date', 'End Date', 'Image'));
        foreach($offers as $offer)
        {
            if($offer['endDate'] == null)
            {
                fputcsv($handle, array($offer['name'], $offer['detail'], $offer['link'], $offer['startDate'],'Ongoing',public_path().$offer['img_src']));
            }
            else
            {
                fputcsv($handle, array($offer['name'], $offer['detail'], $offer['link'], $offer['startDate'],$offer['endDate'],public_path().$offer['img_src']));
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

}
