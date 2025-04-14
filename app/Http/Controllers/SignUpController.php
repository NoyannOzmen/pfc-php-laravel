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
        $plaintextPassword = $request->request->get('_password');
        $plaintextConfirm = $request->request->get('_confirmation');

        if ($plaintextPassword !== $plaintextConfirm) {
            throw new Error(
                'Password and confirmation must match'
            );
        }

        $nom = $request->request->get('_nom');
        $responsable = $request->request->get('_responsable');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');
        $pays = $request->request->get('_pays');
        $telephone = $request->request->get('_telephone');
        $siret = $request->request->get('_siret');
        $site = $request->request->get('_site');
        $description = $request->request->get('_description');
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

            $newShelter = Association::create([
                'nom' => $nom,
                'responsable' => $responsable,
                'rue' =>  $rue,
                'commune' => $commune,
                'code_postal' =>  $code_postal,
                'pays' =>  $pays,
                'telephone' => $telephone,
                'siret' => $siret,
                'site' => ($request->request->has("_site")) ? $site : null,
                'description' => ($request->request->has("_description")) ? $description : null,
                'utilisateur_id' => $newUser->id,
            ]);

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
        }

        $newUser = User::create([
            'email' => $email,
            'roles' => json_encode(["ROLE_FOSTER"]),
            'password' => Hash::make($plaintextPassword, ['rounds' => 8]),
        ]);

        event(new Registered($newUser));

        $nom = $request->request->get('_nom');
        $prenom = $request->request->get('_prenom');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');
        $pays = $request->request->get('_pays');
        $telephone = $request->request->get('_telephone');
        $hebergement = $request->request->get('_hebergement');
        $terrain = $request->request->get('_terrain');

        $newFoster = Famille::create([
            'prenom' => ($request->request->has("_prenom")) ? $prenom : null,
            'nom' => $nom,
            'rue' =>  $rue,
            'commune' => $commune,
            'code_postal' =>  $code_postal,
            'pays' =>  $pays,
            'telephone' => $telephone,
            'hebergement'=> $hebergement,
            'terrain' => ($request->request->has("_terrain")) ? $terrain : null,
            'utilisateur_id' => $newUser->id
        ]);

        Auth::login($newUser);

    return redirect('/famille/inscription');
    }
}
