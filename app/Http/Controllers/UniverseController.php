<?php

namespace App\Http\Controllers;

use App\Models\ParallelUniverse;
use App\Models\NewsBroadcast;
use Illuminate\Http\Request;

class UniverseController extends Controller
{
    /**
     * Display a listing of all parallel universes (home page).
     */
    public function index()
    {
        $universes = ParallelUniverse::with(['newsBroadcasts' => function ($query) {
            $query->orderBy('broadcast_date', 'desc');
        }])->get();
        
        $latestNews = NewsBroadcast::orderBy('broadcast_date', 'desc')->first();
        
        return view('home', compact('universes', 'latestNews'));
    }

    /**
     * Display the specified universe with its events and news.
     */
    public function show(ParallelUniverse $universe)
    {
        $universe->load(['historicalEvents' => function($query) {
            $query->orderBy('event_year');
        }, 'newsBroadcasts' => function($query) {
            $query->orderBy('broadcast_date', 'desc');
        }]);
        
        return view('universes.show', compact('universe'));
    }
}
