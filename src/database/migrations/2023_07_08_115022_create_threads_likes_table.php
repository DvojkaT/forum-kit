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
        Schema::create('thread_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('id пользователя поставившего лайк');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->morphs('likable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thread_likes');
    }
};
