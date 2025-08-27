<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParallelUniverse extends Model
{
    protected $fillable = [
        'name',
        'divergence_point',
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
}
