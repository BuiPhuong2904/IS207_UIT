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
        Schema::create('membership_package', function (Blueprint $table) {
            $table->id('package_id');
            $table->string('package_name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('duration_months')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_package');
    }
};
