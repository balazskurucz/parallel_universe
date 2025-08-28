<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParallelUniverse extends Model
{
    protected $fillable = [
        'name',
        'divergence_point',
        'divergence_year',
        'description',
        'cover_image_path',
    ];

    public function historicalEvents()
    {
        return $this->hasMany(HistoricalEvent::class);
    }

    public function newsBroadcasts()
    {
        return $this->hasMany(NewsBroadcast::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')->where('file_type', 'image');
    }

    public function videos()
    {
        return $this->morphMany(Media::class, 'mediable')->where('file_type', 'video');
    }
}
