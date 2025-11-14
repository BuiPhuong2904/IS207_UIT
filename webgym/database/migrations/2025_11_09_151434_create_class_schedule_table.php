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
        Schema::create('class_schedule', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->unsignedBigInteger('class_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->string('room')->nullable();
            $table->string('status')->nullable(); // 'scheduled', 'cancelled', 'completed'
            $table->timestamps();

            $table->foreign('class_id')->references('class_id')->on('class')->onDelete('cascade');
            $table->foreign('trainer_id')->references('user_id')->on('trainer')->onDelete('set null');
            $table->foreign('branch_id')->references('branch_id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedule');
    }
};
