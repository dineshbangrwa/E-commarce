<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProLanguage extends Model
{
    protected $fillable =[
      'product_id',
      'translated_data',  
    ];

    protected $casts = [
    'translated_data' => 'array',
];

    public function block()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
