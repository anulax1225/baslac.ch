<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Utils\Mail;

Artisan::command('mail', function () {
    $user = User::find(1);

    Mail::send((object)[
        "template" => "email.test",
        "user" => $user,
        "subject" => "Test mail envoyé",
        "data" => []
    ]);

})->purpose('Send test mail');
