<?php

namespace App\Http\Controllers;

use App\Models\NewsBroadcast;
use App\Models\ParallelUniverse;

class UniverseController extends Controller
{
    /**
     * Display a listing of all parallel universes (home page).
     */
    public function index()
    {
        $universes = ParallelUniverse::with(['coverImage', 'newsBroadcasts' => function ($query) {
            $query->orderBy('broadcast_date', 'desc')->limit(1);
        }])->get();

        $latestNews = NewsBroadcast::with(['parallelUniverse', 'coverImage'])
            ->orderBy('broadcast_date', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('universes', 'latestNews'));
    }

    /**
     * Display the specified universe with its events and news.
     */
    public function show(ParallelUniverse $universe)
    {
        $universe->load(['historicalEvents' => function ($query) {
            $query->orderBy('event_year');
        }, 'newsBroadcasts' => function ($query) {
            $query->orderBy('broadcast_date', 'desc');
        }]);

        return view('universes.show', compact('universe'));
    }
}
