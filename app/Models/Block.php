<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Block extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'status',
        'identifire',
        'image',
        'description',

    ];

    protected static function booted()
    {
        static::deleting(function ($block) {
            $block->clearMediaCollection('image');
        });
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'block_id');
    }
}
