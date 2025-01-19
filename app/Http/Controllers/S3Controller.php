<?php

namespace App\Http\Controllers;

use App\Utils\S3;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Normalizer;


class S3Controller extends Controller
{
    private $bucket;

    public function __construct() {
        $this->bucket = config("filesystems.disks.s3.bucket");
    }

    private static function NormalizeName($name) {
        // Normalize the filename according to the NFC convention
        // Requires php-intl module
        // More info: https://www.php.net/manual/en/class.normalizer.php
        if (class_exists('Normalizer')) {
            $normalized_filename = Normalizer::normalize($name, Normalizer::FORM_C);
            if ($normalized_filename !== false) {
                return $normalized_filename;
            }
        } else {
            // If Normalizer is not installed, we transform the text into an 
            // ASCII representation without diacritics.
            return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        }

        return $name;
    }


    public function GeneratePresignedUrl(Request $request)
    {
        return response()->json([ "url" => S3::signUrl($request->key) ]);
    }

    public function StartMultipartUpload(Request $request)
    {
        $filename = "tmp/" . Str::random(10) . "_" . Str::replace(" ", "_", $request->filename);
        $client = ((object)Storage::disk("s3"))->getClient();
        $result = $client->createMultipartUpload([
            "Bucket" => $this->bucket,
            "Key" => $filename,
            'ContentDisposition' => 'inline',
        ]);
        return response()->json([ 
            "uploadId" => $result["UploadId"],
            "key" => $filename,  
        ]);
    }

    public function GeneratePresignedMultipartUrl(Request $request)
    {
        $client = ((object)Storage::disk("s3"))->getClient();
        $command = $client->getCommand('UploadPart', [
            "Bucket" => $this->bucket,
            "Key" => $request->key,
            "UploadId" => $request->uploadId,
            "ContentLength" => $request->partLength,
            "PartNumber" => $request->partNumber,
        ]);
        $preSignedUrl = $client->createPresignedRequest($command, Carbon::tomorrow());
        return response()->json([ "url" => (string)$preSignedUrl->getUri() ]);
    }

    public function CompleteMultipartUpload(Request $request)
    {
        $client = ((object)Storage::disk("s3"))->getClient();
        $result = $client->completeMultipartUpload([
            "Bucket" => $this->bucket,
            "Key" => $request->key,
            "UploadId" => $request->uploadId,
            "MultipartUpload" => [
                "Parts" => $request->parts
            ]
        ]);
        return response()->json([ "message" => "Upload completed", "Location" => $result["Location"] ]);
    }

    public function ProxyS3(Request $request)
    {
        $response = Http::withBody($request->getContent(), "binary/octet-stream")->withHeaders([ "Content-Length" => $request->header("Content-Length") ])->put($request->header("X-SignedUrl"));
        $ETag = $response->getHeader("ETag") ? $response->getHeader("ETag")[0] : dd($response);
        return response(json_encode([
            "ETag" => $ETag
        ]), $response->status());
    }

    public function Download(Request $request)
    {
        $url = S3::signUrl($request->key);
        return redirect($url);
    }
}

