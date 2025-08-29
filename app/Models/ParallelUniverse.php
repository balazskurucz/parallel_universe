<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ParallelUniverse extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'divergence_point',
        'divergence_year',
        'short_description',
        'long_description',
        'cover_image_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

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
