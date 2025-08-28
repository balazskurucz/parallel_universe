<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParallelUniverse;
use Illuminate\Http\Request;

class ParallelUniverseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universes = ParallelUniverse::all();
        return view('admin.universes.index', compact('universes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.universes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'divergence_point' => 'required|string|max:255',
            'divergence_year' => 'nullable|integer|min:1|max:' . (date('Y') + 1000),
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image_path'] = $request->file('cover_image')->store('universes', 'public');
        }

        ParallelUniverse::create($validated);

        return redirect()->route('admin.universes.index')->with('success', 'Universe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParallelUniverse $universe)
    {
        return view('admin.universes.show', compact('universe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParallelUniverse $universe)
    {
        return view('admin.universes.edit', compact('universe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParallelUniverse $universe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'divergence_point' => 'required|string|max:255',
            'divergence_year' => 'nullable|integer|min:1|max:' . (date('Y') + 1000),
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($universe->cover_image_path) {
                \Storage::disk('public')->delete($universe->cover_image_path);
            }
            $validated['cover_image_path'] = $request->file('cover_image')->store('universes', 'public');
        }

        $universe->update($validated);

        return redirect()->route('admin.universes.index')->with('success', 'Universe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParallelUniverse $universe)
    {
        // Delete image if exists
        if ($universe->cover_image_path) {
            \Storage::disk('public')->delete($universe->cover_image_path);
        }

        $universe->delete();

        return redirect()->route('admin.universes.index')->with('success', 'Universe deleted successfully.');
    }
}
