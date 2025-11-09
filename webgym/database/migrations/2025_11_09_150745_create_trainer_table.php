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
        Schema::create('trainer', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('specialty')->nullable();
            $table->integer('experience_years')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->text('work_schedule')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('status')->nullable();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('branch_id')->references('branch_id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer');
    }
};
