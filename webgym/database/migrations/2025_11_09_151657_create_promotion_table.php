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
        Schema::create('promotion', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('discount_value', 10, 2);
            $table->boolean('is_percent')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('per_user_limit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion');
    }
};
