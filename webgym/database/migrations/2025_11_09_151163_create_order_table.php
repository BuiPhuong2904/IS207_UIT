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
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_code')->unique();

            $table->dateTime('order_date');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->nullable(); // e.g., pending, completed, canceled
            $table->text('shipping_address')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->string('promotion_code')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
