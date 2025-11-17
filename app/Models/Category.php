<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;


    protected $fillable = [
        'parent_category',
        'name',
        'status',
        'show_in_menu',
        'url_key',
        'meta_tag',
        'meta_title',
        'meta_description',
        'short_description',
        'description',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }
    
}
