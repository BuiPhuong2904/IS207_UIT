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
        Schema::create('payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('payment_type')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('package_registration_id')->nullable(); //????

            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
