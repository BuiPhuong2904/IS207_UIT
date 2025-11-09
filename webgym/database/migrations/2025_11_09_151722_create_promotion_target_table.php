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
        Schema::create('promotion_target', function (Blueprint $table) {
            $table->id('p_target_id');
            $table->unsignedBigInteger('promotion_id');
            $table->string('target_type');
            $table->unsignedBigInteger('target_id')->nullable();

            $table->foreign('promotion_id')->references('promotion_id')->on('promotion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_target');
    }
};
