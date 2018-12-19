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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        if($request->file('photo'))
        {
            $file = $request->file('photo');
            $name = time().$file->getClientOriginalName();
            $file->move('/images/categories',$name);
            $img_src = '/images/categories/'.$name;
        }
        Category::create([
            'name' => $request->name,
            'sku' => $sku,
            'img_src' => $img_src,
            'parent_id' => $parent_id,
        ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
