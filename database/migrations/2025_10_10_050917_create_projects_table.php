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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('job_order');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->boolean('visibility')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->date('completed_date')->nullable();
            $table->timestamp('added_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
