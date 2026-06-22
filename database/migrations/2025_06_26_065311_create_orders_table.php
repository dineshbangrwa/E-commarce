<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_increment_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->text('address_2');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->string('coupon');
            $table->double('coupon_discount');
            $table->double('total', 10, 2);
            $table->string('payment_method');
            $table->string('shipping_method');
            $table->string('shipping_cost');
            $table->string('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
