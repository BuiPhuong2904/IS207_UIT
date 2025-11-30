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
            // Khóa chính ghép: cart_id + item_id + item_type → giống hệt order_detail
            $table->primary(['cart_id', 'item_id', 'item_type']);

            $table->unsignedBigInteger('cart_id');
            $table->morphs('item');                    // tạo item_id + item_type
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
