<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::paginate(15);
        if (count($albums) > $request->page) return response($albums[$request->page]);
        return response(["message" => "Page not found"], 404);
    }

    public function show(Request $request)
    {
        $album = Album::find($request->id);
        if ($album) return response($album);
        return response(["message" => "Album not found"], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        response(Album::create($request->all()));
    }

    public function update(Request $request)
    {
        $album = Album::find($request->id);
        if (!$album) return response(["message" => "Album not found"], 404);
        $album->update($request->all());
        return response($album);
    }

    public function destroy(Request $request)
    {
        $album = Album::find($request->id);
        if (!$album) return response(["message" => "Album not found"], 404);
        $album->destroy();
        return response([]);
    }
}
