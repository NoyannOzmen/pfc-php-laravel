<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

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
    public function login() {

    }
}
