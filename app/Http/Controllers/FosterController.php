<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Demande;
use App\Models\Famille;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FosterController extends Controller
{
    /**
     * Display Foster profile.
     */
    public function foster_profile(): View
    {
        /* $userId = $user->accueillant->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;

        return view('foster/profilInfos', ['famille' => Famille::findOrFail($userId)]);
    }

    /**
     * Handle info updates.
     */
    public function foster_edit(Request $request): RedirectResponse
    {
        /* $userId = $user->accueillant->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $famille = Famille::findOrFail($userId);

        $nom = $request->request->get('_nom');
        $prenom = $request->request->get('_prenom');
        $hebergement = $request->request->get('_hebergement');
        $terrain = $request->request->get('_terrain');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');

        if ($request->has("_nom")) {$famille->nom($nom);};
        if ($request->has("_prenom")) {$famille->prenom($prenom);};
        if ($request->has("_hebergement")) {$famille->hebergement($hebergement);};
        if ($request->has("_terrain")) {$famille->terrain($terrain);};
        if ($request->has("_rue")) {$famille->rue($rue);};
        if ($request->has("_commune")) {$famille->commune($commune);};
        if ($request->has("_$code_postal")) {$famille->code_postal($code_postal);};

        $famille->save();

        return redirect('foster/profilInfos', ['famille' => $famille]);
    }

    /**
     * Handle account deletion.
     */
    public function foster_destroy(): RedirectResponse
    {
        /* $userId = $user->accueillant->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $famille = Famille::findOrFail($userId);

        $requests = Demande::where('famille_id', $userId);
        if ($requests) {
            foreach ($requests as $request) {
                $request->destory();
              }
        }

        $fostered = Animal::where('famille_id', $userId);

        if (!$fostered) {
            $famille->destroy();
            /* $user->destroy(); */
            //* Possibly add soft-delete ?
            return redirect("staticPages/accueil");
        }
        $message = "Vous accueillez actuellement un ou plusieurs animaux enregistrés sur notre site.
        Merci de contacter le refuge concerné avant de supprimer votre compte !";

        return redirect("foster/profilInfos", ["famille" => $famille, "message" => $message]);
    }

    /**
     * Display pending requests.
     */
    public function foster_requests(): View
    {
        /* $userId = $user->accueillant->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $famille = Famille::findOrFail($userId);

        $requests = Demande::all()->where('famille_id', $userId);

        return view("foster/profilDemande", ["famille" => $famille, "requests" => $requests]);
    }
}
