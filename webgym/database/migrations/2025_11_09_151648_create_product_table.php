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
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('is_discounted')->default(false);
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('unit')->nullable();
            $table->string('status')->nullable();
            $table->foreign('category_id')->references('category_id')->on('product_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
