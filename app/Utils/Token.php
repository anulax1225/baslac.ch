<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class Token 
{
    public static function create($email){
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        return $token;
    }
}

