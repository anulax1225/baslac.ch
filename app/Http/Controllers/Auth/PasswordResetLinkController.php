<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\Mail;
use App\Utils\Token;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "email" => "required|string|email|max:255"
        ]);
        $user = User::where("email", $request->email)->firstOrFail();
        $token = Token::create($user->email);
        Mail::send((object)[
            "user" => $user,
            "template" => "email.auth.reset",
            "data" => [ "token" => $token ],
            "subject" => "Mot de passe oublié."
        ]);
        return back()->with('status',"Nous vous avons envoyé par email le lien de réinitialisation du mot de passe !");
    }
}
