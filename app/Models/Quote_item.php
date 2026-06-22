<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote_item extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'quote_id',
        'product_id',
        'name',
        'sku',
        'price',
        'qty',
        'row_total',
        'custom_option',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ========ican at to cart 1 ya 2================
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
}
