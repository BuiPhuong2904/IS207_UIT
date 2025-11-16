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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->primary(['order_id', 'variant_id']);

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('variant_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();

            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
            $table->foreign('variant_id')->references('variant_id')->on('product_variant')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
