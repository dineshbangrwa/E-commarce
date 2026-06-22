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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('is_featured');
            $table->integer('stock');
            $table->integer('weight');
            $table->integer('price');
            $table->integer('special_price');
            $table->string('special_price_from');
            $table->string('special_price_to');
            $table->string('short_description');
            $table->string('description');
            $table->string('related_product');
            $table->string('url_key');
            $table->string('meta_tag');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
