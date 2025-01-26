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
        $aps = DB::table("album_photo")->get();
        foreach($aps as $ap) {
            $photo = DB::table("photos")->where("id", $ap->photo_id)->first();
            DB::table("album_photo")->where("id", $ap->id)->update([
                "created_at" => $photo->created_at
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
