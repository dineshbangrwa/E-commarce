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
        Schema::create('slid_languages', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('slider_id'); 
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade'); 
            $table->json('translated_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slid_languages');
    }
};
