<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Mail;
use App\Utils\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/User/Index', [
            "users" => User::orderBy("created_at", "DESC")->get()->jsonSerialize(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users"
        ]);

        $user = User::create([
            "password" => bcrypt(Str::Random(10)),
            "email" => $request->email,
            "name" => $request->name,
            "totem" => $request->totem,
            "email_verified_at" => Carbon::now(),
        ]);

        $token = Token::create($user->email);
        Mail::send((object)[
            "user" => $user,
            "template" => "email.auth.reset",
            "data" => [ "token" => $token ],
            "subject" => "Nouveau compte"
        ]);
        return redirect(route("admin.user.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
