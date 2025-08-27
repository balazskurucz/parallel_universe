<?php

namespace App\Http\Controllers;

use App\Models\NewsBroadcast;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display the specified news broadcast with full details.
     */
    public function show(NewsBroadcast $news)
    {
        $news->load('parallelUniverse');
        return view('news.show', compact('news'));
    }
}
