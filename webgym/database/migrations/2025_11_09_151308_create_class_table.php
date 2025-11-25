<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('class', function (Blueprint $table) {
            $table->id('class_id');
            $table->string('class_name');
            $table->string('image_url')->nullable();
            $table->enum('type', ['cardio', 'strength', 'mind_body', 'combat', 'dance'])->default('cardio');
            $table->integer('max_capacity')->default(20);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class');
    }
};
