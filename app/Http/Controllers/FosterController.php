<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Demande;
use App\Models\Famille;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FosterController extends Controller
{
    /**
     * Display Foster profile.
     */
    public function foster_profile(): View
    {
        $userId = Auth::user()->accueillant->id;


        return view('foster/profilInfos', ['famille' => Famille::findOrFail($userId)]);
    }

    /**
     * Handle info updates.
     */
    public function foster_edit(Request $request): RedirectResponse
    {
        $userId = Auth::user()->accueillant->id;

        $famille = Famille::findOrFail($userId);

        $nom = $request->request->get('_nom');
        $prenom = $request->request->get('_prenom');
        $hebergement = $request->request->get('_hebergement');
        $terrain = $request->request->get('_terrain');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');

        if ($request->has("_nom")) {$famille->nom = $nom;};
        if ($request->has("_prenom")) {$famille->prenom = $prenom;};
        if ($request->has("_hebergement")) {$famille->hebergement = $hebergement;};
        if ($request->has("_terrain")) {$famille->terrain = $terrain;};
        if ($request->has("_rue")) {$famille->rue = $rue;};
        if ($request->has("_commune")) {$famille->commune = $commune;};
        if ($request->has("_$code_postal")) {$famille->code_postal = $code_postal;};

        $famille->save();

        return redirect('famille/profil')->with('famille', $famille);
    }

    /**
     * Handle account deletion.
     */
    public function foster_destroy(): RedirectResponse
    {
        $userId = Auth::user()->accueillant->id;
        $user = User::find(Auth::user()->id);

        $famille = Famille::findOrFail($userId);

        $requests = Demande::where('famille_id', '=', $userId)->get();
        if (count($requests) > 0) {
            foreach ($requests as $request) {
                $request->delete();
              }
        }

        $fostered = Animal::where('famille_id', $userId)->get();

        if ((count($fostered) == 0)) {
            $famille->delete();
            $user->delete();
            //* Possibly add soft-delete ?
            return redirect('/deconnexion');
        }
        $message = "Vous accueillez actuellement un ou plusieurs animaux enregistrés sur notre site.
        Merci de contacter le refuge concerné avant de supprimer votre compte !";

        return back()->with("famille", $famille)->with("message", $message);
    }

    /**
     * Display pending requests.
     */
    public function foster_requests(): View
    {
        $userId = Auth::user()->accueillant->id;

        $famille = Famille::findOrFail($userId);

        $requests = Demande::all()->where('famille_id', $userId);

        return view("foster/profilDemande", ["famille" => $famille, "requests" => $requests]);
    }
}
