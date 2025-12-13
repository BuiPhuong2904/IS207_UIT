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
        Schema::create('rental_transaction', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            
            $table->integer('quantity');
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->foreign('item_id')->references('item_id')->on('rental_item')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_transaction');
    }
};
