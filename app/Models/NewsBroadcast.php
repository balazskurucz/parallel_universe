<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsBroadcast extends Model
{
    protected $fillable = [
        'parallel_universe_id',
        'headline',
        'slug',
        'broadcast_date',
        'short_description',
        'long_description',
        'cover_image_id',
    ];

    protected function casts(): array
    {
        return [
            'broadcast_date' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->headline);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('headline') && empty($model->slug)) {
                $model->slug = Str::slug($model->headline);
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
