<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["image" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        $path = $request->file("image")->hashName();
        $request->file('image')->store("public/images");
        return response(Image::create([
            "url" => $path
        ]));
    }

    public function destroy(Request $request)
    {
        $image = Image::find($request->id);
        if (!$image) return response(["message" => "Image not found"], 404);
        Storage::disk('local')->delete("public/images/". $image->url);
        $image->destroy();
        return response([]);
    }
}
