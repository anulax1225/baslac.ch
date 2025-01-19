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
        Schema::table("users", function (Blueprint $table) {
            $table->string("totem", 100)->default("");
            $table->string("tel", 25)->default("");
            $table->string("role", 255)->default("");
            $table->tinyInteger("contactable")->default(0);
            $table->string("path")->default("profiles/none.png");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumns(["totem", "tel", "role"]);
        });
    }
};
