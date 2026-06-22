<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'status',
        'show_in_menu',
        'show_in_footer',
        'description',
        'url_key',
        'meta_tag',
        'meta_title',
        'image',
        'meta_description',
    ];

    protected static function booted()
    {
        static::deleting(function ($page) {
            $page->clearMediaCollection('image');
        });
    }
}
