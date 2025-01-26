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
    public function index(Request $request)
    {
        $total = Photo::count();
        $pageSize = 12;
        $page = 1;
        return Inertia::render('Photo/Index', [
            "lastPage" => ceil($total / $pageSize),
            "photos" => Photo::orderBy("created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize(),
        ]);
    }

    public function pages(Request $request)
    {
        $pageSize = 12;
        $total = Photo::count();
        $page = $request->page ?? 2;
        $page = $request->page <= ceil($total / $pageSize) ? $page : ceil($total / $pageSize);
        return response()->json([
            "lastPage" => ceil($total / $pageSize),
            "photos" => Photo::orderBy("created_at", "DESC")->offset($page * $pageSize - $pageSize)->limit($pageSize)->get()->jsonSerialize(),
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
        $photo = Photo::create([
            "uuid" => $uuid,
            "name" => $request->name,
            "path" => $path,
            "user_id" => Auth::user()->id
        ]);
        if($request->redirect) {
            return redirect()->back();
        }
        return response()->json([
            "uuid" => $photo->uuid
        ]);
    }


        /**
     * Store a newly created resource in storage.
     */
    public function stores(Request $request)
    {
        $request->validate([
            "files" => "required"
        ]);

        $redirect = $request->redirect ?? true;
        $uuids = [];
        foreach($request["files"] as $file) {
            $file = (object)$file;
            if(!Storage::disk("s3")->exists($file->path)) 
                return redirect()->back()->withErrors(["path" => "Probleme with the file transfert"]);
            $uuid = Str::uuid();
            $path = "photos/" . $uuid . "-" . $file->name . "." . pathinfo($file->path, PATHINFO_EXTENSION);
            Storage::disk("s3")->move($file->path, $path);
            $photo = Photo::create([
                "uuid" => $uuid,
                "name" => $file->name,
                "path" => $path,
                "user_id" => Auth::user()->id
            ]);
            array_push($uuids, $photo->uuid);
        }
        if($redirect) {
            return redirect()->back();
        }
        return response()->json([
            "uuids" => $uuids
        ]);
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
        $photo->albums()->detach();
        $photo->delete();
        return redirect(route("photo.index"))->with(["message" => "Photo supprimée avec success"]);
    }
}
