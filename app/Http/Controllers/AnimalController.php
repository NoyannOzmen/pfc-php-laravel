<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Demande;
use App\Models\Espece;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    /**
     * Display available animals in a list.
     */
    public function displayAll(): View
    {
        $animals = Animal::where('statut', 'En refuge')->get();
        return view('animaux/animalList', ['animals' => $animals, 'especes' => Espece::all(), 'tags' => Tag::all()]);
    }

    /**
     * Handle search for animals.
     */
    public function getSearched(Request $request): View
    {
        $query = Animal::where('statut', 'En refuge')->with('tags');

        $request->validate([
            'minAge' => 'integer',
            'maxAge' => 'integer'
        ]);

        $speciesFull = $request->request->get('_especeDropdownFull');
        $speciesSmall = $request->request->get('_especeDropdownSmall');
        $sexe = $request->request->get('_sexe');
        $minAge = $request->request->get('_minAge');
        $maxAge = $request->request->get('_maxAge');
        $dpt = $request->request->get('_dptSelect');
        $tags = $request->input('_tags');

        if ($request->has('_especeDropdownSmall')) {
            $query->where('espece_id', "$speciesSmall");
        };

        if ($request->has('_especeDropdownFull')) {
            $query->where('espece_id', "$speciesFull");
        };

        if ($request->has('_sexe')) {
            $query->where('sexe', "$sexe");
        };

        if ($request->has('_minAge') && !(empty($minAge))) {
            $query->where('age', '>', "$minAge");
        };

        if ($request->has('_maxAge') && !(empty($minAge))) {
            $query->where('age', '<', "$maxAge");
        };

        if ($request->has('_dptSelect'))  {
            $query->whereHas('refuge', function($q) use ($dpt) {
                $q->where('code_postal', 'LIKE', "$dpt%");
            });
        };

        //! Returns only the first result for now
        if ($request->has('_tags') && count($tags) > 0) {
            $query->whereHas('tags', function($q) use ($tags) {
                $q->whereNotIn('nom', $tags)->orWhere('nom', '!=', null);
            });
        }

        $searchedAnimals = $query->get();
        $qr = $query->toSql();

        return view('animaux/animalSearchResults', ['searchedAnimals' => $searchedAnimals, 'qr' => $qr, 'tags' => $tags]);
    }


    /**
     * Display single animal page.
     */
    public function animal_details($id): View
    {
        return view('animaux/animalDetails', ['animal' => Animal::findOrFail($id)]);
    }

    /**
     * [LOGGED USER] Create a new foster request
     */
    public function make_request($id, Request $request): RedirectResponse
    {
        $animal = Animal::findOrFail($id);

        $user = Auth::user()->accueillant->id;

        $demande = Demande::where('animal_id', '=', $animal->id)->where('famille_id', '=', $user)->first();

        if (!$demande) {
            $newRequest = new Demande;
            $newRequest->animal_id = $animal->id;
            $newRequest->famille_id = $user;
            $newRequest->statut_demande = 'En attente';
            $newRequest->date_debut = date('Y/m/d');
            $newRequest->date_fin = date('Y/m/d', strtotime('+1 year'));

            $newRequest->save();
            return back()->with('animal', $animal)->with('error', 'Votre demande a bien été prise en compte !');

        } else {
            return back()->with('animal', $animal)->with('error', 'Vous avez déjà effectué une demande pour cet animal !');
        }
    }
}
