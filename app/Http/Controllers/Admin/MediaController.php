<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::orderBy('folder_name', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $folders = Media::select('folder_name')
            ->distinct()
            ->whereNotNull('folder_name')
            ->orderBy('folder_name')
            ->pluck('folder_name');

        return view('admin.media.index', compact('media', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $folders = Media::select('folder_name')
            ->distinct()
            ->whereNotNull('folder_name')
            ->orderBy('folder_name')
            ->pluck('folder_name');

        return view('admin.media.create', compact('folders'));
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
            'folder_name' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        // Handle folder organization
        $folderName = $request->folder_name ?: 'general';
        $folderPath = 'media/' . $folderName;
        
        // Store file in the specified folder
        $filePath = $file->storeAs($folderPath, $fileName, 'public');

        // Determine file type
        $mimeType = $file->getMimeType();
        $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'video';

        // Create media record
        $media = Media::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'folder_name' => $folderName,
            'folder_path' => $folderPath,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'alt_text' => $request->alt_text,
            'description' => $request->description,
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

}
