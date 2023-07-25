<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название треда');
            $table->string('slug')->unique()->comment('Слаг треда');
            $table->text('content')->nullable()->comment('Содержание треда');

            $table->unsignedBigInteger('author_id')->comment('id автора треда');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable()->comment('id категории треда');
            $table->foreign('category_id')->references('id')->on('thread_categories')->onDelete('cascade');

            $table->unsignedBigInteger('image_id')->nullable()->comment('id картинки треда');
            $table->foreign('image_id')->references('id')->on('attachments')->onDelete('set null');

            $table->string('seo_title')->nullable()->comment('SEO title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
