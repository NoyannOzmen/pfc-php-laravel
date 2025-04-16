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

        $request->validate([
            'nom' => 'bail|required|string',
            'prenom' => 'bail|required|string',
            'rue' => 'bail|required|string',
            'commune' => 'bail|required|string',
            'code_postal' => ['bail','required','regex:/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/'],
            'pays' => 'bail|required|string',
            'hebergement' => 'bail|required|string',
            'terrain' => 'nullable|string',
        ]);

        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $request->whenHas($key, fn ($value) => $famille->$key = $value);
        }

        $famille->save();

        return redirect('famille/profil')->with('famille', $famille);
    }

    /**
     * Handle account deletion.
     */
    public function foster_destroy(Request $request): RedirectResponse
    {
        $userId = Auth::user()->accueillant->id;
        $user = User::find(Auth::user()->id);

        $famille = Famille::findOrFail($userId);

        $demandes = Demande::where('famille_id', '=', $userId)->get();
        if (count($demandes) > 0) {
            foreach ($demandes as $demande) {
                $demande->delete();
              }
        }

        $fostered = Animal::where('famille_id', $userId)->get();

        if ((count($fostered) == 0)) {
            $famille->delete();
            $user->delete();
            //* Possibly add soft-delete ?
            return redirect('/deconnexion');
        }

        return back()->with("famille", $famille)->with('error', 'Vous accueillez actuellement un ou plusieurs animaux enregistrés sur notre site.
        Merci de contacter le refuge concerné avant de supprimer votre compte !');;
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
