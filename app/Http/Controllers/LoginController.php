<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display Login Form.
     */
    public function display_login(): View
    {
        return view('signIn/connexion');
    }

    /**
     * Handle Login Form.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            '_username' => 'bail|required|string',
            '_password' => 'bail|required|string',
        ]);

        $email = $request->request->get("_username");
        $password = $request->request->get("_password");

        $user = User::where('email', '=', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (!Hash::check($password, $user->password, [
            'rounds' => 8,
        ])) {
            return back()->withErrors([
                'password' => 'The provided credentials do not match our records.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
