<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Famille;
use App\Models\User;
use Error;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function shelter_signup(Request $request): RedirectResponse
    {
        $request->validate([
            '_password' => 'bail|required|string',
            '_confirmation' => 'bail|required|string',
            //* For testing purposes
            '_email' => 'bail|required|email',
            /* '_email' => 'bail|required|email:spoof,rfc,dns', */
            'nom' => 'bail|required|string',
            'responsable' => 'bail|required|string',
            'rue' => 'bail|required|string',
            'commune' => 'bail|required|string',
            'code_postal' => ['bail','required','regex:/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/'],
            'pays' => 'bail|required|string',
            'telephone' => ['bail','required','regex:/^(0|\+33 )[1-9]([\-. ]?[0-9]{2} ){3}([\-. ]?[0-9]{2})|([0-9]{8})$/'],
            'siret' => ['bail','required','regex:/^(\d{14}|((\d{3}[ ]\d{3}[ ]\d{3})|\d{9})[ ]\d{5})$/'],
            'site' => 'nullable|url:http,https',
            'description' => 'nullable|string',
        ]);

        $plaintextPassword = $request->request->get('_password');
        $plaintextConfirm = $request->request->get('_confirmation');

        if ($plaintextPassword !== $plaintextConfirm) {
            throw new Error(
                'Password and confirmation must match'
            );
        }

        $email = $request->request->get('_email');

        $user = User::find(['email' => $email]);

        if (count($user) > 0) {
            throw new Error(
                'Invalid credentials'
            );
        } else {
            $newUser = User::create([
                'email' => $email,
                'roles' => json_encode(["ROLE_SHELTER"]),
                'password' => Hash::make($plaintextPassword, ['rounds' => 8]),
            ]);

            $association = new Association;

            $data = $request->except('_token', '_email', '_password', '_confirmation', 'api_gouv');
            foreach ($data as $key => $value) {
                $request->whenHas($key, fn ($value) => $association->$key = $value);
            }
            $association->utilisateur_id = $newUser->id;

            $association->save();

            event(new Registered($newUser));

            Auth::login($newUser);
        }

        return redirect('/');
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
    public function foster_signup(Request $request): RedirectResponse
    {
        $request->validate([
            '_password' => 'bail|required|string',
            '_confirmation' => 'bail|required|string',
            //* For testing purposes
            '_email' => 'bail|required|email',
            /* '_email' => 'bail|required|email:spoof,rfc,dns', */
            'nom' => 'bail|required|string',
            'prenom' => 'bail|required|string',
            'telephone' => ['bail','required','regex:/^(0|\+33 )[1-9]([\-. ]?[0-9]{2} ){3}([\-. ]?[0-9]{2})|([0-9]{8})$/'],
            'hebergement' => 'bail|required|string',
            'terrain' => 'nullable|string',
            'rue' => 'bail|required|string',
            'commune' => 'bail|required|string',
            'code_postal' => ['bail','required','regex:/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/'],
            'pays' => 'bail|required|string',
        ]);

        $plaintextPassword = $request->request->get('_password');
        $plaintextConfirm = $request->request->get('_confirmation');

        if ($plaintextPassword !== $plaintextConfirm) {
            throw new Error(
                'Password and confirmation must match'
            );
        };

        $email = $request->request->get('_email');
        $user = User::find(['email' => $email]);

        if (count($user) > 0) {
            throw new Error(
                'Invalid credentials'
            );
        } else {
            $newUser = User::create([
                'email' => $email,
                'roles' => json_encode(["ROLE_FOSTER"]),
                'password' => Hash::make($plaintextPassword, ['rounds' => 8]),
            ]);

            $famille = new Famille;

            $data = $request->except('_token', '_email', '_password', '_confirmation', 'api_gouv');
            foreach ($data as $key => $value) {
                $request->whenHas($key, fn ($value) => $famille->$key = $value);
            }
            $famille->utilisateur_id = $newUser->id;

            $famille->save();

            event(new Registered($newUser));

            Auth::login($newUser);
        };

    return redirect('/');
    }
}
