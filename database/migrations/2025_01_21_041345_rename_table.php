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
        Schema::rename("albums_photos", "album_photo");
        Schema::rename("tags_albums", "album_tag");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename("album_photo", "albums_photos");
        Schema::rename("album_tag", "tags_albums");
    }
};
