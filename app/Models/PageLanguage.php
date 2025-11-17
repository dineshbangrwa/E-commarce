<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageLanguage extends Model
{
    protected $fillable = [

        'page_id',
        'translated_data',
    ];

    protected $casts = [
        'translated_data' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
