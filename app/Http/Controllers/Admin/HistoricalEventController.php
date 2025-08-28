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
        $events = HistoricalEvent::with(['parallelUniverse', 'coverImage'])->get();
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
    public function show(HistoricalEvent $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoricalEvent $event)
    {
        $universes = ParallelUniverse::all();
        $mediaFiles = \App\Models\Media::where('file_type', 'image')->orderBy('created_at', 'desc')->get();
        return view('admin.events.edit', compact('event', 'universes', 'mediaFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoricalEvent $event)
    {
        $validated = $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'title' => 'required|string|max:255',
            'event_year' => 'required|integer',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'cover_image_id' => 'nullable|exists:media,id',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Historical event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoricalEvent $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Historical event deleted successfully.');
    }

    /**
     * Show the form for mass uploading events.
     */
    public function massUploadForm()
    {
        $universes = ParallelUniverse::all();
        return view('admin.events.mass-upload', compact('universes'));
    }

    /**
     * Process the mass upload of events from JSON file.
     */
    public function massUploadProcess(Request $request)
    {
        $request->validate([
            'parallel_universe_id' => 'required|exists:parallel_universes,id',
            'json_file' => 'required|file|mimes:json|max:2048',
        ]);

        $file = $request->file('json_file');
        $jsonContent = file_get_contents($file->getRealPath());
        $events = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['json_file' => 'Invalid JSON file format.']);
        }

        if (!is_array($events)) {
            return back()->withErrors(['json_file' => 'JSON file must contain an array of events.']);
        }

        $successCount = 0;
        $errors = [];

        foreach ($events as $index => $eventData) {
            try {
                // Validate required fields
                if (!isset($eventData['eventName']) || !isset($eventData['year']) || 
                    !isset($eventData['shortDescription']) || !isset($eventData['longDescription'])) {
                    $errors[] = "Event at index {$index}: Missing required fields.";
                    continue;
                }

                // Convert BCE years to negative
                $year = $eventData['year'];
                if (is_string($year) && str_contains($year, 'BCE')) {
                    $year = -intval(preg_replace('/[^0-9]/', '', $year));
                } else {
                    $year = intval(preg_replace('/[^0-9]/', '', $year));
                }

                // Create the event
                HistoricalEvent::create([
                    'parallel_universe_id' => $request->parallel_universe_id,
                    'title' => $eventData['eventName'],
                    'event_year' => $year,
                    'short_description' => $eventData['shortDescription'],
                    'long_description' => $eventData['longDescription'],
                    'cover_image_id' => null, // Can be added later via normal edit
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Event at index {$index}: " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$successCount} events.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        return redirect()->route('admin.events.index')->with('success', $message);
    }
}
