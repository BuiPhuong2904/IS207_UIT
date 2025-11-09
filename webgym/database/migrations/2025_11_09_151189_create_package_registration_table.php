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
        Schema::create('package_registration', function (Blueprint $table) {
            $table->id('registration_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('package_id')->references('package_id')->on('membership_package')->onDelete('cascade');
            $table->foreign('payment_id')->references('payment_id')->on('payment')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_registration');
    }
};
