<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv|max:51200', // 50MB max per file
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'folder_name' => 'nullable|string|max:255',
        ]);

        $uploadedFiles = [];
        $files = $request->file('files');

        // Handle folder organization
        $folderName = $request->folder_name ?: 'general';
        $folderPath = 'media/'.$folderName;

        foreach ($files as $file) {
            $fileName = time().'_'.uniqid().'_'.$file->getClientOriginalName();

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

            $uploadedFiles[] = $media;
        }

        $fileCount = count($uploadedFiles);
        $message = $fileCount === 1 ? 'Media uploaded successfully!' : "{$fileCount} media files uploaded successfully!";

        return redirect()->route('admin.media.index')
            ->with('success', $message);
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
     * Serve a media file (resized for images, original for videos).
     */
    public function serve(string $id, string $dimensions): Response|BinaryFileResponse
    {
        $media = Media::findOrFail($id);

        // Check if file exists
        if (! Storage::disk('public')->exists($media->file_path)) {
            abort(404, 'Media file not found');
        }

        // Get the file path
        $filePath = Storage::disk('public')->path($media->file_path);

        // For videos, serve the original file directly
        if ($media->isVideo()) {
            return response()->file($filePath, [
                'Content-Type' => $media->mime_type,
                'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
                'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000).' GMT',
            ]);
        }

        // For images, continue with resizing logic
        if (! $media->isImage()) {
            abort(404, 'Media file is not supported');
        }

        // Parse dimensions (e.g., "600x300")
        if (! preg_match('/^(\d+)x(\d+)$/', $dimensions, $matches)) {
            abort(400, 'Invalid dimensions format. Use format: widthxheight (e.g., 600x300)');
        }

        $width = (int) $matches[1];
        $height = (int) $matches[2];

        // Validate dimensions (prevent abuse)
        if ($width > 2000 || $height > 2000 || $width < 1 || $height < 1) {
            abort(400, 'Invalid dimensions. Width and height must be between 1 and 2000 pixels');
        }

        // Create resized image
        $resizedImage = $this->resizeImage($filePath, $width, $height, $media->mime_type);

        return response($resizedImage)
            ->header('Content-Type', $media->mime_type)
            ->header('Cache-Control', 'public, max-age=31536000') // Cache for 1 year
            ->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
    }

    /**
     * Resize an image using GD library.
     */
    private function resizeImage(string $filePath, int $width, int $height, string $mimeType): string
    {
        // Create image resource from file
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($filePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($filePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($filePath);
                break;
            default:
                throw new \Exception('Unsupported image type: '.$mimeType);
        }

        if (! $sourceImage) {
            throw new \Exception('Failed to create image resource');
        }

        // Get original dimensions
        $originalWidth = imagesx($sourceImage);
        $originalHeight = imagesy($sourceImage);

        // Create new image with desired dimensions
        $resizedImage = imagecreatetruecolor($width, $height);

        // Preserve transparency for PNG and GIF
        if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }

        // Resize the image
        imagecopyresampled(
            $resizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $width, $height,
            $originalWidth, $originalHeight
        );

        // Output image to string
        ob_start();
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($resizedImage, null, 85); // 85% quality
                break;
            case 'image/png':
                imagepng($resizedImage);
                break;
            case 'image/gif':
                imagegif($resizedImage);
                break;
            case 'image/webp':
                imagewebp($resizedImage, null, 85); // 85% quality
                break;
        }
        $imageData = ob_get_contents();
        ob_end_clean();

        // Clean up memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);

        return $imageData;
    }
}
