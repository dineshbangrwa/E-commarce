<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class translation extends Model
{
    protected $fillable = [
        'block_id',
        'translated_data',
    ];

    protected $casts = [
        'translated_data' => 'array',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    // Relation: Translation belongs to Language (optional)
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
