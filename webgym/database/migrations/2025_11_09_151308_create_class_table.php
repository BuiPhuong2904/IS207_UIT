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
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('max_capacity')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('trainer_id')->references('user_id')->on('trainer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_class');
    }
};
