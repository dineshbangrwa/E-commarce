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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('parent_category');
            $table->string('name');
            $table->integer('status');
            $table->integer('show_in_menu');
            $table->string('url_key');
            $table->string('meta_tag');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('short_description');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
