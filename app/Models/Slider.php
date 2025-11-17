<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'title',
        'url_key',
        'image',
        'description',
        
    ];
      protected static function booted()
    {
        static::deleting(function ($slider) {
            $slider->clearMediaCollection('image');
        });
    }
}
