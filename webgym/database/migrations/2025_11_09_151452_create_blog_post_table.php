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
        Schema::create('blog_post', function (Blueprint $table) {
            $table->id('post_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->string('tags')->nullable();
            $table->string('image_url')->nullable();

            $table->foreign('author_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post');
    }
};
