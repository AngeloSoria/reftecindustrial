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
        Schema::create('contents_general_product_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignId('upload_id')
              ->nullable() // optional, if not all records have an upload
              ->constrained('uploads') // references 'id' on 'uploads' table
              ->onDelete('cascade'); // optional: delete related rows automatically

            $table->boolean('visibility')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents_general_product_lines');
    }
};
