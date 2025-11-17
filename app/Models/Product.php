<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;


class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'status',
        'is_featured',
        'stock',
        'weight',
        'price',
        'special_price',
        'special_price_from',
        'special_price_to',
        'short_description',
        'description',
        'related_product',
        'url_key',
        'meta_tag',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'special_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'special_price_from' => 'date',
        'special_price_to' => 'date',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function combinations()
    {
        return $this->hasMany(AttributeCombination::class, 'product_id');
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->clearMediaCollection('image');
            $product->clearMediaCollection('banner_image');
            $product->combinations()->delete();
        });
    }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    //  public function translations()
    // {
    //     return $this->hasMany(ProTranslation::class, 'product_id');
    // }
    public function getNameAttribute($value)
{
    $langCode = session('language_code', config('app.locale'));
    $translation = \App\Models\ProLanguage::where('product_id', $this->id)->first();

    if ($translation && isset($translation->translated_data[$langCode]['name'])) {
        return $translation->translated_data[$langCode]['name'];
    }

    return $value; // original name जब translation न मिले
}

}
