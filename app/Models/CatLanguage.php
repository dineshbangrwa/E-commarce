<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatLanguage extends Model
{
    protected $fillable = [

        'category_id',
        'translated_data',
    ];

    protected $casts = [
        'translated_data' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
