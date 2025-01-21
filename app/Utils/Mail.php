<?php

namespace App\Utils;

use App\Mail\Communication;
use Illuminate\Support\Facades\Mail as FacMail;


class Mail 
{
    public static function send($data)
    {
        FacMail::to($data->user->email)
        ->send(new Communication($data));
    }
}