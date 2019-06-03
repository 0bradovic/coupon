<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SearchQuery;
use DB;
use Carbon\Carbon;

class SearchQueryController extends Controller
{
    
    public function index(Request $request)
    {
        if($request->from != null && $request->to != null)
        {
            $queries = DB::table('search_queries')
            ->select('*', DB::raw('count(*) as total'))
            ->groupBy('query')
            ->whereBetween('created_at',array($request->from,$request->to))
            ->orderBy('total','DESC')
            ->get();
        }
        elseif($request->from != null && $request->to == null)
        {
            $queries = DB::table('search_queries')
            ->select('*', DB::raw('count(*) as total'))
            ->groupBy('query')
            ->where('created_at','>=',$request->from)
            ->orderBy('total','DESC')
            ->get();
        }
        elseif($request->from == null && $request->to != null)
        {
            $queries = DB::table('search_queries')
            ->select('*', DB::raw('count(*) as total'))
            ->groupBy('query')
            ->where('created_at','<=',$request->to)
            ->orderBy('total','DESC')
            ->get();
        }
        else
        {
            $queries = DB::table('search_queries')
            ->select('*', DB::raw('count(*) as total'))
            ->groupBy('query')
            ->orderBy('total','DESC')
            ->get();
        }
        
            
       return view('search-queries.index',compact('queries'));
    }

}
