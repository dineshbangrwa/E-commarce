<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['product_id','name'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
       public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}