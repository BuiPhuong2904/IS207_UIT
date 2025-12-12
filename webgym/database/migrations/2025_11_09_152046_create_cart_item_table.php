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

        Schema::dropIfExists('cart_item');

        Schema::create('cart_item', function (Blueprint $table) {
            // Khóa chính 
            $table->primary(['cart_id', 'variant_id']);

            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('variant_id');

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);

            // Foreign key
            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('cart')
                ->onDelete('cascade');
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
