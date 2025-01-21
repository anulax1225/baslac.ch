<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Album/Index', [
            "albums" => Album::orderBy("created_at", "DESC")->get()->jsonSerialize(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::where("uuid", $id)->first();
        return Inertia::render('Album/Show', [
            "album" => $album->jsonSerialize(),
            "photos" => $album->photos->jsonSerialize()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "path" => "required|string",
        ]);
        
        if(!Storage::disk("s3")->exists($request->path)) 
            return redirect()->back()->withErrors(["path" => "Probleme with the file transfert"]);

        $uuid = Str::uuid();
        $path = "albums/" . $uuid . "-" . $request->name . "." . pathinfo($request->path, PATHINFO_EXTENSION);
        Storage::disk("s3")->move($request->path, $path);
        Album::create([
            "uuid" => $uuid,
            "name" => $request->name,
            "path" => $path,
            "user_id" => Auth::user()->id
        ]);
        return redirect(route("album.index"))->with(["message" => "Photo ajouté avec success"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function addPhoto(Request $request)
    {
        $album = Album::where("uuid", $request->id)->first();
        $photo = Photo::where("uuid", $request->uuid)->first();
        if(!$photo) redirect()->back()->withErrors(["uuid" => "Photo introuvable" ]);
        if(!$album) redirect()->back()->withErrors(["uuid" => "Album introuvable" ]);
        $album->photos()->attach($photo);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
