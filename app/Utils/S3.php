<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class S3 
{
    public static function encodeURI($str)
    {
        $revert = ['%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')', '%2F'=>'/'];
        return strtr(rawurlencode($str), $revert);
    }

    public static function signUrl($key){
        $client = ((object)Storage::disk("s3"))->getClient();
        $bucket = config("filesystems.disks.s3.bucket");
        $command = $client->getCommand('GetObject', [
            "Bucket" => $bucket,
            "Key" => $key
        ]);
        return (string)$client->createPresignedRequest($command, Carbon::tomorrow())->getUri();
    }
}
