<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variant', function (Blueprint $table) {
            $table->id('variant_id');
            $table->unsignedBigInteger('product_id');
            $table->string('color');
            $table->string('size');
            $table->float('price');
            $table->float('discount_price');
            $table->boolean('is_discounted')->default(false);
            $table->integer('stock');
            $table->float('weight');
            $table->string('unit');
            $table->string('image_url');
            $table->string('status');

            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant');
    }
};
