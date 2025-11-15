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
        Schema::create('class_registration', function (Blueprint $table) {
            $table->id('class_reg_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('schedule_id');
            // $table->dateTime('registration_date');
            $table->string('status')->nullable(); // 'registered', 'attended', 'cancelled'
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('schedule_id')->references('schedule_id')->on('class_schedule')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_registration');
    }
};
