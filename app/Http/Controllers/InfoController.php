<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    public function index(Request $request)
    {
        $infos = Info::paginate(15);
        if (count($infos) > $request->page) return response($infos[$request->page]);
        return response(["message" => "Page not found"], 404);
    }

    public function show(Request $request)
    {
        $info = Info::find($request->id);
        if ($info) return response($info);
        return response(["message" => "Info not found"], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        response(Info::create($request->all()));
    }

    public function update(Request $request)
    {
        $info = Info::find($request->id);
        if (!$info) return response(["message" => "Info not found"], 404);
        $info->update($request->all());
        return response($info);
    }

    public function destroy(Request $request)
    {
        $info = Info::find($request->id);
        if (!$info) return response(["message" => "Info not found"], 404);
        $info->destroy();
        return response([]);
    }
}
