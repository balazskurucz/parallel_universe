<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoricalEvent;
use App\Models\ParallelUniverse;
use Illuminate\Http\Request;

class HistoricalEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = HistoricalEvent::with('parallelUniverse')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universes = ParallelUniverse::all();
        $mediaFiles = \App\Models\Media::where('file_type', 'image')->orderBy('created_at', 'desc')->get();
        return view('admin.events.create', compact('universes', 'mediaFiles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'title' => 'required|string|max:255',
            'event_year' => 'required|integer',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'cover_image_id' => 'nullable|exists:media,id',
        ]);

        HistoricalEvent::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Historical event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoricalEvent $historicalEvent)
    {
        return view('admin.events.show', compact('historicalEvent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoricalEvent $historicalEvent)
    {
        $universes = ParallelUniverse::all();
        $mediaFiles = \App\Models\Media::where('file_type', 'image')->orderBy('created_at', 'desc')->get();
        return view('admin.events.edit', compact('historicalEvent', 'universes', 'mediaFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoricalEvent $historicalEvent)
    {
        $validated = $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'title' => 'required|string|max:255',
            'event_year' => 'required|integer',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'cover_image_id' => 'nullable|exists:media,id',
        ]);

        $historicalEvent->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Historical event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoricalEvent $historicalEvent)
    {
        $historicalEvent->delete();

        return redirect()->route('admin.events.index')->with('success', 'Historical event deleted successfully.');
    }
}
