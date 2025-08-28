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
        'cover_image_id',
    ];

    public function parallelUniverse()
    {
        return $this->belongsTo(ParallelUniverse::class);
    }

    public function coverImage()
    {
        return $this->belongsTo(Media::class, 'cover_image_id');
    }
}
