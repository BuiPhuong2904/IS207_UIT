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
            $table->string('room')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('trainer_id');
            $table->unsignedBigInteger('branch_id');

            $table->foreign('class_id')->references('class_id')->on('class')->onDelete('cascade');
            $table->foreign('trainer_id')->references('user_id')->on('trainer')->onDelete('cascade');
            $table->foreign('branch_id')->references('branch_id')->on('branch')->onDelete('cascade');
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
