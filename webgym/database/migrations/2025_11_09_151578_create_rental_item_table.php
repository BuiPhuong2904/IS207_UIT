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
        Schema::create('rental_item', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('item_name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rental_fee', 10, 2);
            $table->integer('quantity_total');
            $table->integer('quantity_available');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('branch_id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_item');
    }
};
