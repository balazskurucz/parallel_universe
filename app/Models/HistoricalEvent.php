<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalEvent extends Model
{
    protected $fillable = [
        'parallel_universe_id',
        'title',
        'event_year',
        'short_description',
        'long_description',
    ];

    public function parallelUniverse()
    {
        return $this->belongsTo(ParallelUniverse::class);
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
