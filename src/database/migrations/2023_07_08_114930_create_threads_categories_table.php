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
        Schema::create('thread_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название категории тредов');
            $table->string('slug')->unique()->comment('Слаг категории');
            $table->string('seo_title')->nullable()->comment('SEO title');
            $table->string('seo_description')->nullable()->comment('SEO description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thread_categories');
    }
};
