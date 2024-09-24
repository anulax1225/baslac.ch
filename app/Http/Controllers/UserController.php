<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(15);
        if (count($users) > $request->page) return response($users[$request->page]);
        return response(["message" => "Page not found"], 404);
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        if ($user) return response($user);
        return response(["message" => "User not found"], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        response(User::create($request->all()));
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) return response(["message" => "User not found"], 404);
        $user->update($request->all());
        return response($user);
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) return response(["message" => "User not found"], 404);
        $user->destroy();
        return response([]);
    }
}
