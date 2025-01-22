<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        $reset = DB::table("password_reset_tokens")->where("token", $request->token)->whereDate("created_at", '>=', (new DateTime())->modify('-1 day')->format("Y-m-d H:i:s"))->first();
        if(!$reset || !$reset->email) return redirect(route("login"))->withErrors(["email" => "Le lien de réinitialisation n'est plus valide ou a été corrompu."]);
        return Inertia::render('Auth/ResetPassword', [
            'email' => $reset->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $reset = DB::table("password_reset_tokens")
        ->where("token", $request->token)
        ->whereDate("created_at", '>=', (new DateTime())->modify('-1 day')
        ->format("Y-m-d H:i:s"))->first();

        if(!$reset || !$reset->email) 
            return redirect(route("login"))->withErrors(["email" => "Le lien de réinitialisation n'est plus valide ou a été corrompu."]);

        User::where("email", $reset->email)->update([
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);
        DB::table("password_reset_tokens")
        ->where("token", $request->token)->delete();

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        
        return redirect()->route('login')->with('status', 'Mot de passe réinisialisé succès');
    }
}
