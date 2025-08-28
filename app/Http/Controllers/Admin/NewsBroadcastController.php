<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsBroadcast;
use App\Models\ParallelUniverse;
use Illuminate\Http\Request;

class NewsBroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = NewsBroadcast::with('parallelUniverse')->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universes = ParallelUniverse::all();
        $mediaFiles = \App\Models\Media::where('file_type', 'image')->orderBy('created_at', 'desc')->get();
        return view('admin.news.create', compact('universes', 'mediaFiles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'headline' => 'required|string|max:255',
            'broadcast_date' => 'required|date',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'cover_image_id' => 'nullable|exists:media,id',
        ]);

        NewsBroadcast::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'News broadcast created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsBroadcast $newsBroadcast)
    {
        return view('admin.news.show', compact('newsBroadcast'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsBroadcast $newsBroadcast)
    {
        $universes = ParallelUniverse::all();
        $mediaFiles = \App\Models\Media::where('file_type', 'image')->orderBy('created_at', 'desc')->get();
        return view('admin.news.edit', compact('newsBroadcast', 'universes', 'mediaFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsBroadcast $newsBroadcast)
    {
        $validated = $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'headline' => 'required|string|max:255',
            'broadcast_date' => 'required|date',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'cover_image_id' => 'nullable|exists:media,id',
        ]);

        $newsBroadcast->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'News broadcast updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsBroadcast $newsBroadcast)
    {
        $newsBroadcast->delete();

        return redirect()->route('admin.news.index')->with('success', 'News broadcast deleted successfully.');
    }
}
