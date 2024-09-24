<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    public function index(Request $request)
    {
        return response(Categorie::all());
    }

    public function show(Request $request)
    {
        $categorie = Categorie::find($request->id);
        if ($categorie) return response($categorie);
        return response(["message" => "Categorie not found"], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        response(Categorie::create($request->all()));
    }

    public function update(Request $request)
    {
        $categorie = Categorie::find($request->id);
        if (!$categorie) return response(["message" => "Categorie not found"], 404);
        $categorie->update($request->all());
        return response($categorie);
    }

    public function destroy(Request $request)
    {
        $categorie = Categorie::find($request->id);
        if (!$categorie) return response(["message" => "Categorie not found"], 404);
        $categorie->destroy();
        return response([]);
    }
}
