<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Photo/Index', [
            "photos" => Photo::all()->jsonSerialize(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Photo/Create');
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
        $path = "photos/" . $uuid . "-" . $request->name . "." . pathinfo($request->path, PATHINFO_EXTENSION);
        Storage::disk("s3")->move($request->path, $path);
        Photo::create([
            "uuid" => $uuid,
            "name" => $request->name,
            "path" => $path,
            "user_id" => Auth::user()->id
        ]);
        return redirect(route("photo.index"))->with(["message" => "Photo ajouté avec success"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
        ]);
        $photo = Photo::where("uuid", $request->id)->first();
        if(!$photo) redirect()->back()->withErrors(["uuid" => "Photo introuvable" ]);
        $photo->update([
            "name" => $request->name
        ]);
        return redirect(route("photo.index"))->with(["message" => "Nom de la photo modifié avec success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::where("uuid", $id)->first();
        if(!$photo) redirect()->back()->withErrors(["uuid" => "Photo introuvable" ]);
        $photo->delete();
        return redirect(route("photo.index"))->with(["message" => "Photo supprimée avec success"]);
    }
}
