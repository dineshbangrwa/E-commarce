<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_address extends Model
{
    protected $fillable = [

        'order_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'address-2',
        'city',
        'state',
        'country',
        'pincode',
        'address_type',
    ];
}
