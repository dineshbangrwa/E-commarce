<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'order_increment_id',  
        'user_id',  
       'name',  
       'email', 
       'phone',  
       'address',  
       'address_2',  
       'city',  
       'state', 
       'country',  
       'pincode',  
       'coupon',  
       'coupon_discount',  
       'total',  
       'payment_method',  
       'shipping_method',  
       'shipping_cost',
       'subtotal',
    ];
       public function order_items()
{
    return $this->hasMany(Order_item::class);
}
}
