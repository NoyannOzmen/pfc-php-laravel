<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Famille;
use App\Models\User;
use Error;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        if ($user) {
            throw new Error(
                'Invalid credentials'
            );
        } else {
            $newUser = new User();
            $newUser->email($email);
            $newUser->roles(["ROLE_SHELTER"]);
            /*
            $hashedPassword = $passwordHasher->hashPassword(
                $newUser,
                $plaintextPassword
            )
            */;
            $hashedPassword = "";
            //!TODO ADD HASHING

            $newUser->password($hashedPassword);
            $newUser->save();

            $newShelter = new Association();
            $newShelter->utilisateur($newUser);
            $newShelter->nom($nom);
            $newShelter->responsable($responsable);
            $newShelter->rue($rue);
            $newShelter->commune($commune);
            $newShelter->code_postal($code_postal);
            $newShelter->pays($pays);
            $newShelter->telephone($telephone);
            $newShelter->siret($siret);
            if ($request->request->has("_site")) {$newShelter->site($site);};
            if ($request->request->has("_description")) {$newShelter->description($description);};
            $newShelter->save();

            $message = "Création de compte réussie, bienvenue ! Merci de vous connecter à present";
        }

        return redirect('signIn/inscriptionAsso', ['message' => $message]);
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
        $email = $request->request->get('_email');
        $user = User::find(['email' => $email]);

        if ($user) {
            throw new Error(
                'Invalid credentials'
            );
        }

        $newUser = new User();
        $newUser->email($email);
        $newUser->roles(["ROLE_FOSTER"]);
        $plaintextPassword = $request->request->get('_password');
        $plaintextConfirm = $request->request->get('_confirmation');

        if ($plaintextPassword !== $plaintextConfirm) {
            throw new Error(
                'Password and confirmation must match'
            );
        };
        /*
        $hashedPassword = $passwordHasher->hashPassword(
            $newUser,
            $plaintextPassword
        );
        */
        $hashedPassword = "";
        //!TODO ADD HASHING

        $newUser->password($hashedPassword);
        $newUser->save();

        $nom = $request->request->get('_nom');
        $prenom = $request->request->get('_prenom');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');
        $pays = $request->request->get('_pays');
        $telephone = $request->request->get('_telephone');
        $hebergement = $request->request->get('_hebergement');
        $terrain = $request->request->get('_terrain');

        $newFoster = new Famille();
        $newFoster->utilisateur($newUser);
        $newFoster->nom($nom);
        if ($request->request->has("_prenom")) {$newFoster->prenom($prenom);};
        if ($request->request->has("_terrain")) {$newFoster->terrain($terrain);};
        $newFoster->hebergement($hebergement);
        $newFoster->rue($rue);
        $newFoster->commune($commune);
        $newFoster->code_postal($code_postal);
        $newFoster->pays($pays);
        $newFoster->telephone($telephone);;
        $newFoster->save();

        $newUser->accueillant($newFoster);
        $newUser->save();

        $message = "Création de compte réussie, bienvenue ! Merci de vous connecter à present";

    return redirect('signIn/inscriptionFam', ["message" => $message]);
    }
}
