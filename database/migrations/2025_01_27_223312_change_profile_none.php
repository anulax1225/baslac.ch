<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table("users")->where("path", "profiles/none.png")->update([
            "path" => "profiles/none.webp"
        ]);
        $anulax = DB::table("users")->where("email", "anulax1225@icloud.com")->first();
        $gmail = DB::table("users")->where("email", "vinayak.ambigapathy@gmail.com")->first();
        if($anulax && $gmail){
            DB::table("photos")->where("user_id", $anulax->id)->update([ "user_id" => $gmail->id ]);
            DB::table("albums")->where("user_id", $anulax->id)->update([ "user_id" => $gmail->id ]);
            DB::table("users")->where("id", $anulax->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
