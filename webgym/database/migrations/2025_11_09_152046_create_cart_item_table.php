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
        Schema::create('cart_item', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('variant_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);

            $table->foreign('cart_id')->references('cart_id')->on('cart')->onDelete('cascade');
            $table->foreign('variant_id')->references('variant_id')->on('product_variant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};
