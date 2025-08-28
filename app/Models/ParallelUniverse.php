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
        'cover_image_id',
    ];

    public function historicalEvents()
    {
        return $this->hasMany(HistoricalEvent::class);
    }

    public function newsBroadcasts()
    {
        return $this->hasMany(NewsBroadcast::class);
    }

    public function coverImage()
    {
        return $this->belongsTo(Media::class, 'cover_image_id');
    }
}
