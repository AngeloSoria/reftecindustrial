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
        Schema::create('contents_projects', function (Blueprint $table) {
            $table->id();
            $table->json('images')->nullable();
            $table->string('job_order')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'on_going', 'completed'])->default('pending');
            $table->date('year_completed')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents_projects');
    }
};
