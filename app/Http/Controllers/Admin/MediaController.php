<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\ParallelUniverse;
use App\Models\HistoricalEvent;
use App\Models\NewsBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::with('mediable')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.media.index', compact('media'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universes = ParallelUniverse::orderBy('name')->get();
        $events = HistoricalEvent::with('parallelUniverse')->orderBy('title')->get();
        $news = NewsBroadcast::with('parallelUniverse')->orderBy('headline')->get();

        return view('admin.media.create', compact('universes', 'events', 'news'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv|max:51200', // 50MB max
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'mediable_type' => 'required|in:universe,event,news',
            'mediable_id' => 'required|integer',
        ]);

        // Validate that the mediable_id exists for the given type
        $this->validateMediableExists($request->mediable_type, $request->mediable_id);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('media', $fileName, 'public');

        // Determine file type
        $mimeType = $file->getMimeType();
        $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'video';

        // Get the correct model class
        $mediableClass = $this->getMediableClass($request->mediable_type);

        // Create media record
        $media = Media::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'alt_text' => $request->alt_text,
            'description' => $request->description,
            'mediable_type' => $mediableClass,
            'mediable_id' => $request->mediable_id,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media = Media::findOrFail($id);
        
        // Delete the file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        // Delete the database record
        $media->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully!');
    }

    /**
     * Validate that the mediable entity exists
     */
    private function validateMediableExists(string $type, int $id): void
    {
        $model = match($type) {
            'universe' => ParallelUniverse::find($id),
            'event' => HistoricalEvent::find($id),
            'news' => NewsBroadcast::find($id),
            default => null
        };

        if (!$model) {
            abort(422, "The selected {$type} does not exist.");
        }
    }

    /**
     * Get the full model class name for the mediable type
     */
    private function getMediableClass(string $type): string
    {
        return match($type) {
            'universe' => ParallelUniverse::class,
            'event' => HistoricalEvent::class,
            'news' => NewsBroadcast::class,
            default => throw new \InvalidArgumentException("Invalid mediable type: {$type}")
        };
    }
}
