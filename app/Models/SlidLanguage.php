<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlidLanguage extends Model
{
    protected $fillable = [
        'slider_id',
        'translated_data',
    ];

     protected $casts = [
        'translated_data' => 'array',
    ];
    
    public function slider()
    {
        return $this->belongsTo(Slider::class, 'slider_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
