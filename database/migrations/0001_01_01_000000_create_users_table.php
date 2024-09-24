<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("lastname");
            $table->string("totem")->nullable();
            $table->string('email')->unique();
            $table->string("phone")->unique()->nullable();
            $table->tinyInteger("contactable")->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger("image_id")->default(0);
            $table->string("api_token", 80)->after('password')->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign("image_id")->references("id")->on("images");
        });

        DB::table("users")->insert([
            "name" => "Vinayak",
            "lastname" => "Ambigapathy",
            "totem" => "Tax",
            "email" => "anulax1225@icloud.com",
            "contactable" => 1,
            "password" => bcrypt(env("ADMIN_PASSWORD")),
            "email_verified_at" => Carbon::now(), 
            "api_token" => Str::random(80),
        ]);

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
