<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
     protected $fillable = [

        'cart_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'subtotal',
        'coupon',
        'coupon_discount',
        'total',
    ];
    public function quoteItems()
    {
        return $this->hasMany(Quote_item::class, 'quote_id', 'id');
    }
}
