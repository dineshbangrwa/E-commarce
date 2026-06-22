<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'title',
        'coupon_code',
        'status',
        'valid_from',
        'valid_to',
        'coupon_discount',
    ];
}
