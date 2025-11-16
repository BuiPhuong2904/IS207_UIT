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

            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('unit')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('is_discounted')->default(false);
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

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