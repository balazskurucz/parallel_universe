<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'alt_text',
        'description',
    ];

    /**
     * Get the parent mediable model (ParallelUniverse, HistoricalEvent, or NewsBroadcast).
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    /**
     * Check if the media is an image.
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the media is a video.
     */
    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    /**
     * Get the full URL to the media file.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
