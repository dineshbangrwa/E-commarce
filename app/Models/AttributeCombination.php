<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AttributeCombination extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['product_id', 'price', 'stock', 'attribute_value_ids'];

    protected $casts = [
        'attribute_value_ids' => 'array', // Automatically handle JSON encoding/decoding
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getValues()
    {
        return AttributeValue::whereIn('id', $this->attribute_value_ids ?? [])
            ->with('attribute')
            ->get();

    }
}
