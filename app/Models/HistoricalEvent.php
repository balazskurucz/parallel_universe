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
        'image_path',
        'video_url',
    ];

    public function parallelUniverse()
    {
        return $this->belongsTo(ParallelUniverse::class);
    }
}
