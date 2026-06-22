<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class language extends Model
{
    protected $fillabel = [
        'language',
        'code',
    ];

    public function translations()
    {
        return $this->hasMany(Translation::class, 'language_id');
    }
}
