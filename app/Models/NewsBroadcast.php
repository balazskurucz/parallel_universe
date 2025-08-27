<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsBroadcast extends Model
{
    protected $fillable = [
        'parallel_universe_id',
        'headline',
        'broadcast_date',
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
