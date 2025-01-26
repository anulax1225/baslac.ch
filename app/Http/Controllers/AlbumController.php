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
        $total = Album::count();
        $pageSize = 12;
        $page = 1;
        return Inertia::render('Album/Index', [
            "lastPage" => ceil($total / $pageSize),
            "albums" => Album::orderBy("created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::where("uuid", $id)->first();
        $total = $album->photos()->count();
        $pageSize = 12;
        $page = 1;
        return Inertia::render('Album/Show', [
            "album" => $album->jsonSerialize(),
            "lastPage" => ceil($total / $pageSize),
            "photos" => $album->photos()->orderBy("album_photo.created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize()
        ]);
    }

    public function pages(Request $request)
    {
        $total = Album::count();
        $pageSize = 12;
        $page = $request->page ?? 2;
        $page = $request->page <= ceil($total / $pageSize) ? $page : ceil($total / $pageSize);
        return response()->json([
            "lastPage" => ceil($total / $pageSize),
            "albums" => Album::orderBy("created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize(),
        ]);
    }

    public function photoUuids(Request $request)
    {
        $album = Album::where("uuid", $request->id)->first();
        $uuids = [];
        foreach($album->photos as $photo) array_push($uuids, $photo->uuid);
        return response()->json([
            "uuids" => $uuids,
        ]);
    }

    public function photoPages(Request $request)
    {
        $album = Album::where("uuid", $request->id)->first();
        $total = $album->photos()->count();
        $pageSize = 12;
        $page = $request->page ?? 2;
        $page = $request->page <= ceil($total / $pageSize) ? $page : ceil($total / $pageSize);
        return response()->json([
            "lastPage" => ceil($total / $pageSize),
            "photos" => $album->photos()->orderBy("album_photo.created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize(),
        ]);
    }

    public function photoRemove(Request $request)
    {
        $album = Album::where("uuid", $request->id)->first();
        $total = $album->photos()->detach(Photo::where("uuid", $request->photoId)->first());
        return redirect(route("album.show", [ "id" => $album->uuid ]))->with(["message" => "Photo supprimée avec success"]);
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

    public function addPhotos(Request $request)
    {
        $album = Album::where("uuid", $request->id)->first();
        if(!$album) redirect()->back()->withErrors(["uuid" => "Album introuvable" ]);
        foreach($request->uuids as $uuid) {
            $photo = Photo::where("uuid", $uuid)->first();
            if(!$photo) redirect()->back()->withErrors(["uuid" => "Photo introuvable" ]);
            $album->photos()->attach($photo);
        }
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
