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
        Schema::create('pro_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Define the product_id column first
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // Then add foreign key
            $table->json('translated_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_languages');
    }
};
