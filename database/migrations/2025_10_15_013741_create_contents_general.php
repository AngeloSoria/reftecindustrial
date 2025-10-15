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
        Schema::create('contents_general', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('image_path')->nullable();
            $table->json('extra_data')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents_general');
    }
};
