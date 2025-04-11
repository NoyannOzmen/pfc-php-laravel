<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SignUpController extends Controller
{
    /**
     * Display shelter register form.
     */
    public function display_shelter_signup() : View
    {
        return view('signIn/inscriptionAsso');
    }

    /**
     * Handle Shelter register form.
     */
    public function shelter_signup() {

    }

        /**
     * Display Foster register form.
     */
    public function display_foster_signup() : View
    {
        return view('signIn/inscriptionFam');
    }

    /**
     * Handle Foster register form.
     */
    public function foster_signup() {

    }
}
