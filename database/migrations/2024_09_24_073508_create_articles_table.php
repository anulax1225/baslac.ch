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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->string("description", 800);
            $table->longText("content")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("album_id")->default(0);
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("album_id")->references("id")->on("albums");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
