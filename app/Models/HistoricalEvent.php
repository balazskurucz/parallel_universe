<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HistoricalEvent extends Model
{
    protected $fillable = [
        'parallel_universe_id',
        'title',
        'slug',
        'event_year',
        'short_description',
        'long_description',
        'cover_image_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function parallelUniverse()
    {
        return $this->belongsTo(ParallelUniverse::class);
    }

    public function coverImage()
    {
        return $this->belongsTo(Media::class, 'cover_image_id');
    }
}
