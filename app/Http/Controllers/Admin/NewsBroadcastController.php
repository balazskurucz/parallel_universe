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
        return view('admin.news.create', compact('universes'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

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
        return view('admin.news.edit', compact('newsBroadcast', 'universes'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($newsBroadcast->image_path) {
                \Storage::disk('public')->delete($newsBroadcast->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        $newsBroadcast->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'News broadcast updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsBroadcast $newsBroadcast)
    {
        // Delete image if exists
        if ($newsBroadcast->image_path) {
            \Storage::disk('public')->delete($newsBroadcast->image_path);
        }

        $newsBroadcast->delete();

        return redirect()->route('admin.news.index')->with('success', 'News broadcast deleted successfully.');
    }
}
